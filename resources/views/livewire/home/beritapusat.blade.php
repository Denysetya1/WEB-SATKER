<div>
    @if ($pusatnews != null)
        <section>
            <div class="container">
                <div class="section-title sect_dec">
                    <h2>Berita Kejaksaan Agung RI</h2>
                    <h4>Lihat Berita Terbaru Dari Seluruh Indonesia</h4>
                </div>
                <div class="row">
                    @foreach ($pusatnews as $pusat)
                        @if ($loop->first)
                            <div class="col-md-5">
                                <div class="list-post-wrap list-post-wrap_column list-post-wrap_column_fw">
                                    <!--list-post-->
                                    <div class="list-post fl-wrap">
                                        <a class="post-category-marker" href="#">Berita</a>
                                        <div class="list-post-media">
                                            <a href="{{$pusat['link']}}" target="blank">
                                                <div class="bg-wrap">
                                                    <div class="bg" data-bg="{{$pusat['img']}}"></div>
                                                </div>
                                            </a>
                                            <span class="post-media_title">&copy; Image Copyrights KEJAKSAAN AGUNG RI</span>
                                        </div>
                                        <div class="list-post-content">
                                            <h3><a href="{{$pusat['link']}}" target="blank">{{$pusat['title']}} </a></h3>
                                            <span class="post-date"><i class="far fa-clock"></i> {{$pusat['published']}}</span>
                                            <p>{{str($pusat['text'])->words(15, ' ...Baca Selengkapnya')}}</p>
                                        </div>
                                    </div>
                                    <!--list-post end-->
                                </div>
                                <a href="https://www.kejaksaan.go.id/berita" target="blank" class="dark-btn fl-wrap"> Baca Seluruh Berita </a>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-md-7">
                        <div class="picker-wrap-container fl-wrap">
                            <div class="picker-wrap-controls">
                                <ul class="fl-wrap">
                                    <li><span class="pwc_up"><i class="fas fa-caret-up"></i></span></li>
                                    <li><span class="pwc_pause"><i class="fas fa-pause"></i></span></li>
                                    <li><span class="pwc_down"><i class="fas fa-caret-down"></i></span></li>
                                </ul>
                            </div>
                            <div class="picker-wrap fl-wrap">
                                <div class="list-post-wrap  fl-wrap">
                                    @foreach ($pusatnews as $pusat)
                                        @if ($loop->first)
                                        @else
                                            <!--list-post-->
                                            <div class="list-post fl-wrap">
                                                <div class="list-post-media">
                                                    <a href="{{$pusat['link']}}" target="blank">
                                                        <div class="bg-wrap">
                                                            <div class="bg" data-bg="{{$pusat['img']}}"></div>
                                                        </div>
                                                    </a>
                                                    <span class="post-media_title">&copy; Image Copyrights KEJAKSAAN AGUNG RI</span>
                                                </div>
                                                <div class="list-post-content">
                                                    <a class="post-category-marker" href="#">Berita</a>
                                                    <h3><a href="{{$pusat['link']}}" target="blank">{{$pusat['title']}} </a></h3>
                                                    <span class="post-date"><i class="far fa-clock"></i> {{$pusat['published']}}</span>
                                                    <p>{{str($pusat['text'])->words(15, ' ...Baca Selengkapnya')}}</p>
                                                </div>
                                            </div>
                                            <!--list-post end-->
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="controls-limit fl-wrap"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="limit-box"></div>
        </section>
    @endif
</div>
