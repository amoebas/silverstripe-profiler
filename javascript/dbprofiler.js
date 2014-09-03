$(document).ready(function() {
	
	$('td .cursor').each(function(){
		$(this).dblclick(function(){
			var hidden = $(this).parent().find('.hide');
			var displayed = $(this).parent().find('.display');
			console.log(displayed);
			displayed.removeClass('display').addClass('hide');
			hidden.removeClass('hide').addClass('display');

			$('html, body').animate({
				scrollTop: $(this).parent().offset().top
			}, 0);

			return false;
		});
	});
});