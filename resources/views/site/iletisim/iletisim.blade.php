@extends('site.layouts.base')
@section('title','İletişim')
@section('content')
    <div class="page-title-container">
        <div class="container">
            <div class="page-title pull-left">
                <h2 class="entry-title">İletişim</h2>
            </div>
            <ul class="breadcrumbs pull-right">
                <li><a href="/">Anasayfa</a></li>
                <li class="active">İletişim</li>
            </ul>
        </div>
    </div>

    <section id="content">

        <div class="container">
            <div id="main">
                <div class="travelo-google-map block"></div>
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <div class="travelo-box contact-us-box">
                            <h4>Bize Ulaşın</h4>
                            <ul class="contact-address">
                                <li class="address">
                                    <i class="soap-icon-address circle"></i>
                                    <h5 class="title">Adres</h5>
                                    <p>Suadiye, Bağdat Cd. No:399,</p>
                                    <p> 34740 Kadıköy/İstanbul</p>
                                </li>
                                <li class="phone">
                                    <i class="soap-icon-phone circle"></i>
                                    <h5 class="title">Telefon</h5>
                                    <p>İş: 1-800-123-hello</p>
                                    <p>Cep: 1-800-123-hello</p>
                                </li>
                                <li class="email">
                                    <i class="soap-icon-message circle"></i>
                                    <h5 class="title">Email</h5>
                                    <p>info@izoletatilim.com</p>
                                    <p>www.izoletatilim.com</p>
                                </li>
                            </ul>
                            <ul class="social-icons full-width">
                                <li><a href="#" data-toggle="tooltip" title="Twitter"><i class="soap-icon-twitter"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" title="GooglePlus"><i class="soap-icon-googleplus"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" title="Facebook"><i class="soap-icon-facebook"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" title="Linkedin"><i class="soap-icon-linkedin"></i></a></li>
                                <li><a href="#" data-toggle="tooltip" title="Vimeo"><i class="soap-icon-vimeo"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-8 col-md-9">
                        <div class="travelo-box">
                            @include('site.layouts.partials.messages')
                            <form action="{{ route('iletisim.sendMail') }}" method="POST">
                                @csrf
                                <h4 class="box-title">Bizimle İletişime Geç!</h4>
                                <div class="alert small-box" style="display: none;"></div>
                                <div class="row form-group">
                                    <div class="col-xs-6">
                                        <label>Adınız</label>
                                        <input type="text" name="name" class="input-text full-width" required>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>Email Adresiniz</label>
                                        <input type="text" name="email" class="input-text full-width" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mesajınız</label>
                                    <textarea name="message" rows="6" class="input-text full-width" placeholder="Mesajınızı buraya giriniz" required></textarea>
                                </div>
                                <button type="submit" class="btn-large full-width">Gönder</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('footer')
    <!-- Google Map Api -->
    <script type='text/javascript' src="http://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
    <script type="text/javascript" src="/site/js/gmap3.min.js"></script>
    <!-- load page Javascript -->
    <script type="text/javascript" src="/site/js/theme-scripts.js"></script>
    <script type="text/javascript" src="/site/js/contact.js"></script>

    <script type="text/javascript">
        tjq(".travelo-google-map").gmap3({
            map: {
                options: {
                    center: [40.96477, 29.07982],
                    zoom: 12
                }
            },
            marker:{
                values: [
                    {latLng:[40.96477, 29.07982], data:"Suadiye"}

                ],
                options: {
                    draggable: false
                },
            }
        });
    </script>
@endsection
