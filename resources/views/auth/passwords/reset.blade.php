@extends('site.layouts.base')
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
    </style>
@endsection
@section('content')
    <section id="content">
        <div class="container">
            @include('site.layouts.partials.messages')
            <div id="main" class="text-align-center">
                <div class="text-center  box come "><h5 class="page-title yellow-color">Parola Sıfırlama</h5></div>

                <div class="col-sm-8 col-md-6 col-lg-5 no-float no-padding center-block">
                    <form method="POST" action="{{ route('password.request') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label for="" class="pull-left">Email</label>
                            <input id="email" type="email" class="input-text full-width {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ $email ?? old('email') }}" required autofocus placeholder="email adresiniz">
                        </div>
                        <div class="form-group">
                            <label for="" class="pull-left">Yeni Parola</label>
                            <input type="password" name="password" class="input-text input-large full-width"
                                   placeholder="Parolanızı Girin" required />
                        </div>

                        <div class="form-group ">
                            <label for="" class="pull-left">Yeni Parola Tekrar</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn-large full-width sky-blue1">Parola Güncelle</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
