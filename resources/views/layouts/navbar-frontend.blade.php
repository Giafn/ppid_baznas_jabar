<nav class="navbar navbar-expand-md shadow fixed-top px-3 bg-white">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img class="navbar-brand" src="{{ asset('image/icon.png') }}" alt="{{ config('app.name', 'Laravel') }}" height="60">
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
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    PPID Baznas Jabar
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/profile">
                        Profile
                    </a>
                    <a class="dropdown-item" href="/visi-misi">
                        Visi Misi
                    </a>
                    <a class="dropdown-item" href="/tugas-fungsi">
                        Tugas dan Fungsi
                    </a>
                    <a class="dropdown-item" href="/struktur-organisasi">
                        Struktur PPID
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="outside">Layanan Informasi</a>
                <ul class="dropdown-menu shadow">
                    <li class="dropend">
                        <a href="#" class="dropdown-item dropdown-toggle me-2" data-bs-toggle="dropdown">Formulir</a>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href=""> Permohonan Informasi</a></li>
                            <li><a class="dropdown-item" href=""> Permohonan Kunjungan</a></li>
                            <li><a class="dropdown-item" href=""> Pengajuan Keberatan</a></li>
                            <li><a class="dropdown-item" href=""> Penilaian Layanan</a></li>
                        </ul>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Rekomendasi Laz</a></li>
                    <li><a class="dropdown-item" href="">Maklumat Pelayanan</a></li>
                    <li><a class="dropdown-item" href="">Waktu Dan Biaya Layanan</a></li>
                    <li><a class="dropdown-item" href="">Ramah Disabilitas</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Informasi Publik
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">
                        Informasi Berkala
                    </a>
                    <a class="dropdown-item" href="">
                        Informasi Serta Merta
                    </a>
                    <a class="dropdown-item" href="">
                        Informasi Setiap Saat
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Regulasi
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">
                        Regulasi Informasi Publik
                    </a>
                    <a class="dropdown-item" href="">
                        Regulasi Pengelolaan Zakat
                    </a>
                    <a class="dropdown-item" href="">
                        Regulasi Baznas Jabar
                    </a>
                    <a class="dropdown-item" href="">
                        Regulasi LAZ
                    </a>
                    <a class="dropdown-item" href="">
                        Regulasi UPZ
                    </a>
                    <a class="dropdown-item" href="">
                        Hubungan Zakat dan Pajak
                    </a>
                    <a class="dropdown-item" href="">
                        Fatwa MUI
                    </a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Laporan
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="">
                        Laporan Keuangan
                    </a>
                    <a class="dropdown-item" href="">
                        Laporan Keu Bulanan
                    </a>
                    <a class="dropdown-item" href="">
                        Laporan Kinerja
                    </a>
                    <a class="dropdown-item" href="">
                        Laporan Pengelolaan Zakat
                    </a>
                    <a class="dropdown-item" href="">
                        Statistik Zakat Nasional
                    </a>
                    <a class="dropdown-item" href="">
                        Laporan Layanan Informasi
                    </a>
                    <a class="dropdown-item" href="">
                        Layanan Visitasi
                    </a>
                    <a class="dropdown-item" href="">
                        Laporan Survey Kepuasan
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('faq') ? 'fw-bold' : '' }}" href="">
                    FAQ
                </a>
            </li>
        </ul>
      </div>
    </div>
  </nav>