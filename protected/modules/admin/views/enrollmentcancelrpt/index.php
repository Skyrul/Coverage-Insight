<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/grid-view.css');
?>

<div class="col-md-offset-2 col-md-8">

    <div class="col-md-12">
        <a href="<?php echo $this->moduleURL('site') . '/index'; ?>" class="btn btn-default">
        	<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
        </a>
    </div>
    
    <h2 class="text-center">Enrollment/Cancel Report</h2>
    
    <br>
    <form action="" method="post">
    	<table>
    		<tr>
    		<td>Start Date:</td>
    		<td><input type="text" class="datepicker" name="FormFilter[start_date]" value="" /></td>
    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    		<td>End Date:</td>
    		<td><input type="text" class="datepicker" name="FormFilter[end_date]" value="" /></td>
    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    		<td>
    			<select name="FormFilter[invoice_type]">
    				<option value="ALL">All</option>
    				<option value="<?php echo EnumStatus::ENROLLMENT; ?>">Enrollment</option>
    				<option value="<?php echo EnumStatus::SUBSCRIPTION; ?>">Subscription</option>
    				<option value="<?php echo EnumStatus::BUYSTAFF; ?>">Buy Staff</option>
    				<option value="<?php echo EnumStatus::CANCELMEMBERSHIP; ?>">Cancel Membership</option>
    			</select>
    		</td>
    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    		<td><input type="submit" class="btn btn-default" value="Search" /></td>
    		</tr>
    	</table>
    </form>
    
    <hr>
    <p>&nbsp;</p>

	<table id="grid" class="table table-hover">
		<thead>
    		<tr>
				<td>Date/Time</td> 
				<td>Account name</td>
				<td>Email address</td>
				<td>Amount</td>
				<td>Promo Code</td>
				<td>Promo Amount Off</td>
				<td>Type</td>
    		</tr>
		</thead>
		<tbody>
            <?php if (!empty($records)): ?>
            			<?php 
            			foreach($records as $k=>$v): 
            			$acct = AccountSetup::model()->find('id = :account_id', array(
            			    ':account_id'=>$v->account_id,
            			)); 
            			
            			?>
                		<tr>
            				<td><?php echo $v->created_at; ?></td> 
            				<td><?php echo $acct->first_name . ' ' . $acct->last_name; ?></td>
            				<td><?php echo $acct->email; ?></td>
            				<td><?php echo $v->invoice_total; ?></td>
            				<td><?php echo $v->promo_code; ?></td>
            				<td><?php echo $v->promo_off; ?></td>
            				<td><?php echo $v->invoice_type; ?></td>
                		</tr>
                		<?php 
                		endforeach; 
                		?>
            <?php else: ?>
                		<tr>
            				<td>No Results</td> 
            			</tr>
            <?php endif; ?>
    	</<tbody>
    </table>
    
</div>
<script>
function msg()
{
	return confirm('Are you sure to delete this item?');
}

function view_report(that) {
	var url = '<?php echo $href    = $this->programURL() . '/reports/renderpdf?report_name=billing&report_tpl=billing&billno=';?>';
	var bill_no = $(that).attr('data-id');
	showReport(url+bill_no);
}
</script>