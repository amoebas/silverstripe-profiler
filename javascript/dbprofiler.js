$(document).ready(function() {
	
	$('td').each(function(){
		$(this).click(function(e){
			e.preventDefault();
			var hidden = $(this).find('.hide');
			var displayed = $(this).find('.display');
			displayed.removeClass('display').addClass('hide');
			hidden.removeClass('hide').addClass('display');
		});
	});
});