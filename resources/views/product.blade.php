@extends('layouts.standard')

@section('content')

<div class="breadcrumbs">
	<div class="container">
		<p>
			<a href="#">Home</a>
			<a href="#">Products</a>
			<span class="current">{{ $product -> name }}</span>
		</p>
	</div>
</div>

<section class="product-characteristics">
	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-md-12">
				<div class="product-actions">
					<div class="image-container">
						<img src="https://cdn.trivita.com/US/EN/images/products/{{ $product -> product_id }}-lrg.png" alt="{{ $product -> name }}" />
					</div>
					<div class="block-text">
						<form action="#" onsubmit="return false">
							<div class="title-block">
								<p class="name">{{ $product -> name }}</p>
								<p class="price">${{ $product -> net_price ? $product -> net_price : $product -> retail_price }}</p>
							</div>
							<div class="quantity-block">
								<p>
									<span>{{ $product -> package }}</span>
									<span>{{ $product -> serving }}</span>
								</p>

								<div class="quantity-input">
									<input class="quantity-arrow-minus" type="button" value="-" />
									<input class="quantity-num" name="quantity" type="number" value="1" readonly />
									<input class="quantity-arrow-plus" type="button" value="+" />
								</div>
							</div>
							@if($equivalents)
							<div class="custom-select">
								<select name="product-selection">
									@foreach($equivalents as $equivalent)
 									<option value="{{ $equivalent -> product_id }}">{{ $equivalent -> name }}</option>
									@endforeach
								</select>
							</div>
							@endif
							<input type="button" data-product="{{ $product -> name }}" data-id="{{ $product -> product_id }}" data-price="{{ $product -> net_price ? $product -> net_price : $product -> retail_price }}" onclick="addToCart(this,true,true)" class="btn-wide" value="Add to cart" />
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-7 col-md-12">
				<div class="product-info">
					<h1 class="product-title">{{ $product -> name }}</h1>
					<div class="stars-block big four border-under d-flex align-items-center" data-score="{{ $product -> review_score }}">
						<ul>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
						</ul>
						<a href="#" class="number-reviews">(<span>{{ $product -> review_total }}</span> Reviews)</a>
					</div>
					{!! $product -> short_description !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-5 col-md-12">
			</div>
			<div class="col-lg-7 col-md-12">
				<div class="acc product-accordion">
					@if($product -> long_description)
					<div class="acc-card">
						<div class="acc-title">Read more</div>
						<div class="acc-panel">
							{!! $product -> long_description !!}
						</div>
					</div>
					@endif
					<div class="acc-card prod-info">
						<div class="acc-title">Product Information</div>
						<div class="acc-panel">
							{!! $product -> details !!}
							<p><a href="#" data-url="//cdn.trivita.com/US/EN/images/products/labels/{{ $product -> product_id }}-label-1-lrg.jpg" onclick="return viewInfo(this)">View Supplement Facts Panel</a></p>
							@if($product -> seals)
							<ul class="seals">
								@foreach($product -> seals as $seal)
								<li><img src="//cdn.trivita.com/US/EN/images/product-seals/{{ $seal -> ImageFilePath }}" alt="{{ $seal -> Description }}" />@if($seal -> Definition)<a href="#" onclick="return displaySealInfo(this)">View Details</a><p>{{ $seal -> Definition }}</p>@endif</li>
								@endforeach
							</ul>
							@endif
						</div>
					</div>
					@if($product -> faq)
					<div class="acc-card">
						<div class="acc-title">Frequently Asked Questions</div>
						<div class="acc-panel">
							@foreach($product -> faq as $faq)
							<p class="question">{{ $faq -> Question }}</p>
							{!! $faq -> Answer !!}
							@endforeach
						</div>
					</div>
					@endif
					<!--div class="acc-card">
						<div class="acc-title">Review</div>
						<div class="acc-panel">
							<ul class="review-faq-list">
								<li>
									<p class="review-faq-text"></p>
									<p class="review-faq-text-author">- John Dow</>
								</li>
							</ul>
						</div>
					</div-->
					@if($product -> references)
					<div class="acc-card">
						<div class="acc-title">References</div>
						<div class="acc-panel">
							@foreach($product -> references as $reference)
							<p>{{ $reference -> Text }}</p>
							@endforeach
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>

@if($product -> reviews)
<section class="testimonials-section accent-bg">
	<div class="container">
		<div class="row">
			<div class="list-testimonials col-md-10 offset-md-1">

				<div class="testimonial-slider">
					@foreach($product -> reviews -> take(5) as $review)
					<div class="testimonial-item">
						<div class="stars-block four d-flex justify-content-center" data-score="{{ $review -> score }}">
							<ul>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<p class="testimonial-text text-center font-italic">
							{{ $review -> content }}
						</p>
					</div>
					@endforeach	
				</div>
			</div>
		</div>
	</div>
</section>
@endif

<x-posts limit="3" title="Recent Blog Posts" />

@endsection