<footer id="footer">
    <div class="footer-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <h2>Kurumsal</h2>
                    <ul class="discover triangle hover row">
                        <li class="col-xs-6"><a href="{{ route('page.static',['page' => 'nasil-calisir']) }}">Nasıl Çalışır ?</a></li>

                        <li class="col-xs-6"><a href="{{ route('user.register') }}">Üye Ol</a></li>
                        <li class="col-xs-6"><a href="{{ route('page.static',['page' => 'hakkimizda']) }}">Hakkımızda</a></li>
                        <li class="col-xs-6"><a href="{{ route('user.login') }}">Giriş Yap</a></li>

                        <li class="col-xs-6"><a href="/iletisim">İletişim</a></li>
                        <li class="col-xs-6"><a href="{{ route('page.static',['page' => 'gizlilik-politikasi']) }}">Gizlilik</a></li>
                        <li class="col-xs-6"><a href="{{ route('page.static',['page' => 'hizmet-sartlari']) }}">Hizmet Şartları</a></li>
                        <li class="col-xs-6"><a href="{{ route('page.static',['page' => 'kurallar']) }}">Kurallar</a></li>
                    </ul>
                </div>
                <div class="col-sm-9 col-md-6">
                    <h2>Keşfet</h2>
                    <ul class="discover triangle hover row">
                        <li class="col-xs-6"><a href="#">HAVUZLU VİLLA KİRALAMA</a></li>
                        <li class="col-xs-6"><a href="#">DAĞ EVİ KİRALAMA</a></li>
                        <li class="col-xs-6"><a href="#">ÇİFTLİK BUNGALOW  KİRALAMA</a></li>
                        <li class="col-xs-6"><a href="#">MOTORYAT KİRALAMA</a></li>
                        <li class="col-xs-6"><a href="#">YELKENLİ KİRALAMA</a></li>
                        <li class="col-xs-6"><a href="#">MOTOKARAVAN KİRALAMA</a></li>
                        <li class="col-xs-6"><a href="#">4X4 CAMPERVAN KİRALAMA</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h2>Hakkımızda</h2>
                    <p>Nunc cursus libero purus ac congue arcu cursus ut sed vitae pulvinar massaidp nequetiam lore elerisque.</p>
                    <br />
                    <address class="contact-details">
                        <span class="contact-phone"><i class="soap-icon-phone"></i> 1-800-123-HELLO</span>
                        <br />
                        <a href="#" class="contact-email">info@izoletatilim.com</a>
                    </address>
                    <ul class="social-icons clearfix">
                        <li class="twitter"><a title="twitter" href="#" data-toggle="tooltip"><i class="soap-icon-twitter"></i></a></li>
                        <li class="googleplus"><a title="googleplus" href="#" data-toggle="tooltip"><i class="soap-icon-googleplus"></i></a></li>
                        <li class="facebook"><a title="facebook" href="#" data-toggle="tooltip"><i class="soap-icon-facebook"></i></a></li>
                        <li class="linkedin"><a title="linkedin" href="#" data-toggle="tooltip"><i class="soap-icon-linkedin"></i></a></li>
                        <li class="vimeo"><a title="vimeo" href="#" data-toggle="tooltip"><i class="soap-icon-vimeo"></i></a></li>
                        <li class="dribble"><a title="dribble" href="#" data-toggle="tooltip"><i class="soap-icon-dribble"></i></a></li>
                        <li class="flickr"><a title="flickr" href="#" data-toggle="tooltip"><i class="soap-icon-flickr"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom gray-area">
        <div class="container">
            <div class="logo pull-left">
                <a href="/" title="İzole Tatil">
                    <img src="/site/images/logo/logo2.png" alt="{{ $site->title }}" height="57" />
                </a>
            </div>
            <div class="pull-right">
                <a id="back-to-top" href="#" class="animated" data-animation-type="bounce"><i class="soap-icon-longarrow-up circle"></i></a>
            </div>
            <div class="copyright pull-right">
                <p>&copy; 2020 izoletatilim.com</p>
            </div>
        </div>
    </div>
</footer>
