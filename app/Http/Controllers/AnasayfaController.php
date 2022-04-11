<?php

namespace App\Http\Controllers;


use App\Models\Ayar;
use App\Models\Banner;
use App\Models\Kategori;
use App\Models\LocationType;
use App\Models\Product\Urun;
use App\Models\Region\Location;
use App\Models\Sepet;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\SSS;
use App\Models\Vehicles\AracMarka;
use App\Repositories\Interfaces\KampanyaInterface;
use App\Repositories\Interfaces\UrunlerInterface;
use App\Repositories\Traits\SepetSupportTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

class AnasayfaController extends Controller
{
    use SepetSupportTrait;


    public function index()
    {

        return view("site.index", [
            'types' => ServiceType::where(['status' => 1])->get(),
            'locations' => Location::latest()->where('status', 1)->take(12)->get(),
            'local_services' => Service::withCount('active_comments')->where(['status' => 1, 'store_type' => Service::STORE_TYPE_LOCAL])->take(12)->latest()->get(),
        ]);
    }

    /**
     * hakkımızda sayfası
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about()
    {
        $sss = SSS::where(['lang' => curLangId(), 'active' => 1])->orderByDesc('id')->get();
        return view('site.main.about', compact('sss'));
    }

    public function sitemap()
    {
        $products = Urun::orderBy('id', 'DESC')->take(1000)->get();
        $categories = Kategori::orderBy('id', 'DESC')->take(1000)->get();
        $now = Carbon::now()->toAtomString();
        $content = view('site.sitemap', compact('products', 'now', 'categories'));
        return response($content)->header('Content-Type', 'application/xml');
    }

    public function setLanguage(Request $request, $locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        $lang = Ayar::getLanguageIdByShortName($locale);
        session()->put('lang_id', $lang);
        session()->put('currency_id', Ayar::getCurrencyId());
        session()->put('product_price_currency_field', Ayar::getCurrencyProductPriceFieldByLang($lang));
        if ($request->user()) {
            $this->matchSessionCartWithBasketItems(Sepet::getCurrentBasket());
            $request->user()->update(['locale' => Ayar::languages()[$lang][3]]);
        }

        return back();
    }



    /**
     *  statik sayfalar için kullanılır.
     * @param $name
     */
    public function page($page)
    {
        if (!View::exists("site.static." . $page)){
            abort(404);
        }
        return view("site.static." . $page);
    }
}
