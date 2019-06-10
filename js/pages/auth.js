$(document).ready(function(e) {
	$('input[type="button"]').on('click', function(e) {
		var url = $(this).attr('href');
		location.href=url;
	});
});