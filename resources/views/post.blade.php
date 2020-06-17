@extends('layouts.standard')

@section('content')

<div class="breadcrumbs">
	<div class="container-md">
		<p>
			<a href="{{ $mws -> default ? route('mws_index') : route('index') }}">Home</a>
			<a href="{{ $mws -> default ? route('mws_blog') : route('blog') }}">Blog</a>
			<span class="current">{{ $post -> name }}</span>
		</p>
	</div>
</div>

<div class="container-md">
	<div class="row">
		<div class="single-blog-section col-lg-8 col-md-7">
			<article class="article-wrapper">
				@if($post -> image)
				<img class="article-image" src="{{ $post -> image }}" alt="{{ $post -> name }}">
				@endif
				<h1 class="article-title border-under">{{ $post -> name }}</h1>
				{!! $post -> content !!}

				<div class="article-footer">
					<a href="{{ $mws -> default ? route('mws_blog') : route('blog') }}" class="back-btn">Back to Blog</a>

					<div class="share-nav">
						<p class="label-share">Share This</p>
						<ul>
							<li class="share-fb">
								<a href="#"></a>
							</li>
							<li class="share-twitter">
								<a href="#"></a>
							</li>
							<li class="share-in">
								<a href="#"></a>
							</li>
						</ul>
					</div>
				</div>

			</article>
		</div>
		<aside class="aside col-lg-4 col-md-5 ">
			<div class="widget widget-mobile">
				<h2 class="widget-title">Lastest blog post</h2>

				<div class="js-slider-1-2-columns">

					@foreach($recent as $post)
					<article class="border-above">
						<h3>{{ $post -> name }}</h3>
						<p>{{ $post -> excerpt }}</p>
						@if(isset($post -> reference_id))
						<a href="{{ $mws -> default ? route('mws_post',['site'=>$mws -> store ->  site,'id'=>$post -> reference_id]) : route('post',['id'=>$post -> reference_id]) }}" class="read-more-btn">Read more</a>
						@else
						<a href="{{ $mws -> default ? route('mws_post',['site'=>$mws -> store ->  site,'id'=>$post -> id]) : route('post',['id'=>$post -> id]) }}" class="read-more-btn">Read more</a>
						@endif
					</article>
					@endforeach

				</div>

			</div>
		</aside>
	</div>
</div>
@endsection