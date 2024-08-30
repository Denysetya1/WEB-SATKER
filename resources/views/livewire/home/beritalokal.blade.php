<div>
    <div class="col-md-8">
        <!-- section Berita Lokal -->
        <div class="main-container fl-wrap fix-container-init">
            <div class="content-banner-wrap cbw_mar">
                <img src="{{asset('gmag/images/all/banner.jpg')}}" class="respimg" alt="">
            </div>
            <div class="clearfix"></div>
            <div class="section-title sect_dec" id="list-berita-lokal">
                <h2>Berita Terbaru</h2>
                <h4>Jangan Terlewatkan Berita Terbaru</h4>
            </div>
            <div class="grid-post-wrap">
                <div class="more-post-wrap  fl-wrap">
                    <div class="list-post-wrap list-post-wrap_column fl-wrap">
                        <div class="row" style="display: grid;grid-template-columns: 50% 50%;">
                            @foreach ($beritas as $berita)
                                <div class="col-md-12">
                                    <!--list-post-->
                                    <div class="list-post fl-wrap">
                                        @foreach ($berita->tags as $item)
                                            <a class="post-category-marker" href="{{route('filamentblog.tag.post', ($item->slug))}}">{{$item->name}}</a>
                                        @endforeach
                                        <div class="list-post-media">
                                            <a href="{{route('filamentblog.post.show', ($berita['slug']))}}"> <!--Link ke Berita-->
                                                <div class="bg-wrap">
                                                    <div class="bg"  style="background-image: url('storage{{$berita['cover_photo_path']}}')"></div>
                                                </div>
                                            </a>
                                            <span class="post-media_title">&copy; Image Copyrights CKN Pagimana</span>
                                        </div>
                                        <div class="list-post-content">
                                            <h3 {{ Popper::theme('danger')->distance(30)->delay(200,0)->placement('top', 'middle')->pop($berita->title)}}><a href="{{route('filamentblog.post.show', ($berita['slug']))}}">{{str($berita->title)->words(5, ' ...')}}</a></h3><!--Link ke Berita-->
                                            <span class="post-date"><i class="far fa-clock"></i>  {{$berita->published_at->format('d M Y')}}</span>
                                        </div>
                                    </div>
                                    <!--list-post end-->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{-- <a href="blog2.html" class="dark-btn fl-wrap"> Baca Lebih Banyak </a> --}}
            {{$beritas->links('vendor/livewire/bootstrap', data: ['scrollTo' => '#list-berita-lokal'])}}
        </div>
        <!-- section end -->
    </div>
    <div class="col-md-4" wire:ignore>
        <!-- sidebar   -->
        <div class="sidebar-content fl-wrap fix-bar">
            <!-- box-widget -->
            <div class="box-widget fl-wrap">
                <div class="box-widget-content">
                    <div class="single-grid-slider slider_widget">
                        <div class="slider_widget_title">Editor's Choice</div>
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="grid-post-item     fl-wrap">
                                        <div class="grid-post-media gpm_sing">
                                            <div class="bg-wrap">
                                                <div class="bg" data-bg="{{asset('gmag/images/all/1.jpg')}}"></div>
                                                <div class="overlay"></div>
                                            </div>
                                            <div class="grid-post-media_title">
                                                <a class="post-category-marker" href="category.html">Technology</a>
                                                <h4><a href="post-single.html">Tesla it tested hypersonic Model-C</a></h4>
                                                <span class="video-date"><i class="far fa-clock"></i>16 january 2022</span>
                                                <ul class="post-opt">
                                                    <li><i class="far fa-comments-alt"></i> 11 </li>
                                                    <li><i class="fal fa-eye"></i>  55 </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- swiper-slide end-->
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="grid-post-item  bold_gpi  fl-wrap">
                                        <div class="grid-post-media gpm_sing">
                                            <div class="bg-wrap">
                                                <div class="bg" data-bg="{{asset('gmag/images/all/1.jpg')}}"></div>
                                                <div class="overlay"></div>
                                            </div>
                                            <div class="grid-post-media_title">
                                                <a class="post-category-marker" href="category.html">Politics</a>
                                                <h4><a href="post-single.html">Blue Origin practices with   orbital rocket in Florida</a></h4>
                                                <span class="video-date"><i class="far fa-clock"></i> 05 december 2021</span>
                                                <ul class="post-opt">
                                                    <li><i class="far fa-comments-alt"></i>  14 </li>
                                                    <li><i class="fal fa-eye"></i>  134 </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- swiper-slide end-->
                                <!-- swiper-slide-->
                                <div class="swiper-slide">
                                    <div class="grid-post-item  bold_gpi  fl-wrap">
                                        <div class="grid-post-media gpm_sing">
                                            <div class="bg-wrap">
                                                <div class="bg" data-bg="{{asset('gmag/images/all/1.jpg')}}"></div>
                                                <div class="overlay"></div>
                                            </div>
                                            <div class="grid-post-media_title">
                                                <a class="post-category-marker" href="category.html">Technology</a>
                                                <h4><a href="post-single.html">Scientific research goes to the next level</a></h4>
                                                <span class="video-date"><i class="far fa-clock"></i> 03 March 2022</span>
                                                <ul class="post-opt">
                                                    <li><i class="far fa-comments-alt"></i>  25 </li>
                                                    <li><i class="fal fa-eye"></i>  164 </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- swiper-slide end-->
                            </div>
                            <div class="sgs-pagination sgs_hor "></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- box-widget  end -->
            <!-- box-widget -->
            <div class="box-widget fl-wrap">
                <div class="box-widget-content">
                    <div id="weather-widget" class="ideaboxWeather" data-city="{{$city}}"></div>
                </div>
            </div>
            <!-- box-widget  end -->
            <!-- box-widget -->
            <div class="box-widget fl-wrap">
                <div class="widget-title">Follow Us</div>
                <div class="box-widget-content">
                    <div class="social-widget">
                        <a href="#" target="_blank" class="facebook-soc">
                        <i class="fab fa-facebook-f"></i>
                        <span class="soc-widget-title">Likes</span>
                        <span class="soc-widget_counter">2640</span>
                        </a>
                        <a href="#" target="_blank" class="twitter-soc">
                        <i class="fab fa-twitter"></i>
                        <span class="soc-widget-title">Followers</span>
                        <span class="soc-widget_counter">1456</span>
                        </a>
                        <a href="#" target="_blank" class="youtube-soc">
                        <i class="fab fa-youtube"></i>
                        <span class="soc-widget-title">Followers</span>
                        <span class="soc-widget_counter">1456</span>
                        </a>
                        <a href="#" target="_blank" class="instagram-soc">
                        <i class="fab fa-instagram"></i>
                        <span class="soc-widget-title">Followers</span>
                        <span class="soc-widget_counter">1456</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- box-widget  end -->
            <!-- box-widget -->
            <div class="box-widget fl-wrap">
                <div class="widget-title">Popular Tags</div>
                <div class="box-widget-content">
                    <div class="tags-widget">
                        <a href="#">Science</a>
                        <a href="#">Politics</a>
                        <a href="#">Technology</a>
                        <a href="#">Business</a>
                        <a href="#">Sports</a>
                        <a href="#">Food</a>
                    </div>
                </div>
            </div>
            <!-- box-widget  end -->
        </div>
        <!-- sidebar  end -->
    </div>

</div>
