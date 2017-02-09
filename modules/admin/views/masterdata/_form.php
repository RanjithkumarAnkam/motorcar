<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

 <script>

             $(document).ready(function() {   
			  $("[data-mask]").inputmask();
		
			 
             $('#brand_form').click(function(e){
             var is_new = <?php echo $model->isNewRecord ? 1:0; ?>;
			e.preventDefault(); 
			brandSubmitForm(is_new);
             		});
					
             		});

                          
             </script>
   
	    <?php
$form = $model->isNewRecord ? (ActiveForm::begin(['enableClientValidation' => false,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'brand-form']])) : (ActiveForm::begin(['enableClientValidation' => false,'options' => ['method' => 'post','enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'brand-form']])); ?>
    
              <div class="box-body">
                <div class="form-group">
                <div class="col-sm-6">
                  <label class="control-label"><h4>Brand Name<span class="imp_red">*</span></h4></label>
								
                 <?php echo $form->field($model,'brand_name')->label(false)->textInput(['class'=>'form-control form-height','maxlength'=>'34','onkeypress'=>'return brandKeycode(event);' ]); ?>
				    
                  </div>
                  <?php if($model->isNewRecord){  ?>
                  <div class="col-sm-6">
                  </div>
                  <?php }else{?>
                   <div class="col-sm-6 img-padding">
                  <img class="img-width" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/brand_logo/<?php echo $model['brand_logo'] ?>">
                  </div>
                  <?php }?>
                </div>
                
                <div class="form-group">
                 <div class="col-sm-6">
                  <label class="control-label"><h4>Logo<span class="imp_red">*</span></h4></label>
                   <?php echo $form->field($model, 'brand_logo')->fileInput(['class'=>'form-control form-height'])->label(false); ?>
	               </div>
                </div>
                
                <div class="form-group">
                <div class="col-sm-6">
                  <label class="control-label"><h4>Support Email<span class="imp_red">*</span></h4></label>
                   <?php echo $form->field($model,'support_email')->input('email',['class'=>'form-control form-height','maxlength'=>'50'])->label(false); ?>
                   
                  </div>
                </div>
                
                <div class="form-group">
                <div class="col-sm-6">
                  <label class="control-label"><h4>Support Phone Number<span class="imp_red">*</span></h4></label>
              
              	<?php /*echo $form->field($model,'support_number')->label(false)->textInput()->widget(\yii\widgets\MaskedInput::className(), [  'mask' => '(999) 999-9999',
				'clientOptions' => [
				    'removeMaskOnSubmit' => true,
				]]); */?>
				<?php echo $form->field($model,'support_number')->label(false)->textInput(['data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>
              <!--  <input type="text" class="form-control form-height" id="inputEmail3" placeholder="">-->
                  </div>
                </div>
				
				<div class="form-group">
                 <div class="col-sm-6">
                  <label class="control-label"><h4>Terms and Condition URL<span class="imp_red">*</span></h4></label>
                <?php echo $form->field($model,'brand_url')->label(false)->textInput(['class'=>'form-control form-height' ]); ?>
	               </div>
                </div>
				
				<div class="form-group">
                 <div class="col-sm-6">
                  <label class="control-label"><h4>Right Signature URL</h4></label>
                <?php echo $form->field($model,'right_sign_url')->label(false)->textInput(['class'=>'form-control form-height' ]); ?>
	               </div>
                </div>
				
				<div class="form-group">
                 <div class="col-sm-6">
                  <label class="control-label"><h4>Right Signature Key</h4></label>
                <?php echo $form->field($model,'secure_token')->label(false)->textInput(['class'=>'form-control form-height' ]); ?>
	               </div>
                </div>
				
                 <div class="form-group">
                 <div class="col-sm-6">
                  <label class="control-label"><h4>Status<span class="imp_red">*</span></h4></label>
                    	<?php echo $form->field($model, 'brand_status')->dropDownList([ '0' => 'Select', '1' => 'Active', '2' => 'Inactive'],['class'=>'form-control form-height'])->label(false); ?>
                
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
            <div class="box-footer pull-right" >
            
            <?php echo Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','id' => 'brand_form']); ?>
    
			<!--  <button type="submit"  class="btn btn-success ">Save</button>-->
                 <a type="" class="btn btn-default" href="<?php echo Yii::$app->homeUrl;?>admin/masterdata">Cancel</a>
               
                </div> 
              <!-- /.box-footer -->
             <?php  ActiveForm::end(); ?> 

             
            