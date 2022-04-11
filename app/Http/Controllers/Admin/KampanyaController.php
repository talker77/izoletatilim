<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\RemoveCampaignProductDiscountPricesAndDelete;
use App\Jobs\UpdateCompanyProductDiscountPriceByCategory;
use App\Models\Kampanya;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\KategoriInterface;
use App\Repositories\Interfaces\UrunFirmaInterface;
use App\Repositories\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class KampanyaController extends AdminController
{
    use ImageUploadTrait;

    protected KampanyaInterface $model;
    private KategoriInterface $categoryService;
    private UrunFirmaInterface $companyService;

    public function __construct(KampanyaInterface $model, KategoriInterface $categoryService, UrunFirmaInterface $companyService)
    {
        $this->model = $model;
        $this->categoryService = $categoryService;
        $this->companyService = $companyService;
    }

    public function list()
    {
        $query = request('q');
        if ($query) {
            $list = $this->model->allWithPagination([['title', 'like', "%$query%"]]);
        } else {
            $list = $this->model->allWithPagination();
        }
        return view('admin.campaign.listCampaigns', compact('list'));
    }

    public function newOrEditForm($id = 0)
    {
        $categories = $this->categoryService->all(['active' => 1]);
        $companies = $this->companyService->all(['active' => 1]);
        $entry = new Kampanya();
        $selected_categories = $selected_products = $selected_companies = [];
        $currencies = $this->activeCurrencies();
        if ($id != 0) {
            $entry = $this->model->getById($id, null, ['campaignProducts', 'campaignCategories']);
            $selected_categories = $entry->campaignCategories->pluck('id');
        }
        return view('admin.campaign.newOrEditCampaign',
            compact('entry', 'categories', 'selected_categories', 'companies', 'selected_companies', 'currencies'));
    }

    public function save(Request $request, $id = 0)
    {
        $request_data = $request->only(['title', 'discount_type', 'discount_amount', 'start_date', 'end_date', 'min_price', 'spot', 'currency_id']);
        $request_data['active'] = $request->has('active') ? 1 : 0;
        $posted_categories = $request->get('categories');
        $request_data['slug'] = createSlugByModelAndTitle($this->model, $request_data['title'], $id);
        $oldCurrencyID = config('admin.default_currency');
        $oldCompanyMinPrice = 0;
        if ($id != 0) {
            $entry = Kampanya::find($id);
            $oldCompanyMinPrice = $entry->min_price;
            $oldCurrencyID = $entry->currency_id;
            $entry->update($request_data);
        } else {
            $entry = $this->model->create($request_data);
        }
        if ($entry) {
            $imageName = $this->uploadImage($request->file('image'), $entry->title, 'public/kampanyalar/', $entry->image, Kampanya::MODULE_NAME);
            $entry->update(['image' => $imageName]);

            UpdateCompanyProductDiscountPriceByCategory::dispatch($entry, $posted_categories, $oldCurrencyID,$oldCompanyMinPrice);
            Kampanya::forgetCaches();
            return redirect(route('admin.campaigns.edit', $entry->id));
        }
        return back()->withInput();

    }

    public function delete($id)
    {
        $campaign = Kampanya::find($id);
        RemoveCampaignProductDiscountPricesAndDelete::dispatch($campaign);
        return redirect(route('admin.campaigns'))->with('message', 'Kampanya indirimleri silindikten sonra tamamen silinmek üzere kuyruğa alındı');
    }
}
