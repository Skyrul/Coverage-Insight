<?php
$this->with_progressbar = true;
$this->progress_bar = array('start'=>'70', 'end'=>'30');
$this->page_label = $customer->primary_firstname.' '.$customer->primary_lastname.''.
                    (($customer->secondary_firstname) ? ' & '.$customer->secondary_firstname.' '.$customer->secondary_lastname : '');

$cri = new CDbCriteria;

// Referrals
$cri->condition="account_id=:account_id AND customer_id=:customer_id";
$cri->params=array(
        ':account_id'=>Yii::app()->session['account_id'],
        ':customer_id'=>Yii::app()->session['customer_id'],
);
$ltg = Referral::model()->findAll($cri);
$maincontent = '';
$maincontent .= '<table class="col-xs-12">';
$maincontent .= '<tr>';
$maincontent .= '<td><label>Name</label></td>';
$maincontent .= '<td><label>Email</label></td>';
$maincontent .= '<td><label>Phone</label></td>';
$maincontent .= '<td><label>Note</label></td>';
$maincontent .= '<td>&nbsp;</td>';
$maincontent .= '</tr>';

if(!empty($ltg)) {
    foreach($ltg as $k=>$v) {
        $maincontent .= '<form id="EditForm_'. $v->id .'" method="post">';
        $maincontent .= '<tr>';
        $maincontent .= '<input name="ReferralEdit[id]" value="'. $v->id.'" type="hidden">';
        $maincontent .= '<td class="col-xs-2"><input name="ReferralEdit[refer_name]" class="form-control" value="'. $v->refer_name .'" data-id="'. $v->id.'"></td>';
        $maincontent .= '<td class="col-xs-2"><input name="ReferralEdit[refer_email]" class="form-control" value="'. $v->refer_email .'" data-id="'. $v->id.'"></td>';
        $maincontent .= '<td class="col-xs-2"><input name="ReferralEdit[refer_phone]" class="form-control phone-mask" value="'. $v->refer_phone .'" data-id="'. $v->id.'"></td>';
        $maincontent .= '<td class="col-xs-2"><input name="ReferralEdit[refer_note]" class="form-control" value="'. $v->refer_note .'" data-id="'. $v->id.'"></td>';
        $maincontent .= '<td class="col-xs-1"><a class="btn btn-primary btn-sm btn-send-credit" data-id="'. $v->id .'" data-email="'. $v->refer_email .'">Send Credit</a></td>';
        // $maincontent .= '<td class="col-xs-1"><a class="btn btn-default btn-sm btn-remove" data-href="?action=delete&id='. $v->id.'"><i class="fa fa-close"></i></a></td>';
        $maincontent .= '</tr>';
        $maincontent .= '</form>';

        $rgc = ReferralGC::model()->findAll('refer_id=:refer_id AND account_id = :account_id', array(
            ':refer_id'=>$v->id,
            ':account_id'=>Yii::app()->session['account_id']
        ));
        if ($rgc != null) {
            foreach($rgc as $kk=>$vv){
                $maincontent .= '<tr>';
                $maincontent .= '<td></td>';
                $maincontent .= '<td colspan="10">';
                // $maincontent .= '<button class="btn btn-primary btn-referral-edit-gc" data-id="'. $vv->refer_id .'">Edit</button>&nbsp;&nbsp;';
                $maincontent .= '<strong>'. date('m/d/Y', strtotime($vv->refer_date)) .'</strong>&nbsp;';
                $maincontent .= 'Gift Card Credit $'. number_format($vv->gc_amount, 2) .' '. $vv->gc_offer .' | Gift Card sent to '. $vv->refer_email;
                $maincontent .= '</td>';
                $maincontent .= '</tr>';
                $maincontent .= '<tr><td>&nbsp;</td></tr>';
            }
        } // Check if giftcards recorded

    }
}



$maincontent .= '<form id="NewForm" method="post">';
$maincontent .= '<tr class="tr-referral" style="display: none;">';
$maincontent .= '<td class="col-xs-2"><input name="ReferralNew[refer_name]" class="form-control" value=""></td>';
$maincontent .= '<td class="col-xs-2"><input name="ReferralNew[refer_email]" class="form-control" value=""></td>';
$maincontent .= '<td class="col-xs-2"><input name="ReferralNew[refer_phone]" class="form-control phone-mask" value=""></td>';
$maincontent .= '<td class="col-xs-2"><input name="ReferralNew[refer_note]" class="form-control" value=""></td>';
$maincontent .= '</tr>';
$maincontent .= '</form>';

$maincontent .= '<tr>';
$maincontent .= '<td colspan="10">';
$maincontent .= '<button type="button" name="button" class="btn btn-warning btn-add-referral">Add Referral</button>';
$maincontent .= '<button type="button" name="button2" class="btn btn-warning btn-save-referral" style="display:none;">Save Item</button>';
$maincontent .= '<button type="button" name="button2" class="btn btn-warning btn-update-referral" style="display:none;">Update</button>';
$maincontent .= '</td>';
$maincontent .= '</tr>';
$maincontent .= '</table>';

?>
<style>
    .form-control {
      margin-bottom: 10px;
    }
  
    .select2.select2-container.select2-container--default.select2-container--below {
        width: 100% !important;
        border: 1px solid;
    }
    
    .btn-remove {
      margin-bottom: 12px;
      margin-left: -24px;
    }
    
    label {
        font-size: 14px;
        margin-left: 8px;
        vertical-align:middle; 
    }
    
    textarea {
        font-size: 16px;
    }

    .btn-send-credit {
        margin-bottom: 12px;
    }
</style>

<div class="container">
  <div class="col-xs-12">
    <div class="page-sub-label text-center">Referrals</div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  </div>

  <div class="col-xs-12">
      <table>
          <?php echo $maincontent; ?>
      </table>
      <p>&nbsp;</p>
  </div>

  <!-- footer buttons -->
  <div class="col-xs-12" style="margin-bottom:1em;">
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Back', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=prev',
            'class'=>'btn btn-primary btn-block',
        ));
      ?>
    </div>
    <div class="col-xs-2">
      <?php
        echo CHtml::button('Next', array(
            'submit'=>'?customer_id='. $customer->id .'&direction=next',
            'class'=>'btn btn-warning btn-block',
        ));
      ?>
    </div>
  </div>
    
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
