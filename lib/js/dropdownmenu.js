jQuery(document).ready(function($) {
	$('nav#select-nav select').change( function() {
		var url = $('nav#select-nav select option:selected').attr('value');
		window.location = url;
	});
});