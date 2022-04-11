<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Product\UrunFirma;
use App\Models\Region\Country;
use App\Models\Report;
use App\Models\Service;
use App\Models\ServiceCompany;
use App\Repositories\Interfaces\UrunFirmaInterface;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyServiceController extends Controller
{
    use ResponseTrait;

    /**
     * @var UrunFirmaInterface
     */
    private UrunFirmaInterface $companyService;

    public function __construct(UrunFirmaInterface $companyService)
    {
        $this->companyService = $companyService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.services.company.list', [
            'companies' => UrunFirma::orderBy('title')->get(),
            'countries' => Country::orderBy('title')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $data['slug'] = createSlugByModelAndTitleByModel(ServiceCompany::class, $data['title'], 0);
        $item = ServiceCompany::create($data);
        success();

        return redirect(route('admin.services.company.edit', $item->id));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail($id = 0)
    {
        $item = $id != 0 ? ServiceCompany::findOrFail($id) : new ServiceCompany();

        return view('admin.services.company.create', [
            'item' => $item,
            'companies' => $this->companyService->all()->toArray(),
            'services' => Service::select('id', 'title')->orderBy('title')->get()->toArray(),
            'count' => [
                'click' => Report::where(['type' => $item->id, 'type' => Report::TYPE_SERVICE_COMPANY])->first()
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param ServiceCompany $serviceCompany
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, ServiceCompany $serviceCompany)
    {
        $data = $request->all();
        $data['status'] = activeStatus('status');
        $data['slug'] = createSlugByModelAndTitleByModel(ServiceCompany::class, $data['title'], $serviceCompany->id);
        $serviceCompany->update($data);
        success();

        return redirect(route('admin.services.company.edit', $serviceCompany->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ServiceCompany $serviceCompany
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(ServiceCompany $serviceCompany)
    {
        $serviceCompany->delete();

        return $this->success([]);
    }


    /**
     * @param ServiceCompany $serviceCompany
     * @return mixed
     * @throws \Exception
     */
    public function appointments(ServiceCompany $serviceCompany)
    {
        return Datatables::of(
            Appointment::with(['service_company', 'service_company.service'])->where('service_company_id', $serviceCompany->id)
        )->make();
    }
}
