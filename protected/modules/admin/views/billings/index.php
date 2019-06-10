<?php
/* @var $this BillingsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Billings',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/grid-view.css');
?>

<div class="col-md-offset-2 col-md-8">

    <div class="col-md-12">
        <a href="<?php echo $this->moduleURL('site') . '/index'; ?>" class="btn btn-default">
        	<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
        </a>
    </div>
    
    <h2 class="text-center">Billing History</h2>
    
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
    			<select name="FormFilter[status]">
    				<option value="ALL">All</option>
    				<option value="<?php echo EnumStatus::PAID; ?>">Paid</option>
    				<option value="<?php echo EnumStatus::UNPAID; ?>">Unpaid</option>
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
				<td>Invoice Date</td> 
				<td>Invoice Number</td>
				<td>Description</td>
				<td>Promo Code</td>
				<td>Promo Amount Off</td>
				<td>Total Amount</td>
				<td>Invoice Status</td>
				<td>Options</td>
    		</tr>
		</thead>
		<tbody>
            <?php if (!empty($records)): ?>
            			<?php 
            			foreach($records as $k=>$v): 
            			?>
                		<tr>
            				<td><?php echo date("m/d/Y", strtotime($v->created_at)); ?></td>
            				<td><?php echo $v->bill_no; ?></td>
            				<td><?php echo $v->bill_type; ?></td>
            				<td><?php echo $v->promo_code; ?></td>
            				<td><?php echo $v->promo_off; ?></td>
            				<td><?php echo $v->bill_amount; ?></td>
            				<td><?php echo $v->bill_status; ?></td>
            				<td><button data-id="<?php echo $v->bill_no; ?>" class="btn-view" onclick="view_report(this)">View</button></td>
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
    
    <?php 
//     $btnview = '"<button data-id=\"$data->bill_no\" class=\"btn-view\" onclick=\"view_report(this)\">View</button>"';
    
//     $this->widget('zii.widgets.grid.CGridView', array(
//         'id'=>'tgrid',
//         'dataProvider'=>$dataProvider,
//         'enablePagination' => false,
//         'columns'=>array(
//             array(
//                 'type'=>'raw',
//                 'header'=>'Invoice Date',
//                 'name'=>'created_at',
//                 'value'=>'date("m/d/Y", strtotime($data->created_at))',
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//             array(
//                 'type'=>'raw',
//                 'header'=>'Invoice Number',
//                 'name'=>'bill_no',
//                 'value'=>'$data->bill_no',
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//             array(
//                 'type'=>'raw',
//                 'header'=>'Description',
//                 'name'=>'bill_type',
//                 'value'=>'$data->bill_type',
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//             array(
//                 'type'=>'raw',
//                 'header'=>'Promo Code',
//                 'name'=>'promo_code',
//                 'value'=>'$data->promo_code',
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//             array(
//                 'type'=>'raw',
//                 'header'=>'Amount Off',
//                 'name'=>'promo_off',
//                 'value'=>'$data->promo_off',
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//             array(
//                 'type'=>'raw',
//                 'header'=>'Amount Due',
//                 'name'=>'bill_amount',
//                 'value'=>'$data->bill_amount',
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//             array(
//                 'type'=>'raw',
//                 'header'=>'Status',
//                 'name'=>'bill_status',
//                 'value'=>'$data->bill_status',
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//             array(
//                 'type'=>'raw',
//                 'header'=>'Options',
//                 'name'=>'bill_no',
//                 'value'=>$btnview,
//                 'headerHtmlOptions'=>array('width'=>'20px'),
//             ),
//          ),
//     ));
    
//     $this->widget('EExcelView', array(
//         'id'=>'datagrid',
//         'dataProvider'=> $dataProvider,
//         'title'=>'Billing History',
//         'autoWidth'=>true,
//         'template'=>"{exportbuttons}",
//         'filename'=>'output'
//     ));
    
    ?>


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