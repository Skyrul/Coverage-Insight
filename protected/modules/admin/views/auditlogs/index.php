<?php
/* @var $this AuditlogsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Audit Logs',
);

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/grid-view.css');
?>

<div class="col-md-offset-2 col-md-8">

    <div class="col-md-12">
        <a href="<?php echo $this->moduleURL('site') . '/index'; ?>" class="btn btn-default">
        	<i class="fa fa-chevron-circle-left" aria-hidden="true"></i> <?php echo $this->back_text; ?>
        </a>
    </div>
    
    <h2 class="text-center">Audit Logs</h2>

    <?php
    // $this->widget('zii.widgets.CListView', array(
    // 	'dataProvider'=>$dataProvider,
    // 	'itemView'=>'_view',
    // ));
    
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$dataProvider,
    ));
    ?>  
    
    <?php 
    $this->widget('EExcelView', array(
        'id'=>'datagrid',
        'dataProvider'=> $dataProvider,
        'title'=>'Audit Logs',
        'autoWidth'=>true,
        'template'=>"{exportbuttons}",
        'filename'=>'output.xlsx'
    ));
    ?>
</div>