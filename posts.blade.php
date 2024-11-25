	<div class="col-lg-6 col-md-6">
			@php $no=1 @endphp
			@foreach($result_posts as $res_posts)
			@if($no%2!=0)
				<div class="blog">
					@if(!empty($res_posts->thumbnail))
						@php
							$aturan_file = explode(".", $res_posts->thumbnail);
							$extensi = end($aturan_file);
						@endphp
						@if($extensi=="JPG" || $extensi=="jpg" || $extensi=="jpeg" || $extensi=="JPEG" || $extensi=="png" || $extensi=="PNG" || $extensi=="gif")
							<div class="img-gallery">
								<a href="{{ asset($prefix_link.$res_posts->slug_posts) }}"><img src="{{ $res_posts->thumbnail }}" alt="{{$res_posts->title_posts}}" class="img-fluid img-height"></a>
							</div>
						@endif
					@endif
					<div class="blog-portal">
						<h2 class="head-title-page blog-title">{{ $res_posts->title_posts }}</h2>
						<div class="blog-meta">
							<i class="fa fa-calendar-check-o"></i>&nbsp; {{ Carbon\Carbon::parse($res_posts->publish_date)->formatLocalized('%A %d %B %Y') }}
							&nbsp; <i class="fa fa-user"></i>&nbsp; {{ $res_posts->user->nm_lengkap!=''?$res_posts->user->nm_lengkap:'-' }}
							&nbsp; <i class="fa fa-eye"></i>&nbsp; {{ $res_posts->hits!=''?$res_posts->hits:'0' }}
						</div>
						<p class="blog-content">{!! substr(strip_tags($res_posts->content), 0, 200) !!}</p>
						<div class="blog-footer">
							<div class="pull-left">
								<a href="{{ asset($prefix_link.$res_posts->slug_posts) }}" class="btn btn-sm btn-success btn-custom"><i class="fa fa-eye"></i>&nbsp; Baca</a>
							</div>
							<div class="pull-right">
								<div class="social-icons">
									<a href="whatsapp://send?text={{ asset($prefix_link.$res_posts->slug_posts) }}" class="btn btn-sm btn-shared popup_custom btn-success"><i class="fa fa-whatsapp"></i></a>
									<a href="http://www.facebook.com/sharer.php?u={{ asset($prefix_link.$res_posts->slug_posts) }}" rel="external" class="btn btn-sm btn-shared popup_custom btn-primary"><i class="fa fa-facebook"></i></a>
									<a href="http://twitter.com/share?source=sharethiscom&text={{$res_posts->title_posts}}&url={{ asset($prefix_link.$res_posts->slug_posts) }}" class="btn btn-sm btn-shared popup_custom btn-info"><i class="fa fa-twitter"></i></a>
									<a href="http://www.linkedin.com/shareArticle?mini=true&url={{ asset($prefix_link.$res_posts->slug_posts) }} &title={{$res_posts->title_posts}}&summary={{$res_posts->title_posts}}" class="btn btn-sm btn-shared popup_custom btn-danger"><i class="fa fa-linkedin"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
			@php $no++ @endphp
			@endforeach
		</div>
		<div class="col-lg-6 col-md-6">
			@php $no=1 @endphp
			@foreach($result_posts as $res_posts)
			@if($no%2==0)
				<div class="blog">
					@if(!empty($res_posts->thumbnail))
						@php
							$aturan_file = explode(".", $res_posts->thumbnail);
							$extensi = end($aturan_file);
						@endphp
						@if($extensi=="JPG" || $extensi=="jpg" || $extensi=="jpeg" || $extensi=="JPEG" || $extensi=="png" || $extensi=="PNG" || $extensi=="gif")
							<div class="img-gallery">
								<a href="{{ asset($prefix_link.$res_posts->slug_posts) }}"><img src="{{ $res_posts->thumbnail }}" alt="{{$res_posts->title_posts}}" class="img-fluid img-height"></a>
							</div>
						@endif
					@endif
					<div class="blog-portal">
						<h2 class="head-title-page blog-title">{{ $res_posts->title_posts }}</h2>
						<div class="blog-meta">
							<i class="fa fa-calendar-check-o"></i>&nbsp; {{ Carbon\Carbon::parse($res_posts->created_at)->formatLocalized('%A %d %B %Y') }}
							&nbsp; <i class="fa fa-user"></i>&nbsp; {{ $res_posts->user->nm_lengkap!=''?$res_posts->user->nm_lengkap:'-' }}
							&nbsp; <i class="fa fa-eye"></i>&nbsp; {{ $res_posts->hits!=''?$res_posts->hits:'0' }}
						</div>
						<p class="blog-content">{!! substr(strip_tags($res_posts->content), 0, 200) !!}</p>
						<div class="blog-footer">
							<div class="pull-left">
								<a href="{{ asset($prefix_link.$res_posts->slug_posts) }}" class="btn btn-sm btn-success btn-custom"><i class="fa fa-eye"></i>&nbsp; Baca</a>
							</div>
							<div class="pull-right">
								<div class="social-icons">
									<a href="whatsapp://send?text={{ asset($prefix_link.$res_posts->slug_posts) }}" class="btn btn-sm btn-shared popup_custom btn-success"><i class="fa fa-whatsapp"></i></a>
									<a href="http://www.facebook.com/sharer.php?u={{ asset($prefix_link.$res_posts->slug_posts) }}" rel="external" class="btn btn-sm btn-shared popup_custom btn-primary"><i class="fa fa-facebook"></i></a>
									<a href="http://twitter.com/share?source=sharethiscom&text={{$res_posts->title_posts}}&url={{ asset($prefix_link.$res_posts->slug_posts) }}" class="btn btn-sm btn-shared popup_custom btn-info"><i class="fa fa-twitter"></i></a>
									<a href="http://www.linkedin.com/shareArticle?mini=true&url={{ asset($prefix_link.$res_posts->slug_posts) }} &title={{$res_posts->title_posts}}&summary={{$res_posts->title_posts}}" class="btn btn-sm btn-shared popup_custom btn-danger"><i class="fa fa-linkedin"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
			@php $no++ @endphp
			@endforeach
		</div>
		<div class="col-sm-12">
			<center>{{ $result_posts->onEachSide(1)->links() }}</center>
		</div>
