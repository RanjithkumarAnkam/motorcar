

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TblAcaUsers;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaLookupOptions;
use yii\helpers\ArrayHelper;
use app\models\TblAcaCompanyReporitngPeriod;
use app\models\TblAcaBrands;

?>
	      <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/client.css" rel="stylesheet">



<div class=" box-info">
     
     <?php $form = $new_client->isNewRecord ? (ActiveForm::begin(['enableClientValidation' => false,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'','id'=>'client-form']])):($form = ActiveForm::begin(['enableClientValidation' => false,'options' => ['method' => 'post','enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'','id'=>'client-form']]));
	 
	 ?>
          
 
            
            
              <div class="box-body">
              <div class="col-md-6">
              
                  <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Brand<span class="imp_red">*</span></h4></label>
             <?php  
             	$listData= ArrayHelper::map(TblAcaBrands::find()->where(['=', 'is_deleted', 1])->andwhere(['=', 'brand_status', 1])->all(), 'brand_id', 'brand_name');
             	echo $form->field($new_client, 'brand_id')->dropDownList($listData, ['prompt'=>'Select','class'=>'form-control form-height','onchange'=>'return brandThree();','disabled'=> $new_client->isNewRecord ? false : true])->label(false);;
                    ?>
                
                 </div>
                </div>
                
                <div class="form-group hide">
                <div class="col-sm-12">
                  <label class="control-label"><h4>Client Number</h4></label>
				     <?= $form->field($new_client, 'client_number')->label(false)->textInput(['class'=>'form-control form-height','maxlength'=>'20','disabled'=>'']); ?>
				
                    
                  </div>
                </div>
                
                <div class="form-group">
                 <div class="col-sm-12">
                  <label class="control-label"><h4>Client Name<span class="imp_red">*</span></h4></label>
                    <?= $form->field($new_client, 'client_name')->label(false)->textInput(['class'=>'form-control form-height','onkeypress'=>'return companyname(event);','maxlength'=>'70','disabled'=> $new_client->isNewRecord ? false : true]); ?>
                  </div>
                </div>
                
                <div class="form-group">
                <div class="col-sm-12">
                  <label class="control-label"><h4>Order Number</h4></label>
                  <?= $form->field($new_client, 'order_number')->label(false)->textInput(['class'=>'form-control form-height','maxlength'=>'6']); ?>
                   </div>
                </div>
                <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Contact Person First Name<span class="imp_red">*</span></h4></label>
                    <?= $form->field($new_client, 'contact_first_name')->label(false)->textInput(['class'=>'form-control form-height','onkeypress'=>'return nameSpecial(event);','maxlength'=>'20']); ?>
                     
                  </div>
                </div>
                
                
                <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Contact Person Last Name<span class="imp_red">*</span></h4></label>
                     <?= $form->field($new_client, 'contact_last_name')->label(false)->textInput(['class'=>'form-control form-height','onkeypress'=>'return nameSpecial(event);','maxlength'=>'20']); ?>
                     
                  </div>
                </div>
                <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Contact Person Email<span class="imp_red">*</span></h4></label>
                     <?= $form->field($new_client, 'email')->label(false)->input('email')->textInput(['class'=>'form-control form-height','maxlength'=>'50','disabled'=> $new_client->isNewRecord ? false : true]); ?>
                     
                  </div>
                </div>
               
               <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Account Manager</h4></label>
                  
                  
                  <?php 
                  $models = TblAcaStaffUsers::find()->joinWith('user')->where(['tbl_aca_users.is_deleted'=>0,'tbl_aca_users.usertype'=>1,'tbl_aca_users.is_active'=>1])->asArray()->all();
                  $data = ArrayHelper::map($models, 'user_id', function($model, $defaultValue) {
								return $model['first_name'].' '.$model['last_name'].'';
							});
                  
                   echo $form->field($new_client, 'account_manager')->dropdownList(
                  		$data,
                  		['prompt'=>'Select Manager','class'=>'form-control form-height']
                  )->label(false);
                  ?>
                     
                     </div>
                </div>
                
                </div>
                 <div class="col-md-6">
                 
                <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Contact Person Phone Number<span class="imp_red">*</span></h4></label>
                      
                  	<?php echo $form->field($new_client,'phone')->label(false)->textInput(['data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>   
                  </div>
                </div>
                
                
                <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Product</h4></label>
                    
                    
                    <?php 
                   
                    $listData= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 4])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');
					   echo $form->field($new_client, 'product')->dropDownList($listData, ['prompt'=>'Select','class'=>'form-control form-height'])->label(false);;
					     ?>
					   
                    
                     
                     </select>
                     
                     </div>
                </div>
                
            
                
              
                   <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Package Type<span class="imp_red">*</span></h4></label>
                 <?php 
                    $listData= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 2])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');
					   echo $form->field($new_client, 'package_type')->dropDownList($listData, ['prompt'=>'Select','class'=>'form-control form-height'])->label(false);;
					     ?>
                  </div>
                </div>
                
                <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>ACA Year<span class="imp_red">*</span></h4></label>
                                    <?php 
                    $listData= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 5])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');
					   echo $form->field($new_client, 'aca_year')->dropDownList($listData, ['prompt'=>'Select','class'=>'form-control form-height','disabled'=> $new_client->isNewRecord ? false : true])->label(false);;
					     ?>
                    </div>
                </div>
                
                <div class="form-group">
                   <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Reporting Structure<span class="imp_red">*</span></h4></label>
                                   <?php 
                    $listData= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 3])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');
					   echo $form->field($new_client, 'reporting_structure')->dropDownList($listData, ['prompt'=>'Select','class'=>'form-control form-height','onchange'=>'disableCount();'])->label(false);;
					     ?>
                    
                     
                    </div>
                </div>
                
                <div class="form-group">  
                <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Number of Forms Bought</h4></label>
                  <?= $form->field($new_client, 'forms_bought')->label(false)->textInput(['type' => '','class'=>'form-control form-height numbers','maxlength'=>'7']); ?>
                     
                   
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Sub EIN Count  <?php if($new_client->isNewRecord){}else{?> <small>(Current Ein Count :<?php echo $old_ein_count;	 ?>)</small><?php }?></h4></label>
                   <?php echo $form->field($new_client, 'ein_count')->label(false)->textInput(['type' => '','min'=>'1','class'=>'form-control form-height numbers','maxlength'=>'3','onkeyup'=>'this.value = minmax(this.value, 1)','disabled'=> $new_client->isNewRecord ? false : ( $new_client->reporting_structure == 15 ? true : false)]); ?>
                 
                
                  </div>
                </div>
                
                            
                <div class="form-group">
                    <div class="col-sm-12">
                  <label for="inputEmail3" class="control-label"><h4>Price Paid</h4></label>
                   <div class="input-group " style="margin-bottom: 10px;">
																				<span class="input-group-addon">$ </span>
																				 <?= $form->field($new_client, 'price_paid')->label(false)->textInput(['class'=>'form-height form-control ','maxlength'=>'6']); ?>
																				
																			</div>
                   </div>
                </div>
                
                 </div>
                
                <div class="col-sm-12">
             <div class="pull-right" >
			 
			 <script type="text/javascript">
					document.write('<?php echo Html::submitButton($new_client->isNewRecord ? 'Save' : 'Update', ['class' => $new_client->isNewRecord ? 'btn btn-success' : 'btn btn-success','id' => 'client_form']) ?>');
			</script>
			<noscript>
					<?php if($new_client->isNewRecord) { ?>
					<button class="btn btn-success" type="button">Save</button>
					<?php }else{ ?>
					<button class="btn btn-success" type="button">Update</button>
					<?php } ?>
			</noscript>

                
              
                <a  class="btn btn-default" href="<?php echo Yii::$app->homeUrl;?>admin/clients">Cancel</a>
                </div>
                 </div>
              </div>
              <!-- /.box-body -->
               
              <!-- /.box-footer -->
           <?php ActiveForm::end() ?>
          </div>
		  
		  <script>

		  
		 
