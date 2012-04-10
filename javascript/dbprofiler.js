$(document).ready(function() {
	
	$('td.query').each(function(){
		$(this).click(function(){
			var hidden = $(this).find('.hide');
			var displayed = $(this).find('.display');
			displayed.removeClass('display').addClass('hide');
			hidden.removeClass('hide').addClass('display');
		});
	});
});