@extends('site.layouts.base')
@section('title','Kullanıcı Detay')
@section('header')
    <style>
        .form-container div {
            padding-top: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">Profil</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">Profil</li>
            </ul>
        </div>
    </div>
    <section id="content" class="gray-area">
        <div class="container">
            <div id="main">
                <div class="tab-container full-width-style arrow-left dashboard">
                    @include('site.kullanici.partials.myAccountLeftSidebar')
                    <div class="tab-content">
                        <div id="settings" class="tab-pane fade in active">
                            <h2>Hesap Ayarları</h2>
                            @include('site.layouts.partials.messages')
                            <h5 class="skin-color">Genel</h5>
                            <form action="{{ route('user.detail.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row form-group form-container">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <x-site.input name="name" label="Ad*" width="3"
                                                      :value="$item->name" maxlength="30"
                                                      class="input-text full-width"/>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <x-site.input name="surname" label="Soyad*" width="3"
                                                      :value="$item->surname" maxlength="30"
                                                      class="input-text full-width"/>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <x-site.input name="phone" label="Telefon" width="3"
                                                      :value="$item->phone" maxlength="30" placeholder="5__ ___ ____"
                                                      class="input-text full-width"/>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <x-site.input label="Email" width="3" name="email"
                                                      :value="$item->email" disabled
                                                      class="input-text full-width"/>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <x-site.input name="nickname" label="Görünen İsim" width="4"
                                                      :value="$item->nickname" maxlength="30" placeholder="Sitede gözükecek olan isminiz"
                                                      class="input-text full-width"/>
                                    </div>
                                    @if(loggedPanelUser()->isStore())
                                        <div class="col-xs-12 col-sm-6 col-md-5">
                                            <x-site.input name="phone_visible" type="checkbox" label="Telefon Numarası gözüksün mü ?"
                                                          width="1" :value="$item->phone_visible" class="minimal"/>
                                        </div>
                                    @endif
                                </div>
                                <h5 class="skin-color">Parola</h5>
                                <div class="row form-group">
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <x-site.input name="password" label="Parola" width="3"
                                                      maxlength="60" type="password"
                                                      autocomplete="off"
                                                      help-block="Parola en az 8 karakter olmalıdır."
                                                      class="input-text full-width"/>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-3">
                                        <x-site.input name="password_confirmation" label="Parola Tekrar" width="3"
                                                      maxlength="60" type="password"
                                                      autocomplete="off"
                                                      class="input-text full-width"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-medium">Güncelle</button>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script>
        $("#change-pass-checkbox").click(function () {
            console.log(this);
            if ($(this).prop('checked')) {
                $("#password,#password_confirm").attr('required', 'true')
            } else {
                $("#password,#password_confirm").removeAttr('required')
            }
        })
    </script>
@endsection
