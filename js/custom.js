 $(function () {

 	$(".datepicker").datepicker({
 		autoclose: true,
 		todayHighlight: true
 	});
 	$("#go-box").click(function () {

 		$(".mega-box").slideToggle();


 	});
 	$('#vertical').lightSlider({
 		gallery: true,
 		item: 1,
 		vertical: true,
 		verticalHeight: 384,
 		vThumbWidth: 49,
 		thumbItem: 5,
 		thumbMargin: 11,
 		slideMargin: 0,



 	});
 	$('.ads-slider').owlCarousel({
 		loop: true,
 		margin: 0,
 		nav: true,
 		items: 1,
 		dots: false,
 		navText: ["<img src='images/left-arrow.svg'>", "<img src='images/right-arrow.svg'>"],

 	});
 	$('#vertical-two').lightSlider({
 		gallery: true,
 		item: 1,
 		vertical: true,
 		verticalHeight: 592,
 		vThumbWidth: 49,
 		thumbItem: 8,
 		thumbMargin: 11,
 		slideMargin: 20
 	});



 	$('.main-foto-slider').owlCarousel({
 		loop: true,
 		margin: 19,
 		nav: true,
 		dots: false,
 		navText: ["<img src='images/left-arrow.svg'>", "<img src='images/right-arrow.svg'>"],
 		responsive: {
 			0: {
 				items: 1
 			},
 			480: {
 				items: 2
 			},
 			600: {
 				items: 3
 			},
 			1000: {
 				items: 4
 			}
 		}
 	});

 	$('.modal-slider').owlCarousel({
 		loop: true,
 		margin: 200,
 		nav: false,
 		dots: false,
 		center: true,
 		responsive: {
 			0: {
 				items: 1
 			},
 			576: {
 				items: 2
 			},
 			600: {
 				items: 2.1,
 				margin: 100,
 			},
 			1000: {
 				items: 2.1
 			}
 		}
 	});









 });
