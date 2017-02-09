<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\PasswordForm;
use yii\widgets\ActiveForm;
/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') {
	/**
	 * Do not use this code in your template.
	 * Remove it.
	 * Instead, use the code $this->layout = '//main-login'; in your controller.
	 */
	echo $this->render ( 'main-login', [ 
			'content' => $content 
	] );
} else {
	
	if (class_exists ( 'backend\assets\AppAsset' )) {
		backend\assets\AppAsset::register ( $this );
	} else {
		// print_r($this); die();
		app\assets\AppAsset::register ( $this );
	}
	
	dmstr\web\AdminLteAsset::register ( $this );
	
	$directoryAsset = Yii::$app->assetManager->getPublishedUrl ( '@vendor/almasaeed2010/adminlte/dist' );
	?>
    <?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta charset="<?= Yii::$app->charset ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags()?>
		<link rel="shortcut icon" type="image/png"
	href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/favicon.png">
<title><?= Html::encode($this->title) ?></title>
        <?php $this->head()?>
         
</head>
<body class=" sidebar-mini skin-blue fixed" style="margin: 0;" onload='updateFDFXFA()'>
    <?php $this->beginBody()?>

    <script type="text/javascript" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/forms/EcmaJSAPI.js"></script>
<script type="text/javascript" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/forms/EcmaParser.js"></script>
    
    
    <div class="wrapper">

        <?=$this->render ( 'header.php', [ 'directoryAsset' => $directoryAsset ] )?>

        <?=$this->render ( 'left.php', [ 'directoryAsset' => $directoryAsset ] )?>

        <?=$this->render ( 'content.php', [ 'content' => $content,'directoryAsset' => $directoryAsset ] )?>

    </div>

    <?php $this->endBody()?>
	


	<!-- jQuery 2.1.4 -->
<script>
    $(document).ready(function() {
    toastr.options = {
    "closeButton": true,
    "timeOut": 10000,
    }
    });
    </script>

</body>
    
  <?php
	$session = \Yii::$app->session;
	$email = $session ['admin_email'];
	
	?>  
    <!-- ---------- change password modal --------------- -->

	<form  class="" id="change-password-form">
<div class="modal fade" id="myModal-change-pswd" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" onclick="resetchangepassword();"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Change Password</h4>
			</div>
			<div class="modal-body" style="float: left;">
				
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Email:</label>
				</div>
				<div class="col-sm-8">
					<span class="form-control"><?php echo $email; ?></span> 
				</div>
				</div>
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Current Password:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">

					<input type="password" class="form-control add-member-input"
						placeholder="Current Password.." id="current-password" name="oldpass"/> <span
						class="error-msg red" id="current-password-error"></span>
				</div>
				</div>
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">New Password:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">
					<input type="password" class="form-control add-member-input"
						placeholder="New Password.." id="new-password" name="newpass"/> <span
						class="error-msg red" id="new-password-error"></span>
				</div>
				</div>
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Confirm Password:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">
					<input type="password" class="form-control add-member-input"
						placeholder="Confirm Password.." id="new-confirm-password" name="repeatnewpass"/> <span
						class="error-msg red" id="confirm-password-error"></span> <label
						class="error-msg" id="display-password-error"></label>
				</div>
				</div>
				
			</div>
			<div class="modal-footer" style="border-top: none;">
				<button type="button" class="btn btn-primary" id="chng_pwd_btn" onclick="return changepassword();">Save
					Changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal"
					onclick="resetchangepassword();">Close</button>



			</div>
		</div>
	</div>
</div>
</form>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.extensions.js"></script>


<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/bootstrap-datepicker.js"></script>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/customfunctions.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/validation.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/toastr.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/basicscroll.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/jquery.slimscroll.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/client-ajax.js"></script>
	
 
	
<div id="pswd_info">
	<h4>Suggested Password Combinations:</h4>
		<ul style="list-style: none;">
			<li id="letter" class="invalid">At least <strong>one letter</strong></li>
			<li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
			<li id="number" class="invalid">At least <strong>one number</strong></li>
			<li id="specialchar" class="invalid">At least <strong>one special character</strong></li>
			<li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
		</ul>
</div>
</html>
<?php $this->endPage()?>

 <link
		href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"
		rel="stylesheet">

	<script type="text/javascript"
		src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>		

<?php } ?>
