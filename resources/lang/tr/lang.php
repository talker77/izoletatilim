<?php
// Türkçe Dil Dosyası
return [
    'welcome' => 'Sitemize Hoşgeldin',
    'contact' => 'İletişim',
    'home' => 'Anasayfa',

    'an_error_occurred_during_the_process' => 'An error occurred during the process',
    'success_message' => "İşlem başarılı şekilde gerçekleşti",
    'error_message' => "İşlem sırasında bir hata oluştu",


    // Kullanıcı
    'welcome_to_app' => 'Hoşgeldin Giriş Başarılı',
    'wrong_username_or_password' => 'hatalı kullanıcı adı veya şifre kontrol ediniz',
    'please_verify_email_for_active_account' => 'kullanıcı kaydınızı aktifleştirmek için lütfen mail adresinizi kontrol ediniz ve aktivasyonu gerçekleştiriniz',
    'the_order_has_been_received_successfully' => 'Paket başarılı şekilde hesabınıza tanımlandı.',

    // Ebulten
    'congratulations_you_have_successfully_registered_for_the_newsletter' => 'Tebrikler ebültene başarılı şekilde kaydoldunuz',


    //=============== Email ===============
    'hello' => 'Merhaba',
    'order_code' => 'Sipariş Kodu',
    'order_date' => 'Sipariş Tarihi',
    'product' => 'Ürün',
    'price' => 'Fiyat',
    'status' => 'Durum',
    'qty' => 'Adet',
    'cargo_price' => 'Kargo Fiyatı',
    'total' => 'Toplam',
    'product_total' => 'Ürün Toplam',
    'total_amount' => 'Toplam Tutar',
    'coupon_total' => 'Kupon Toplam',
    'sub_total' => 'Alt Toplam',
    'coupon' => 'Kupon',
    'delivery_address' => 'Teslimat Adresi',
    'invoice_address' => 'Fatura Adresi',
    'hello_username' => 'Merhaba :username',
    'order_successfully_received' => 'siparişiniz başarılı şekilde alındı',


    // PasswordReset Notification
    'you_are_receiving_this_email_because_we_have_received' => 'Bu e-postayı, hesabınız için bir şifre sıfırlama isteği aldığımız için alıyorsunuz.',
    'reset_password' => 'Parola Sıfırla',
    'if_you_have_not_requested_a_password_reset_ignore_this_email' => 'Parola sıfırlama isteğinde bulunmadıysanız, bu maili dikkate almayınız',

    // RESERVATION STATUS
    'reservation' => [
        'status' => [
            \App\Models\Reservation::STATUS_EMAIL_ONAY_BEKLIYOR => "Email Onayı Bekliyor",
            \App\Models\Reservation::STATUS_EMAIL_ONAYLANDI => "Email Onaylandı",
            \App\Models\Reservation::STATUS_ONAY_BEKLIYOR => "Onay Bekliyor",
            \App\Models\Reservation::STATUS_ONAYLANDI => "Onaylandı",
            \App\Models\Reservation::STATUS_RED => "Red Edildi",
            \App\Models\Reservation::STATUS_IPTAL => "İptal Edildi",
            \App\Models\Reservation::STATUS_SURE_DOLDU => "Süre Doldu",
        ]
    ],

    'reservations' => [
        'reservation_created_please_verify_email' => 'Rezervasyon alındı. İşlemi doğrulamak için lütfen mail adresiniz kontrol ediniz.',
        'no_available_reservation_not_found_at_selected_times' => 'belirtilen tarihlerde uygun rezervasyon bulunamadı',
        'already_reserved_by_other_user' => ':reserved_days günleri rezerve edilmiş lütfen farklı bir tarih seçiniz.'
    ],

    'service_types' => [
        'villa-mustakil-ev' => [
            'title' => "Sizin İçin En İyi Villa / Müstakil Ev Önerileri",
            'banner_image' => "villa_1_slider.jpg",
            'sub_title' => "Bütçenize Uygun Seçenekler",
            'popular_locations' => 'Öne Çıkan Villalar',
            'parallax_text' => "Akdeniz ve Ege'nin En Güzel Villalarından, Karadeniz'in En Otantik Dağ Evlerine <em> Kadar Özel Kiralama Seçeneklerini Keşfedin </em>",
            'seo' => [
                [
                    'title' => 'En İyi Villa Deneyimi',
                    'description' => '<strong style="font-weight: 900">Sorunsuz Bir Tatil Geçirmeniz İçin Buradayız..</strong><br>
                    Kaliteli ve butik bir hizmet almak istiyorsanız seçim yaptığınız firmanın desteği sınırlı olmamalıdır. Biz tatilcilere ve kiraya verenlere anlık olarak sürekli destek vermekteyiz. Yaşanacak en küçük sorunlar bile bizler için çok önemlidir. Sorunsuz bir villa tatili için araştırma ve geliştirme süreçlerimizle tüm tesislerde gerekli işlemler yapılmaktadır. Sitemizde sizler için özenle seçilmiş birbirinden kaliteli <b>kiralık yazlık</b> çeşitlerini bulabilirsiniz. Hayalinizdeki villa da tatil yapmak için size uygun olan villalara göz atın.. <br><br>
                    İzoletatilim, "<b>villa kiralama & kiraya verme</b>" yapmak isteyen misafirlerine güvenli bir villa tatili deneyimi sunar...'
                ],
                [
                    'title' => 'Benzersiz Müstakil Evler',
                    'description' => 'İzoletatilim ile müstakil ev kiralama & kiraya verme çok daha kolay hale geliyor. Müstakil evler herkese hitap edebilmesi için geniş bir yelpazede sunuluyor. Hem konum açısından hem de özellikleri açısından farklılıklar sunan müstakil evler, sevdiklerinizle unutulmaz bir tatil yaşamanıza olanak tanıyor. <br> <br>
        En seçkin müstakil ev alternatifleri ile İzoletailim karşınıza birbirinden farklı müstakil ev seçenekleri çıkarıyor. Tatil planınızı yaparken, size sunulan fırsatları yakalayarak çok daha keyifli hale getirebilirsiniz. Müstakil ev türlerinden en az biri sizin için ideal fırsatlara sahip olacaktır.'
                ],
            ]
        ],
        'karavan' => [
            'title' => "Sizin İçin En İyi Karavan Önerileri",
            'banner_image' => "karavan_1_slider.jpg",
            'sub_title' => "Tek Başınıza veya Ailenizle Dilediğiniz Her Yerde Konaklamanızı Sağlayacak Motokaravan/Çekme Karavanları Keşfedin",
            'popular_locations' => 'Öne Çıkan Karavanlar',
            'parallax_text' => "Türkiye'nin Her Bölgesinden Kiralayabileceğiniz Karavanlar ile Kapınız Yemyeşil Bir Ormana veya Masmavi Bir Denize Açılabilir. Birbirinden Güzel Karavan İlanlarını Keşfedin",
            'parallax_image' => 'flat-lay-yellow-luggage-with-copy-space.jpg',
            'seo' => [
                [
                    'title' => 'En İyi Karavan Deneyimi',
                    'description' => "Karavan seyahati çoğumuzun hayalinde vardır. Türkiye'nin en güzel karavan rotalarına bir göz atın!
'Kendi eviniz yanınızdayken' seyahat etmenin güven ve konforu ile karavan rotaları şimdi çok daha cezbedici. Kendi karavanınızı dilediğiniz gibi dekore etme özgürlüğünüz varken lüks karavan tatilleri ile güneşin doğuşuna, kuşların melodisine şahit olmaya ne dersiniz? Karavanla tatil yapanlar önümüzdeki yıllarda seyahat trendlerinin belirleyicisi olacak."
                ],
                [
                    'title' => 'Benzersiz Çekme ve Motokaravanlar',
                    'description' => 'Türkiye’de gezilecek ve keşfedilecek birçok saklı cennet var. Bu keşifleri karavanla gerçekleştirmek istiyorsanız satın almak ya da karavan kiralama şirketleri aracılığıyla kiralamak için öncelikle nasıl bir karavana ihtiyaç duyduğunuza karar vermelisiniz. Çünkü herkes seyahat konusunda farklı standartlara sahip. Kimileri daha geniş, ferah bir alana ihtiyaç duyarken kimilerine ise daha küçük bir alan yeter. Bu doğrultuda siz de kendi standartlarınızı belirlemek adına aşağıdaki noktalara dikkat edebilirsiniz:
                    <ul>
                            <li>• Karavanın büyüklüğü</li>
                            <li>• Gücü</li>
                            <li>• İç tasarımı</li>
                            <li>• Taşıyacağı kişi kapasitesi</li>
                    </ul>
                   <p> İhtiyaçlarınızı belirledikten sonra farklı karavan modelleri hakkında bilgi sahibi olarak seçiminize netlik kazandırabilirsiniz.</p>'
                ],
            ]
        ],
        'bungalov' => [
            'title' => "Sizin İçin En İyi Bungalov Önerileri",
            'banner_image' => "bungalov.png",
            'sub_title' => "Türkiye'nin Her Yerinden 4 Mevsim Bungalovları Keşfedin",
            'popular_locations' => 'Öne Çıkan Bungalovlar',
            'parallax_text' => "Akdeniz ve Ege'nin En Güzel Bungalovlarından, Karadeniz'in En Otantik Dağ Evlerine Kadar <em>Özel Kiralama Seçeneklerini Keşfedin</em>",
            'seo' => [
                [
                    'title' => 'En İyi Bungalov Deneyimi',
                    'description' => 'Bungalovlarda konaklamaya ilgi son yıllarda artış gösterdi. Özellikle son bir yılda, izole tatil yapmak isteyenler için ideal bir konaklama çeşidi haline geldi. İlgi arttıkça bungalov çeşitleri de artmaya başladı.  Bu yazıda bungalov tatili için sana bir rehber hazırlamaya çalıştık. Bungalov tatilin tanımından kimler için uygun olduğuna; nerelerde kalabileceğinden, nelere dikkat edebileceğine kadar detaylı bilgi bulabilirsin.'
                ],
                [
                    'title' => 'Benzersiz Bungalovlar',
                    'description' => 'Antalya, Fethiye, Sapanca, Trabzon gibi Türkiye’de turizmi ile ünlü destinasyonların neredeyse tamamında bungalov tatil yapabilirsiniz. Bölgelere göre çeşitlilik gösteren bungalovlara mevsimine göre gitmenizi öneririz. <br>
Lüks bir bungalov tatili deneyimi için Alanya, Çeşme ve Bodrum civarlarındaki otelleri değerlendirebilirsiniz. Yeşillikler içerisinde, bol oksijenli bir dinlenme için Karadeniz’deki bungalovlar en ideali. İstanbul’a yakın bir yerler arıyorsanız Bolu, Şile ve Ağva’daki bungalov evlerine bakabilirsiniz.'
                ],
            ]
        ],
        'dag-evi' => [
            'title' => "Sizin İçin En İyi Dağ Evi Önerileri",
            'banner_image' => "dag-evi.png",
            'sub_title' => "Doğa ile İç İçe Olacağınız Birbirinden Güzel Dağ Evlerini Keşfedin",
            'popular_locations' => 'Öne Çıkan Dağ Evleri',
            'parallax_text' => "Şömine Başında Kış Tatilinizi Geçireceğiniz, Baharda Doğa ile İç İçe Olacağınız, Yazın Sıcaklardan Kaçıp Keyif Yapacağınız 4 Mevsim Dağ Evlerini Keşfedin",
            'seo' => [
                [
                    'title' => 'En İyi Dağ Evi Deneyimi',
                    'description' => 'Gürültüden uzak bir ortam sunan dağ evleri ücretlendirme açısından geniş bir yelpazeye sahiptir. Ödeyeceğiniz miktarı azaltmak adına farklı şehirlerde bulabileceğiniz yine dağ evlerinin havasını yaşamanıza olanak sunacak orman evleri seçeneğini de değerlendirebilirsiniz. Bu seçeneği tercih ettiğiniz zaman da doğanın keyfini çıkarabilir, sakinlikte huzur bulabilirsiniz. Tatilde konaklama biçiminizin dağ evi konseptinde olmasını istiyor ve bütçenizi kısıtlı tutmanız gerekiyorsa günlük kiralanan evleri tercih edebilirsiniz. Mis gibi hava ile temas etmenizi sağlayan bu şirin dağ evleri, doğa ile yakın bir ilişki kurmanıza vesile oluyor. Dağ evleri genelde dekorasyonları ve buz gibi günlerde içinizi ısıtacak atmosferi ile ön plana çıkıyor. Siz de farklı boyutlarda ve farklı avantajlara sahip evler arasından size hitap edebilecek olanı kolaylıkla bulabilirsiniz. Kış mevsiminin güzelliklerini bu tip evlerde birebir yaşayabilirsiniz. Yaşadığınız şehre yakın yerlerdeki dağ evleri konaklama seçeneklerini tercih edip hafta sonu gibi kısa tatil zamanlarını bile en iyi şekilde değerlendirebilirsiniz. '
                ],
                [
                    'title' => 'Benzersiz Dağ Evleri',
                    'description' => "Yeşilliğin içinde şehirden uzak bir tatili tercih ediyorsanız dikkat etmeniz gereken noktalar bulunuyor. Dağ evlerinde konaklayacağınız mevsime göre yanınızda ne getirdiğinize de özen göstermeniz gerekiyor. Adeta inzivaya çekilmenizi sağlayacak bu tatil tercihi için yanınızdaki mutlaka mevsime uygun giysiler getirmelisiniz.
Kış mevsimi dışında da ziyaret edebileceğiniz dağ evleri, sıcak günlerde doğanın ve temiz havanın tadını çıkarmanızı sağlayacak. Dağ evlerini her mevsim tercih edebileceğiniz bazı bölgeler de mevcut, bunlardan biri de Kuzey Ege. Özellikle Kazdağları'nda bulunan dağ evleri hem soğuk hem sıcak günlerde misafirlerini ağırlıyor."
                ],
            ]
        ],
        'tekne' => [
            'title' => "Sizin İçin En İyi Tekne Önerileri",
            'banner_image' => "tekne.png",
            'sub_title' => "Kısa veya Uzun Süreli Mavi Yolculuk Planınız İçin Tekneleri Keşfedin",
            'popular_locations' => 'Öne Çıkan Tekneler',
            'parallax_text' => "İstanbul, İzmir, Muğla, Antalya Hareketli Tamamen Size Özel Yelkenli Tekne ve Yat, Lüks Motorsailor, Motoryat ve Katamaran Kiralama Seçeneklerini Keşfedin ",
            'seo' => [
                [
                    'title' => 'En İyi Tekne Deneyimi',
                    'description' => 'Mavi yolculuk yapmak için tekne&yat kiralayarak birçok detayı bir arada yaşayabilirsiniz. Ulaşımı zor olan yerlere, rotasını ve özelliklerini kendiniz belirleyeceğiniz tekne turları yapabilir, dilediğiniz yerde dilediğiniz kadar kalabilirsiniz. Ailenizle ve kalabalık arkadaş grubunuzla mükemmel bir tatil deneyimi yaşayabilirsiniz. İstediğiniz şekilde seçeneklere uygun olarak deniz tatilinin tadını sevdiğiniz rotaya yelken açarak çıkarabilirsiniz. '
                ],
                [
                    'title' => 'Benzersiz Tekne ve Yatlar',
                    'description' => 'Ülkemizde görülmesi gereken o kadar çok güzellik var ki... Deniz tabanın göründüğü cam gibi sularıyla birbirinden eşsiz koyları görmeyi kim istemez? Deniz tutkunlarının vazgeçilmezi olan mini ve uzun mavi yolculuk turları, İzoletatilim.com’da bulunuyor. Uzun mavi yolculuk yat turlarıyla Türkiye’deki; hiç görmediğiniz limanları, şehirleri ve adaları gezebilirsiniz. Mavi yolculuk turları aynı zamanda tam pansiyon konseptini de içeriyor. Klimalı kabinlerde konaklayarak deniz keyfini yaşayabilir, müthiş bir manzara eşliğinde birbirinden lezzetli yemeklerin keyfini çıkartabilirsiniz.'
                ],
            ]
        ],
    ]

];
