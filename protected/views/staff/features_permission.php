<?php
if ($this->is_admin()) {
    exit;
}

header('Content-Type: application/javascript');

$js = '';

$notvisible = ProgramPermission::model()->with('feature')->findAll("account_id = :acct_id AND visible != :visible", array(
    ':acct_id'=>Yii::app()->session['account_id'],
    ':visible'=>'on',
));

if (!empty($notvisible))
{
    foreach($notvisible as $k=>$v){
        $feature = ProgramFeatures::model()->find('program_code=:code', array(':code'=>$v->program_code));
        
        // pages not allowed to view
        if ($feature->feature_type == 'page')
            $js .= 'pages.push("'. $feature->page_identifier .'");'."\n";

        // sections not allowed to view
        if ($feature->feature_type == 'section')
            $js .= 'sections.push("'. $feature->feature_identifier .'");'."\n";
        
        if ($feature->feature_type == 'button')
            $js .= 'buttons.push("'. $feature->feature_identifier .'");'."\n";
        
        if ($feature->feature_type == 'gotomenu')
            $js .= 'gotomenus.push("'. $feature->feature_identifier .'");'."\n";
        
    }    
}

?>


var pages     = [];
var sections  = [];
var buttons   = [];
var gotomenus = [];

(function() {
	<?php echo $js; ?>
	
	
	// pages
	$.each(pages, function(k, v) {
    	var curl = global_config.current_url;
    	curl = curl.split('/');
    	debugger;
		var rurl = v.split('/');
		
		var cond1 = (curl[3] === rurl[1]);
		var cond2 = (curl[4] === rurl[2]);
		if (cond1 && cond2) {
			location.href = '<?php echo $this->programURL();?>/invalid_access.html';	
		}
	});
	
	// sections
	$.each(sections, function(k, v) {
		$(v).remove();
	});
	
	// buttons
	$.each(buttons, function(k, v) {
		$(v).remove();
	});
	
	// buttons
	$.each(gotomenus, function(k, v) {
		$(v).remove();
	});
	
})();