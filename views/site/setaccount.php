<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;

use yii\bootstrap\ActiveForm;

$this->title = 'Set Account';

$this->params ['breadcrumbs'] [] = $this->title;

?><link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/css/custom.css" rel="stylesheet" type="text/css" /><div class="site-login">
     <?php if(Yii::$app->session->hasFlash('custom')): ?>
        <div class="alert alert-danger" role="alert">
            <?= Yii::$app->session->getFlash('custom')?>
        </div>
    <?php endif; ?><style>
.help-block-error{
	color:red;
	}
	
</style>
<div class="row">		<div class="col-sm-4"></div>		<div class="col-sm-4 box"			style="background-color: white; box-shadow: 0 1px 3px 0 #bfbfbf; border-radius: 6px;">			<div class="">				<div class="col-xs-12">					<!-- BEGIN LOGIN FORM -->
	  <?php
			
$form = ActiveForm::begin ( [ 
					
					'id' => 'login-form',
					
					'options' => [ 
							'class' => 'login-form' 
					] 
			]
			 );
			?>
<h4 class=""						style="margin: 25px 0 15px 0; font-weight: bold; text-align: left;">Set Password</h4>					<!-- BEGIN LOGIN FORM -->					<form action="" class="login-form" method="post"						novalidate="novalidate">						<div class="form-group" style="margin-bottom: 0px;">							<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->							<div class="input-icon">						  <?=$form->field ( $model, 'password' )->label ( false )->passwordInput ( [ 'placeholder' => $model->getAttributeLabel ( 'Password' ),'class' => 'form-control  placeholder-no-fix' ] )?>
				

			</div>
									</div>						<div class="form-group">							<div class="input-icon">
			 			<?=$form->field ( $model, 'confirmpassword' )->label ( false )->passwordInput ( [ 'placeholder' => $model->getAttributeLabel ( 'Confirm Password' ),'class' => 'form-control  placeholder-no-fix' ] )?>				


			</div>						</div>
						
						<div class="form-group">
							  <div class="col-md-12" style=" padding: 0;margin-bottom:15px;">
							<div class="col-md-1 padding-left-0" style="float: left; padding-left: 0;">
							
							<input type="checkbox" id="checkme">
									</div>		
							<div class="col-md-10" style="padding-left: 0;">I accept  these<a href="<?php echo $link;?>"  target="_blank"> terms and conditions</a></div>
			           </div>
			           
			           </div>						<div class="form-actions">
			
			 <?= Html::submitButton('Save', ['class' => 'btn btn-primary blue col-xs-6 ','disabled'=>'', 'name' => 'login-button','style'=>'width: 100px; margin-bottom: 5%;','onclick'=>'return validatesetpassword();'])?>
			

		</div>					</form>					<!-- END LOGIN FORM -->

	 <?php ActiveForm::end(); ?>
          
          
        </div>			</div>		</div>	</div></div><div id="pswd_info">
								<h4>Suggested Password Combinations:</h4>
								<ul style="list-style: none;">
									<li id="letter" class="invalid">At least <strong>one letter</strong></li>
									<li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
									<li id="number" class="invalid">At least <strong>one number</strong></li>
									<li id="specialchar" class="invalid">At least <strong>one special character</strong></li>
									<li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
								</ul>
							</div><script>
var checker = document.getElementById('checkme');
 // when unchecked or checked, run the function
 checker.onchange = function(){

if(this.checked == true){
    $(".blue").attr('disabled',false)
} else {
      $(".blue").attr('disabled',true)
}

}
</script>