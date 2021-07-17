<!--

=========================================================
* Volt Free - Bootstrap 5 Dashboard
=========================================================

* Product Page: https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard
* Copyright 2021 Themesberg (https://www.themesberg.com)

* Designed and coded by https://themesberg.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. Please contact us to request a removal. Contact us if you want to remove it.

-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>HIPPAM: Desa Klampok</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="title" content="HIPPAM: Desa Klampok">
    <meta name="author" content="Andry">
    <meta name="description" content="HIPPAM: Desa Klampok">
    <meta name="keywords" content="HIPPAM: Desa Klampok" />
    <link rel="canonical" href="HIPPAM: Desa Klampok">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('assets/img/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/img/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/img/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/img/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('assets/img/favicon/safari-pinned-tab.svg')}}" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Volt CSS -->
    <link type="text/css" href="{{asset('css/volt.css')}}" rel="stylesheet">

</head>

<body>
    <main>
        <div class="mb-5"></div>
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <p class="text-center">
                    <a href="{{route('root.index')}}" class="d-flex align-items-center justify-content-center">
                        Kembali
                    </a>
                </p>
                <div class="row justify-content-center form-bg-image">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                                Link verifikasi telah dikirim
                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                            </div>
                            @endif
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Mohon verifikasi email dahulu</h1>
                            </div>
                            <form action="{{route('verification.send')}}" method="post">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>
                            <form action="{{route('logout')}}" method="post">
                                @csrf
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-secondary">Logout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="mb-5"></div>
    </main>

    <!-- Core -->
    <script src="{{asset('vendor/@popperjs/core/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Vendor JS -->
    <script src="{{asset('vendor/onscreen/dist/on-screen.umd.min.js')}}"></script>

    <!-- FA Icon -->
    <script src="https://kit.fontawesome.com/8482c12eb4.js" crossorigin="anonymous"></script>

    <!-- Smooth scroll -->
    <script src="{{asset('vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js')}}"></script>
</body>

</html>