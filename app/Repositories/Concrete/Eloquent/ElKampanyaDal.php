<?php namespace App\Repositories\Concrete\Eloquent;

use App\Jobs\UpdateCompanyProductDiscountPriceByCategory;
use App\Models\Kampanya;
use App\Models\KampanyaKategori;
use App\Models\KampanyaMarka;
use App\Models\KampanyaUrun;
use App\Models\Kategori;
use App\Models\KategoriUrun;
use App\Models\Product\Urun;
use App\Models\Product\UrunAttribute;
use App\Models\Product\UrunDetail;
use App\Models\Product\UrunInfo;
use App\Models\Product\UrunMarka;
use App\Models\Product\UrunSubAttribute;
use App\Models\Product\UrunSubDetail;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use Illuminate\Support\Facades\Cache;

class ElKampanyaDal implements KampanyaInterface
{

    protected $model;
    private $_productService;

    public function __construct(Kampanya $model, UrunlerInterface $productService)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
        $this->_productService = $productService;
    }

    public function all($filter = null, $columns = array("*"), $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = array("*"), $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem);
    }

    public function getById($id, $columns = array('*'), $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = array('*'), $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $this->model->update($data, $id);
        return $this->getById($id, null, ['campaignProducts', 'campaignCategories']);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }


    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }




    public function getCampaignDetail($slug, $order = null, $selectedSubAttributeList = null, $category = null, $brandIdList = null)
    {
        $filteredProductIdList = $this->_productService->filterProductsFilterBySelectedSubAttributeIdList($selectedSubAttributeList);
        $campaign = Kampanya::with(['campaignProducts', 'campaignCategories.getProducts'])->where(['slug' => $slug, 'active' => 1])->firstOrFail();
        $campaignProductsIdList = KampanyaUrun::select('product_id')->where('campaign_id', $campaign->id)->pluck('product_id');
        $campaignCategoryProductsIdList = KategoriUrun::select('product_id')->whereIn('category_id', $campaign->campaignCategories->pluck('id'))->distinct('product_id')->pluck('product_id');
        $companyProductIdList = UrunInfo::select('product_id')->whereIn('company_id', $campaign->campaignCompanies->pluck('id'))->distinct('product_id')->pluck('product_id');
        $newProductIdList = collect([$campaignProductsIdList, $campaignCategoryProductsIdList, $companyProductIdList])->collapse();
        if (!is_null($filteredProductIdList)) {
            $newProductIdList = array_diff($newProductIdList->toArray(), array_diff($newProductIdList->toArray(), $filteredProductIdList));
        }
        $newProductIdList = array_unique((!is_array($newProductIdList) ? $newProductIdList->toArray() : $newProductIdList));
        $campaignProducts = Urun::with('detail')->whereIn('id', $newProductIdList)->whereHas('categories', function ($query) use ($category) {
            $category = Kategori::whereSlug($category)->first();
            if (!is_null($category)) {
                return $query->where('category_id', $category->id);
            }
        })->when(!is_null($brandIdList), function ($q) use ($brandIdList) {
            $q->whereHas('info', function ($query) use ($brandIdList) {
                $query->whereIn('brand_id', $brandIdList);
            });
        })->select('title', 'price', 'image', 'id', 'slug', 'discount_price')->orderBy(Urun::getProductOrderType($order)[0], Urun::getProductOrderType($order)[1]);
        $newProductIdList = $campaignProducts->pluck('id');
        $productTotalCount = Urun::whereIn('id', $newProductIdList)->select('id')->count();
        $totalPage = ceil($productTotalCount / Urun::PER_PAGE);
        $subAttributeIdList = UrunSubDetail::select('sub_attribute')->whereHas('parentDetail', function ($query) use ($newProductIdList) {
            $query->whereIn('product', $newProductIdList);
        })->pluck('sub_attribute')->toArray();
        $attributeIdList = UrunAttribute::getActiveAttributesWithSubAttributesCache()->whereIn('id', UrunDetail::whereIn('product', $newProductIdList)->pluck('parent_attribute')->toArray())->pluck('id')->toArray();
        $returnedSubAttributes = UrunSubAttribute::getActiveSubAttributesCache()->whereIn('id', $subAttributeIdList)->whereIn('parent_attribute', $attributeIdList)->pluck('id')->toArray();
        $productDetails = UrunDetail::select('parent_attribute', 'id')->with('subDetails')->whereIn('product', $newProductIdList);
        $attributesIdList = $productDetails->pluck("parent_attribute");
        $attributes = UrunAttribute::getActiveAttributesWithSubAttributesCache()->find($attributesIdList);
        $subAttributesIdList = UrunSubDetail::select('sub_attribute')->whereIn('parent_detail', $productDetails->pluck('id'))->pluck('sub_attribute');
        $subAttributes = UrunSubAttribute::getActiveSubAttributesCache()->find($subAttributesIdList);
        $brandIdList = UrunInfo::select('brand_id')->whereNotNull('brand_id')->whereIn('product_id', $newProductIdList)->distinct('brand_id')->get()->pluck('brand_id')->toArray();
        $brands = array_values(UrunMarka::getActiveBrandsCache()->find($brandIdList)->toArray());
        return [
            'products' => $campaignProducts->simplePaginate(),
            'brands' => $brands,
            'totalPage' => $totalPage != 0 ? $totalPage : 1,
            'productTotalCount' => $productTotalCount,
            'campaign' => $campaign,
            'attributes' => $attributes,
            'subAttributes' => $subAttributes,
            'categories' => $campaign->campaignCategories,
            'returnedSubAttributes' => $returnedSubAttributes,
            'filterSideBarAttr' => $attributeIdList
        ];
    }


    public function getLatestActiveCampaigns($qty)
    {
        $cache = Cache::get("cacheLatestActiveCampaigns{$qty}");
        if (is_null($cache))
            $cache = Cache::remember("cacheLatestActiveCampaigns{$qty}", 24 * 60, function () {
                return Kampanya::select('title', 'slug', 'image')->whereActive(1)->get();
            });
        return $cache;
    }
}
