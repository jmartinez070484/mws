<aside class="aside col-lg-4 col-md-5 hide-mobile">
	<div class="widget">
		<h2 class="widget-title">Latest Updates</h2>
        <div class="feed-container">
            @foreach($feed as $article)
            <article class="border-above">
                @if($date = \Carbon\Carbon::parse($article -> created_al))
                <p class="date-post">{{ $date -> format('M') }} <span>- {{ $date -> format('d') }}</span></p>
                @endif
                <p class="content">{{ $article -> content }}</p>
                @if(isset($article -> image))
                <img class="widget-image" src="{{ $article -> image }}" alt="">
                @endif
            </article>
            @endforeach 
        </div>
	</div>
	@if($store -> specials)
		@include('partials/specials')
	@endif
</aside>