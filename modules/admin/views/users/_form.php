<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
 <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/users.css" rel="stylesheet">
<script>  
$(document).ready(function() {   
			  $("[data-mask]").inputmask();
             		});
					</script>
<?php $form = ActiveForm::begin(['enableClientValidation' => false,'options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'user-form']]); ?>
<div class="box-body">

<div class="col-md-6 padding-left-0 padding-right-0">
	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>
					First Name<span class="red">*</span>
				</h4></label>
				 <?= $form->field($model_staff_users, 'first_name')->textInput(['maxlength' => '20','class'=>'form-control form-height','onkeypress'=>'return nameSpecial(event);'])->label(false)?>
				
			</div>
		
                  
                  
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>
					Last Name<span class="red">*</span>
				</h4></label>
				<?= $form->field($model_staff_users, 'last_name')->textInput(['maxlength' => '20','class'=>'form-control form-height','onkeypress'=>'return nameSpecial(event);'])->label(false)?>
				
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
				 <?= $form->field($model_staff_users, 'phone')->label(false)->textInput(['data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'','class'=>'form-control form-height']);?>
				
			</div>
	</div>

	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>Phone Extension</h4></label> 
				 <?= $form->field($model_staff_users, 'phone_ext')->label(false)->textInput(['data-inputmask'=>'"mask": "(9999)"','data-mask'=>'','class'=>'form-control form-height']);?>
				
			</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>Profile Image</h4></label>
				
				 <?=$form->field ( $model_staff_users, 'profile_pic' )->fileInput ( [ 'class' => 'form-control form-height' ] )->label ( false )?>
    		
			</div>
	</div>
	<?php
	$session = \Yii::$app->session;
	$logged_user_id = $session ['admin_user_id'];
	$logged_permissions = $session ['admin_permissions'];
	if (($model_users->user_id == $logged_user_id)) {
		?>
	
	
	<?php
	
} else {
		
			?>
	<div class="form-group">
		<div class="col-sm-12">
			<label class="control-label"><h4>Assign Permissions</h4></label>

			<table id="example2" class="table table-bordered table-hover margin-0 ">

				<thead>
					<tr class="tr-grid-header">
						<th class="width-10">Select</th>
						<th>Pages</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td style="text-align: center;"><input type="checkbox"
							id="selectall"></td>
						<td><span id="changeText">Administrator</span></td>
					</tr>
					<?php
			
if (! empty ( $staff_rights_details )) {
				foreach ( $staff_rights_details as $rights ) {
					?>
					<tr>
						<td style="text-align: center;"><input type="checkbox"
							class="permission_check"
							value="<?php echo $rights->staff_permission_id; ?>"
							name="staffpermissions[]"
							<?php if(!empty($staff_permissions_details)) if(in_array($rights->staff_permission_id,$staff_permissions_details)) {?>
							checked <?php }?>></td>
						<td><span><?php echo $rights->permission_name; ?></span></td>
					</tr>
					<?php } } ?>
				</tbody>
			</table>


		</div>
	</div>
<?php
		

	}
	?>
	

</div>
<div class="col-md-6 padding-left-0 padding-right-0">
 <?php if($model_staff_users->isNewRecord){  ?>
<?php }else{?>
                   <div class="col-sm-12 padding" style="text-align: -webkit-center;">
				   <?php if(!empty($model_staff_users->profile_pic)){?>
                  <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/<?php echo $model_staff_users->profile_pic ?>" class="img img-responsive" width="200" height="200" >
				  <?php }?>
				 </div>
                  <?php }?>

</div>
</div>
<!-- /.box-body -->
<div class="form-group" style="margin-bottom: 10px;">
	<div class="col-md-6">
		<div class=" pull-right">
			    <?= Html::submitButton($model_users->isNewRecord ? 'Save' : 'Update', ['class' => $model_users->isNewRecord ? 'btn btn-success' : 'btn btn-success','id'=>'user_form'])?>
    
				<a type="submit" class="btn btn-default"
				href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/users">Cancel</a>

		</div>
	</div>
</div>
<!-- /.box-footer -->
<?php ActiveForm::end(); ?>
