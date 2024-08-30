<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!--=============== basic  ===============-->
        <meta charset="UTF-8">
        <title>Cabjari Pagimana</title>
        <meta name="robots" content="index, follow" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        >
        <meta
            name="description"
            content="Website Resmi Cabang Kejaksaan Negeri Banggai Di Pagimana. Terdapat Berita Terbaru Resmi Kejaksaan, Informasi Terkini dan Video Kejaksaan RI"
        >
        <meta
            name="keywords"
            content="Cabang Kejaksaan Negeri Banggai Di Pagimana, CKN, ckn, pagimana, Pagimana, Kejaksaan, cabjari, Cabjari, Banggai, Luwuk, Berita Kejaksaan, Info Kejaksaan"
        >
        <meta
            name="author"
            content="denysetya1"
        >
        <!--=============== css  ===============-->
        <link type="text/css" rel="stylesheet" href="{{asset('gmag/css/plugins.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('gmag/css/style.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('gmag/css/color.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('gmag/css/loader.css')}}">
        <!--=============== favicons ===============-->
        {{-- <link rel="shortcut icon" href="{{asset('gmag/images/favicon.ico')}}"> --}}
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/Pagimana_Logo.ico')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/Pagimana_Logo 16x16.ico')}}">
        @vite('resources/css/filament/admin/theme.css')
        {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
        @livewireStyles
    </head>
    <body>
        <!-- main start  -->
        <div id="main">
            {{-- @livewire('home') --}}
            <!-- Loading -->
            {{-- <div class="pre-loader">
                <svg class="spinner" viewBox="0 0 50 50">
                    <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                </svg>
            </div> --}}
            <div class="loader">
                <div class="boxes">
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="box">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>
            <!-- progress-bar  -->
            <div class="progress-bar-wrap">
                <div class="progress-bar color-bg"></div>
            </div>
            <!-- progress-bar end -->
            <!-- header -->
            <livewire:home.navbar />
            <!-- header end  -->
            <!-- wrapper -->
            @include('modals.scanQr')
            <div id="wrapper">
                <!-- content    -->
                <div class="content">
                    <livewire:home.rekomendasi />
                    <!-- section Bagian Satu -->
                    <section>
                        <div class="container">
                            <div class="row">
                                {{-- <div class="col-md-8"> --}}
                                    @livewire('home.beritalokal')
                                {{-- </div> --}}
                                {{-- <div class="col-md-4">
                                    @livewire('home.sidebar')
                                </div> --}}
                            </div>
                            <div class="limit-box fl-wrap"></div>
                        </div>
                    </section>
                    <!-- section end -->
                    <!-- section Video Youtube Kejagung -->
                    <section class="dark-bg no-bottom-padding">
                        @livewire('home.videoyoutube')
                    </section>
                    <!-- section end -->
                    <!-- section Berita Pusat -->
                    @livewire('home.beritapusat')
                    <!-- section end -->
                    <!-- section Majalah -->
                    @livewire('home.majalah')
                    <!-- section end -->
                    <div class="gray-bg ad-wrap fl-wrap">
                        <div class="content-banner-wrap">
                            <img src="{{asset('gmag/images/all/banner.jpg')}}" class="respimg" alt="">
                        </div>
                    </div>
                    <!-- section end -->
                </div>
                <!-- content  end-->
                <!-- footer -->
                <footer class="fl-wrap main-footer">
                    <div class="container">
                        <!-- footer-widget-wrap -->
                        <div class="footer-widget-wrap fl-wrap">
                            <div class="row">
                                <!-- footer-widget -->
                                <div class="col-md-4">
                                    <div class="footer-widget">
                                        <div class="footer-widget-content">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.429412155932!2d122.64649491422269!3d-0.7999965994163916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d86946713769e19%3A0xa97ea89f267dd539!2sCabang%20Kejaksaan%20Negeri%20Banggai%20di%20Pagimana!5e0!3m2!1sid!2sid!4v1665381507491!5m2!1sid!2sid"
                                                style="border:0; border-radius:16px;" width="100%" height="250px" allowfullscreen="" loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                                <!-- footer-widget  end-->
                                <!-- footer-widget -->
                                <div class="col-md-4">
                                    <div class="footer-widget">
                                        <div class="footer-widget-title">Kontak</div>
                                        <div class="footer-widget-content">
                                            <div class="footer-contacts">
                                                <ul>
                                                    <li>
                                                        <a href="#" target="_blank"><i class="far fa-location-circle"></i></a>
                                                        <p>Jl. Mawar No.1, Hohudongan, Pagimana, Kabupaten Banggai, Sulawesi Tengah 94752</p>
                                                    </li>
                                                    <li>
                                                        <a href="#" target="_blank"><i class="far fa-envelope"></i></a>
                                                        <p>cabjaripagimana.2119@gmail.com</p>
                                                    </li>
                                                    <li>
                                                        <a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a>
                                                        <p></p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- footer-widget  end-->
                                <!-- footer-widget -->
                                <div class="col-md-4">
                                    <div class="footer-widget">
                                        <div class="footer-widget-content">
                                            <a href="index.html" class="footer-logo"><img src="{{asset('images/logo_ckn_pagimana.png')}}" alt=""></a>
                                            <div class="footer-p">Kunjungi Media Sosial Kami.</div>
                                            <div class="footer-social fl-wrap">
                                                <ul>
                                                    <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                    <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                    <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- footer-widget  end-->
                            </div>
                        </div>
                        <!-- footer-widget-wrap end-->
                    </div>
                    <div class="footer-bottom fl-wrap">
                        <div class="container">
                            <div class="copyright"><span>&#169; Kejaksaan RI 2023</span> . All rights reserved. </div>
                            <div class="to-top"> <i class="fas fa-caret-up"></i></div>
                        </div>
                    </div>
                </footer>
                <!-- footer end-->
                <div class="aside-panel">
                    <ul>
                        <li> <a href="#"><i class="far fa-stars"></i><span>Hasil SKM</span></a></li>
                        <li> <a href="#"><i class="far fa-phone-office"></i><span>Kontak</span></a></li>
                        <li> <a href="#"><i class="far fa-building"></i><span>Kejaksaan Agung</span></a></li>
                    </ul>
                </div>
            </div>
            <!-- wrapper end -->
            {{-- @include('modals.scanQr') --}}
        </div>
        <!-- Main end -->
        <!--=============== scripts  ===============-->
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
        <script src="{{asset('gmag/js/jquery.min.js')}}"></script>
        <script src="{{asset('gmag/js/plugins.js')}}"></script>
        <script src="{{asset('gmag/js/scripts.js')}}"></script>
        <script src="{{asset('gmag/js/loader.js')}}"></script>
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            window.addEventListener('swal', function(e) {
                swal.fire(e.detail);
            });
        </script> --}}
        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />
        @stack('scripts')
        @include('popper::assets')
    </body>
</html>
