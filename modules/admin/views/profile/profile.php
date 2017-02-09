<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
 <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/users.css" rel="stylesheet">
<div class=" box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title">Update Profile</h3>
		<span style="float: right;"></span>

	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">You can update profile from this screen.</p>
	</div>
	<div class="col-md-12">
		<div class=" box-info">

		
<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
<div class="box-body">

<div class="col-md-6 padding-left-0 padding-right-0">
	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>
					First Name<span class="red">*</span>
				</h4></label>
				 <?= $form->field($model_staff_users, 'first_name')->textInput(['maxlength' => '34','class'=>'form-control form-height'])->label(false)?>
				
			</div>
		
                  
                  
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>
					Last Name<span class="red">*</span>
				</h4></label>
				<?= $form->field($model_staff_users, 'last_name')->textInput(['maxlength' => '34','class'=>'form-control form-height'])->label(false)?>
				
			</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>
					Email<span class="red">*</span>
				</h4></label>
				 <?= $form->field($model_users, 'useremail')->textInput(['maxlength' => '50','class'=>'form-control form-height','readonly'=> $model_staff_users->isNewRecord ? false : true])->label(false)?>
				
			</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>Phone</h4></label> 
				 <?= $form->field($model_staff_users, 'phone')->widget(\yii\widgets\MaskedInput::className(), [  'mask' => '(999) 999-9999',])->textInput(['class'=>'form-control form-height phone']) ->label(false)?>
				
			</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>Profile Image</h4></label>
				
				 <?=$form->field ( $model_staff_users, 'profile_pic' )->fileInput ( [ 'class' => 'form-control form-height' ] )->label ( false )?>
    		
			</div>
	</div>
	

</div>
<div class="col-md-6 padding-left-0 padding-right-0">

                   <div class="col-sm-12 padding" style="text-align: -webkit-center;">
				   <?php if(!empty($model_staff_users->profile_pic)){?>
                  <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/<?php echo $model_staff_users->profile_pic ?>" class="img img-responsive" width="200" height="200" >
				  <?php }?>
				 </div>
                

</div>
</div>
<!-- /.box-body -->
<div class="form-group" style="margin-bottom: 10px;">
	<div class="col-md-6">
		<div class=" pull-right">
			    <?= Html::submitButton($model_users->isNewRecord ? 'Save' : 'Update', ['class' => $model_users->isNewRecord ? 'btn btn-success' : 'btn btn-success'])?>
    
				<a type="submit" class="btn btn-default"
				href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin">Cancel</a>

		</div>
	</div>
</div>
<!-- /.box-footer -->
<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>