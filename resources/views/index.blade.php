@extends('layouts.standard')

@section('content')

<section class="hero-section">
	<h1>{{ $store -> name }} <span>Wellness Store</span></h1>
</section>

@if($store -> story)
<section class="intro-section">
	<div class="container-md">
		<div class="row">
			<div class="col-lg-8 col-md-12">
				{!! $store -> story !!}
			</div>
		</div>
	</div>
</section>
@endif

@if($products)
<section class="top-products-section">
	<div class="container">
		<div class="row">

			<div class="col-lg-8 col-md-7">
				<h2 class="header-section text-center">Top Products</h2>

				<div class="product-list row">

					@foreach($products as $product)
					<div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
						<div class="product-card top-product">
							<a href="{{ route('product',['product'=>$product -> slug]) }}" class="wrap-product">
								<div class="image-container">
									<img src="https://cdn.trivita.com/US/EN/images/products/{{ $product -> product_id }}-lrg.png" alt="{{ $product -> name }}" />
								</div>
								<div class="block-text">
									<h3 class="product-name border-under">{{ $product -> name }}</h3>
									<p>{{ $product -> claim }}</p>
								</div>
							</a>
						</div>
					</div>
					@endforeach

				</div>

				<div class="wrap-btn text-center">
					<a href="{{ route('catalog') }}" class="btn">Show more</a>
				</div>
			</div>
			
			<x-sidebar/>
		</div>
	</div>
</section>
@endif

<x-posts limit="3" title="Recent Blog Posts" />

<!--aside only mobile-->
<div class="wrapper-aside-mobile">
    <div class="container">
        <div class="aside">
        </div>
    </div>
</div>
<!--end-aside only mobile-->

<section class="giving-back-section d-md-none">
	<div class="container">
		<h2 class="text-center">Giving Back</h2>
		<p class="text-center">The Houes of Giving Cras fermentum eros id lorem molestie, ut congue dui vestibulum. Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
	</div>
</section>

@endsection