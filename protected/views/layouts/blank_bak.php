<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Libraries (CSS) -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/datatables.net-dt/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">


	<!-- Base CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<!-- Libraries (JS) -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/datatables.net/js/jquery.dataTables.js"></script>

	<!-- Global Setting -->
	<script type="text/javascript">
		var app = {
			'base_url': "<?php echo Yii::app()->getBaseUrl(true); ?>"
		};
	</script>

	<style type="text/css">
		body {
			background-color: #d9d9d9 !important;
		}
		.container {
			background-color: transparent !important;
		}
		.errorMessage {
		    color: red;
		    font-size: 11px;
		}
	</style>

	<title><?php echo CHtml::encode(Yii::app()->name . (($this->page_label) ? ' - ' . $this->page_label : '') ); ?></title>
</head>

<body>

<div class="container" id="page">
	<?php echo $content; ?>
</div><!-- page -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/global.js"></script>
</body>
</html>
