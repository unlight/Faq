jQuery(function($){
	
	if ($.fn.accordion) {
		$('ul.Faqs').accordion({
			canToggle: true,
			canOpenMultiple: true,
			handle: "strong",
			panel: "div"
		});		
	}
	
	
	if ($.fn.autogrow) {
		$('.AskQuestionForm input#Form_Question').livequery(function() {
			$(this).autogrow();
		});
	}
});