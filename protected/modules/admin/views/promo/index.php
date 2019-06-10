<?php
/* @var $this PromoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Promo',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/grid-view.css');
?>

<?php
if (!$this->is_superuser()):
    echo 'No permission to view';
    exit;
endif; 
?>

<div class="col-md-offset-2 col-md-9">

    <div class="col-md-12">
        <a href="<?php echo $this->moduleURL('site') . '/index'; ?>" class="btn btn-default">
        	<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
        </a>
        <a href="<?php echo $this->moduleURL('promo'); ?>/create" class="btn btn-default">
        	<i class="fa fa-plus" aria-hidden="true"></i> Create Promo
        </a>
    </div>
    
    <h2 class="text-center">Promo Management</h2>
    
    <?php 
    $btnedit    = 'CHtml::link("<i class=\"fa fa-pencil\"></i>&nbsp;Edit", "'. $this->moduleURL("promo") .'/update?id=".$data->id, array("class"=>"btn btn-default"))';
    $btndelete  = 'CHtml::link("<i class=\"fa fa-trash\"></i>&nbsp;Delete", "'. $this->moduleURL("promo") .'/delete?id=".$data->id, array("class"=>"btn btn-default", "onclick"=>"return msg()"))';
    
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'tgrid',
    'dataProvider'=>$dataProvider,
    'rowCssClassExpression'=>'($data->status==EnumStatus::INACTIVE)?"odd":"even"',
    'columns'=>array(
            'promo_name',
            array(
                'name'=>'promo_code',
                'htmlOptions'=>array('class'=>'text-center'),
            ),
            array(
                'name'=>'amount_off', 
                'value'=>'Yii::app()->numberFormatter->formatCurrency($data->amount_off,"USD")',
                'headerHtmlOptions'=>array('width'=>'100px'),
                'htmlOptions'=>array('class'=>'text-right'),
            ),
            array(
                'header'=>'No. of Months validity',
                'name'=>'valid_num_months',
                'value'=>'Yii::app()->numberFormatter->formatDecimal($data->valid_num_months)',
                'headerHtmlOptions'=>array('width'=>'100px'),
                'htmlOptions'=>array('class'=>'text-center'),
            ),
            array(
                'name'=>'promo_start',
                'value'=>'date("m/d/Y", strtotime($data->promo_start))',
                'headerHtmlOptions'=>array('width'=>'100px'),
                'htmlOptions'=>array('class'=>'text-center'),
            ),
            array(
                'name'=>'promo_end',
                'value'=>'date("m/d/Y", strtotime($data->promo_end))',
                'headerHtmlOptions'=>array('width'=>'100px'),
                'htmlOptions'=>array('class'=>'text-center'),
            ),
            array(
                'name'=>'status', 
                'value'=>'strtoupper($data->status)',
                'htmlOptions'=>array('class'=>'text-center'),
            ),
            array(
                'type'=>'raw',
                'header'=>'',
                'name'=>'id',
                'value'=>$btnedit,
                'headerHtmlOptions'=>array('width'=>'20px'),
            ),
            array(
                'type'=>'raw',
                'value'=>$btndelete,
                'htmlOptions'=>array('class'=>'text-center'),
                'headerHtmlOptions'=>array('width'=>'20px'),
            ),
        ),
    ));
    
    //         'selectionChanged'=>"
    //            function(id){
    //               var tid = $.fn.yiiGridView.getSelection(id);
    //               location.href='". $this->moduleURL('promo') ."/update?id='+tid;
    //            }",
    
    $this->widget('EExcelView', array(
        'id'=>'datagrid',
        'dataProvider'=> $dataProvider,
        'title'=>'Promo',
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