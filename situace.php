<?php
include "./header.php";
?>
<div class="article">
<div class="row">
	<div class="col-lg-12">
		<div class="px-3 pb-3">
			<h1 class="p-3">Situace</h1>
		</div>
		<div class="portfolio-item row pl-4 pb-4">
			<div class="item col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage1.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage1.png" alt="">
				</a>
			</div>
			<div class="col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage2.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage2.png" alt="">
				</a>
			</div>
			<div class="col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage3.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage3.png" alt="">
				</a>
			</div>
			<div class="col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage4.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage4.png" alt="">
				</a>
			</div>
			<div class="col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage5.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage5.png" alt="">
				</a>
			</div>
			<div class="col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage6.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage6.png" alt="">
				</a>
			</div>
			<div class="col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage7.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage7.png" alt="">
				</a>
			</div>
			<div class="col-lg-3 col-md-4 col-6 col-sm">
				<a href="./stages/stage8.png" class="fancylight popup-btn" data-fancybox-group="light">
					<img class="img-fluid img-thumbnail" src="./stages/stage8.png" alt="">
				</a>
			</div>
		</div>
		<div class="p-3"><a href="./stages/stages.pdf"><img src="./images/pdf.png" width="32px">Stáhnout vše</a></div>
	</div>
</div>
</div>

<script>
// https://isotope.metafizzy.co/layout-modes.html
// $('.portfolio-item').isotope({
//  	itemSelector: '.item',
//  	layoutMode: 'fitRows',
//  });


  $('.portfolio-menu ul li').click(function(){
  	$('.portfolio-menu ul li').removeClass('active');
  	$(this).addClass('active');
  	
  	var selector = $(this).attr('data-filter');
  	$('.portfolio-item').isotope({
  		filter:selector
  	});
  	return  false;
  });
  $(document).ready(function() {
  var popup_btn = $('.popup-btn');
  popup_btn.magnificPopup({
  type : 'image',
  gallery : {
  	enabled : true
  }
  });
  });
</script>


<?php include "./footer.php";?>