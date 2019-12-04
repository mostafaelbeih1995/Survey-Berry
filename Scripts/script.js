$(document).ready(function(){

	$(".slider").slick({
		dots: true,
		adaptiveHeight: true,
		slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        Speed: 3000,
        prevArrow:'.left-arrows',
        nextArrow:'.right-arrows'
	});

});