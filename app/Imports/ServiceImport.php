<?php

namespace App\Imports;

use App\Models\Region\Country;
use App\Models\Region\District;
use App\Models\Region\State;
use App\Models\Service;
use App\Models\ServiceAttribute;
use App\Models\ServiceType;
use App\Repositories\Traits\ImageUploadTrait;
use App\User;
use App\Utils\Concerns\Models\ServiceImageConcern;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ServiceImport implements ToCollection, WithHeadingRow, WithValidation
{
    use ServiceImageConcern;
    use ImageUploadTrait;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $type = ServiceType::where('slug', $row['tip'])->first();
            $country = Country::where(['title' => $row['ulke']])->first();
            $state = State::where(['title' => $row['sehir']])->first();
            $district = District::where(['title' => $row['ilce']])->first();
            $attributes = ServiceAttribute::whereIn('title', explode(',', $row['ozellikler']))->get()->pluck('id')->toArray();

            $service = Service::create([
                'slug' => createSlugByModelAndTitleByModel(Service::class, $row['baslik'], 0),
                'title' => $row['baslik'],
                'address' => $row['adres'],
                'type_id' => $type->id,
                'status' => Service::STATUS_REQUIRE_ACTIVE_APPOINTMENT,
                'country_id' => $country ? $country->id : Country::TURKEY,
                'state_id' => $state->id,
                'district_id' => $district->id,
                'store_type' => Service::STORE_TYPE_LOCAL,
                'view_count' => 0,
                'person' => $row['kisi'],
                'user_id' => $this->user->id,
                'short_description' => $row['aciklama'],
                'description' => $row['aciklama'],
                'published_at' => $row['durum'] ? now() : null
            ]);

            $service->attributes()->sync($attributes);

            $this->uploadImageFromRow($service, $row['gorsel']);


        }
    }

    /**
     * @param Service $service
     * @param null $image
     */
    private function uploadImageFromRow(Service $service, $image = null)
    {
        if (!$image) return false;

        $file = file_get_contents($image);
        $imagePath = $this->uploadImage($file, $service->title, "public/services", $service->image, Service::MODULE_NAME);

        $service->update([
            'image' => $imagePath
        ]);
        $this->uploadThumbImage($file, $imagePath, 'public/services/thumb', $service->image, 'service_thumb');
    }

    public function rules(): array
    {
        return [
            'baslik' => 'required|max:200',
            'ulke' => 'required|string|exists:countries,title',
            'sehir' => 'required|string|exists:states,title',
            'ilce' => 'required|string|exists:districts,title',
            'adres' => 'nullable|string|max:255',
            'aciklama' => 'nullable|max:255|string',
            'tip' => 'required|string|exists:service_types,title',
            'kisi' => 'required|numeric|min:0|max:255',
        ];
    }
}
