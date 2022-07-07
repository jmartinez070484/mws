@extends('layouts.standard')

@section('content')

<section class="header-page products-page">
	<div class="container text-center">
		<h1>Feel Better <span>Today!</span></h1>
	</div>
</section>

<section class="content-section">
	<div class="container-md">
		<div class="row">
			<div class="col-12">
				<h2>Conquer Inflammation & Feel Better!</h2>
				<p>Receive $50 off your first wellness regimen when you choose from 1 of the 3 packages. Included with your order are lifetime Premier Membership benefits and the Feel Better Guide, helping you with nutrition, activities, and habits for a healthier anti-inflammatory life.</p>
			</div>
		</div>
	</div>
</section>

<section class="product-section">
	<div class="container">
		<div class="row justify-content-center product-list">
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="product-card">
					<div class="image-container">
						<img src="https://cdn.trivita.com/US/EN/images/products/2745-lrg.png" alt="Vital C Pack">
					</div>
					<div class="block-text">
						<h3 class="product-name border-under">Platinum Package</h3>
						<div class="detail-block">
							<ul>
								<li>Nopalea 4-pack</li>
								<li>Omega3 Prime</li>
								<li>Trans-resveratrol</li>
								<li>Loyalty VitaPoints. value of $36 (20%)*</li>
								<li>Auto-enrollment in monthly shipping to keep you on track</li>
								<li>Feel Better Guide</li>
							</ul>
							<p class="price">Price: $179.97 - $50.00 = $129.97</p>
						</div>
						<a href="#" data-product="Vital C Pack" data-id="2745" data-price="39.98" onclick="return addToCart(this,true,true)" class="btn-wide">Add to cart</a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="product-card">
					<div class="image-container">
						<img src="https://cdn.trivita.com/US/EN/images/products/2745-lrg.png" alt="Vital C Pack">
					</div>
					<div class="block-text">
						<h3 class="product-name border-under">Gold Package</h3>
						<div class="detail-block">
							<ul>
								<li>Nopalea 4-pack</li>
								<li>Trans-Resveratrol</li>
								<li>Loyalty VitaPoints, value of $30 (20%)*</li>
								<li>Auto-enrollment in monthly shipping to keep you on track</li>
								<li>Feel Better Guide</li>
							</ul>
							<p class="price">Price: $149.98 - $50.00 = $99.98</p>
						</div>
						<a href="#" data-product="Vital C Pack" data-id="2745" data-price="39.98" onclick="return addToCart(this,true,true)" class="btn-wide">Add to cart</a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
				<div class="product-card">
					<div class="image-container">
						<img src="https://cdn.trivita.com/US/EN/images/products/2745-lrg.png" alt="Vital C Pack">
					</div>
					<div class="block-text">
						<h3 class="product-name border-under">Silver Package</h3>
						<div class="detail-block">
							<ul>
								<li>-Nopalea 4-pack</li>
								<li>Loyalty VitaPoints, value of $24 (20%)*</li>
								<li>Auto-enrollment in monthly shipping to keep you on track</li>
								<li>Feel Better Guide</li>
							</ul>
							<p class="price">Price: $119.99 - $50.00 = $69.99</p>
						</div>
						<a href="#" data-product="Vital C Pack" data-id="2745" data-price="39.98" onclick="return addToCart(this,true,true)" class="btn-wide">Add to cart</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="content-section">
	<div class="container-md">
		<div class="row">
			<div class="col-12">
				<p>*Loyalty VitaPoints applied on next order<br />Disclaimer: One-time purchase per household. First-time customers only. </p>
			</div>
		</div>
	</div>
</section>

@endsection