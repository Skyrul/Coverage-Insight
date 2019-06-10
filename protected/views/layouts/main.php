<?php 
// check if account is not yet paid and due date (lock account)
if(AccountFacade::is_access_expired()) {
    $page_id = Yii::app()->getController()->getAction()->id;
    if ($page_id != 'setup') {
        header('Location: '. Yii::app()->request->baseUrl.'/account/setup#billing');
    } else {
        $access_expired_message = '<div class="access_expired_message"><h4>'. Yii::app()->name.' Access Locked</h4><p>Sorry, Your membership access to this apps have been temporarily locked out until you settled pending Invoice.</p></div>';
    }
}

// check if account is cancelled
if(AccountFacade::is_account_cancelled()) {
    echo '<meta http-equiv="refresh" content="5; url='. $this->programURL() .'/site/logout" />';
    echo '<h4>Your account is already cancelled.</h4><br>Redirecting in 5seconds';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Developed by Engagex (http://engagex.com) -->
	<!-- Application: <?php echo Yii::app()->name; ?> -->
	<!-- <?php echo Yii::app()->params['buildVersion']; ?> -->

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<meta name="viewport" content="width=device-width, initial-scale=1">
    
	<!-- Libraries (CSS) -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/datatables.net-dt/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/alertify.js/dist/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/@fengyuanchen/datepicker/dist/datepicker.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/select2/dist/css/select2.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/spectrum/spectrum.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/timepicker/jquery.timepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap-slider/dist/css/bootstrap-slider.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/input-tags/jquery.tagsinput.min.css" rel="stylesheet">

	<!-- Libraries (JS) -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/jquery/dist/jquery.min.js"></script>

	<!-- Base CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css?c=<?php echo time(); ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css?c=<?php echo time(); ?>" id="alertifyCSS">
	
	
	<?php if(isset(Yii::app()->session['account_id'])): ?>
	<!-- Override application theme colour -->
	<style type="text/css">
		body {
			color: <?php echo $this->applicationColour()['theme']->color_1; ?> !important;
		}
		.modal-header {
			background-color: <?php echo $this->applicationColour()['theme']->color_2; ?> !important;
			color: <?php echo $this->applicationColour()['theme']->color_1; ?> !important;
		}
		.page-label {
			color: <?php echo $this->applicationColour()['theme']->color_1; ?> !important;
		}
		.page-sub-label {
			color: <?php echo $this->applicationColour()['theme']->color_1; ?> !important;
		}
		.step-head {
			color: <?php echo $this->applicationColour()['theme']->color_1; ?> !important;
		}
		label.step {
			color: <?php echo $this->applicationColour()['theme']->color_1; ?> !important;
		}
		
		input[type="text"] {
			color: <?php echo $this->applicationColour()['theme']->color_2; ?> !important;
		}
		
		.btn-warning {
			background-color: <?php echo $this->applicationColour()['theme']->color_3; ?> !important;
			color: <?php echo $this->applicationColour()['theme']->color_4; ?> !important;
		}
		.btn-primary {
			background-color: <?php echo $this->applicationColour()['theme']->color_3; ?> !important;
			color: <?php echo $this->applicationColour()['theme']->color_4; ?> !important;
		}
		.goto-sub {
			background-color: <?php echo $this->applicationColour()['theme']->color_5; ?> !important;
			color: <?php echo $this->applicationColour()['theme']->color_6; ?> !important;
		}
		.goto-sub:hover {
			background-color: <?php echo $this->applicationColour()['theme']->color_6; ?> !important;
			color: <?php echo $this->applicationColour()['theme']->color_5; ?> !important;
		}
		.card {
			background-color: <?php echo $this->applicationColour()['theme']->color_5; ?> !important;
			color: <?php echo $this->applicationColour()['theme']->color_6; ?> !important;
		}
		.card:hover {
			background-color: <?php echo $this->applicationColour()['theme']->color_5; ?> !important;
			color: <?php echo $this->applicationColour()['theme']->color_6; ?> !important;
		}
		.progress-status-warning {
			background-color: <?php echo $this->applicationColour()['theme']->color_2; ?> !important;
		}
		.progress-status-primary {
			background-color: <?php echo $this->applicationColour()['theme']->color_3; ?> !important;
		}
		.access_expired_message {
		  background-color: orange;
		  font-size: 16px;
		  text-align: center;
		  padding: 4px;
		  border: 1px solid brown;
		}
		.img-thumbnail {
		  border: none !important;
		}
	</style>
	<?php endif; ?>

	<!-- Global Setting -->
	<script type="text/javascript">
		// Configuration
		var global_config = {
			'base_url': '<?php echo $this->programUrl(); ?>',
			'current_url': window.location.href,
			'timer_delay': 1000,
            'dlg': '#global-modal'
		};

		// Application
		var app = {
			datagrid: null,
			filter_limit: 4,
			col_ctr: 0,
			col_skipped: [],
		};
                
        <?php if($this->id == 'needassessment' && !isset(Yii::app()->session['accessed_via_email'])): ?> 
        global_config.disable_input = true;
        <?php endif; ?>
	</script>



	<title><?php echo CHtml::encode(Yii::app()->name . (($this->page_label) ? ' - ' . $this->page_label : '') ); ?></title>
</head>

<body>
<noscript>
<meta http-equiv="refresh" content="0; url=<?php echo $this->programURL();?>/nojs.html" />
</noscript>


<div class="container" id="page">
	<!-- Report view window -->
	<div id="reportview-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <h4>Report View</h4>
	      </div>

	      <div class="modal-body">
	      	<p id="report-label-status"></p>
	      	<iframe id="report_frame" src="" width="100%" height="640px" frameborder="0" scrolling="yes"></iframe>

	      </div>
	    </div>
	  </div>
	</div>
        
	<!-- Feedback/Agent Prep/NA/CIR Inline-Popup viewer -->
	<div id="global-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	        <h4></h4>
	      </div>
	      <div class="modal-body">
	      </div>
	    </div>
	  </div>
	</div>
        
	<div id="header">
		<div class="container">
			<div class="row">
                <?php 
                    $feedback_display = '';
                    if(isset(Yii::app()->session['accessed_via_email'])):
                        $feedback_display = 'style="visibility: hidden;"';
                    endif;
                ?>
                <div <?php echo $feedback_display; ?> class="col-xs-4">
                    <a href="#!" onclick="openfeedback()">
                    <img class="feedback img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/images/feedbackicon-16.png">
                    </a>
				</div>
				<div class="col-xs-4">
                    <img class="account-logo img-responsive" src="<?php echo $this->applicationLogo(EnumLogo::CLIENT); ?>">
				</div>
				<div class="col-xs-4">
					<p>&nbsp;</p>
				</div>
			</div>
		</div>
	</div><!-- header -->
        <span id="server-datetime" class="pull-right" style="display: none;">
            <br>
            <i class="fa fa-globe fa-2x"></i>&nbsp;
            <b>Server Date: </b>
                <?php echo date('F jS Y'); ?>
                &nbsp;/&nbsp;
                <?php echo date('h:i:s A'); ?>
        </span>

	<?php echo $content; ?>
	
	<div class="clear"></div>

	<div id="footer">
    <?php
    if (isset($access_expired_message)) {
        echo $access_expired_message;
    } 
    ?>
                <?php if($this->action->id == 'save_exit'): ?>
                    <div class="col-xs-12" style="border-top: 2px dotted #e5e5e5;">
                        <div class="col-xs-offset-1">
                            <span class="goto" onclick="location.href='<?php echo $this->programUrl(); ?>'" style="font-size: 14px;">Login</span>
                        </div>
                    </div>
                <?php elseif($this->with_footer_menu == 'hide'): ?>
                	<!-- No menu to show -->
                <?php elseif($this->id == 'needassessment' && isset(Yii::app()->session['accessed_via_email'])): ?>
                    <div class="col-xs-12" style="border-top: 2px dotted #e5e5e5;">
                    	<?php if ($this->goto_menu): ?>
                        <div class="col-xs-offset-1">
                            <span class="goto" onclick="location.href='<?php echo $this->programUrl() . '/' . $this->id . '/'. 'save_exit'; ?>'" style="font-size: 14px;">Save & Exit</span>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="col-xs-12" style="border-top: 2px dotted #e5e5e5;">
                    		<?php if ($this->goto_menu): ?>
                            <div class="col-xs-offset-2" id="GM1">
                            <?php else: ?>
                            <div class="col-xs-offset-3" id="GM1">
                            <?php endif; ?>
                            		<?php if ($this->goto_menu): ?>
                                    	<span class="goto goto-menu">Go to:</span>
                                    <?php endif; ?>
                                    <span id="GM2" class="goto <?php echo $this->menu_collapsed; ?>" href="<?php echo Yii::app()->createUrl('site/index'); ?>">Dashboard</span>
                                    <span id="GM3" class="goto <?php echo $this->menu_collapsed; ?>" href="<?php echo Yii::app()->createUrl('customer/listing'); ?>">Customer List</span>
                                    <span id="GM4" class="goto <?php echo $this->menu_collapsed; ?>" href="<?php echo Yii::app()->createUrl('account/action_item'); ?>">Action Items</span>
                                    <span id="GM5" class="goto <?php echo $this->menu_collapsed; ?>" href="<?php echo Yii::app()->createUrl('account/setup'); ?>">Account Setup</span>
                                    <span class="goto <?php echo $this->menu_collapsed; ?>" href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><i class="fa fa-sign-out"></i> Logout</span>
                           	</div>
                            <br>
                    </div>
                <?php endif; ?>
                <div id="footer-content">
                    <div class="col-xs-12">
                        &copy; 2017 - <?php echo date('Y'); ?> by Engagex | All Rights Reserved.<br/>
                        <span class="build-version"><?php echo Yii::app()->params['buildVersion']; ?></span><br>
                    </div>
                </div>
	</div><!-- footer -->

</div><!-- page -->

<!-- Load Libraries -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/select2/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/datatables.net/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/@fengyuanchen/datepicker/dist/datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/alertify.js/dist/js/alertify.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/storejs/store.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/spectrum/spectrum.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/timepicker/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/inputmask/dist/jquery.inputmask.bundle.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap-slider/dist/bootstrap-slider.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/cleave.js/dist/cleave.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/input-tags/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootbox.min.js"></script>

<!-- Custom Libraries -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/timersjs.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/stringutil.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/sort_filter.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/browsing.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/carquery.js?t=<?php echo time(); ?>"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/global.js?t=<?php echo time(); ?>"></script>

<script type="text/javascript">           
	$(document).ready(function() {
		var mtext = '';
		<?php if(Yii::app()->user->hasFlash('success')):?>
			mtext = '<?php echo Yii::app()->user->getFlash('success'); ?>';
		    msgbox('success', mtext);
		<?php endif; ?>
		<?php if(Yii::app()->user->hasFlash('error')):?>
			mtext = '<?php echo Yii::app()->user->getFlash('error'); ?>';
		    msgbox('error', mtext);
		<?php endif; ?>
		<?php if(Yii::app()->user->hasFlash('notice')):?>
			mtext = '<?php echo Yii::app()->user->getFlash('notice'); ?>';
		    msgbox('notice', mtext);
		<?php endif; ?>
		<?php if(Yii::app()->user->hasFlash('form_error')):?>
			mtext = <?php echo Yii::app()->user->getFlash('form_error'); ?>;
		        $.each(mtext, function(k, v) {
                           msgbox('error', v);    
                });
                        
		<?php endif; ?>

		// set to memory the current page
		store.set('current_url', global_config.current_url);

		// release notes
		$('#footer-content').on('click', function() {
			location.href="release-notes.txt"
		});
	});
</script>

<?php if ($this->is_staff()): ?>
<!-- User roles was not admin/superuser -->
<script type="text/javascript" src="<?php echo $this->programURL();?>/staff/features_permission?js=true"></script>
<?php endif; ?>


</body>
</html>