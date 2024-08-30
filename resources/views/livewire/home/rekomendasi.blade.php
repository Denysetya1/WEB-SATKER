<div>
    <!-- Rekomendasi -->
    <div class="hero-slider-wrap fl-wrap">
        <!-- hero-slider-container     -->
        <div class="hero-slider-container multi-slider fl-wrap full-height">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!-- swiper-slide -->
                    @foreach ($rekomsnews as $news)
                        <div class="swiper-slide">
                            <div class="bg-wrap">
                                <div class="bg" style="background-image: url('storage{{$news['cover_photo_path']}}')" data-swiper-parallax="40%"></div>
                                {{-- <div class="bg" data-bg="{{asset('gmag/images/all/1.jpg')}}" data-swiper-parallax="40%"></div> --}}
                                <div class="overlay"></div>
                            </div>
                            <div class="hero-item fl-wrap">
                                <div class="container">
                                    @foreach ($news->tags as $item)
                                        <a class="post-category-marker" href="{{route('filamentblog.tag.post', ($item->slug))}}">{{$item->name}}</a>
                                    @endforeach
                                    {{-- <a class="post-category-marker" href="#">Luhkum</a> --}}
                                    <div class="clearfix"></div>
                                    <h2><a href="{{route('filamentblog.post.show', ($news['slug']))}}">{{$news['title']}}</a></h2>
                                    <h4>
                                        <a href="{{route('filamentblog.post.show', ($news['slug']))}}" class="isi-berita">
                                            {!! tiptap_converter()->asHTML($news->body, toc: true, maxDepth: 3) !!}
                                        </a>
                                    </h4>
                                    {{-- <h4>
                                        <a href="#" class="isi-berita">
                                            {!!str($news->body)->words(15, ' ...Baca Seluruhnya')!!}
                                        </a>
                                    </h4> --}}
                                    <div class="clearfix"></div>
                                    {{-- <div class="author-link"><a href="author-single.html"><img src="images/avatar/1.jpg" alt="">  <span>By Jessie Bond</span></a></div> --}}
                                    <span class="post-date"><i class="far fa-clock"></i>  {{$news['published_at']}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="fs-slider_btn color-bg fs-slider-button-prev"><i class="fas fa-caret-left"></i></div>
            <div class="fs-slider_btn color-bg fs-slider-button-next"><i class="fas fa-caret-right"></i></div>
        </div>
        <!-- hero-slider-container  end   -->
        <!-- hero-slider_controls-wrap   -->
        <div class="hero-slider_controls-wrap">
            <div class="container">
                <div class="hero-slider_controls-list multi-slider_control">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <!-- swiper-slide  -->
                            @foreach ($rekomsnews as $rekom)
                                <div class="swiper-slide">
                                    <div class="hsc-list_item fl-wrap">
                                        <div class="hsc-list_item-media">
                                            <div class="bg-wrap">
                                                <div class="bg" style="background-image: url('storage{{$rekom['cover_photo_path']}}')"></div>
                                                {{-- <div class="bg" data-bg="{{asset('gmag/images/all/1.jpg')}}"></div> --}}
                                            </div>
                                        </div>
                                        <div class="hsc-list_item-content fl-wrap">
                                            <h4>{{$rekom['title']}}</h4>
                                            <span class="post-date"><i class="far fa-clock"></i> {{$rekom['published_at']}}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="multi-pag"></div>
            </div>
        </div>
        <!-- hero-slider_controls-wrap end  -->
        <div class="slider-progress-bar act-slider">
            <span>
                <svg class="circ" width="30" height="30">
                    <circle class="circ2" cx="15" cy="15" r="13" stroke="rgba(255,255,255,0.4)" stroke-width="1" fill="none" />
                    <circle class="circ1" cx="15" cy="15" r="13" stroke="#e93314" stroke-width="2" fill="none" />
                </svg>
            </span>
        </div>
    </div>
    <!-- hero-slider-wrap  end   -->
</div>
