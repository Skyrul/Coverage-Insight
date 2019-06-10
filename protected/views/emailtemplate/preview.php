<?php 
$head = CHtml::decode($model->html_head);
$body = CHtml::decode($model->html_body);
$combined = $head . "\n" . $body;

$combined = $this->standardSmartTagsReplace($combined);


// Styling
$tbl = ($model->bg_image_url!='') ? $model->bg_image_url : '';
$tr  = 'height: 0px; line-height: 20px;';
$td  = 'padding: 20px;';
if ($model->format_type == EnumStatus::FLUID_LAYOUT) {
    // Fluid
    $tblstyle = 'width: 100%;height: 700px;';
} else {
    // Fixed
    $tblstyle = 'width: 500px;height: 700px;';
}

if ($model != null): 
?>
<html>
<style>
body {
    margin: 0;
}
.btn-verify {
    background: #3498db; background-image: -webkit-linear-gradient(top, #3498db, #2980b9); background-image: -moz-linear-gradient(top, #3498db, #2980b9); background-image: -ms-linear-gradient(top, #3498db, #2980b9);background-image: -o-linear-gradient(top, #3498db, #2980b9); background-image: linear-gradient(to bottom, #3498db, #2980b9); border-radius: 28px; font-family: Arial; color: #ffffff; padding: 10px 20px 10px 20px; text-decoration: none; width: 100%;
    color: white;
}
</style>
<body>



<table background="<?php echo $tbl; ?>" style="<?php echo $tblstyle; ?>">
    <tr valign="top" style="<?php echo $tr; ?>">
        <td style="<?php echo $td; ?>">
        <p><?php echo $combined; ?></p>
        </td>
    </tr>
</table>

</body>
</html>
<?php endif; ?>