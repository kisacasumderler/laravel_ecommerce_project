<footer class="site-footer border-top bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h3 class="footer-heading mb-4">Kurumsal</h3>
                <a href="#" class="block-6">Hakkımızda</a>
                <a href="#" class="block-6">Banka Hesaplarımız</a>
                <a href="#" class="block-6">Havale Bildirim Formu</a>
                <a href="#" class="block-6">Kargom Nerede?</a>
                <a href="#" class="block-6">İletişim</a>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h3 class="footer-heading mb-4">Üyelik & Hizmetler</h3>
                <a href="" class="block-6">Giriş Yap</a>
                <a href="" class="block-6">Yeni Üye Ol</a>
                <a href="" class="block-6">Sık Sorulan sorular</a>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                <h3 class="footer-heading mb-4">Sözleşmeler</h3>
                <a href="" class="block-6">Üyelik Sözleşmesi</a>
                <a href="" class="block-6">Kullanım Koşulları</a>
                <a href="" class="block-6">Gizlilik Sözleşmesi</a>
                <a href="" class="block-6">Mesafeli Satış sözleşmesi</a>
                <a href="" class="block-6">Teslimat</a>
                <a href="" class="block-6">İptal & İade & Değişim</a>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="block-5 mb-5">
                    <h3 class="footer-heading mb-4">İletişim</h3>
                    <ul class="list-unstyled">
                        <li class="address">{!!$settings['address']!!}</li>
                        <li class="phone"><a href="tel://{{str_replace(' ','',$settings['phone'])}}">{{$settings['phone']}}</a></li>
                        <li class="email">{{$settings['email']}}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
            <div class="col-md-12">
                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy; {{ date('Y') }} | {{ config('app.name') }} Tüm hakları saklıdır
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </div>

        </div>
    </div>
</footer>
