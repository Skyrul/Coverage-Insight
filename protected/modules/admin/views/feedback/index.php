<?php
/* @var $this FeedbackController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Feedback',
);

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
    </div>
    
    <h2 class="text-center">Feedback</h2>
    
    <form action="" method="POST" id="form1">
    <div class="row">
        <table class="pull-right">
            <tr>
                <td>Show:</td>
                <td>
                    <select class="form-control" name="tfilter" id="tfilter">
                        <option value="ALL">ALL</option>
                        <option value="OPEN">OPEN</option>
                        <option value="REVIEW">READY FOR REVIEW</option>
                        <option value="CLOSED">CLOSED</option>
                        <option value="PENDING">PENDING</option>
                        <option value="UNRESOLVED">UNRESOLVED</option>
                    </select>
                </td>
                <td><button type="submit" class="btn btn-primary btn-sm">Submit</button></td>
            </tr>
        </table>
    </div>
    </form>

    <?php 
    $btnedit    = 'CHtml::link("<i class=\"fa fa-pencil\"></i>&nbsp;Modify", "'. $this->moduleURL("feedback") .'/update?id=".$data->id, array("class"=>"btn btn-default"))';
    $btndelete  = 'CHtml::link("<i class=\"fa fa-trash\"></i>&nbsp;Delete", "'. $this->moduleURL("feedback") .'/delete?id=".$data->id, array("class"=>"btn btn-default", "onclick"=>"return msg()"))';
    
    $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'tgrid',
    'dataProvider'=>$dataProvider,
    'columns'=>array(
            array(
                'type'=>'raw',
                'header'=>'ID',
                'name'=>'id',
                'value'=>'$data->id',
                'headerHtmlOptions'=>array('width'=>'20px'),
            ),
            array(
                'type'=>'raw',
                'header'=>'Date',
                'name'=>'created_at',
                'value'=>'date("m/d/Y", strtotime($data->created_at))',
                'headerHtmlOptions'=>array('width'=>'50px'),
            ),
            'reporter_email',
            array(
                'type'=>'raw',
                'header'=>'Summary',
                'name'=>'message',
                'value'=>'(strlen($data->message) > 0) ? substr($data->message,0,10)."...":""',
            ),
            array(
                'type'=>'raw',
                'header'=>'Status',
                'name'=>'status',
                'value'=>'strtoupper($data->status)',
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
    'selectionChanged'=>"
        function(id){
            var tid = $.fn.yiiGridView.getSelection(id);
            dialogbox('View Feedback #'+tid, '". $this->moduleURL("feedback") ."/view/'+tid, 'show');
        }",

    ));
    
    $this->widget('EExcelView', array(
        'id'=>'datagrid',
        'dataProvider'=> $dataProvider,
        'title'=>'feedback',
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

function mainload() {
    $('#tfilter').on('select2:select', function() {
        $('#form1').submit();
    });
}

// Window load
if (window.attachEvent) {window.attachEvent('onload', mainload);}
else if (window.addEventListener) {window.addEventListener('load', mainload, false);}
else {document.addEventListener('load', mainload, false);}

</script>