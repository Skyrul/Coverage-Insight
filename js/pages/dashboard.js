// use for Dashboard counter auto-update
(function() {
	$('[class^="card-title card"]').text('..');
	
	// Check "card counters" update every 2seconds
	var i = 0;
	var timer = TimersJS.timer(2000, function(k, n) {
		// poll customer count
		$.post(global_config.base_url + '/dashboard/counter', function(data) {
			$('.card1').text(data.today_appt);
                        $('.card2').text(data.sales_oppt);
                        $('.card3').text(data.appt_missing_ap);
                        $('.card4').text(data.future_appt);
                        $('.card5').text(data.open_action_item);
                        $('.card6').text(data.appt_missing_na);
		});
		if (i==0) {
			$('[class^="card-title card"]').text('0');
		}
		i++;		
	});
})();