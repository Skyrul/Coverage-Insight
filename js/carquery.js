/**
 * CarQuery API
 * 
 * Written for the use of Agency Thrive Only (EngageX)
 * 
 * Note: 
 *   Make sure the jQuery is loaded
 *   The Car Results here for all USA only
 */

//If jQuery is being used instead of $ temporarily re-assign the variable name
if(typeof jQuery == 'function')
{
	//If $ is already in use by something else, save it, and restore it when carquery is done.
	if (typeof $ != 'undefined')
		var $tmp = $;
		
	var $ = jQuery;
}

var CarQuery = function(){}

CarQuery.prototype = {
		getYears: function() {
			$.post(global_config.base_url + '/carquery/getyears', function(data) {
				return data;
			});
		},
		getMakes: function(year) {
			
		},
		getModels: function(make) {
			
		}
};