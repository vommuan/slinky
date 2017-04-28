$(function () {
	var shortenForm = $('.shorten-form').eq(0);
	
	shortenForm.on('submit', loadShortLink);
	
	function loadShortLink(event) {
		var resultBlock = shortenForm.closest('.site-index').find('.shorten-result').eq(0);
		
		$.post(shortenForm.attr('action'), shortenForm.serialize(), function(response) {
			resultBlock.html(response);
		});
		
		event.preventDefault();
	}
});