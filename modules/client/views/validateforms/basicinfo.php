<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use app\models\TblAcaCountries;
use app\models\TblUsaStates;
use app\models\TblCityStatesUnitedStates;


$get_id = Yii::$app->request->get ();
$company_id = $get_id ['c_id'];
 
?>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/reporting.js"></script>
<link rel="stylesheet" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/reporting.css">

<?php


$country_list =  ArrayHelper::map(TblAcaCountries::find()->All(), 'country_code', 'country_name');

$usStates =  ArrayHelper::map(TblUsaStates::find()->All(), 'state_code', 'state_code');

$uscityStates =  array();

$suffix= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 7])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');

?>
<style>
.form-height {
    
    width: 50%;
}
.help-block{
float: left;
}
</style>
<div class="box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title col-xs-6">Validate &amp; Create Forms - <?php if(!empty($c_details['company_name'])){echo htmlentities($c_details['company_name']); }?> <small><?php if(!empty($c_details['company_client_number'])){echo '('.htmlentities($c_details['company_client_number']).')'; }?></small></h3>
		<div class="col-xs-6 pull-right padding-right-0">
			<a class=" btn bg-orange btn-social pull-right " data-toggle="tooltip" data-placement="bottom" title="Click to view help video"  onclick="playVideo(7);"> <i
				class="fa fa-youtube-play"></i>View Help Video
			</a>
		</div>
	</div>
	<div class="col-md-12">
		<div class="col-xs-12 header-new-main">
			<span class="header-icon-band"><i class="fa fa-file-text-o icon-band lighter"></i></span>
			<p class="sub-header-new">You can update with the correct information from this screen</p>
		</div>
	</div>
	
	

	<div class="col-md-12 ">



		<div class="row">
			<div class="">
				<div class="box box-solid">

					<!-- /.box-header -->
					<div class="box-body">

						<div class="box-group" id="accordion">
							<div class="" id="meccoverage">