$(document).ready(function() {
 $("[data-mask]").inputmask();
<?php 
if(!empty($old_ein_count))
{
if($old_ein_count > 1)
{
?>
	$("#tblacaclients-reporting_structure option[value=15]").hide();
<?php }}?>
	
});	


				
						</script>
						

<div class="modal fade" id="eincountconfirm" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="clearFields();">x</button>
				<h4 class="modal-title" id="myModalLabel">EIN Confirmation</h4>
			</div>
			<form id="resetlink">
			<div class="modal-body">
			<div class="form-group">
				<div class="col-sm-12 add-mem"  style="line-height: 33px;">
					<label class="add-member-label">Are you sure your EIN count is <span id="confirm"></span>  ?</label>
				</div>
				
	</div>
			</div>
			<div class="modal-footer"
				style="border-top: none; margin-right: 15px;">
				<button type="button" class="btn btn-default btn-sm"
					data-dismiss="modal" >Close</button>
					   <a id="einnumbersuccess" class="btn btn-primary btn-sm" >Save</a>
				
			</div>
			</form>
		</div>
	</div>
</div>

<div class="load-gif" id="loadGif" style="display:none;">
 <div class="procressing_plz_wait">Processing please wait ....
  <img class="gif-img-prop" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/j-max-loader.gif" /> 
 </div>
</div>