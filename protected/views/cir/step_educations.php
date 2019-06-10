<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'50', 'end'=>'50');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

$criteria = new CDbCriteria;

// Account policies
$criteria->condition = "account_id=:account_id AND policy_parent_label = :policy_parent_label AND is_child_checked = 1";
$criteria->params=array(
    ':account_id'=>Yii::app()->session['account_id'],
    ':policy_parent_label'=>$line_insurance['title'],
);
$policies = AccountSetupPolicy::model()->findAll($criteria);
$maincontent ='';
if (!empty($policies)) 
{
    $maincontent .= '<ul>';
    foreach($policies as $key=>$value) {
        $d = true;
        if ($line_insurance['title'] == 'Home' && $value->policy_child_label == 'Type') {
            $d = false;
        }
        if ($line_insurance['title'] == 'Auto' && ($value->policy_child_label == 'Year' || $value->policy_child_label == 'Make' || $value->policy_child_label == 'Model')) {
            $d = false;
        }
        if ($d) {
            $criteria->condition = "account_id=:account_id AND customer_id=:customer_id AND policy_parent_label = :policy_parent_label AND policy_child_label = :policy_child_label";
            $criteria->params=array(
                ':account_id'=>Yii::app()->session['account_id'],
                ':customer_id'=>Yii::app()->session['customer_id'],
                ':policy_parent_label'=>$line_insurance['title'],
                ':policy_child_label'=>$value->policy_child_label,
            );
            $is_checked = (Education::model()->find($criteria) != null) ? 'checked' : '';
            $maincontent .= '<li><input '. $is_checked .' type="checkbox" name="Education[Option][policy_child_label][]" value="'. $value->policy_child_label .'"><label>'. $value->policy_child_label .'</label></li>';
        }
    }
    $maincontent .= '</ul>';
}

// Assigned Resource Files
$client_resources = ClientResources::model()->findAll('account_id = :account_id AND insurance_type = :insurance_type',
    array(':account_id'=> Yii::app()->session['account_id'], ':insurance_type'=> $line_insurance['title']));
$maincontent_resource = '';
if(!empty($client_resources)):
    $maincontent_resource .= '<h4>Resources:</h4>';
    $maincontent_resource .= '<hr>';
    foreach($client_resources as $k=>$v):
        $json = json_decode($v->json);
        $public_id = explode('/', $json->public_id);
        
        $maincontent_resource .= '<input type="hidden" class="chk-resource" name="resource[insurance_type]" value="'. $line_insurance['title'] .'">';
        $is_checked = '';
        $cc = EducationResource::model()->find('account_id = :account_id AND customer_id = :customer_id AND json = :public_id', array(
            ':account_id'=>Yii::app()->session['account_id'],
            ':customer_id'=>Yii::app()->session['customer_id'],
            ':public_id'=>$public_id[1]
        ));
        if ($cc != null) {
          $is_checked = 'checked';   
        }
        
        $custom_label = '';
        if ($v->custom_label == '0' || $v->custom_label == '') {
            $custom_label = $public_id[1];
        } else {
            $custom_label = $v->custom_label;
        }
        $maincontent_resource .= '<input '. $is_checked .' type="checkbox" class="chk-resource" name="resource[public_id][]" data-itype="'. $line_insurance['title'] .'" value="'. $public_id[1] .'">';
        $maincontent_resource .= '<span>&nbsp;';
        $maincontent_resource .= '<a href="'. $json->secure_url .'" target="_blank">'. CHtml::encode($custom_label) .'</a>';
        if ($this->endsWith($json->secure_url, '.pdf')) { 
            $maincontent_resource .= '&nbsp;(<i class="fa fa-file-pdf-o"></i> pdf)';
        }
        else if ($this->endsWith($json->secure_url, '.jpg')) {
            $maincontent_resource .= '&nbsp;(<i class="fa fa-file-image-o"></i> image)';
        } 
        else if ($this->endsWith($json->secure_url, '.gif')) {
            $maincontent_resource .= '&nbsp;(<i class="fa fa-file-image-o"></i> image)';
        } 
        else if ($this->endsWith($json->secure_url, '.png')) {
            $maincontent_resource .= '&nbsp;(<i class="fa fa-file-image-o"></i> image)';
        } 
        else {
            $maincontent_resource .= '&nbsp;(<i class="fa fa-files-o"></i> other)';
        } 
        $maincontent_resource .= '</span><br>';
    endforeach;
    $maincontent_resource .= '<br>';
    
endif;

?>
<style>
.form-control {
  width: 34em;
  margin-bottom: 10px;
}

ul {
    list-style: none;
    margin-left: 160px;
    margin-top: 20px;
    margin-bottom: 20px;
}

input[type="checkbox"] {
    width: 28px;
    height: 28px;
    vertical-align:middle; 
}

label {
    font-size: 18px;
    margin-left: 8px;
    vertical-align:middle; 
}
</style>

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Explanation <?php echo str_replace('_', ' ', $line_insurance['title']); ?> Policy</div>
    <p>&nbsp;</p>
  </div>
  <?php
      $form=$this->beginWidget('CActiveForm', array(
        'id'=>'new-form',
        'enableAjaxValidation' => true,
        'htmlOptions'=> array('class'=>'form-horizontal'),
      ));
  ?>
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
      <?php
        echo CHtml::errorSummary($model);
       ?>
    </div>
  </div>

  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
        <?php echo $maincontent; ?>
    </div>
  </div>
  
  <div class="col-xs-12">
    <div class="col-xs-offset-2 col-xs-8">
        <?php echo $maincontent_resource; ?>
    </div>
  </div>

  <div class="col-xs-12">
      <div class="col-xs-offset-2 col-xs-8">
          <p class="page-note"></p>
      </div>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-bottom:1em;">
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block btn-action-item">Action Item</button>
    </div>
    <div class="col-xs-2">
      <button type="button" name="button" class="btn btn-primary btn-block btn-goals-concerns">Goals & Concerns</button>
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Back', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=prev&qid='. $line_insurance['id'],
            'class'=>'btn btn-primary btn-block',
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Next', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=next&qid='. $line_insurance['id'],
            'class'=>'btn btn-warning btn-block',
        ));
      ?>
    </div>
  </div>

  <?php $this->endWidget(); ?>
</div>

<script>
<?php 
if (Yii::app()->session['arr_pages']){ 
    echo 'global_config.page_names = ' . json_encode(Yii::app()->session['arr_pages']) . ';'; 
}
?>
</script>

<script>
global_config.page_name="<?php echo basename(__FILE__, '.php'); ?>";
<?php $this->loadActivity(); ?>
</script>

<?php
// custom script
Yii::app()->clientScript->registerScriptFile(
	Yii::app()->baseUrl . '/js/pages/cir.js',
	CClientScript::POS_END
);
?>
