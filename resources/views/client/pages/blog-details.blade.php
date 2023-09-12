@extends('client.master')
@section('title','Tin tức')
@section('content')

<section class="banner_area">
	<div class="banner_inner d-flex align-items-center">
		<div class="container">
			<div class="banner_content d-md-flex justify-content-between align-items-center">
				<div class="mb-3 mb-md-0">
					<h2>Tin tức nổi bật</h2>
					<p>Luôn được cập nhật liên tục</p>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="blog_area section_gap">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 mb-5 mb-lg-0">
				<div class="blog_left_sidebar">
					<article class="blog_item">
						<div class="blog_item_img">
							<img class="card-img rounded-0" src="{{ asset('public/uploads/blog') }}/{{$blog->picture}}" alt="">
						</div>
						<div class="blog_details">
							<a class="d-inline-block" href="single-blog.html">
								<h2>{{$blog->title}}</h2>
							</a>
							<p>{{$blog->content}}</p>
						</div>
					</article>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="blog_right_sidebar" style="margin-top: 30px;">
					<aside class="single_sidebar_widget popular_post_widget">
						<h3 class="widget_title">Bài viết khác</h3>
						@foreach($blogs as $blog)
						<div class="media post_item">
							<img style="width:100px; height:70px;border-radius:3%" src="{{ asset('public/uploads/blog') }}/{{$blog->picture}}" alt="post">
							<div class="media-body">
								<a href="{{url('blogs/details')}}/{{$blog->id}}">
									<h3>{{$blog->title}}</h3>
								</a>
							</div>
						</div>
						@endforeach
				</div>
				</aside>

			</div>
		</div>
	</div>
	</div>
</section>


@endsection