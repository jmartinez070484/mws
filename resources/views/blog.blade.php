@extends('layouts.standard')

@section('content')

<x-posts limit="4" pagination="1" />

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