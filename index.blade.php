@extends('temp/temp_web')
@section('judul', 'PPID Kabupaten Morowali - ')
@section('tambah_css')

@endsection
@section('isi')
    <div class="no-bottom no-top" id="content">
        <div id="top"></div>
        <section class="full-height text-light relative no-top no-bottom vertical-center" data-stellar-background-ratio=".5">
            <div style="position: absolute; top: 0; width: 100%; height: 100%; z-index: -1;">
                <video loop muted autoplay preload="" poster="{{ asset('') }}assets/web/images/background/1.jpg"
                    style="position: absolute;  top: 50%;  left: 50%;  min-width: 100%;  min-height: 100%;  width: auto;  height: auto;  z-index: 0;  -ms-transform: translateX(-50%) translateY(-50%);  -moz-transform: translateX(-50%) translateY(-50%);  -webkit-transform: translateX(-50%) translateY(-50%);  transform: translateX(-50%) translateY(-50%);">

                    <source src="{{ asset('') }}assets/web/images/background3.mp4" type="video/mp4">
                </video>
            </div>
            <div class="overlay-gradient t50">
                <div class="center-y relative">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-12 wow fadeInLeft text-center" data-wow-delay=".5s"> <img
                                    src="{{ asset('') }}assets/web/images/misc/3.png" width="50%" class="img-fluid"
                                    alt="" /> </div> {{-- <div class="col-lg-12 wow fadeInRight text-center" data-wow-delay=".5s">                                <div class="h1"><br>                                    <div class="typed-strings">                                        <p><span class="id-color">PEJABAT</span></p>                                        <p><span class="id-color">PENGELOLA</span></p>                                        <p><span class="id-color">INFORMASI</span></p>                                        <p><span class="id-color">DAN</span></p>                                        <p><span class="id-color">DOKUMENTASI</span></p>                                    </div>                                    <div class="typed"></div>                                </div>                                <p class="lead"></p>                                <div class="spacer-20"></div>                                <div class="mb-sm-30"></div>                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="section-services" data-bgcolor="#F6F7FB">> <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="text-center">
                            <h2>Layanan Publik</h2>
                            <p style="margin-top: -20px; font-size: 20px;" class="lead">PPID Kabupaten Morowali </p>
                            <div class="spacer-10"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12  mb30 wow fadeInUp" data-wow-delay="0s"> <a
                            href="{{ route('info.berkala') }}">
                            <div class="fp-wrap f-invert mb20">
                                <div class="fp-icon"><i class="icon_documents_alt">
                                        <h4 style="color: white"><br>Informasi Berkala</h4>
                                    </i></div> <img src="{{ asset('') }}assets/web/images/services/1.jpg"
                                    class="fp-image img-fluid" alt="">
                            </div>
                        </a> </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb30 wow fadeInUp" data-wow-delay=".25s"> <a
                            href="{{ route('info.sermer') }}">
                            <div class="fp-wrap f-invert mb20">
                                <div class="fp-icon"><i class="fa icon_menu-square_alt2">
                                        <h4 style="color: white"><br>Informasi Serta Merta</h4>
                                    </i></div> <img src="{{ asset('') }}assets/web/images/services/2.jpg"
                                    class="fp-image img-fluid" alt="">
                            </div>
                        </a> </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb30 wow fadeInUp" data-wow-delay=".5s"> <a
                            href="{{ route('info.kecuali') }}">
                            <div class="fp-wrap f-invert mb20">
                                <div class="fp-icon"><i class="icon_document_alt">
                                        <h4 style="color: white"><br>Informasi Dikecualikan</h4>
                                    </i></div> <img src="{{ asset('') }}assets/web/images/services/7.jpg"
                                    class="fp-image img-fluid" alt="">
                            </div>
                        </a> </div>
                </div>
        </section>
        <section class="text-light" style="background-color: darkblue;">
            <div class="text-center">
                <h2><a style="color:white" href="{{ route('press.berita') }}">Berita</a>
                    <hr style="border-top: 3px solid white; width:2php00px;">
                </h2>
                <div class="spacer-20"></div>
                @if (empty($berita))
                    <center>[APIErrorFetchData]</center>
                @endif
            </div>
            <div id="ss-carousel" class="owl-carousel owl-theme">
                @foreach ($berita as $berita)
                    <div class="bloglist item">
                        <div class="post-content">
                            <div class="post-image"> <img alt="" width="100" height="250"
                                    src="{{ $berita->thumbnail }}">
                                <div class="post-info">
                                    <div class="inner"> <span class="post-date" style="color: white"><i
                                                class="fa fa-calendar">&nbsp;</i>
                                            {{ date('d-m-Y', strtotime($berita->publish_date)) }}&nbsp;&nbsp;&nbsp; <i
                                                class="fa fa-clock-o">&nbsp;</i>
                                            {{ date('H:i:s', strtotime($berita->publish_date)) }} <a
                                                style="color: white">&nbsp;&nbsp;&nbsp; <i class="fa fa-user">&nbsp;</i>
                                                {{ ucwords($berita->nama_pub) }} </span> </div>
                                </div>
                            </div>
                            <div class="post-text">
                                <h4><a class="text-white"
                                        href="{{ url('https://morowalikab.go.id/home/blogs/berita/read') }}/{{ $berita->slug_posts }}"
                                        target="_blank">{{ $berita->title_posts }}</a> </h4>
                                <p> @php
                                    $text = strip_tags($berita->content);
                                    $text2 = substr($text, 0, 100);
                                @endphp {{ $text2 }} </p> <a
                                    class="float-right btn btn-sm btn-primary"
                                    href="{{ url('https://morowalikab.go.id/home/blogs/berita/read') }}/{{ $berita->slug_posts }}"
                                    target="_blank">Baca Selengkapnya &nbsp; <i
                                        class="bg-color i-circle fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section> <br style="color:#F6F7FB;">
        <section class=" text-light" style="background-color: darkblue;">
            <div class="text-center">
                <h2 style="font-size: 32px;">STATISTIK PERMOHONAN<br>
                    <hr style="border-top: 3px solid white; width:php;">
                </h2>
                <div class="spacer-20"></div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay="0s">
                        <div class="de_count">
                            <h3 class="timer" data-to="{{ $jum_per }}" data-speed="3000">0</h3> <span
                                style="font-size: 20px;"><b>JUMLAH PERMOHONAN</b></span><br>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay=".25s">
                        <div class="de_count">
                            <h3 class="timer" data-to="{{ $jum_per_ter }}" data-speed="3000">0</h3> <span
                                style="font-size: 20px;"><b>PERMOHONAN DIKABULKAN</b></span><br>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay=".5s">
                        <div class="de_count">
                            <h3 class="timer" data-to="{{ $jum_per_tol }}" data-speed="3000">0</h3> <span
                                style="font-size: 20px;"><b>PERMOHONAN DITOLAK</b></span><br>
                        </div>
                    </div>
                </div> <br><br><br>
                <div class="row">
                    <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay="0s">
                        <div class="de_count">
                            <h3 class="timer" data-to="{{ $berkala }}" data-speed="3000">0</h3> <span
                                style="font-size: 20px;"><b>INFORMASI BERKALA</b></span><br>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay=".25s">
                        <div class="de_count">
                            <h3 class="timer" data-to="{{ $serta_merta }}" data-speed="3000">0</h3> <span
                                style="font-size: 20px;"><b>INFORMASI SERTA MERTA</b></span><br>
                        </div>
                    </div>
                    {{-- <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay=".5s">
                        <div class="de_count">
                            <h3 class="timer" data-to="{{ $setiap_saat }}" data-speed="3000">0</h3> <span
                                style="font-size: 20px;"><b>INFORMASI SETIAP SAAT</b></span><br>
                        </div>
                    </div> --}}
                    <div class="col-md-4 col-sm-12 wow fadeInUp" data-wow-delay=".5s">
                        <div class="de_count">
                            <h3 class="timer" data-to="{{ $dikecualikan }}" data-speed="3000">0</h3> <span
                                style="font-size: 20px;"><b>INFORMASI DIKECUALIKAN</b></span><br>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <footer class="footer-light">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <div class="widget">
                        <h5>Aplikasi</h5> <a href="https://morowalikab.go.id" target="_blank"><img alt=""
                                style="height:80;" class="logo img-fluid"
                                src="{{ asset('') }}assets/web/images/logo_pemda2.png"></a>
                        <div class="spacer-10"></div> <a href="https://www.lapor.go.id" target="_blank"><img
                                alt="" style="height:80;" class="logo img-fluid"
                                src="{{ asset('') }}assets/web/images/logo_lapor.png"></a> {{-- <div class="spacer-10"></div>                        <a href="https://www.lapor.go.id" target="_blank"><img alt="" style="height: 50;"                                class="logo img-fluid" src="{{ asset('') }}assets/web/images/logo_diskominfo.png"></a> --}}
                    </div>
                </div>
                <div class="col-md-5 col-sm-12 wow">
                    <div class="widget">
                        <h5>Peta</h5> <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d484.07560894302816!2d121.93726182167434!3d-2.4802455337615648!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xff4c654ad057244!2sDinas%20Infokom%20Kab.%20Morowali!5e0!3m2!1sid!2sid!4v1663225192223!5m2!1sid!2sid"
                            width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 wow">
                    <div class="widget">
                        <h5>Kontak</h5>
                        <ul>
                            <li><a href="#"><i class="icon_phone"></i>&nbsp; 0813-5561-5130</a></li>
                            <li><a href="#"><i class="icon_mail"></i>&nbsp; ppid@morowalikab.go.id</a></li>
                            <li><a href="#">
                                    <div class="spacer-10"></div><i class="icon_location"></i>
                                    <p style="text-align: justify">Jalan Trans Sulawesi, Kompleks Perkantoran Fonuasingko ,
                                        Bente, Kec. Bungku Tengah, Kabupaten Morowali, Sulawesi Tengah 94973</p>
                                </a></li>
                        </ul>
                        <div class="spacer-40"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 sm-text-center mb-sm-30">
                    <div class="mt10">Powered by @ Diskominfo Kabupaten Morowali</div>
                </div>
                <div class="col-md-6 text-md-right text-sm-left">
                    <div class="mt10">&copy; {{ date('Y') }} - PPID Kabupaten Morowali </div>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('tambah_js')
    <script>
        $(function() {
            $(".typed").typed({
                stringsElement: $('.typed-strings'),
                typeSpeed: 100,
                backDelay: 1500,
                loop: true,
                contentType: 'html',
                loopCount: false,
                callback: function() {
                    null;
                },
                resetCallback: function() {
                    newTyped();
                }
            });
        });
    </script>
@endsection
