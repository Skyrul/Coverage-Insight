<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Account Successfully Created';
?>

<style>
.account-logo-login {
    display: block;
    margin: 0 auto;
    width: 20%;
}
.container {
    width: 60% !important;
}
.text-center {
    text-align: center;
}
.btn-login {
    height: 40px;
    width: 120px;
    font-size: 16px;
}
</style>

<script>
<?php
	    foreach(Yii::app()->user->getFlashes() as $key => $message) {
	        if ($key == 'success') {
	            echo 'alert("' . $message . '")';
	        }
	    }
?>
</script>


<div class="form">
    <img class="account-logo-login" src="<?php echo Yii::app()->request->baseUrl; ?>/images/program.png">
    <br>
    
    <div class="row">
    
    <?php if(isset($_GET['resend'])):?>
        <h1 class="text-center">Email Verification Successfully Sent!</h1>
        <h3 class="text-center">(Please check your Inbox)</h3>
        <br>
    
    <?php else: ?>
        <h1 class="text-center">Your account was successfully created!</h1>
        <h3 class="text-center">Please check your inbox for Verification</h3>
        <br>
        <h4 class="text-center">If you DO not received your email verification. Click here to <a href="<?php echo $this->programURL(); ?>/site/success?email=<?php echo $email;?>&resend=true">Resend Verification</a></h4>
    <?php endif; ?>
    
    <h4 class="text-center"><button class="btn-login" onclick="location.href='<?php echo $this->programURL(); ?>/site/login';">Login</button></h4>
    
    </div>
</div>