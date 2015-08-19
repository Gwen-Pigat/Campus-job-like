$(document).ready(function(){	

	$(".member-1").hover(function(){
		$(".team-info-1").toggle(100);
	});
	$(".member-2").hover(function(){
		$(".team-info-2").toggle(100);
	});
	$(".member-3").hover(function(){
		$(".team-info-3").toggle(100);
	});
	$(".member-4").hover(function(){
		$(".team-info-4").toggle(100);
	});
	$(".member-5").hover(function(){
		$(".team-info-5").toggle(100);
	});
	$(".member-6").hover(function(){
		$(".team-info-6").toggle(100);
	});
	$(".lateral").hover(function(){
		$(".lateral-aside").fadeToggle(100);
	});
	
	$(".enregistrement").fadeOut(2000);

	$(".container").fadeIn(1000);
	$(".carousel").fadeIn(1000);
	$(".box").delay(2000).fadeOut(1000);
	
	$(".container.validation_offre").delay(2500).fadeIn(500);
	$(".loading").fadeOut(2000);

});