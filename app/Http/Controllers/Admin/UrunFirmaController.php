<?php

namespace App\Http\Controllers\Admin;

use App\Models\Auth\Role;
use App\Models\Product\UrunFirma;
use App\Models\Service;
use App\Repositories\Interfaces\UrunFirmaInterface;
use App\Repositories\Traits\ImageUploadTrait;
use App\Repositories\Traits\ResponseTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UrunFirmaController extends Controller
{
    use ResponseTrait;
    use ImageUploadTrait;

    protected UrunFirmaInterface $model;

    public function __construct(UrunFirmaInterface $model)
    {
        $this->model = $model;
    }

    public function list()
    {
        $query = \request()->get('q', null);
        $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        return view('admin.product.company.listProductCompany', compact('list'));
    }

    public function detail($id = 0)
    {
        if ($id != 0)
            $item = UrunFirma::with(['user'])->findOrFail($id);
        else
            $item = new UrunFirma();
        return view('admin.product.company.newOrEditProductCompany', compact('item'));
    }

    public function save(Request $request, $id = 0)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'address' => 'nullable|max:250',
            'phone' => 'nullable|max:30',
            'api_url' => 'nullable|max:255',
        ]);
        $entry = $id != 0 ? $this->model->getById($id) : new UrunFirma();
        $userValidated = $request->validate([
            'name' => 'required|string|max:30',
            'surname' => 'nullable|string|max:30',
            'email' => 'required|string|max:255|unique:users,email,' . $entry->user_id,
//            'password' => 'nullable|string|max:60',
            'phone' => 'nullable|string|max:15',
        ]);
        $validated['api_status'] = activeStatus('api_status');
        $validated['slug'] = createSlugByModelAndTitleByModel(UrunFirma::class, $validated['title'], $id);

        $userValidated['is_active'] = activeStatus('is_active');
        $userValidated['is_admin'] = activeStatus('is_admin');
        $userValidated['role_id'] = Role::ROLE_COMPANY;

        $user = $this->updateOrCreateUser($userValidated, $entry->user_id);
        $validated['user_id'] = $user->id;

        if ($id != 0) {
            $entry = $this->model->update($validated, $id);
        } else {
            $entry = $this->model->create($validated);
        }
        if ($entry) {
            if ($request->hasFile('image')) {
                $imagePath = $this->uploadImage($request->file('image'), $entry->title, "public/company", $entry->image, UrunFirma::MODULE_NAME);
                $entry->update(['image' => $imagePath]);
            }
            return redirect(route('admin.product.company.edit', $entry->id));
        }

        return back()->withInput();
    }

    public function delete(UrunFirma $company)
    {
        $company->delete();
        return $this->success();
    }

    /**
     * @param array $data user information
     * @param int $userId user id
     */
    private function updateOrCreateUser($data, $userId)
    {
        $user = User::find($userId);
        if (request()->filled('password')) {
            $data['password'] = Hash::make(request()->password);
        }
        if ($user) {
            $user->update($data);
        } else {
            $user = User::create($data);
        }
        return $user;
    }
}
