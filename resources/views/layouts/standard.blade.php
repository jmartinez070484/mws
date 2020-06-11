<!doctype html>
<html xml:lang="{{ app()->getLocale() }}" lang="{{ app()->getLocale() }}">
<head>
<title>@if(isset($title)) {{ $title }} | @endif {{ $store -> name }} Wellness Store</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- css stylesheets -->
@if($css = Helper::fileVersion('/css/app.css'))
<link href="{{ $css }}" rel="stylesheet" type="text/css" />
@endif

<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
      
</head>
<body class="{{ $view }}">

<header class="header">

	<a href="/" class="logo">
		<div class="wrap-logo">
			<img src="{{ asset('/assets/main-logo.png') }}" alt="logo My Wellness Store">
		</div>
		<p>My Wellness Store</p>
	</a>

	<div class="menu_wrap">
		<div class="menu_content">
			<ul class="nav">
				<li class="nav_item">
					<a href="/">My Wellness Story</a></li>
				<li class="nav_item">
					<a href="/products">Products</a>
				</li>
				<li class="nav_item">
					<a href="/blog">Blog</a>
				</li>
				<li class="nav_item">
					<a href="#" onclick="return redirectToCart()">Cart</a>
				</li>
			</ul>
			<div class="right-nav">
				<ul class="social-nav">
					@if($store -> facebook)
					<li><a href="{{ $store -> facebook }}" class="facebook-icon"></a></li>
					@endif
					@if($store -> youtube)
					<li><a href="{{ $store -> youtube }}" class="youtube-icon"></a></li>
					@endif
				</ul>
				<a href="{{ route('clinic') }}" class="header-btn">TriVita Clinic of Integrative Medicine</a>
			</div>
		</div>
		<div class="burger">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
		</div>
	</div>

</header>	

<main class="{{ $view }}">

@yield('content')

</main>

<footer class="main-footer">
	<div class="container">
		<ul class="footer-nav">
			<li><a href="{{ route('policy') }}">Privacy Policy</a></li>
			<li><a href="{{ route('terms') }}">Terms of Use</a></li>
			<li><a href="{{ route('contact') }}">Contact Us</a></li>
		</ul>
		<p class="copyright-year">©{{ date('Y') }}</p>
		<p class="copyright-brand">Powered By TriVita</p>
	</div>
</footer>

<div class="modal">
	<div class="row">
		<div class="content">
		</div>
	</div>
</div>

@if(isset($equivalents))
<script>
var productEquivalents = {!! json_encode($equivalents) !!};
</script>
@endif
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="/js/slick.min.js"></script>
@if($js = Helper::fileVersion('/js/app.js'))
<script src="{{ $js }}"></script>
@endif

</body>
</html>