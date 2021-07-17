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
        <section class="section-header overflow-hidden pt-7 pt-lg-8 pb-9 pb-lg-12 bg-primary text-white">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1 class="fw-bolder">Laravel Volt Template Starter</h1>
                        <h2 class="lead fw-normal text-muted mb-5">Open source dashboard powered by Bootstrap 5</h2>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-3">
                    @guest
                    <a href="{{route('login')}}" class="btn btn-secondary">Login</a>
                    <a href="{{route('register')}}" class="btn btn-secondary">Register</a>
                    @else
                    <a href="{{route('dashboard')}}" class="btn btn-secondary">Dashboard</a>
                    @endguest
                </div>
            </div>
            <figure class="position-absolute bottom-0 left-0 w-100 d-none d-md-block mb-n2">
                <svg class="home-pattern" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 3000 185.4">
                    <path d="M3000,0v185.4H0V0c496.4,115.6,996.4,173.4,1500,173.4S2503.6,115.6,3000,0z"></path>
                </svg>
            </figure>
        </section>
    </main>
    <div class="container mt-5">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-5 order-lg-2 mb-5 mb-lg-0">
                <h2 class="h1">Bootstrap 5</h2>
                <p class="mb-4 lead fw-bold">Latest version of Bootstrap without jQuery</p>
                <p class="mb-4">Volt is built using the latest version of Bootstrap 5 and we only used Vanilla Javascript for everything including the plugins</p>
                <a href="#" target="_blank" class="btn btn-outline-gray-600 d-inline-flex align-items-center">
                    Getting started
                </a>
            </div>
            <div class="col-lg-6 order-lg-1"><img src="{{asset('assets/img/illustrations/bs5-illustrations.svg')}}" alt="Front pages overview"></div>
        </div>
    </div>
    <footer class="footer py-6 mt-5 bg-gray-800 text-white">
        <div class="container">
            <div class="row">
                <div class="col mb-md-0">
                    <div class="d-flex text-center justify-content-center align-items-center" role="contentinfo">
                        <p class="fw-normal font-small mb-0">Copyright © Themesberg 2019-<span class="current-year">2021</span>. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Core -->
    <script src="{{asset('vendor/@popperjs/core/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>

    <!-- Vendor JS -->
    <script src="{{asset('vendor/onscreen/dist/on-screen.umd.min.js')}}"></script>

    <!-- FA Icon -->
    <script src="https://kit.fontawesome.com/8482c12eb4.js" crossorigin="anonymous"></script>

</body>

</html>