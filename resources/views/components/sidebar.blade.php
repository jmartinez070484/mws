<aside class="aside col-lg-4 col-md-5 hide-mobile">
	<div class="widget">
		<h2 class="widget-title">Latest Updates</h2>
        <i class="fa fa-caret-down"></i>
        <i class="fa fa-caret-up"></i>
        <div class="feed-container">
            <div class="feed">
                @foreach($feed as $article)
                <article class="border-above">
                    @if($date = \Carbon\Carbon::parse($article -> created_at))
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
	</div>
	@if($store -> specials)
		@include('partials/specials')
	@endif
</aside>