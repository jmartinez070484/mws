@extends('layouts.standard')

@section('content')

<section class="header-page products-page">
	<div class="container text-center">
		<h1>Our <span>Products</span></h1>
	</div>
</section>

<section class="product-section">
	<div class="container">
		<div class="custom-filter" data-category="0">
			@if($categories)
			<ul class="filter-menu row">
				@foreach($categories as $category)
				<li class="col-md-3 item-menu" data-category="{{ $category -> id }}"><button value="all" class="text-center">{{ $category -> name }}</button></li>
				@endforeach
			</ul>
			@endif
		</div>
		<div class="row product-list">
			@foreach($products as $product)
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" data-category="{{ $product -> category }}">
				<div class="product-card">
					<div class="image-container">
						<img src="https://cdn.trivita.com/US/EN/images/products/{{ $product -> product_id }}-lrg.png" alt="{{ $product -> name }}">
						<a href="{{ route('product',$product -> slug) }}"></a>
					</div>
					<div class="block-text">
						<h3 class="product-name border-under">{{ $product -> name }}</h3>
						<div class="detail-block">
							<p class="price">Price: ${{ $product -> retail_price }}</p>
							<a href="{{ route('product',$product -> slug) }}" class="view-delails-btn">View Detials</a>
						</div>
						<a href="#" data-product="{{ $product -> name }}" data-id="{{ $product -> product_id }}" data-price="{{ $product -> net_price ? $product -> net_price : $product -> retail_price }}" onclick="return addToCart(this,true,true)" class="btn-wide">Add to cart</a>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<!--div class="wrap-btn text-center">
			<a href="#" class="btn">Show more</a>
		</div-->
	</div>
</section>

@endsection