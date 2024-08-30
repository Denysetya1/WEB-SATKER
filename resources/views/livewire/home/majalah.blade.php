<div>
    @if ($magazines != null)
        <section class="no-padding">
            <div class="fs-carousel-wrap">
                <div class="fs-carousel-wrap_title">
                    <div class="fs-carousel-wrap_title-wrap fl-wrap">
                        <h4>Kejaksaan Story</h4>
                        <h5>Ikuti perkembangan informasi terkini tentang Kejaksaan Republik Indonesia</h5>
                        <a href="https://www.kejaksaan.go.id/majalah" target="blank" class="dark-btn fl-wrap"> Klik Disini </a>
                    </div>
                    <div class="abs_bg"></div>
                    <div class="gs-controls">
                        <div class="gs_button gc-button-next"><i class="fas fa-caret-right"></i></div>
                        <div class="gs_button gc-button-prev"><i class="fas fa-caret-left"></i></div>
                    </div>
                </div>
                <div class="fs-carousel fl-wrap">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($magazines as $mag)
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="grid-post-item  bold_gpi  fl-wrap">
                                        <div class="grid-post-media gpm_sing">
                                            <div class="bg" data-bg="{{$mag['img']}}"></div>
                                            <div class="grid-post-media_title">
                                                <h4><a href="{{$mag['link']}}">{{$mag['title']}}</a></h4>
                                                <a class="post-category-marker" href="{{$mag['link']}}">Baca</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- swiper-slide end-->
                            @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
