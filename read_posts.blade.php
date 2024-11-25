@extends("themes01.layouts")
@section("title", "KABUPATEN MOROWALI - ".$result->title_posts)
@section("meta_og")
	<meta property="og:title" content="{{ $result->title_posts }}"/>
	<meta property="og:type" content="website"/>
	<meta property="og:description" content="{!! substr(strip_tags($result->content), 0, 100) !!}"/>
	{{-- <meta property="og:url" content="{{asset('/')}}"/> --}}
	<meta property="og:site_name" content="WEBSITE RESMI KABUPATEN MOROWALI"/>
	{{-- <meta property="og:image" content="{{str_replace('https','http',$result->thumbnail)}}" />
	<meta property="og:image:secure_url" content="{{$result->thumbnail}}" />
	<link itemprop="thumbnailUrl" href="{{str_replace('https','http',$result->thumbnail)}}">

	<meta property="og:image:type" content="image/jpeg" />
	 --}}

	<meta property="og:image" itemprop="image" content="{{$result->thumbnail}}" />
	{{-- <meta property="og:image:secure_url" content="{{$result->thumbnail}}" />  --}}
    <meta property="og:image:url" itemprop="image" content="{{$result->thumbnail}}" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:locale" content="en_id" />
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="630" />

@endsection


@section("content")
	{!! CustomFront::breadcrumb() !!}
	<div class="row">
		<div class="col-sm-12">
			<div class="head-blog-title">
				<h1>{{ $result->title_posts }}</h1>
			</div>
			<div class="social-icons" style="margin-bottom:20px;">
				<a href="whatsapp://send?text={{ asset('home/read/'.$result->slug_posts) }}" class="btn btn-sm btn-shared popup_custom btn-success"><i class="fa fa-whatsapp"></i></a>
				<a href="http://www.facebook.com/sharer.php?u={{ asset('home/read/'.$result->slug_posts) }}" rel="external" class="btn btn-sm btn-shared popup_custom btn-primary"><i class="fa fa-facebook"></i></a>
				<a href="http://twitter.com/share?source=sharethiscom&text={{$result->title_posts}}&url={{ asset('home/read/'.$result->slug_posts) }}" class="btn btn-sm btn-shared popup_custom btn-info"><i class="fa fa-twitter"></i></a>
				<a href="http://www.linkedin.com/shareArticle?mini=true&url={{ asset('home/read/'.$result->slug_posts) }} &title={{$result->title_posts}}&summary={{$result->title_posts}}" class="btn btn-sm btn-shared popup_custom btn-danger"><i class="fa fa-linkedin"></i></a>
			</div>
			<div class="single-blog">

				<div class="single-blog-meta">
					<i class="fa fa-calendar-check-o"></i>&nbsp; {{ Carbon\Carbon::parse($result->publish_date)->formatLocalized('%A %d %B %Y') }}
					&nbsp; <i class="fa fa-user"></i> {{ $result->user->nm_lengkap!=''?$result->user->nm_lengkap:'-' }}
					&nbsp; <i class="fa fa-eye"></i>&nbsp; {{ $result->hits!=''?$result->hits:'0' }}
				</div>
				<p>{!! $result->content !!}</p>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-sm-12">
			<ul class="list-group list-g">
				<li class="list-group-item list-g-item"><i class="fa fa-user"></i>&nbsp;&nbsp; Dibuat oleh <b>{{ $result->user->nm_lengkap!=''?$result->user->nm_lengkap:'-' }}</b></li>
				<li class="list-group-item list-g-item"><i class="fa fa-user-circle"></i>&nbsp; Dipublish oleh <b>{{ $publisher->nm_lengkap!=''?$publisher->nm_lengkap:'-' }}</b></li>
				<li class="list-group-item list-g-item">
					<div class="blog-kategori d-block">
						@foreach($data_kategori as $list_kategori_posts)
							<a href="{{asset('home/kategori/'.$list_kategori_posts->slug_kategori)}}"><i class="fa fa-folder-open"></i>&nbsp; {{ $list_kategori_posts->kategori }}</a> &nbsp;
						@endforeach
					</div>
				</li>
			</ul>
		</div>
	</div>

	@if(count($terkait)>0)
	<h3 class="panel-element panel-title-line">Berita Terkait</h3>
	<div class="row">
		<div class="col-sm-12">
			@foreach($terkait as $res_terkait)
				<div class="vertical-blog-post">
					@if(!empty($res_terkait->thumbnail))
					<div class="vertical-post-thumbnail">
						<a href="{{ asset('home/read/'.$res_terkait->slug_posts) }}"><img src="{{ $res_terkait->thumbnail }}" alt="{{$res_terkait->slug_posts}}"></a>
					</div>
					@endif
					<div class="vertical-post-content">
						<h4 class="vertika-post-title" align="justify"><a href="{{ asset('home/read/'.$res_terkait->slug_posts) }}">{{$res_terkait->title_posts}}</a></h4>
						<p class="vertika-post-content" align="justify">{!! substr(strip_tags($res_terkait->content), 0, 250) !!}</p>
						<p class='vertika-post-meta'>
							<i class="fa fa-calendar-check-o"></i>&nbsp; {{ Carbon\Carbon::parse($res_terkait->created_at)->formatLocalized('%A %d %B %Y') }}
							&nbsp; <i class="fa fa-user"></i>&nbsp; {{ $res_terkait->nm_lengkap!=''?$res_terkait->nm_lengkap:'-' }}
							&nbsp; <i class="fa fa-eye"></i>&nbsp; {{ $res_terkait->hits!=''?$res_terkait->hits:'0' }}
						</p>
					</div>
				</div>
			@endforeach

		</div>
	</div>
	@endif
@endsection
