<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="ppid.baznasjabar.org | PPID Baznas Provinsi Jawa Barat">
    <meta name="description" content="PPID BAZNAS Jawa Barat">
    <meta name="keywords" content="ppid, baznas, jawa barat">
    <meta name="author" content="PPID BAZNAS Jawa Barat">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PPID BAZNAS Jawa Barat</title>
    {{-- icon --}}
    <link rel="icon" href="/image/icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <style>
        .bg-green-primary {
            background-color: #0d6e09 !important;
            color: white !important;
        }
        
        .text-green-primary {
            color: #0d6e09 !important;
        }

        html, body {
            margin: 0;
            padding: 0;
        }

        /* html {
            height: 100%;
        } */

        body {
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            background-color: white !important;
        }

        main {
            flex: 1;
            margin-top: 85px;
            min-height: 80vh;
        }

        footer {
            width: 100%;
            padding: 20px 0;
            margin-bottom: 0;
        }

        #footer-frame iframe {
            width: 100% !important;
            height: 300px !important;
            border-radius: 10px;
        }

        /* set zoom page */
        body {
            zoom: 110%;
        }
        .dropdown-item .active {
            background-color: #0d6e09 !important;
        }
        .dropdown-item:active {
            background-color: #0d6e09 !important;
        }
    </style>
    <style>
        .page-item.active .page-link {
            background-color: #0d6e09;
            border-color: #0d6e09;
        }
    </style>
    @stack('css')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    @include('layouts.navbar-frontend')
    <main>
        @yield('content')
    </main>
    <footer class="bg-green-primary">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="wrapper-text mb-3">
                                    <h3 class="fw-bolder" id="namaKantorPPID"></h3>
                                    <p id="alamatKantorPPID"></p>
                                    <span class="d-block">
                                        Telepon: <span id="teleponKantorPPID"></span>
                                    </span>
                                    <span class="d-block">
                                        Email: <span id="emailKantorPPID"></span>
                                    </span>
                                </div>
                                <div class="wrapper-icon d-flex justify-content-start gap-2 mb-3">
                                    <a href="#" class="text-green-primary text-decoration-none d-flex justify-content-center align-items-center p-2 bg-white rounded-circle d-none" id="facebookSosmed" target="_blank">
                                        <i class="fab fa-facebook fs-4"></i>
                                    </a>
                                    <a href="#" class="text-green-primary text-decoration-none d-flex justify-content-center align-items-center p-2 bg-white rounded-circle d-none" id="instagramSosmed" target="_blank">
                                        <i class="fab fa-instagram fs-4"></i>
                                    </a>
                                    <a href="#" class="text-green-primary text-decoration-none d-flex justify-content-center align-items-center p-2 bg-white rounded-circle d-none" id="youtubeSosmed" target="_blank">
                                        <i class="fab fa-youtube fs-4"></i>
                                    </a>
                                    <a href="#" class="text-green-primary text-decoration-none d-flex justify-content-center align-items-center p-2 bg-white rounded-circle d-none" id="whatsappSosmed" target="_blank">
                                        <i class="fab fa-whatsapp fs-4"></i>
                                    </a>
                                    <a href="#" class="text-green-primary text-decoration-none d-flex justify-content-center align-items-center p-2 bg-white rounded-circle d-none" id="twitterSosmed" target="_blank">
                                        <i class="fa-brands fa-x-twitter fs-4"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6" id="footer-frame">
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @stack('js')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/init-required-items',
                type: 'GET',
                success: function(response) {
                    let urlNow = window.location.href;
                    let isActived = false;

                    let formulirnav = response.formulir;
                    let itemLayanan = response.item_layanans
                    let regulasiNav = response.regulasi;
                    let laporanNav = response.laporan;
                    $.each(formulirnav, function(index, value) {
                        isActived = urlNow.includes('formulir/' + value.id);
                        $('#formulirNavList').append(`
                            <li>
                                <a class="dropdown-item ${isActived ? 'bg-green-primary' : ''}" href="/formulir/${value.id}">${value.nama}</a>
                            </li>
                        `);
                    });
                    
                    $.each(itemLayanan, function(index, value) {
                        isActived = urlNow.includes(value.url);
                        $('#ListLayananNavDivider').after(`
                            <li>
                                <a class="dropdown-item ${isActived ? 'bg-green-primary' : ''}" href="${value.url}">${value.nama}</a>
                            </li>
                        `);
                    });

                    // regulasiNavList
                    $.each(regulasiNav, function(index, value) {
                        isActived = urlNow.includes(value.url);
                        $('#regulasiNavList').append(`
                            <li>
                                <a class="dropdown-item ${isActived ? 'bg-green-primary' : ''}" href="${value.url}">${value.nama}</a>
                            </li>
                        `);
                    });

                    // laporanNavList
                    $.each(laporanNav, function(index, value) {
                        isActived = urlNow.includes(value.url);
                        $('#laporanNavList').append(`
                            <li>
                                <a class="dropdown-item ${isActived ? 'bg-green-primary' : ''}" href="${value.url}">${value.nama}</a>
                            </li>
                        `);
                    });

                    let kantor = response.info_kantor;
                    let embed_map = response.embed_map;
                    $('#namaKantorPPID').text(kantor.nama_kantor);
                    $('#alamatKantorPPID').text(kantor.alamat_kantor);
                    $('#teleponKantorPPID').text(kantor.telepon_kantor);
                    $('#emailKantorPPID').text(kantor.email_kantor);
                    $('#footer-frame').append(embed_map);

                    // social media
                    let sosmed = response.sosmed;
                    if (sosmed.facebook) {
                        $('#facebookSosmed').attr('href', sosmed.facebook).removeClass('d-none');
                    }
                    if (sosmed.instagram) {
                        $('#instagramSosmed').attr('href', sosmed.instagram).removeClass('d-none');
                    }
                    if (sosmed.youtube) {
                        $('#youtubeSosmed').attr('href', sosmed.youtube).removeClass('d-none');
                    }
                    if (sosmed.whatsapp) {
                        $('#whatsappSosmed').attr('href', sosmed.whatsapp).removeClass('d-none');
                    }
                    if (sosmed.twitter) {
                        $('#twitterSosmed').attr('href', sosmed.twitter).removeClass('d-none');
                    }
                }
            });
        });
    </script>
</body>
</html>
