<?php
// remove goto menu
$this->goto_menu = false;
?>
<style>
.container {
    background-color: transparent !important;
    margin-left: -16px;
}
</style>
<div class="col-xs-6">     
		<?php
		echo CHtml::beginForm('', 'post', array(
				'enctype'=>'multipart/form-data',
		));
		?>
		<!-- File upload-->
		<div class="row">
    		<!-- Group Header -->
    		<div class="form-group">
    			<h4><i class="fa fa-upload"></i> Upload</h4>
    			<a name="info" href="#!"></a>
    		</div>
			<div class="form-group">
			  <div class="col-xs-12">
    			  	<?php echo CHtml::button('Browse File', array('class'=>'btn btn-primary btn-block', 'id'=>'btn-browse-file')); ?><br>
			  </div>
			</div>
		</div>
		<?php echo CHtml::endForm(); ?>
		
		<div class="row">
    		<!-- Group Header -->
    		<div class="form-group">
    			<h4><i class="fa fa-file"></i> Saved Resources</h4>
    			<a name="" href="#!"></a>
    		</div>

			
            		<?php
            		$client_resources = ClientResources::model()->findAll('account_id = :account_id AND insurance_type = :insurance_type', 
            		    array(':account_id'=> Yii::app()->session['account_id'], ':insurance_type'=> $insurance_type));
            		
            		if(!empty($client_resources)):
            		    foreach($client_resources as $k=>$v):
            		    $json = json_decode($v->json);
    				    ?>
    				    <table class="table table-bordered">
        				<tr>
        					<td>
        						<div class="col-xs-12">
        							<div class="col-xs-4">Resource Label:</div>
        							<div class="col-xs-8">
        								<?php
        								$lbl_custom = '';
        								if ($v->custom_label == '0') {
        								    $lbl_custom = $json->public_id;
        								} else {
        								    $lbl_custom = $v->custom_label;
        								}
        								?>
        								<input type="text" class="form-control resource_custom_label" data-id="<?php echo $v->id; ?>" name="ClientResource[custom_label]" value="<?php echo $lbl_custom; ?>" />
        							</div>
        						</div>
        						<div class="col-xs-12">
        							<div class="col-xs-4">Date Uploaded:</div>
        							<div class="col-xs-8"><?php echo $v->created_at; ?></div>
        						</div>
        						<div class="col-xs-12">
        							<div class="col-xs-4">Posted By:</div>
        							<div class="col-xs-8"><?php echo $v->posted_by; ?></div>
        						</div>
        						<div class="col-xs-12">
        							<div class="col-xs-4">File Type:</div>
        							<div class="col-xs-8"><?php echo $json->resource_type; ?></div>
        						</div>
        						
        						<div class="col-xs-12">
        							<div class="col-xs-4">&nbsp;</div>
        							<div class="col-xs-8"></div>
        						</div>        
        											
            					<div class="col-xs-offset-4 col-xs-8">
            						<a href="<?php echo $json->secure_url; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i> View</a>
            						<button type="button" class="btn btn-default btn-delete-resource" data-id="<?php echo $v->id; ?>">
            							<i class="fa fa-trash"></i> Remove
            						</button>
            					</div>
        					</td>
        				</tr>
        				</table>
    					<?php 
    				    endforeach;
    				else: 
    				?>
    					<table class="table table-bordered">
        				<tr><td colspan="100">Empty Resource</td></tr>
        				</table>
        			<?php
        			endif;
        			?>
			
		</div>
</div>

<?php
// cloudinary library
Yii::app()->clientScript->registerScriptFile(
    '//widget.cloudinary.com/global/all.js',
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl . '/node_modules/lodash/lodash.js',
    CClientScript::POS_END
);
Yii::app()->clientScript->registerScriptFile(
    Yii::app()->baseUrl . '/node_modules/cloudinary-core/cloudinary-core.js',
    CClientScript::POS_END
);

// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/account_setup.js',
	CClientScript::POS_END
);
?>