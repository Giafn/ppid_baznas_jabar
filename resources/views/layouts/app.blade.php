
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    {{-- how to check @yeild('title') --}}
    @if(View::hasSection('title'))
        <title>Admin PPID Baznas Jabar | @yield('title')</title>
    @else
        <title>Admin PPID Baznas Jabar</title>
    @endif

    <link rel="icon" href="/image/icon.png" type="image/x-icon" />

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="/css/custom.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous"> --}}

    <style>
        /* hide element with class .hidden-export when print */
        .hidden-view {
            display: none;
        }
        @media print {
            .hidden-export {
                display: none;
            }
            .hidden-view {
                display: block;
            }
            .card {
                border: none;
            }

            .card-wrapper {
                display: inline-block;
                width: 49%;
            }
        }
        .bg-green-primary {
            background-color: #0d6e09 !important;
            color: white !important;
        }
        
        .text-green-primary {
            color: #0d6e09 !important;
        }

        /* buat class collapse-item active menjadi bold dan warna putih */
        .collapse-item.active {
            font-weight: bold !important;
            color: black !important;
            background-color: rgba(255, 255, 255, 0.5) !important;
        }
        #footer-frame iframe {
            width: 100% !important;
            height: 400px !important;
            border-radius: 10px;
        }
    </style>
    <style>
        .page-item.active .page-link {
            background-color: #0d6e09;
            border-color: #0d6e09;
        }
    </style>
    @stack('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        
        <!-- Sidebar -->
        @include('component.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('component.navbar')
                <div class="row justify-content-center px-md-0 px-3">
                    <div class="col-md-11">
                        <h1 class="h3 mb-4 text-gray-800">@yield('title')</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @foreach ($itemBc as $key => $bc)
                                <li class="breadcrumb-item {{ $key === count($itemBc) - 1 ? 'active' : '' }}">
                                    @if ($key === count($itemBc) - 1)
                                    <b class="text-green-primary fw-bolder">
                                        {{ ucfirst($bc['name']) }}
                                    </b>
                                    @else
                                    <a href="{{ $bc['url'] }}" class="text-dark">
                                        {{ ucfirst($bc['name']) }}
                                    </a>
                                    @endif
                                </li>
                                @endforeach
                            </ol>
                        </nav>
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                           <div>
                                <strong>Mohon Maaf!</strong> Terdapat kesalahan.
                                <ol style="margin-bottom: 0px;">
                                    @foreach ($errors->all() as $error)
                                        <li style="list-style-type: disc; margin-left: 0px;">
                                            {{ ucfirst($error) }}
                                        </li>
                                    @endforeach
                                </ol>
                           </div>
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
        
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                           <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
        
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                           <div><strong>Error!</strong> {{ session('error') }}</div>
                           <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @yield('content')

                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PPID Baznas Jabar
                            {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/js/sb-admin-2.min.js"></script>
    @stack('scripts')
</body>

</html>