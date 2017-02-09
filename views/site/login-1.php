<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'Single Point Reporting | Sign In');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<style>
div#header_back {
    background-image: url('//texaslawshield.com/wp-content/themes/splash-main/images/headerbg.jpg') !important;
	border-bottom: 1px solid #C5C5C5;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.tls {
    font-family: 'IM Fell French Canon SC', serif;
    color: #000;
    font-size: 52px;
}
.fldp {
    color: #c41936;
    font-family: 'IM Fell French Canon SC', serif;
    font-weight: bold;
    text-transform: uppercase;
     font-size: 21.5px;
	 margin-left:26px;
}
.login-page, .register-page {
    background: #FFFFFF;
}
.login-page{
	    background-image: url('//www.texaslawshield.com/facii/media/static/images/constitution-background.jpg') !important;
}
.login-box{
	    margin-top: 3%;
    border: 1px solid #ddd;
    padding: 20px;
    width: 400px;
	   max-width: 400px;
   background: #EAEAEA;
}
.header_text{
	    text-align: center;
    margin-top: 22px;
}
.login-logo, .register-logo {
    font-size: 35px;
    text-align: center;
     margin-bottom: 0px; 
    font-weight: 300;
}
.login-box-body, .register-box-body {
    background: #EAEAEA;
    padding: 20px;
    border-top: 0;
    color: #666;
}
.field-loginform-rememberme{
	margin-bottom:0px;
}
.checkbox{
	margin:0px;
}

</style>
<div id="header_back">
<div id="header" class="container col-md-offset-3 ">

<div class="col-md-1" style="text-align:center;"><h1>
													<img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/home_page/images/USLawShieldLogo.png" alt="US Law Shield" style="max-width:147px;" class="img-responsive">
										
				</h1>
							</div>
			


			<!--<a id="menu-drop-button" href="#"></a>-->
			 <div id="navigation-container" class="col-md-5">
								<div class="header_text">
					<h1 class="tls">US Law Shield</h1>
					<h3 class="fldp">Firearms Legal Defense Program</h3>
				</div>
								<!--
				<ul id="nav" class="clearfix"><li id="menu-item-24" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24"><a href="https://www.texaslawshield.com/do-i-have-to-shoot/">Do I Have to Shoot?</a></li>
<li id="menu-item-266" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-266"><a href="https://www.texaslawshield.com/testimonials/">Our Member Stories</a></li>
</ul>				-->
			</div>
		
		
		</div>
		</div>
		
		<?php 
		if(Yii::$app->session->getFlash('success'))
		{
		
		?>
		<div id="w10-success" class="alert-success alert fade in" style="    margin: 15px;width: 98%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

<i class="icon fa fa-check"></i><?= Yii::$app->session->getFlash('success'); ?>

</div>
		<?php } 
	if(Yii::$app->session->getFlash('error'))
	{
		?>
		<div id="w10-error" class="alert-error alert fade in" style="    margin: 15px;width: 98%;">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

<i class="icon fa fa-close"></i><?= Yii::$app->session->getFlash('error'); ?>

</div>
	<?php } ?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Member Portal</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Login to your account</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
				<a data-toggle="modal" data-target="#myModal" style="cursor:pointer;">I forgot my password</a><br>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>
<!-- 
        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div>
        <!-- /.social-auth-links -->

        
    

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Forgot Password</h4>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                          
                          <p>If you have forgotten your password you can reset it here.</p>
                            <div class="panel-body">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control input-lg" placeholder="E-mail Address" name="email" type="email" id="forgot_email">
										<span id="error_forgot_email" style="color:red;"></span>
                                    </div>
                                    <input class="btn btn-primary btn-block" value="Send My Password" type="button" onclick="sendmail();">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript"
	src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.js"></script>
<link
	href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css"
	rel="stylesheet">
<script>
$(document).ready(function() {  
 toastr.options = {
	  "newestOnTop": true,
	  "progressBar": true,
      "closeButton": true,
      "debug": false,     
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "5000",
      "timeOut": "5000",
      "extendedTimeOut": "5000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
 });
</script>

<script>
function sendmail()
{
	
	if (document.getElementById("forgot_email").value == '') {
		document.getElementById("error_forgot_email").innerHTML = "Email address required";
		document.getElementById("forgot_email").style.borderColor = "red";
		document.getElementById("forgot_email").focus();
		return false;
	} else if (!validateEmail(document.getElementById('forgot_email').value)) {
		document.getElementById('error_forgot_email').innerHTML = "Valid email required";
		document.getElementById("forgot_email").style.borderColor = "red";
		document.getElementById('forgot_email').focus();
		return false;
	} else {
		document.getElementById("error_forgot_email").innerHTML = "";
		document.getElementById("forgot_email").style.borderColor = "";
	}
	
	  var datastr = 'email='+document.getElementById("forgot_email").value;

			$url = '/sendchangemail?' + datastr;
		
			
				$.ajax({ 
						url: $url,
						type: 'GET',
						success: function(response) {	
						if(response == 'Success')
						{
							toastr.success('Reset password link is sent to email');
						$('#myModal').modal('hide');
						}
						else
						{
							toastr.error(response);
						}
						}
				});
				
}

function validateEmail(email) {
	var reg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	if (reg.test(email))
		testresults = true;
	else
		testresults = false;
	return (testresults);
}

</script>