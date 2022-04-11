<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Filters\Admin\ServiceCompanyFilter;
use App\Http\Filters\Admin\ServiceFilter;
use App\Models\Appointment;
use App\Models\Auth\Role;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\LocationType;
use App\Models\PackageUser;
use App\Models\Product\UrunFirma;
use App\Models\Region\Location;
use App\Models\Report;
use App\Models\Service;
use App\Models\ServiceAttribute;
use App\Models\ServiceComment;
use App\Models\ServiceCompany;
use App\Models\ServiceType;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
    /**
     * admin contact page list
     * @return mixed
     * @throws \Exception
     */
    public function contact()
    {
        $contacts = Contact::query();

        return Datatables::of($contacts)->make();
    }

    /**
     * admin blog page list
     * @return mixed
     * @throws \Exception
     */
    public function blog()
    {
        return Datatables::of(
            Blog::query()
        )->make();
    }

    /**
     * admin contact page list
     * @param Request $request
     * @param ServiceFilter $filter
     * @return mixed
     * @throws \Exception
     */
    public function services(Request $request, ServiceFilter $filter)
    {
        $user = $request->user();

        return Datatables::of(
            Service::with(['country', 'district', 'state', 'type'])
                ->when($user->role_id !== Role::ROLE_SUPER_ADMIN, function ($query) use ($user) {
                    $query->where('user_id', $user->id);
//                        ->where('store_type',Service::STORE_TYPE_LOCAL);
                })
                ->filter($filter)
        )->make();
    }

    /**
     * admin contact page list
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function serviceStores()
    {
        return Datatables::of(
            Service::with(['country', 'district', 'state', 'type'])
                ->where('user_id', authAdminUserId())
        )->make();
    }

    /**
     * admin contact page list
     * @return mixed
     * @throws \Exception
     */
    public function serviceAttributes()
    {
        return Datatables::of(
            ServiceAttribute::with('type')
        )->make();
    }

    public function serviceTypes()
    {
        return Datatables::of(
            ServiceType::with('parent')
        )->make();
    }

    /**
     * all locations
     * @return mixed
     * @throws \Exception
     */
    public function locations()
    {
        return Datatables::of(
            Location::with(['type', 'country:id,title', 'state:id,title', 'district:id,title'])
        )->make();
    }

    /**
     * all locations types
     * @return mixed
     * @throws \Exception
     */
    public function locationTypes()
    {
        return Datatables::of(
            LocationType::query()
        )->make();
    }

    /**
     * @param Request $request
     * @param ServiceCompanyFilter $filter
     * @return mixed
     * @throws \Exception
     */
    public function companyServices(Request $request, ServiceCompanyFilter $filter)
    {
        $user = $request->user('admin');
        return Datatables::of(
            ServiceCompany::with(['company', 'service'])
                ->filter($filter)
//                ->when($user->role_id !== Role::ROLE_SUPER_ADMIN, function ($query) use ($user) {
//                    $query->where('company_id', $user->company->id);
//                })
        )->make();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function appointments()
    {
        return Datatables::of(
            Appointment::with(['service_company', 'service_company.service'])
        )->make();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function companies()
    {
        return Datatables::of(
            UrunFirma::with(['user'])
        )->make();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function serviceComments(Request $request)
    {
        return Datatables::of(
            ServiceComment::with(['service', 'user'])
                ->when($request->get('serviceId'), function ($q, $v) {
                    $q->where('service_id', $v);
                })
                ->when(authAdminUser()->role_id !== Role::ROLE_SUPER_ADMIN, function ($query) {
                    $query->whereHas('service', function ($q) {
                        $q->where('user_id', authAdminUser()->id);
                    });
//                        ->where('store_type',Service::STORE_TYPE_LOCAL);
                })
        )->make();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function users()
    {
        return Datatables::of(
            User::with('role')
        )->make();
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function reports(Request $request)
    {
        return Datatables::of(
            Report::query()
        )->make();
    }

    /**
     * kullanıcının oluşturduğu paketler
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function packageTransactions(Request $request)
    {
        return Datatables::of(
            PackageUser::with(['package:id,title,price', 'user:name,surname,id,email'])
        )->make();
    }

}