<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/savebasicinfo?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'','id'=>'basic_info_form']]); ?>

								<div class="box-body">


									<div class="">
									 <div class="col-md-6 box-footer" ><font size="4" ><b>Validate Report ( Basic Information )</b></font></div>
                   <div class=" col-md-6 box-footer pull-right padding-right-0" style="text-align: right;">


												<button type="submit"
													class="btn btn-primary mec-coverage-btn" name="button"
													value="continue"
													>Update</button>
												<a class="btn btn-default btn-default-cancel"
													href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms?c_id=<?php echo $company_id;?>">Cancel</a>

											</div>
										<div class="col-md-12" style="border: 1px solid #ada7a7;">
					
									
								<div class="">
									

									<div style="padding-top:20px;">
									
									
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
									
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.1'])){ echo Html::encode($arrsection_elements['1.1']); } ?></h4></label> 
																			<?=$form->field ( $company_details, 'company_name' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'75','onkeypress'=>'return nameSpecial(event);','readonly'=>true ] )->label ( false )?>
																			<?php if(!empty($arrvalidation_errors[1]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[1]['error_code'].' : '; ?><?php echo $arrvalidation_errors[1]['error_message']; ?></span>
																			<?php }?>
																			
																			<?php if(!empty($arrvalidation_errors[2]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[2]['error_code'].' : '; ?><?php echo $arrvalidation_errors[2]['error_message']; ?></span>
																			<?php }?>
																			
																		</div>
																		</div>
																		
																		<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.2'])){ echo Html::encode($arrsection_elements['1.2']); } ?></h4></label>
																			<?=$form->field ( $company_details, 'company_ein' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','data-inputmask'=>'"mask": "99-9999999"','data-mask'=>'','readonly'=>true ] )->label ( false )?>
																			<?php if(!empty($arrvalidation_errors[3]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[3]['error_code'].' : '; ?><?php echo $arrvalidation_errors[3]['error_message']; ?></span>
																			<?php }?>
																			
																			<?php if(!empty($arrvalidation_errors[4]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[4]['error_code'].' : '; ?><?php echo $arrvalidation_errors[4]['error_message']; ?></span>
																			<?php }?>
																			
																			<?php if(!empty($arrvalidation_errors[5]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[5]['error_code'].' : '; ?><?php echo $arrvalidation_errors[5]['error_message']; ?></span>
																			<?php }?>
																		</div>
																	</div>
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																	
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.3'])){ echo Html::encode($arrsection_elements['1.3']); } ?> (Optional)</h4></label> 
																			<span class="form-control form-height col-sm-6"><?php echo Html::encode($company_details->tbl_aca_company_reporting_period->year->lookup_value); ?></span>

																		</div>
																
																	</div>
																	

																									<div class="form-group col-md-12 padding-left-0 padding-right-0">
																	
																	
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.4'])){ echo Html::encode($arrsection_elements['1.4']); } ?></h4></label> 
																			<?=$form->field ( $model_basic_info, 'contact_first_name' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'20','onkeypress'=>'return nameSpecial(event);' ] )->label ( false )?>
    																<?php if(!empty($arrvalidation_errors[6]['error_code'])){?>
																		<span
																	class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[6]['error_code'].' : '; ?><?php echo $arrvalidation_errors[6]['error_message']; ?></span>
																	<?php }?>
																	<?php if(!empty($arrvalidation_errors[7]['error_code'])){?>
																		<span
																	class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[7]['error_code'].' : '; ?><?php echo $arrvalidation_errors[7]['error_message']; ?></span>
																	<?php }?>
																	<?php if(!empty($arrvalidation_errors[8]['error_code'])){?>
																		<span
																	class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[8]['error_code'].' : '; ?><?php echo $arrvalidation_errors[8]['error_message']; ?></span>
																	<?php }?>
																				
																		</div>
																	
																	
																	</div>
																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																	<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.5&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.5'])){ echo Html::encode($arrsection_elements['1.5']); } ?> (Optional)</h4></label> 
																			
																			<?=$form->field ( $model_basic_info, 'contact_middle_name' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'20','onkeypress'=>'return nameSpecial(event);' ] )->label ( false )?>
																		</div>
																	</div>	
																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.6&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.6'])){ echo Html::encode($arrsection_elements['1.6']); } ?></h4></label> 
																			<?=$form->field ( $model_basic_info, 'contact_last_name' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'20','onkeypress'=>'return nameSpecial(event);' ] )->label ( false )?>
																		<?php if(!empty($arrvalidation_errors[9]['error_code'])){?>
																		<span
																	class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[9]['error_code'].' : '; ?><?php echo $arrvalidation_errors[9]['error_message']; ?></span>
																	<?php }?>
																	<?php if(!empty($arrvalidation_errors[10]['error_code'])){?>
																		<span
																	class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[10]['error_code'].' : '; ?><?php echo $arrvalidation_errors[10]['error_message']; ?></span>
																	<?php }?>
																	<?php if(!empty($arrvalidation_errors[11]['error_code'])){?>
																		<span
																	class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[11]['error_code'].' : '; ?><?php echo $arrvalidation_errors[11]['error_message']; ?></span>
																	<?php }?>
																		</div>
																	</div>
																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.7&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.7'])){ echo Html::encode($arrsection_elements['1.7']); } ?> (Optional)</h4></label> 
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_person_suffix')->dropdownList(
															                  		$suffix,
															                  		['prompt'=>'Select Suffix','class'=>'form-control form-height']
															                  )->label(false);
															                  ?>
																		</div>
																	</div>
																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0" >
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.8&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.1'])){ echo Html::encode($arrsection_elements['1.8']); } ?></h4></label> 
																					<?=$form->field ( $model_basic_info, 'contact_person_title' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'35','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
																	
																			<?php if(!empty($arrvalidation_errors[12]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[12]['error_code'].' : '; ?><?php echo $arrvalidation_errors[12]['error_message']; ?></span>
																			<?php }?>
																			<?php if(!empty($arrvalidation_errors[13]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[13]['error_code'].' : '; ?><?php echo $arrvalidation_errors[13]['error_message']; ?></span>
																			<?php }?>
																		</div>
																		</div>
																		
																		
																		
																		<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.9&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.9'])){ echo Html::encode($arrsection_elements['1.9']); } ?></h4></label> 
																			
																			<?=$form->field ( $model_basic_info, 'contact_person_email' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'100' ] )->label ( false )?>
																			<?php if(!empty($arrvalidation_errors[14]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[14]['error_code'].' : '; ?><?php echo $arrvalidation_errors[14]['error_message']; ?></span>
																			<?php }?>
																			<?php if(!empty($arrvalidation_errors[15]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[15]['error_code'].' : '; ?><?php echo $arrvalidation_errors[15]['error_message']; ?></span>
																			<?php }?>
																		</div>
																	</div>
																	

																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.10&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.10'])){ echo Html::encode($arrsection_elements['1.10']); } ?></h4></label> 
																			
																			 	<?php echo $form->field($model_basic_info,'contact_phone_number')->label(false)->textInput(['class' => 'form-control form-height col-sm-6','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>   
                															 <?php if(!empty($arrvalidation_errors[16]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php ////echo $arrvalidation_errors[16]['error_code'].' : '; ?><?php echo $arrvalidation_errors[16]['error_message']; ?></span>
																			<?php }?>
																			<?php if(!empty($arrvalidation_errors[17]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[17]['error_code'].' : '; ?><?php echo $arrvalidation_errors[17]['error_message']; ?></span>
																			<?php }?>
																		</div>
																	</div>
																	
																	
																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.11&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.11'])){ echo Html::encode($arrsection_elements['1.11']); } ?></h4></label>
																			<?=$form->field ( $model_basic_info, 'street_address_1' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													 						<?php if(!empty($arrvalidation_errors[18]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[18]['error_code'].' : '; ?><?php echo $arrvalidation_errors[18]['error_message']; ?></span>
																			<?php }?>
																			<?php if(!empty($arrvalidation_errors[19]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[19]['error_code'].' : '; ?><?php echo $arrvalidation_errors[19]['error_message']; ?></span>
																			<?php }?>
																		</div>
																		</div>
																		
																		<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.12&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.12'])){ echo Html::encode($arrsection_elements['1.12']); } ?> (Optional)</h4></label>
																			<?=$form->field ( $model_basic_info, 'street_address_2' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													
																		</div>
																		</div>
																		
																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.13&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.13'])){ echo Html::encode($arrsection_elements['1.13']); } ?></h4></label>
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_country')->dropdownList(
															                  		$country_list,
															                  		['prompt'=>'Select Country','class'=>'form-control form-height col-sm-6']
															                  )->label(false);
															                  ?>
															                  
															                  <?php if(!empty($arrvalidation_errors[20]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[20]['error_code'].' : '; ?><?php echo $arrvalidation_errors[20]['error_message']; ?></span>
																			<?php }?>
																			
																		</div>
																				</div>
																				
																				
																				
																		<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.14&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.14'])){ echo Html::encode($arrsection_elements['1.14']); } ?></h4></label> 
																			
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_state')->dropdownList(
															                  		$usStates,
															                  		['prompt'=>'Select State','class'=>'form-control form-height col-sm-6','onchange'=>'statebasicChange(this.value);']
															                  )->label(false);
															                  ?>
															                   <?php if(!empty($arrvalidation_errors[21]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[21]['error_code'].' : '; ?><?php echo $arrvalidation_errors[21]['error_message']; ?></span>
																			<?php }?>
																		</div>


																	</div>
																	
																		
																		
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">

																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.15&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.15'])){ echo Html::encode($arrsection_elements['1.15']); } ?></h4></label> 
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_city')->dropdownList(
															                  		$uscityStates,
															                  		['prompt'=>'Select City','class'=>'form-control form-height col-sm-6']
															                  )->label(false);
															                  ?>
															                   <?php if(!empty($arrvalidation_errors[22]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[22]['error_code'].' : '; ?><?php echo $arrvalidation_errors[22]['error_message']; ?></span>
																			<?php }?>
																			
																		</div>

																				</div>
																				
																				
																				
																		<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.16&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.16'])){ echo Html::encode($arrsection_elements['1.16']); } ?></h4></label> 
																			<?=$form->field ( $model_basic_info, 'contact_zip' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'5','onkeypress'=>'return alphanumeric(event);' ] )->label ( false )?>
													<?php if(!empty($arrvalidation_errors[23]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[23]['error_code'].' : '; ?><?php echo $arrvalidation_errors[23]['error_message']; ?></span>
																			<?php }?>
																		</div>
																	</div>
																	
																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.17&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.17'])){ echo Html::encode($arrsection_elements['1.17']); } ?> (Optional)</h4></label>
																				<?=$form->field ( $model_basic_info, 'emp_benefit_broker_name' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'34','onkeypress'=>'return alpha(event);' ] )->label ( false )?>
    		
																		</div>
</div>

																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.18&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.18'])){ echo Html::encode($arrsection_elements['1.18']); } ?> (Optional)</h4></label> 
																			
																			<?=$form->field ( $model_basic_info, 'emp_benefit_broker_email' )->textInput ( [ 'class' => 'form-control form-height col-sm-6','maxlength'=>'100' ] )->label ( false )?>
																	
																		</div>
																	</div>

																	<div class="form-group col-md-12 padding-left-0 padding-right-0">
																		<div class="col-sm-12">
																			<label class="control-label col-sm-6"><h4>1.19&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.19'])){ echo Html::encode($arrsection_elements['1.19']); } ?> (Optional)</h4></label> 
																			<?php echo $form->field($model_basic_info,'emp_benefit_phone_number')->label(false)->textInput(['class' => 'form-control form-height col-sm-6','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>   
                 
																		</div>


																	</div>


									
									</div>
									

								</div>
								
								
                </div>
									</div>

								</div>
								<?php ActiveForm::end(); ?>
							</div>
							
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>
		</div>
	</div>
	

	
	
	

<script>
$(window).load(function() {
	 
	 var contactstatehtml = '<input type="text" id="tblacabasicinformation-contact_state" class="form-control form-height" name="TblAcaBasicInformation[contact_state]" value="" maxlength="25" onkeypress="return alpha(event);">';
	var contactcity = '<input type="text" id="tblacabasicinformation-contact_city" class="form-control form-height" name="TblAcaBasicInformation[contact_city]" value="" maxlength="50" onkeypress="return alpha(event);">';
		

	
	
	
	<?php  $selected_Country = '';
$contact_state = '';
$contact_city = '';	
			if(!empty($model_basic_info->contact_country))
				{
					$selected_Country = $model_basic_info->contact_country;
				}
				else
				{
					$selected_Country = '';
				}
				
				
					if(!empty($model_basic_info->contact_state))
				{
					$contact_state = $model_basic_info->contact_state;
				}
				
				if(!empty($model_basic_info->contact_city))
				{
					$contact_city = $model_basic_info->contact_city;
				}
					
				
	
	?>
	
	$('#tblacabasicinformation-contact_country').val('<?php echo $selected_Country; ?>');
	
	<?php if($selected_Country != 'US'){?>
	
	$('.field-tblacabasicinformation-contact_state').html(contactstatehtml);
	$('.field-tblacabasicinformation-contact_city').html(contactcity);
	$('#tblacabasicinformation-contact_state').val('<?php echo $contact_state; ?>');
	$('#tblacabasicinformation-contact_city').val('<?php echo $contact_city; ?>');
	
	<?php }else{ ?>
	$('#tblacabasicinformation-contact_state').val('<?php echo $contact_state; ?>').change();
	setTimeout(function(){ $('#tblacabasicinformation-contact_city').val('<?php echo $contact_city; ?>').change(); },1000);
	;
	<?php }?>
	
	
	
	
	

});



</script>
				
