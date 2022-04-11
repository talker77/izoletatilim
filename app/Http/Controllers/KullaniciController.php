<?php

namespace App\Http\Controllers;

use App\Models\Auth\Role;
use App\Models\Log;
use App\Models\Package;
use App\Models\PackageUser;
use App\Repositories\Traits\CartTrait;
use App\Repositories\Traits\SepetSupportTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Cart;
use Illuminate\Validation\Rule;

class KullaniciController extends Controller
{
    use SepetSupportTrait;
    use CartTrait;

    public function __construct()
    {
//        $this->middleware('guest')->except(['logout', 'loginForm']);
    }

    public function loginForm()
    {
        if (loggedPanelUser() && loggedPanelUser()->is_admin) {
            return redirect(route('user.dashboard'));
        }
        return view('site.kullanici.login');
    }

    public function login(Request $request)
    {
        if (request()->isMethod('POST')) {
            $validatedData = $request->validate([
                'email' => 'required|min:6|email',
                'password' => 'required|min:6',
            ]);
            $user_login_data = ['email' => request('email'), 'password' => request('password'), 'role_id' => [Role::ROLE_CUSTOMER, Role::ROLE_STORE], 'is_admin' => 1, 'is_active' => 1];
            if (Auth::guard('panel')->attempt($user_login_data, $request->get('remember_me', 0))) {
                return redirect()->intended(route('user.dashboard'));
            }
            Log::addLog('hatalı kullanıcı girişi', json_encode($user_login_data), Log::TYPE_WRONG_LOGIN);
            return back()->withInput()->withErrors(['email' => 'hatalı kullanıcı adı veya şifre']);
        }
        return view('user.login');
    }

    public function logout()
    {
        auth('panel')->logout();
        request()->session()->flush();
        request()->session()->regenerate();
        return redirect(route('homeView'));
    }

    public function registerForm()
    {
        return view('site.kullanici.register');
    }

    public function register(Request $request)
    {

        $validated = $this->validate($request, [
            'name' => 'required|min:3|max:30',
            'surname' => 'required|min:3|max:30',
            'email' => 'required|min:5|max:100|email|unique:users',
            'password' => 'required|min:8|max:60|confirmed',
            'role_id' => ['required', 'numeric', Rule::in([Role::ROLE_STORE, Role::ROLE_CUSTOMER])],
        ]);

        $data = array_merge($validated, [
            'password' => Hash::make(request('password')),
            'activation_code' => Str::random(60),
            'is_active' => 1,
            'is_admin' => 1
        ]);

        $user = User::create($data);
        Auth::guard('panel')->login($user);

//        $this->dispatch(new SendUserVerificationMail($validated['email'], $user));
        if ($user->isStore()) {
            $this->addWelcomePackageToUser($user);
        }

        success();
        return redirect()->to(route('user.dashboard'));
    }

    public function activateUser($activation_code)
    {
        $user = User::where('activation_code', $activation_code)->first();
        if (!is_null($user)) {
            $user->activation_code = null;
            $user->is_active = true;
            $user->save();
            return redirect()->to('/')
                ->with('message', 'Kullanıcı kaydınız başarıyla tamamlandı')
                ->with('message_type', 'success');
        } else {
            return redirect()->to('/')
                ->with('message', 'Gönderilen doğrulama bilgisi (token) için süre dolmuş veya geçersiz token ')
                ->with('message_type', 'danger');
        }
    }

    /**
     * kullanıcıya ilk kayıt olduğunda package verir.
     * @param User $user
     */
    private function addWelcomePackageToUser(User $user)
    {
        $package = Package::orderBy('day')->first();

        PackageUser::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'started_at' => Carbon::now(),
            'expired_at' => Carbon::now()->addDays($package->day),
            'price' => 0,
            'is_payment' => true,
            'ip_address' => \request()->ip(),
            'last_price' => $package->price,
            'hash' => Str::uuid(),
            'payment_info' => json_encode([
                'package' => $package,
                'message' => 'Uye olmaya ozel paket tanimlandi.'
            ])
        ]);

        $user->update(['active_package_id' => $package->id]);
    }

}
