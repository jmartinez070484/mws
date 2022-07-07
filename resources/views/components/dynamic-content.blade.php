@if($valid)
<h2 class="header-section text-center">Feel Better Today</h2>
<p>Watch the latest episode of Feel Better Today to learn how to manage cronic inflamation.</p>
<div class="videoWrapper">
<iframe width="560" height="315" src="https://player.vimeo.com/video/709253457?h=bd8178b95a&amp;badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="Feel Better Today v1"></iframe>
</div>
<br /><br />
<h2 class="header-section text-center">Introductory Offer</h2>
<p>Take advantage of this outstanding offer today.</p>
<img src="/assets/feel-better-today-offer-banner.png" alt="Introductory Offer" />
<br /><br />
<p style="text-align:center"><a href="{{ $mws -> default && $store -> site ? route('mws_offer',['site'=>$store -> site]) : route('offer') }}" class="btn">View Offer</a></p>
<br /><br />
@endif