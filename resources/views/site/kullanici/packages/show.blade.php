@extends('site.layouts.base')
@section('title','Paketlerim')
@section('header')
    <link rel="stylesheet" href="/site/css/packages.css">
    <style>
        .snip1214 .plan {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">@lang('panel.navbar.packages')</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">@lang('panel.navbar.packages')</li>
            </ul>
        </div>
    </div>
    <section id="content" class="gray-area">
        <div class="container">
            <div id="main">
                <div class="tab-container full-width-style arrow-left dashboard">
                    @include('site.kullanici.partials.myAccountLeftSidebar')
                    <div class="tab-content">
                        <div id="dashboard" class="tab-pane fade in active">
                            @include('site.layouts.partials.messages')
                            <h1 class="no-margin skin-color">@lang('panel.buy_package')</h1>
                            <br/>
                            <form action="{{ route('user.packages.create',['package' => $package->id]) }}" method="post" style="width: 100% !important;" id="paymentForm">
                                <div class="col-md-8">

                                    <input type="hidden" id="taksit_sayisi" name="installment_count" value="1">
                                    @csrf
                                    <div class="form-group">
                                        <label for="kartno">Kredi Kartı Numarası</label>
                                        <input type="text" class="form-control kredikarti" id="kartno" name="cardNumber"
                                               onchange="getInstallmentDetails({{ $package->price }})"
                                               style="font-size:20px;" required value="5890040000000016">
                                    </div>
                                    <div class="form-group">
                                        <label for="holderName">Kart Üzerindeki İsim</label>
                                        <input type="text" class="form-control" id="holderName" name="holderName"
                                               value="Murat 9Haziran2021"
                                               style="font-size:20px;" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cardexpiredatemonth">Son Kullanma Tarihi</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                Ay
                                                <select name="cardExpireDateMonth" id="cardexpiredatemonth" class="form-control" required>
                                                    @foreach (range(1, 12) as $number)
                                                        <option {{ $number == 12 ? 'selected': '' }}>{{$number}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                Yıl
                                                <select name="cardExpireDateYear" class="form-control" required>
                                                    @foreach (range(2020, 2050) as $number)
                                                        <option {{ $number == 2030 ? 'selected': '' }}>{{$number}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                CVV (Güvenlik Numarası)
                                                <input type="text" class="form-control kredikarti_cvv" name="cvv" id="cardcvv2" value="123" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="new-checkout-address" class="">
                                        <h2 class="step-title">Fatura Adresi:</h2>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group required-field">
                                                            <label for="acc-name">Adres İsmi</label>
                                                            <input type="text" class="form-control" name="title" id="title" placeholder="Örnek : Evim" value="{{ old('title') }}">
                                                        </div><!-- End .form-group -->
                                                    </div><!-- End .col-md-4 -->
                                                    <div class="col-md-4">
                                                        <div class="form-group required-field">
                                                            <label for="acc-name">Adınız</label>
                                                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name',$loggedUser->name) }}">
                                                        </div><!-- End .form-group -->
                                                    </div><!-- End .col-md-4 -->

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="acc-mname">Soyadınız</label>
                                                            <input type="text" class="form-control" name="surname" id="surname" value="{{ old('surname',$loggedUser->surname) }}">
                                                        </div><!-- End .form-group -->
                                                    </div>


                                                    <div class="col-md-4">
                                                        <label>İl</label>
                                                        <div class="select-custom">
                                                            <select class="form-control" name="state_id" id="city" onchange="citySelectOnChange(this)">
                                                                <option value="">Seçiniz</option>
                                                                @foreach($states as $city)
                                                                    <option value="{{$city->id}}">{{$city->title}}</option>
                                                                @endforeach
                                                            </select>

                                                        </div><!-- End .select-custom -->
                                                    </div><!-- End .form-group -->
                                                    <div class="col-md-4">
                                                        <label>ilçe</label>
                                                        <div class="select-custom">
                                                            <select class="form-control" name="district_id" id="district">
                                                                <option value="">Seçiniz</option>
                                                            </select>
                                                        </div><!-- End .select-custom -->
                                                    </div><!-- End .form-group -->
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="acc-email">Email</label>
                                                            <input type="text" class="form-control" name="email" id="email" value="{{ old('email',$loggedUser->email) }}">
                                                        </div><!-- End .form-group -->
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label>Adres </label>
                                                        <textarea type="text" class="form-control" name="address" id="address">{{ old('address') }}</textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Telefon </label>
                                                        <div class="form-control-tooltip">
                                                            <input type="tel" class="form-control" id="phone" name="phone" maxlength="10" placeholder="5xx....." value="{{ old('phone',$loggedUser->phone) }}">
                                                        </div><!-- End .form-control-tooltip -->
                                                    </div>


                                                </div><!-- End .row -->

                                            </div><!-- End .col-sm-11 -->
                                        </div>
                                    </div>
                                    <div class="form-group-custom-control">
                                        <div class="custom-control custom-checkbox">
                                            <input name="checkoutTerms" type="checkbox" id="checkoutTerms" class="custom-control-input" checked required>
                                            <label for="inputSozlesme" class="custom-control-label">
                                                <a style="text-decoration: underline" data-toggle="collapse" href="#onBilgilendirmeFormu" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                    Ön bilgilendirme formunu</a> okudum ve kabul ediyorum
                                            </label>
                                            <div class="collapse" id="onBilgilendirmeFormu">
                                                <div class="card card-body DivWithScroll">
                                                    @include('site.sozlesmeler.onBilgilendirmeFormu')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-custom-control">
                                        <div class="custom-control custom-checkbox">
                                            <input id="inputMesafeliSatis" type="checkbox" class="custom-control-input" checked required name="distanceSellingContract">
                                            <label class="custom-control-label" for="inputMesafeliSatis"><a style="text-decoration: underline" data-toggle="collapse" href="#mesafeliSatisSozlesmesi" role="button" aria-expanded="false"
                                                                                                            aria-controls="collapseExample">Mesafeli satış sözleşmesini</a> okudum ve kabul ediyorum.</label>
                                        </div>
                                        <div class="collapse" id="mesafeliSatisSozlesmesi">
                                            <div class="card card-body DivWithScroll">
                                                @include('site.sozlesmeler.satisSozlesmesi')
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success" name="signup1" value="Sign up">Siparişi Tamamla</button>

                                </div>
                                <div class="col-md-4">
                                    <div>
                                        <div class="checkout-info-box" style="display: none" id="taksitContainer">
                                            <label for="installemnt">Taksit Bilgileri <span
                                                    class="spBankName"> -</span></label>
                                            <table class="table" id="iyzico_installment">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Taksit Tutarı</th>
                                                    <th scope="col">Taksit Sayısı</th>
                                                    <th scope="col">Toplam Tutar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="snip1214">
                                        <div class="plan {{ $currentPackageId == $package->id ? 'featured' : '' }}">
                                            <h3 class="plan-title">
                                                Toplam Tutar
                                            </h3>
                                            <div class="plan-cost">
                                                <span class="plan-price">{{ $package->price }} ₺</span>
                                                <span class="plan-type">/ {{ $package->day }} Gün</span>
                                            </div>
                                            <ul class="plan-features">
                                                <li><b>Paket Adı :</b> {{ $package->title }}</li>
                                                <li><b>Geçerlilik Süresi : </b>{{ $package->day }} Gün</li>
                                                <li><b>İlan Sayısı :</b> Sınırsız</li>
                                                <li>
                                                    @if ($currentPackage)
                                                        <b>"{{ $currentPackage->package->title }}"</b> paketinde  kalan gün sayısı ({{ $currentPackage->remaining_day }} Gün)  satın alacağınız paketin gün sayısı üzerine eklenecektir.
                                                    @else
                                                        aktif paket yok
                                                    @endif
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer')
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script src="/js/pages/panel/panel.packages.show.js"></script>
    <script src="/js/pages/app.odeme-adres.js"></script>
    <script>
        $('.kredikarti').mask('0000-0000-0000-0000', {placeholder: "____-____-____-____"});
        $('.kredikarti_cvv').mask('000', {placeholder: "___"});
        $('.telefon').mask('(000) 000-00-00', {placeholder: "(___) ___-__-__"});
    </script>
@endsection
