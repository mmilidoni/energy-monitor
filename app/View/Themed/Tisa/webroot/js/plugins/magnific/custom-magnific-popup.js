$(function(){
	$.fn.customMagnificPopup = function() {
		this.magnificPopup({
			midClick: true
		});
		var href = this.attr("href");
		var value = this.attr("data-val");
		this.click( function(e) {
			$(href + ' .submit-button').attr('href', function(i, val){return val + value});
		});
	}
});
