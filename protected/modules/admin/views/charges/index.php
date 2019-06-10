<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/grid-view.css');
?>

<?php
if (!$this->is_superuser()):
    echo 'No permission to view';
    exit;
endif; 
?>

<div class="col-md-offset-2 col-md-8">

    <div class="col-md-12">
        <a href="<?php echo $this->moduleURL('site') . '/index'; ?>" class="btn btn-default">
        	<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
        </a>
        <?php if (isset($_GET['bypass'])): ?>
        <a href="<?php echo $this->moduleURL('charges'); ?>/create" class="btn btn-default">
        	<i class="fa fa-plus" aria-hidden="true"></i> Create Charges
        </a>
        <?php endif; ?>
    </div>
    
    <h2 class="text-center">Fees and Charges</h2>
    
    <?php 
    $btnedit    = 'CHtml::link("<i class=\"fa fa-pencil\"></i>&nbsp;Edit", "'. $this->moduleURL("charges") .'/update?id=".$data->id, array("class"=>"btn btn-default"))';
    $btndelete  = 'CHtml::link("<i class=\"fa fa-trash\"></i>&nbsp;Delete", "'. $this->moduleURL("charges") .'/delete?id=".$data->id, array("class"=>"btn btn-default", "onclick"=>"return msg()"))';
    
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'tgrid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
            array(
                'name'=>'enrollment_fee', 
                'value'=>'Yii::app()->numberFormatter->formatCurrency($data->enrollment_fee,"USD")',
                'headerHtmlOptions'=>array('width'=>'150px'),
                'htmlOptions'=>array('class'=>'text-right'),
            ),
            array(
                'name'=>'staff_fee',
                'value'=>'Yii::app()->numberFormatter->formatCurrency($data->staff_fee,"USD")',
                'headerHtmlOptions'=>array('width'=>'150px'),
                'htmlOptions'=>array('class'=>'text-right'),
            ),
            array(
                'name'=>'staff_credits',
                'value'=>'$data->staff_credits',
                'headerHtmlOptions'=>array('width'=>'100px'),
                'htmlOptions'=>array('class'=>'text-right'),
            ),
            array(
                'type'=>'raw',
                'header'=>'',
                'name'=>'id',
                'value'=>$btnedit,
                'headerHtmlOptions'=>array('width'=>'50px'),
            ),
//             array(
//                 'type'=>'raw',
//                 'value'=>$btndelete,
//                 'htmlOptions'=>array('class'=>'text-center'),
//                 'headerHtmlOptions'=>array('width'=>'50px'),
//             ),
        ),
    ));
    
    //         'selectionChanged'=>"
    //            function(id){
    //               var tid = $.fn.yiiGridView.getSelection(id);
    //               location.href='". $this->moduleURL('chargesfee') ."/update?id='+tid;
    //            }",
    
    $this->widget('EExcelView', array(
        'id'=>'datagrid',
        'dataProvider'=> $dataProvider,
        'title'=>'chargesfee',
        'autoWidth'=>true,
        'template'=>"{exportbuttons}",
        'filename'=>'output.xlsx'
    ));
    ?>
</div>
<script>
function msg()
{
	return confirm('Are you sure to delete this item?');
}
</script>