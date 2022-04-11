<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Favori;
use App\Models\Product\Urun;
use App\Models\Service;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FavoriController extends Controller
{
    use ResponseTrait;

    public function list(Request $request)
    {
        $favorites = Favori::with('service')
            ->where('user_id', loggedPanelUser()->id)->latest('created_at')
            ->paginate();

        return view('site.kullanici.favorites', compact('favorites'));
    }

    /**
     * @param Request $request
     * @param Service $service
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function addToFavorites(Request $request, Service $service)
    {
        $request->user('panel')->favorites()->firstOrCreate([
            'service_id' => $service->id
        ]);

        return $this->success([]);
    }

    /**
     * @param Favori $favorite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Favori $favorite)
    {
        $this->authorizeForUser(loggedPanelUser(), 'delete', $favorite);
        $favorite->delete();
        success();

        return back();
    }
}
