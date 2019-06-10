<?php
if ($model == null) { exit; }
?>

<div class="modal fade" id="frm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Send Credit</h4>
            </div>
            <div class="modal-body">
                <div id="form-status"></div>
                <form id="sendcredit">
                    <input type="hidden" id="refer_id" name="refer_id" value="<?php echo $refer_id;?>" />
                    <label>Credit Amount:</label>
                    <select id="credit_amount" name="credit_amount">
                    <?php
                        if($model->credit_amounts != null) {
                            $credit_amounts = explode(',', $model->credit_amounts);
                            foreach($credit_amounts as $v) {
                                echo '<option value="'. $v .'">'. $v .'</option>';
                            }
                        } else {
                            echo '<option>Not Configured</option>';
                        }
                    ?>
                    </select>

                    <label>Gift Cards to Offer:</label>
                    <select id="credit_offer" name="credit_offer">
                    <?php
                        if($model->gift_cards_offer != null) {
                            $credit_offer = explode(',', $model->gift_cards_offer);
                            foreach($credit_offer as $v) {
                                echo '<option value="'. $v .'">'. $v .'</option>';
                            }
                        } else {
                            echo '<option>Not Configured</option>';
                        }
                    ?>
                    </select>
                    <label>Send Credit To:</label>
                    <input type="text" id="refer_email" name="refer_email" placeholder="Email" value="<?php echo $refer_email; ?>" class="form-control" />
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-submit-credit">Save & Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
      $('.btn-submit-credit').on('click', function(e) {
          e.preventDefault();
          var param = $('#sendcredit').serialize();
          $.post(global_config.base_url + "/giftcards/savecredit", param, function(data) {
              
              if (data.status === 'error') {
                    $('#form-status').empty();
                    $('#form-status').html(errorText(data.json));
                    $('#form-status').addClass('label-warning');
                    return;
              } else {
                    $('#frm').modal('hide');
                    msgbox(data.status, data.json);
                    setTimeout(function(){
                        $('#frm').remove();
                        location.reload();
                    }, 600);
              }
          });
      });
</script>