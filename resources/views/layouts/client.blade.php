<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
                                <div class="wrapper-text">
                                    <h3 class="fw-bolder">PPID Baznas Jawa Barat</h3>
                                    <p>Jl. Diponegoro No. 61, Bandung</p>
                                    <p>Telepon: (022) 2033 2033</p>
                                    <p>Email: test@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6" id="footer-frame">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.501917260859!2d107.62071178543265!3d-6.949966275130898!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e7b3c42c14c7%3A0x389214b28df6157b!2sBAZNAS%20Provinsi%20Jawa%20Barat!5e0!3m2!1sid!2sid!4v1721652926499!5m2!1sid!2sid" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @stack('js')
    <script>
        // get items nav
        // document ready
        $(document).ready(function() {
            // call ajax to /nav-items
            $.ajax({
                url: '/nav-items',
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    let urlNow = window.location.href;
                    let isActived = false;

                    let formulirnav = response.formulir;
                    let itemLayanan = response.item_layanans
                    let regulasiNav = response.regulasi;
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
                }
            });
        });
    </script>
</body>
</html>
