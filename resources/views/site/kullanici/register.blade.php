@extends('site.layouts.base')
@section('title','Kullanıcı Kayıt')
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
        .pl-20{
            padding-left: 20px;
        }
        .ml-0{
            margin-left: 0;
        }
    </style>
@endsection
@section('content')

    <section id="content">
        <div class="container">
            @include('site.layouts.partials.messages')
            <div id="main">
                <div class="text-center  box come "><h1 class="page-title yellow-color">Kayıt</h1></div>
                <p class="light-blue-color block comep text-align-center">

                    <font>Mevcut bir hesabınız varsa buradan <a href="{{ route('user.login') }}">giriş</a>
                        yapabilirsiniz </font>
                    <a href="{{ route('user.login') }}" class="stn">
                        <font>Giriş Yap</font>
                    </a>
                </p>
                <div class="col-sm-8 col-md-12 col-lg-6 no-float no-padding center-block">
                    <form class="register-form" method="POST" id="registerForm">
                        @csrf
                        <div class="row form-group">
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-10">
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                        <h4>Üyelik Tipi</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="radio-inline ml-0">
                                            <input type="radio" name="role_id" checked
                                                   value="{{ \App\Models\Auth\Role::ROLE_CUSTOMER }}"> <span class="pl-20">Bireysel</span>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="role_id" value="{{ \App\Models\Auth\Role::ROLE_STORE }}"
                                                {{ request('type') == 2 ? 'checked' : '' }}>
                                            <span class="pl-20">Kiraya Ver</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <x-site.input name="name" label="Ad*" width="3" required
                                              maxlength="30" placeholder="Adınız"
                                              class="input-text full-width"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <x-site.input name="surname" label="Soyad*" width="3" required
                                              maxlength="30" placeholder="Soyadınız"
                                              class="input-text full-width"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-12">
                                <x-site.input name="email" label="Email*" width="3" placeholder="ornek@site.com"
                                              maxlength="100" required type="email"
                                              class="input-text full-width"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <x-site.input name="password" label="Parola" width="3"
                                              maxlength="25" type="password"
                                              help-block="Parola en az 8 karakter olmalıdır."
                                              minlength="8" required
                                              class="input-text full-width"/>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <x-site.input name="password_confirmation" label="Parola Tekrar" width="3"
                                              maxlength="25" type="password"
                                              minlength="8" required
                                              class="input-text full-width"/>
                            </div>
                        </div>
                        <button type="submit" class="btn-large full-width sky-blue1">Kayıt Ol</button>
                    </form>
                </div>
            </div>


        </div>
    </section>
@endsection



