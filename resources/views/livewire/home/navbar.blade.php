<div>
    <header class="main-header">
        <!-- top bar -->
        <div class="top-bar fl-wrap">
            <div class="container">
                <div class="date-holder">
                    <span class="date_num"></span>
                    <span class="date_mounth"></span>
                    <span class="date_year"></span>
                </div>
                <div class="header_news-ticker-wrap">
                    <div class="header_news-ticker fl-wrap">
                        <ul style="color: white">
                            <li>Selamat Datang Di Website Cabang Kejaksaan Negeri Banggai Di Pagimana.</li>
                            <li>Kami Akan Memberikan Pelayanan Kepada Masyarakat Secara Maksimal.</li>
                        </ul>
                    </div>
                </div>
                <ul class="topbar-social">
                    <li><a href="https://web.facebook.com/cabjari.pagimana" target="_blank"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UCyTf7WPocCsV-xYLsxXlFJA" target="_blank"><i class="fab fa-youtube"></i></a></li>
                    <li><a href="https://www.instagram.com/cabjaripagimana/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="javascript:;"  id="scanqr" wire:loading.attr="disabled"
                            wire:click="$dispatch('open-modal', { id: 'scaning-modal' })"
                            style="width: 120%;background: rgb(129, 84, 185);">Scan Inventaris</a></li>
                    <li><a href="{{ route('filament.admin.auth.login') }}" style="width: 60px;margin-left: 25%;background: dimgray;">Login</a></li>
                </ul>

            </div>
        </div>
        <!-- top bar end -->
        <div class="header-inner fl-wrap" x-data="{qr: false, toggle4() { this.qr = ! this.qr},}">
            <div class="container">
                <!-- logo holder  -->
                <a href="index.html" class="logo-holder"><img src="{{asset('images/Logolanding.png')}}" alt=""></a>
                <!-- logo holder end -->
                <div class="search_btn htact show_search-btn"><i class="far fa-search"></i> <span class="header-tooltip">Search</span></div>
                <!-- header-search-wrap -->
                <div class="header-search-wrap novis_sarch">
                    <div class="widget-inner">
                        <form action="#">
                            <input name="se" id="se" type="text" class="search" placeholder="Search..." value="" />
                            <button class="search-submit" id="submit_btn"><i class="fa fa-search transition"></i> </button>
                        </form>
                    </div>
                </div>
                <!-- header-search-wrap end -->
                <!-- nav-button-wrap-->
                <div class="nav-button-wrap">
                    <div class="nav-button">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <!-- nav-button-wrap end-->
                <!--  navigation -->
                <div class="nav-holder main-menu">
                    <nav>
                        <ul>
                            <li>
                                <a href="#">Beranda</a>
                            </li>
                            <li>
                                <a href="#">Pelayanan<i class="fas fa-caret-down"></i></a>
                                <!--second level -->
                                <ul>
                                    <li><a href="/konsultasi-hukum-gratis">Konsultasi Hukum</a></li>
                                    <li><a href="blog2.html">Halo JPN</a></li>
                                    <li><a href="blog3.html">Lapor Jaksa</a></li>
                                </ul>
                                <!--second level end-->
                            </li>
                            <li><a href="blog.html">Tentang Kami</a></li>
                            {{-- <li><a href="javascript:;" id="scanqr" x-on:click="qr = ! qr">Scan Inventaris</a></li> --}}
                        </ul>
                    </nav>
                </div>
                <!-- navigation  end -->
            </div>
            {{-- @include('modals.scanQr') --}}
        </div>
    </header>
</div>
@once
    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script type="module">
            function onScanSuccess(decodedText, decodedResult) {
                // handle the scanned code as you like, for example:
                // console.log(`Code matched = ${decodedText}`, decodedResult);
                html5QrcodeScanner.clear()
                @this.call('scanQr', decodedText);
            }

            function onScanFailure(error) {
            }

            let qrboxFunction = function(viewfinderWidth, viewfinderHeight) {
                let minEdgePercentage = 0.7; // 70%
                let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
                let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
                return {
                    width: qrboxSize,
                    height: qrboxSize
                };
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: qrboxFunction
                }, false
            );

            Livewire.on('startQR', data => {
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            });
            // html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            document.addEventListener('DOMContentLoaded', function() {
                $('#scanqr').on('click', function(e) {
                    // let html5QrcodeScanner = new Html5QrcodeScanner(
                    // "reader",
                    // { fps: 10, qrbox: {width: 125, height: 125} }, /* verbose= */ false);
                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                });
                $('#tutupscan').on('click', function(e) {
                    // let html5QrcodeScanner = new Html5QrcodeScanner(
                    // "reader",
                    // { fps: 10, qrbox: {width: 125, height: 125} }, /* verbose= */ false);
                    html5QrcodeScanner.clear();
                    @this.dispatch('close-modal', { id: 'scaning-modal' });
                });
            });
        </script>
    @endpush
@endonce
