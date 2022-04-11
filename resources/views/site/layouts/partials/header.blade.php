<header id="header" class="navbar-static-top base-header">
    <div class="topnav hidden-xs">
        <div class="container">
            <ul class="quick-menu pull-left">
                <li><a href="{{ route('page.static',['page' => 'gizlilik-politikasi']) }}">Çerez Politikası</a></li>
                <li><a href="{{ route('page.static',['page' => 'nasil-calisir']) }}">Nasıl Çalışır ?</a></li>
            </ul>
            <ul class="quick-menu pull-right">
                @auth('panel')
                    <li><a href="{{ route('user.dashboard') }}">{{ loggedPanelUser()->full_name }} ({{ loggedPanelUser()->unreadNotifications->count() }})</a></li>
                @else
                    <li><a href="{{ route('user.login') }}">Üye ol / Giriş</a></li>
                    <li><a href="{{ route('user.register',['type' => \App\Models\Auth\Role::ROLE_STORE]) }}">Kiraya Ver</a></li>
                @endauth


                {{--                <li><a href="#travelo-login" class="soap-popupbox">Gi</a></li>--}}
                {{--                <li><a href="#travelo-signup" class="soap-popupbox">SIGNUP</a></li>--}}
            </ul>
        </div>
    </div>

    <div class="main-header">

        <a href="#mobile-menu-01" data-toggle="collapse" class="mobile-menu-toggle">
            Mobile Menu Toggle
        </a>

        <div class="container">
            <h1 class="logo navbar-brand">
                <a href="/" title="{{ $site->title }} logo">
                    <img src="/site/images/logo/logo2.png" alt="{{ $site->title }} logo" width="250" height="57"/>
                </a>
            </h1>

            <nav id="main-menu" role="navigation">
                <ul class="menu">
                    <li class="menu-item">
                        <a href="{{ route('services.types.index',['serviceType' => 'villa-mustakil-ev']) }}">Villa</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('services.types.index',['serviceType' => 'bungalov']) }}">Bungalov</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('services.types.index',['serviceType' => 'dag-evi']) }}">Dağ Evi</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('services.types.index',['serviceType' => 'tekne']) }}">Tekne</a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('services.types.index',['serviceType' => 'karavan']) }}">Karavan</a>
                    </li>
                    <li class="menu-item">
                        <a class="sp-hire" href="{{ route('locations') }}">Bölgeler</a>
                    </li>
                </ul>
            </nav>
        </div>

        <nav id="mobile-menu-01" class="mobile-menu collapse">
            <ul id="mobile-primary-menu" class="menu">
                <li class="menu-item">
                    <a href="/">Anasayfa</a>
                    <a href="{{ route('locations') }}">Bölgeler</a>
                    <a href="{{ route('locations') }}">Bölgeler</a>
                    <a href="{{ route('locations') }}">Destek</a>
                    <a href="{{ route('iletisim') }}">İletişim</a>
                </li>
            </ul>
            <ul class="mobile-topnav container">
                @if(loggedPanelUser())
                    <li><a href="#">{{ loggedPanelUser()->full_name }}</a></li>
                    <li class="pull-right">
                        <form action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Çıkış</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('user.login') }}">Giriş Yap</a></li>
                    <li><a href="{{ route('user.register') }}">Kiraya Ver</a></li>
                @endif

            </ul>

        </nav>
    </div>
    <div id="travelo-signup" class="travelo-signup-box travelo-box">
        <div class="login-social">
            <a href="#" class="button login-facebook"><i class="soap-icon-facebook"></i>Login with Facebook</a>
            <a href="#" class="button login-googleplus"><i class="soap-icon-googleplus"></i>Login with Google+</a>
        </div>
        <div class="seperator"><label>OR</label></div>
        <div class="simple-signup">
            <div class="text-center signup-email-section">
                <a href="#" class="signup-email"><i class="soap-icon-letter"></i>Sign up with Email</a>
            </div>
            <p class="description">By signing up, I agree to Travelo's Terms of Service, Privacy Policy, Guest Refund
                olicy, and Host Guarantee Terms.</p>
        </div>
        <div class="email-signup">
            <form>
                <div class="form-group">
                    <input type="text" class="input-text full-width" placeholder="first name">
                </div>
                <div class="form-group">
                    <input type="text" class="input-text full-width" placeholder="last name">
                </div>
                <div class="form-group">
                    <input type="text" class="input-text full-width" placeholder="email address">
                </div>
                <div class="form-group">
                    <input type="password" class="input-text full-width" placeholder="password">
                </div>
                <div class="form-group">
                    <input type="password" class="input-text full-width" placeholder="confirm password">
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Tell me about Travelo news
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <p class="description">By signing up, I agree to Travelo's Terms of Service, Privacy Policy, Guest
                        Refund Policy, and Host Guarantee Terms.</p>
                </div>
                <button type="submit" class="full-width btn-medium">SIGNUP</button>
            </form>
        </div>
        <div class="seperator"></div>
        <p>Already a Travelo member? <a href="#travelo-login" class="goto-login soap-popupbox">Login</a></p>
    </div>
    <div id="travelo-login" class="travelo-login-box travelo-box">
        <div class="login-social text-center">
            <img src="http://izoletatilim.com/images/logo2.png">
        </div>
        <div class="seperator"><label>Giriş</label></div>
        <form>
            <div class="form-group">
                <input type="text" class="input-text full-width" placeholder="email address">
            </div>
            <div class="form-group">
                <input type="password" class="input-text full-width" placeholder="password">
            </div>
            <div class="form-group">
                <a href="#" class="forgot-password pull-right">Parolamı Unuttum</a>
                <div class="checkbox checkbox-inline">
                    <label>
                        <input type="checkbox"> Beni Hatırla
                    </label>
                </div>
            </div>
        </form>
        <div class="seperator"></div>
        <p>Don't have an account? <a href="#travelo-signup" class="goto-signup soap-popupbox">Sign up</a></p>
    </div>
</header>
