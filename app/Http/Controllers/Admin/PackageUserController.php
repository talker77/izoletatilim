<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageUser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PackageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.packages.package-user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $id = 0)
    {
        if ($id) {
            $item = PackageUser::findOrFail($id);
            $user = $item->user;
        } else {
            $item = new PackageUser();
            $user = User::find($request->get('user'));
        }
        return view('admin.packages.package-user.create', [
            'item' => $item,
            'packages' => Package::where('status', 1)->orderBy('title')->get()->toArray(),
            'user' => $user
        ]);
    }

    /**
     * update package transcation detail
     * @param Request $request
     * @param PackageUser $packageUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PackageUser $packageUser)
    {
        $validated = $request->validate([
            'package_id' => 'required|numeric',
            'started_at' => 'required|date',
            'expired_at' => 'required|date',
        ]);
        $validated['is_payment'] = activeStatus('status');
        $packageUser->update($validated);
        success();
        return back();
    }

    /**
     * update package transcation detail
     * @param Request $request
     * @param PackageUser $packageUser
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'package_id' => 'required|numeric',
            'started_at' => 'required|date',
            'expired_at' => 'required|date|after_or_equal:started_at',
        ]);
        $package = Package::findOrFail($validated['package_id']);
        $validated = array_merge($validated, [
            'user_id' => $user->id,
            'price' => 0,
            'is_payment' => activeStatus('status'),
            'ip_address' => $request->ip(),
            'installment_count' => 0,
            'last_price' => $package->price,
            'hash' => Str::uuid(),
            'payment_info' => [
                'package' => $package->toArray(),
                'message' => 'Package Created From Admin'
            ]
        ]);
        $packageUser = PackageUser::create($validated);
        success();

        return redirect(route('admin.packages.transactions.edit',['packageUser' => $packageUser->id]));
    }
}
