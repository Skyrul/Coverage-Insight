<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<meta name="viewport" content="width=device-width">

	<!-- Libraries (CSS) -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">


	<!-- Base CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/login.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<!-- Libraries (JS) -->
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/jquery/dist/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/node_modules/inputmask/dist/jquery.inputmask.bundle.js"></script>

	<!-- Global Setting -->
	<script type="text/javascript">
		var app = {
			'base_url': "<?php echo Yii::app()->getBaseUrl(true); ?>"
		};
	</script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<noscript>
<meta http-equiv="refresh" content="0; url=<?php echo $this->programURL();?>/nojs.html" />
</noscript>
<div class="container" id="page">

	<div id="header">
		<div class="container">
			<div class="row">
			</div>
		</div>
	</div><!-- header -->

	<?php echo $content; ?>


	<div class="clear"></div>

	<div id="footer" class="text-center">
		Copyright &copy; <?php echo date('Y'); ?> by Engagex.<br/>
		All Rights Reserved.<br/><br/>
		<span class="build-version"><?php echo Yii::app()->params['buildVersion']; ?></span>
	</div><!-- footer -->

</div><!-- page -->

<script>
$(document).ready(function() {
    // Phone mask
    $('.phone-mask').inputmask({"mask": "(999)-999-9999"});
});
</script>

</body>
</html>
