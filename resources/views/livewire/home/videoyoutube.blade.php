<div>
    <div class="container">
        <div class="main-video-wrap fl-wrap">
            <div class="video-main-cont">
                <div class="video-section-title fl-wrap">
                    <h2>Video Kejaksaan Terbaru</h2>
                    <h4>Stay up-to-date</h4>
                    <a href="https://www.youtube.com/@kejaksaanri3625/featured" target="blank">Lihat Semua <i class="fas fa-caret-right"></i></a>
                </div>
                <a class="video-holder vh-main fl-wrap  image-popup"  href="#">
                    <div class="bg"></div>
                    <div class="overlay"></div>
                    <div class="big_prom"> <i class="fas fa-play"></i></div>
                </a>
                <div class="video-holder-title fl-wrap">
                    <div class="video-holder-title_item"><a href="#"></a></div>
                    <span class="video-date"><i class="far fa-clock"></i> <strong></strong></span>
                    {{-- <a class="post-category-marker" href="category.html"></a> --}}
                </div>
                <div class="vh-preloader"></div>
            </div>
            <!-- video-links-wrap   -->
            <div class="video-links-wrap">
                @foreach ($videos as $video)
                    @if ($loop->first)
                        <!-- video-item  -->
                        <div class="video-item video-item_active fl-wrap" data-url="post-single2.html" data-video-link="{{'https://www.youtube.com/watch?v='.$video['id']}}">
                            <div class="video-item-img fl-wrap">
                                <img src="{{$video['thumbnails']}}" class="respimg" alt="">
                                <div class="play-icon"><i class="fas fa-play"></i></div>
                            </div>
                            <div class="video-item-title">
                                <h4>{{$video['title']}}</h4>
                                <span class="video-date"><i class="far fa-clock"></i> <strong>{{$video['publishedAt']}}</strong></span>
                            </div>
                            {{-- <a class="post-category-marker" href="category.html">Business</a> --}}
                        </div>
                        <!--video-item end   -->
                    @else
                        <!-- video-item  -->
                        <div class="video-item fl-wrap" data-url="post-single2.html" data-video-link="{{'https://www.youtube.com/watch?v='.$video['id']}}">
                            <div class="video-item-img fl-wrap">
                                <img src="{{$video['thumbnails']}}" class="respimg" alt="">
                                <div class="play-icon"><i class="fas fa-play"></i></div>
                            </div>
                            <div class="video-item-title">
                                <h4>{{$video['title']}}</h4>
                                <span class="video-date"><i class="far fa-clock"></i> <strong>{{$video['publishedAt']}}</strong></span>
                            </div>
                            {{-- <a class="post-category-marker" href="category.html">Technology</a> --}}
                        </div>
                        <!--video-item end   -->
                    @endif
                @endforeach
            </div>
            <!-- video-links-wrap end   -->
        </div>
    </div>
    @if ($pelayanan != null)
        <div class="video_carousel-wrap fl-wrap">
            <div class="container">
                <div class="video_carousel-container">
                    <div class="video_carousel_title">
                        <h4>Layanan Kejaksaan</h4>
                        <div class="vc-pagination pag-style"></div>
                    </div>
                    <!-- fw-carousel  -->
                    <div class="video_carousel  lightgallery">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach ($pelayanan as $item)
                                    <!-- swiper-slide-->
                                    <div class="swiper-slide">
                                        <!-- video-item  -->
                                        <div class="video-item fl-wrap">
                                            <div class="video-item-img fl-wrap">
                                                <img src="{{$item['img']}}" class="respimg" alt="">
                                                {{-- <a class="play-icon image-popup" href="{{$item['link']}}">{{$item['title']}}</a> --}}
                                            </div>
                                            <div class="video-item-title">
                                                <h4><a href="{{$item['link']}}">{{$item['title']}}</a></h4>
                                                {{-- <span class="video-date"><i class="far fa-clock"></i> 05december 2021</span> --}}
                                            </div>
                                            <a class="post-category-marker" href="{{$item['link']}}">Layanan</a>
                                        </div>
                                        <!--video-item end   -->
                                    </div>
                                    <!-- swiper-slide end-->
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- fw-carousel end -->
                    <div class="cc-prev cc_btn"><i class="fas fa-caret-left"></i></div>
                    <div class="cc-next cc_btn"><i class="fas fa-caret-right"></i></div>
                </div>
            </div>
        </div>
    @endif
</div>
