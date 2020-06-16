<section class="articles-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-10 col-lg-12">
				@if($title)
				<h2 class="header-section text-center">{{ $title }}</h2>
				@endif
				<div class="articles-list js-slider-1-columns">

					@foreach($posts as $post)
					<article class="article-item">
						@if($post -> image)
						<div class="article-image">
							<div class="image-container">
								<img src="{{ $post -> image }}" alt="{{ $post -> name }}">
							</div>
						</div>
						@endif
						<div class="article-entry">
							<h3 class="border-under">{{ $post -> name }}</h3>
							<p>{{ $post -> excerpt }}</p>
							<a href="{{ $mws -> default ? route('mws_post',['site'=>$mws -> store ->  site,'post'=>$post -> slug]) : route('post',['post'=>$post -> slug]) }}" class="read-more-btn">Read more</a>
						</div>
					</article>
					@endforeach
					
				</div>
			</div>
		</div>
	</div>
</section>