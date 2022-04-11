<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceTypeController extends Controller
{
    /**
     * @param ServiceType $serviceType
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ServiceType $serviceType)
    {
        return view('site.service.type.index', [
            'item' => $serviceType,
            'data' => $this->getHomeData($serviceType->id)
        ]);
    }


    /**
     * @param int $serviceTypeId
     * @return array
     */
    private function getHomeData(int $serviceTypeId)
    {
        // to do : sadece ilgili olanlar
        $data['popular'] = Service::active()->local()->orderByDesc('view_count')->withCount('active_comments')
            ->where('type_id', $serviceTypeId)
            ->take(8)->get();
        $data['last'] = Service::active()->local()->take(12)->where('type_id', $serviceTypeId)->latest()->get();
        $data['favorites'] = Favori::with('service:id,title,slug,image,state_id,district_id')
            ->select('service_id', DB::raw('count(*) as total'))
            ->groupBy('service_id')
            ->orderByDesc('total')
            ->whereHas('service', function ($query) use ($serviceTypeId) {
                $query->active()->local()->where('type_id', $serviceTypeId);
            })
            ->take(18)
            ->get();
        return $data;
    }
}
