@extends('temp/temp_web') @section('judul', 'Berita - PPID Kabupaten Morowali - ') @section('tambah_css') @endsection
@section('isi') <div class="no-bottom no-top" id="content">
        <div id="top"></div> <!-- section begin -->
        <section style="margin-top: 90px;" id="subheader"
            data-bgimage="url({{ asset('') }}assets/web/images/background/5.png) bottom">
            <div style="margin-top: -100px;" class="center-y relative text-center">
                <div class="container">
                    <div style="height: " class="row">
                        <div class="col text-center" style="padding-top: 70px; margin-bottom: -50px;">
                            <h2 style="color: white">Berita</h2>
                            <p style="color: white">Beranda <i class="arrow_carrot-2right"></i> <a style="color: red"
                                    href="#">Berita</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="no-top mt50">
            <div class="container">
                <div class="row"> 
                    @if (empty($berita))
                        <div class="col-12  mb30">
                            <center>[APIErrorFetchData]</center>
                        </div>
                    @else
                        @foreach ($berita as $berita)
                            <div class="col-lg-4 col-md-6 mb30">
                                <div class="bloglist item">
                                    <div class="post-content">
                                        <div class="post-image"> <img alt="" width="100" height="250"
                                                src="{{ $berita->thumbnail }}">
                                            <div class="post-info">
                                                <div class="inner"> <span class="post-date" style="color: white"><i
                                                            class="fa fa-calendar">&nbsp;</i>
                                                        {{ date('d-m-Y', strtotime($berita->publish_date)) }}&nbsp;&nbsp;&nbsp;
                                                        <i class="fa fa-clock-o">&nbsp;</i>
                                                        {{ date('H:i:s', strtotime($berita->publish_date)) }} <a
                                                            style="color: white">&nbsp;&nbsp;&nbsp; <i
                                                                class="fa fa-user">&nbsp;</i>
                                                            {{ ucwords(strtok($berita->nama_pub, ' ')) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="post-text">
                                            <h4>
                                                <a href="{{ url('https://morowalikab.go.id/home/blogs/berita/read') }}/{{ $berita->slug_posts }}">{{ $berita->title_posts }}</a>
                                            </h4>
                                            <p> @php
                                                $text = strip_tags($berita->content);
                                                $text2 = substr($text, 0, 100);
                                            @endphp {{ $text2 }} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="row">
                    <div class="col-12 text-center"> <a href="https://morowalikab.go.id/home/blogs/berita"
                            class="btn btn-outline-primary">Untuk berita lengkap silahkan klik disini</a> </div>
                </div>
            </div>
        </section>
    </div>
    <footer class="fixed-bottom" style="padding-top: 10px; padding-bottom: 10px; background-color: darkblue;">
        <div class="container">
            <div class="row align-items-center">
                <div class="text-sm-left text-sm-center">
                    <h5 style="font-size: 12px;" class="no-bottom">© {{ date('Y') }}. Pejabat Pengelola Informasi dan
                        Dokumentasi (PPID) Kabupaten Morowali </h5>
                </div>
            </div>
        </div>
    </footer>
@endsection

@section('tambah_js')
@endsection
