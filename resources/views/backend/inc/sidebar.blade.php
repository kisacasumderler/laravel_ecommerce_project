<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item active">
            <a class="nav-link" href="{{ asset('panel') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Pano</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#sliderId" aria-expanded="false"
                aria-controls="sliderId">
                <i class="ti-image menu-icon"></i>
                <span class="menu-title">Sliders</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="sliderId">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.slider.index') }}">Slider</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.slider.create') }}">Slider Ekle</a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-toggle="collapse" href="#KagegoriId" aria-expanded="false"
                aria-controls="KagegoriId">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Kategoriler</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="KagegoriId">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.category.index') }}">Kategori</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.category.create') }}">Kategori
                            Ekle</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#about" aria-expanded="false" aria-controls="about">
                <i class="ti-info-alt menu-icon"></i>
                <span class="menu-title">Hakkımızda</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="about">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.about.index') }}">Hakkımızda</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#mesajlar" aria-expanded="false" aria-controls="mesajlar">
                <i class="ti-comment menu-icon"></i>

                <span class="menu-title">Mesajlar</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="mesajlar">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.contact.index') }}">Mesajlar</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="icon-contract menu-icon"></i>
                <span class="menu-title">Site Ayarları</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('panel.setting.index') }}">Site Ayarları</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="ti-layout-grid2 menu-icon"></i>
            <span class="menu-title">Ürünler</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{ route('panel.product.index') }}"> Ürünler </a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('panel.product.create') }}"> Ürün Ekle </a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
              <i class="ti-star menu-icon"></i>
              <span class="menu-title">Kampanya</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('panel.offer.index')}}">Kampanya</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#order" aria-expanded="false" aria-controls="order">
              <i class="icon-paper menu-icon"></i>
              <span class="menu-title">Siparişler</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="order">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('panel.order.index')}}">Siparişler</a></li>
              </ul>
            </div>
          </li>
        {{--


        <li class="nav-item">
          <a class="nav-link" href="pages/documentation/documentation.html">
            <i class="icon-paper menu-icon"></i>
            <span class="menu-title">Documentation</span>
          </a>
        </li> --}}
    </ul>
</nav>
