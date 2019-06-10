<?php
if ($this->is_staff()){
    echo 'You are not allowed to access this module';
    exit;    
}

$this->page_label = 'Admin Console';
?>
<!DOCTYPE html>
<html>
<head>
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
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/buttons.dataTables.min.css" rel="stylesheet">

	<!-- Base CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" id="alertifyCSS">
	
	<?php if(is_null($this->applicationColour()['theme']) != 1): ?>
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
		.text-label {
		      margin-top: -2px;
		      padding-bottom: 22px;
              font-size: 20px;
		}
        #header {
            height: 120px !important;
            top: 0;
            background-color: <?php echo $this->applicationColour()['theme']->color_5; //#ffd18c ?> !important;
            border-bottom: 1px solid gray;
            color: #175d91 !important;
        }
		#content {
		  top: 20% !important;
		}
	</style>
	<?php endif; ?>


	<!-- Global Setting -->
	<script type="text/javascript">
		// Configuration
		var global_config = {
			'base_url': '<?php echo $this->programUrl(); ?>',
			'current_url': '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->request->getUrl()); ?>',
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
                <div class="col-xs-4">
                    
				</div>
				<div class="col-xs-4">
					<img class="account-logo img-responsive" src="<?php echo $this->applicationLogo(EnumLogo::SYSTEM_DEFAULT); ?>">
					<p class="text-center text-label"><?php echo $this->page_label; ?></p>
				</div>
				<div class="col-xs-4">
				</div>
			</div>
		</div>
	</div><!-- header -->

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
                <div id="footer-content">
                    <div class="col-xs-12">
                        Copyright &copy; <?php echo date('Y'); ?> by Engagex | All Rights Reserved.<br/>
                        <span class="build-version"><?php echo Yii::app()->params['buildVersion']; ?></span>
                    </div>
                </div>
	</div><!-- footer -->

</div><!-- page -->

<!-- Load Libraries -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/jquery/dist/jquery.min.js"></script>
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
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/input-tags/jquery.tagsinput.min.js"></script>

<!-- Custom Libraries -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/timersjs.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/stringutil.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/sort_filter.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/browsing.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/carquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/global.js"></script>

<!-- Libraries for jQuery DataTable -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/jszip.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/pdfmake.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/vfs_fonts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/file-export/buttons.print.min.js"></script>



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

		(function() {
			$('#grid').DataTable({
				dom: 'Bfrtip',
		        buttons: [
		            'copy', 'excel', 'pdf', 'print'
		        ]
			});
		})();
	});
</script>

</body>
</html>