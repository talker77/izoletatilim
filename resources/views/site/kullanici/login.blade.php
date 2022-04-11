@extends('site.layouts.base')
@section('title','Kullanıcı Giriş')
@section('header')
    <style>
        .page-title {
            font-size: 4em;
        }
        .text-align-center{
            text-align: center;
        }
        #content{
            background-color: white !important;
        }
        .yellow-color{
            color: #fdb714 !important;
        }
        .stn {
            color: #01b7f2;
        }
        .float-left{
            float: left;
        }
    </style>
@endsection
@section('content')

    <section id="content">
        <div class="container">
            @include('site.layouts.partials.messages')
            <div id="main" class="text-align-center">
                <div class="text-center  box come "><h1 class="page-title yellow-color">Giris Yap!</h1></div>
                <p class="light-blue-color block comep">

                    <font>Hesabınız yoksa buradan yeni hesap oluşturabilirsiniz. </font>
                    <a href="{{ route('user.register') }}" class="stn">
                        <font>Kayıt Ol</font>
                    </a>
                </p>
                <div class="col-sm-8 col-md-6 col-lg-5 no-float no-padding center-block">
                    <form class="login-form" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="input-text full-width" placeholder="E-posta" value="{{ old('email',config('admin.store_email')) }}" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="input-text input-large full-width" placeholder="Parolanızı Girin" required value="{{ config('admin.store_password') }}">
                        </div>

                        <div class="form-group ">
                            <label class="checkbox float-left">
                                <input type="checkbox" value="" name="remember_me">beni hatırla
                            </label>

                        </div>
                        <button type="submit" class="btn-large full-width sky-blue1">Giriş Yap</button>
                        <label class=" float-left mt-4">
                            <a href="{{ route('password.request') }}">Şifremi Unuttum</a>
                        </label>
                    </form>
                </div>
            </div>


        </div>
    </section>
@endsection
@section('footer')
{{--    <script>--}}
{{--        $("body").removeAttr('class').addClass('soap-login-page')--}}
{{--    </script>--}}
@endsection


