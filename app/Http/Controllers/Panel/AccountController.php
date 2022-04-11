<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailSaveRequest;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Siparis;
use App\Repositories\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    use ResponseTrait;

    /**
     * dashboard for store role
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function dashboard()
    {
        if (loggedPanelUser()->isCustomer()) {
            return redirect(route('user.customer.dashboard'));
        }
        $reservations = Reservation::with(['service:id,title,image,slug,type_id', 'service.type'])
            ->whereHas('service', function ($query) {
                $query->where('user_id', loggedPanelUser()->id);
            })
            ->where('status', Reservation::STATUS_ONAY_BEKLIYOR)
            ->latest()->get();


        $reservationCounts = [];
        foreach ([Reservation::STATUS_ONAY_BEKLIYOR, Reservation::STATUS_RED, Reservation::STATUS_ONAYLANDI] as $status) {
            $reservationCounts[] = [
                'count' => Reservation::whereHas('service', function ($query) {
                    $query->where('user_id', loggedPanelUser()->id);
                })->where('status', $status)->count(),
                'type' => $status
            ];
        }
//        dump(loggedPanelUser()->notifications->toArray());

        return view('site.kullanici.dashboard', [
            'service_types' => ServiceType::where(['status' => true])->get(),
            'reservations' => $reservations,
            'reservationCounts' => $reservationCounts,
            'notifications' => loggedPanelUser()->notifications()->latest()->take(10)->get()
        ]);
    }

    /**
     * dashboard for customer role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboardCustomer()
    {
        $reservations = Reservation::with(['service:id,title,image,slug,type_id', 'service.type'])
            ->where('user_id', loggedPanelUser()->id)
            ->latest()->take(6)->get();

        return view('site.kullanici.dashboard_user', [
            'service_types' => ServiceType::where(['status' => true])->get(),
            'reservations' => $reservations,
            'notifications' => loggedPanelUser()->notifications()->latest()->take(10)->get()
        ]);
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userDetail()
    {
        return view('site.kullanici.userDetail', [
            'item' => loggedPanelUser()
        ]);
    }


    /**
     * @param Request $request
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:255',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = $request->user();

        if (!\Hash::check($validated['old_password'], $user->password)) {
            return back()->withErrors(__('lang.old_password_does_not_match'));
        } else {
            $request->user()->update(['password' => Hash::make($request->new_password)]);
            success(__('lang.password_successfully_updated'));

            return back();
        }
    }

    /**
     * @param UserDetailSaveRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userDetailSave(UserDetailSaveRequest $request)
    {
        $data = $request->validated();
        $data['phone_visible'] = activeStatus('phone_visible');

        if ($request->filled('password')) {
            $data['password'] = Hash::make(request('password'));
        }

        loggedPanelUser()->update($data);
        success();

        return redirect(route('user.detail'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function services(Request $request)
    {
        $user = $request->user();
        $defaultAddress = $user->default_address;
        $orders = Siparis::with('basket')->whereHas('basket', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->take(5)->get();

        return view('site.kullanici.dashboard', compact('user', 'defaultAddress', 'orders'));
    }

    /**
     *  get notification detail modal.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notification(Request $request, $id)
    {
        $notification = $request->user('panel')->notifications()->findOrFail($id);
        $notification->markAsRead();

        return view('site.kullanici.dashboard.partials.notification-modal', [
            'notification' => $notification
        ]);
    }
}
