<nav class="navbar navbar-expand-xl shadow fixed-top px-3 bg-white">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img class="navbar-brand" src="{{ asset('image/icon.png') }}" alt="{{ config('app.name', 'Laravel') }}" style="height: 50px;">
        <h4 class="fw-bolder text-green-primary d-sm-block d-none ms-1">
            PPID BAZNAS JABAR
        </h4>
      </a>
      <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-content">
        <div class="hamburger-toggle">
          <div class="hamburger">
            <span class="navbar-toggler-icon"></span>
          </div>
        </div>
      </button>
      <div class="collapse navbar-collapse" id="navbar-content">
        <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
          
        </ul>
        @php
            $nowUrl = Request::url();
        @endphp
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    PPID Baznas Jabar
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item {{ Request::is('profile') ? 'bg-green-primary' : '' }}" href="/profile">
                        Profile
                    </a>
                    <a class="dropdown-item {{ Request::is('visi-misi') ? 'bg-green-primary' : '' }}" href="/visi-misi">
                        Visi Misi
                    </a>
                    <a class="dropdown-item {{ Request::is('tugas-fungsi') ? 'bg-green-primary' : '' }}" href="/tugas-fungsi">
                        Tugas dan Fungsi
                    </a>
                    <a class="dropdown-item {{ Request::is('struktur-organisasi') ? 'bg-green-primary' : '' }}" href="/struktur-organisasi">
                        Struktur PPID
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Layanan Informasi</a>
                <ul class="dropdown-menu shadow">
                    <li class="dropend">
                        <a href="#" class="dropdown-item dropdown-toggle me-2" data-bs-toggle="dropdown">Formulir</a>
                        <ul class="dropdown-menu shadow" id="formulirNavList">
                        </ul>
                    </li>
                    <li id="ListLayananNavDivider"><hr class="dropdown-divider"></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Informasi Publik
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item {{ Request::is('informasi-publik/berkala') ? 'bg-green-primary' : '' }}" href="/informasi-publik/berkala">
                        Informasi Berkala
                    </a>
                    <a class="dropdown-item {{ Request::is('informasi-publik/serta-merta') ? 'bg-green-primary' : '' }}" href="/informasi-publik/serta-merta">
                        Informasi Serta Merta
                    </a>
                    <a class="dropdown-item {{ Request::is('informasi-publik/setiap-saat') ? 'bg-green-primary' : '' }}" href="/informasi-publik/setiap-saat">
                        Informasi Setiap Saat
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Regulasi
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" id="regulasiNavList">
                </div>
            </li>

            {{-- tender --}}
            <li class="nav-item">
                <a class="nav-link {{ Request::is('tender') ? 'fw-bold' : '' }}" href="/tender">
                    Tender Info
                </a>
            </li>

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Laporan
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" id="laporanNavList">
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('faqs') ? 'fw-bold' : '' }}" href="/faqs">
                    FAQ
                </a>
            </li>
        </ul>
      </div>
    </div>
  </nav>