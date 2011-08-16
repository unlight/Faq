jQuery(function($){
	
	$('ul.Faqs').accordion({
		canToggle: true,
		canOpenMultiple: true,
		handle: "strong",
		panel: "div"
	});
});