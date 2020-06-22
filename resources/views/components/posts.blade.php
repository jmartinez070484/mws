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
							<p>{!! $post -> type == 1 ? Helper::excerpt($post -> content,250) : $post -> excerpt !!}</p>
							@if(isset($post -> reference_id))
							<a href="{{ $mws -> default ? route('mws_post',['site'=>$mws -> store ->  site,'id'=>$post -> reference_id]) : route('post',['id'=>$post -> reference_id]) }}" class="read-more-btn">Read more</a>
							@else
							<a href="{{ $mws -> default ? route('mws_post',['site'=>$mws -> store ->  site,'id'=>$post -> id]) : route('post',['id'=>$post -> id]) }}" class="read-more-btn">Read more</a>
							@endif
						</div>
					</article>
					@endforeach
				</div>
				@if($pagination)
				{{ $posts -> links() }}
				@endif
			</div>
		</div>
	</div>
</section>