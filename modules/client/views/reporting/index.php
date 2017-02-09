<?php 
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\TblAcaCountries;
use app\models\TblUsaStates;
use app\models\TblCityStatesUnitedStates;
use app\models\TblAcaLookupOptions;

$get_id = Yii::$app->request->get();
$company_id = $get_id['c_id'];

?>

<!-- InputMask -->


<script type="text/javascript">
$(document).ready(function(){
	 $("#basic_reporting").addClass("active");
	 $("#basic_reporting_treeview").addClass("open");
	
	  <?php if(!empty($model_designated_govt_entity->dge_state)){?>
	 statedgeChange('<?php echo $model_designated_govt_entity->dge_state; ?>');
	 
	 setTimeout(function(){
		 $('#tblacadesignatedgovtentity-dge_city').val(<?php echo $model_designated_govt_entity->dge_city; ?>);
		 $('#tblacadesignatedgovtentity-dge_zip').val(<?php echo $model_designated_govt_entity->dge_zip; ?>);
	 }, 1000);
<?php }?>
	 
});
</script>
<?php


$country_list =  ArrayHelper::map(TblAcaCountries::find()->All(), 'country_code', 'country_name');

$usStates =  ArrayHelper::map(TblUsaStates::find()->All(), 'state_code', 'state_code');

$uscityStates =  array();

$suffix= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 7])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');

?>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/reporting.js"></script>
<link rel="stylesheet" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/reporting.css">


<div class="box box-warning container-fluid padding-responsive">
	<div class="box-header with-border">
		<h3 class="box-title col-xs-8">
			Basic Reporting Information - <?php echo Html::encode($company_details->company_name); ?> <small> (<?php echo Html::encode($company_details->company_client_number); ?>) </small>
		</h3>
		<div class="col-xs-4 pull-right">
			<a class=" btn bg-orange btn-flat btn-social pull-right"  data-toggle="tooltip" data-placement="bottom" title="Click to view help video"
				onclick="playVideo(3);"> <i class="fa fa-youtube-play"></i>View Help
				Video
			</a>
		</div>
	</div>

	
	<div class="col-md-12 ">



		<div class="row">
			<div class="col-md-12">
				<div class="box box-solid">

					<!-- /.box-header -->
					<div class="box-body">
						<div class="box-group" id="accordion">
							<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
							<div class="panel  box " id="basicinformation">
								<div class="parent-tabs box-header with-border accordian-band-color">

									<span id="step" class="steps col-xs-2" onclick="editbasic();">
										<span class="check " style="display: none;"> <i
											class="fa fa-check" aria-hidden="true"></i> <span class="">1</span>
									</span> <span style="display: none;" class="edit">Edit</span>
									</span>

									<h4 class="box-title col-xs-8">
										<div class="fixed-number col-md-1 col-xs-2" style="top: 3px;">
											<span class="block-number">1</span>
										</div>
										<a class="custom-bg col-md-11 col-xs-10 white"
											data-parent="#accordion" onclick="editbasic()"
											style=" padding-left: 0;"> Basic Information </a>
									</h4>

									<div class="box-title col-xs-2 col-lg-3 pull-right"
										style="padding-top: 7px;">
										<p class="custom-bg summary-text pull-right white"
											style="font-size: 12px; ">Provide employer
											information</p>
									</div>

								</div>
								<div id="collapseOne"
									class="panel-collapse collapse bg-white black">
									<div class="box-body">
										<p class="highlight-fancy">
											<span class="status"><i class="fa fa-info-circle"
												aria-hidden="true"></i></span> Fill the basic information in
											the form below


										</p>
										<div class="col-md-12 padding-right-0">
										<?php $form = ActiveForm::begin(['action' => ['/client/reporting/savebasicinfo?c_id='.$company_id.'#basicinformation'],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'basic_info_form']]); ?>
											
											<div class="row">
												<div class="col-md-12">

													<div class=" box-info">

														<!-- /.box-header -->
														<!-- form start -->
														
															<div class="box-body">
																<div class="col-xs-offset-1 col-xs-10">
																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.1'])){ echo Html::encode($arrsection_elements['1.1']); } ?></h4></label> 
																			<span class="form-control form-height"><?php echo Html::encode($company_details->company_name); ?></span>
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.2'])){ echo Html::encode($arrsection_elements['1.2']); } ?></h4></label>
																			<span class="form-control form-height"><?php echo Html::encode($company_details->company_ein); ?></span>
																		</div>
																	</div>

																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.3'])){ echo Html::encode($arrsection_elements['1.3']); } ?></h4></label> 
																			<span class="form-control form-height"><?php echo Html::encode($company_details->tbl_aca_company_reporting_period->year->lookup_value); ?></span>

																		</div>
																	</div>

																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.4'])){ echo Html::encode($arrsection_elements['1.4']); } ?></h4></label> 
																			<?=$form->field ( $model_basic_info, 'contact_first_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'20','onkeypress'=>'return nameSpecial(event);' ] )->label ( false )?>
    		
																				
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.5&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.5'])){ echo Html::encode($arrsection_elements['1.5']); } ?></h4></label> 
																			
																			<?=$form->field ( $model_basic_info, 'contact_middle_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'20','onkeypress'=>'return nameSpecial(event);' ] )->label ( false )?>
																		</div>
																	</div>

																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.6&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.6'])){ echo Html::encode($arrsection_elements['1.6']); } ?></h4></label> 
																			<?=$form->field ( $model_basic_info, 'contact_last_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'20','onkeypress'=>'return nameSpecial(event);' ] )->label ( false )?>
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.7&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.7'])){ echo Html::encode($arrsection_elements['1.7']); } ?></h4></label> 
																			
																			
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_person_suffix')->dropdownList(
															                  		$suffix,
															                  		['prompt'=>'Select Suffix','class'=>'form-control form-height']
															                  )->label(false);
															                  ?>
																		</div>
																	</div>

																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.8&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.1'])){ echo Html::encode($arrsection_elements['1.8']); } ?></h4></label> 
																					<?=$form->field ( $model_basic_info, 'contact_person_title' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'35','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
																	
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.9&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.9'])){ echo Html::encode($arrsection_elements['1.9']); } ?></h4></label> 
																			
																			<?=$form->field ( $model_basic_info, 'contact_person_email' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'100' ] )->label ( false )?>
																	
																		</div>
																	</div>

																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.10&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.10'])){ echo Html::encode($arrsection_elements['1.10']); } ?></h4></label> 
																			
																			 	<?php echo $form->field($model_basic_info,'contact_phone_number')->label(false)->textInput(['class' => 'form-control form-height','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>   
                 
																		</div>
																	</div>

																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.11&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.11'])){ echo Html::encode($arrsection_elements['1.11']); } ?></h4></label>
																			<?=$form->field ( $model_basic_info, 'street_address_1' )->textInput ( [ 'class' => 'form-control form-height ','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.12&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.12'])){ echo Html::encode($arrsection_elements['1.12']); } ?></h4></label>
																			<?=$form->field ( $model_basic_info, 'street_address_2' )->textInput ( [ 'class' => 'form-control form-height ','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													
																		</div>
																	</div>



																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.13&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.13'])){ echo Html::encode($arrsection_elements['1.13']); } ?></h4></label>
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_country')->dropdownList(
															                  		$country_list,
															                  		['class'=>'form-control form-height']
															                  )->label(false);
															                  ?>
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.14&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.14'])){ echo Html::encode($arrsection_elements['1.14']); } ?></h4></label> 
																			
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_state')->dropdownList(
															                  		$usStates,
															                  		['prompt'=>'Select State','class'=>'form-control form-height','onchange'=>'statebasicChange(this.value);']
															                  )->label(false);
															                  ?>
																		</div>


																	</div>

																	<div class="form-group">

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.15&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.15'])){ echo Html::encode($arrsection_elements['1.15']); } ?></h4></label> 
																			<?php 
                  
															                   echo $form->field($model_basic_info, 'contact_city')->dropdownList(
															                  		$uscityStates,
															                  		['prompt'=>'Select City','class'=>'form-control form-height']
															                  )->label(false);
															                  ?>
																			
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.16&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.16'])){ echo Html::encode($arrsection_elements['1.16']); } ?></h4></label> 
																			<?=$form->field ( $model_basic_info, 'contact_zip' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'5','onkeypress'=>'return isNumberKey(event);' ] )->label ( false )?>
													
																		</div>
																	</div>



																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.17&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.17'])){ echo Html::encode($arrsection_elements['1.17']); } ?></h4></label>
																				<?=$form->field ( $model_basic_info, 'emp_benefit_broker_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'34','onkeypress'=>'return alpha(event);' ] )->label ( false )?>
    		
																		</div>

																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.18&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.18'])){ echo Html::encode($arrsection_elements['1.18']); } ?></h4></label> 
																			
																			<?=$form->field ( $model_basic_info, 'emp_benefit_broker_email' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'100' ] )->label ( false )?>
																	
																		</div>
																	</div>

																	<div class="form-group">
																		<div class="col-sm-6">
																			<label class="control-label"><h4>1.19&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['1.19'])){ echo Html::encode($arrsection_elements['1.19']); } ?></h4></label> 
																			<?php echo $form->field($model_basic_info,'emp_benefit_phone_number')->label(false)->textInput(['class' => 'form-control form-height','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>   
                 
																		</div>


																	</div>

																</div>
																<!-- /.box-body -->

																<!-- /.box-footer -->
														
															
													</div>

												</div>
											</div>
											<div class="box-footer pull-right padding-right-0">
												<a class="btn btn-default btn-default-cancel"
													href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
												
												<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success basic-information' ,'name' => 'button','value'=>'exit'])?>
    	
													<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success basic-information' ,'name' => 'button','value'=>'continue'])?>
    	
											</div>
								</div>
<?php ActiveForm::end(); ?>
									</div>



								</div>
							</div>
						</div>
						<div class="panel   box " id="empstatustracking">
							<div class="parent-tabs box-header with-border">
								<span id="step1" class="steps col-xs-2" onclick="editbasic1()">
									<span class="check " style="display: none;"> <i
										class="fa fa-check" aria-hidden="true"></i> <span class="">2</span>
								</span> <span style="display: none;" class="edit">Edit</span>
								</span>

								<h4 class="box-title col-xs-8">
									<div class="fixed-number col-md-1 col-xs-2" style="top: 3px;">
										<span class="block-number">2</span>
									</div>
									<a class="custom-bg col-md-11 col-xs-10" onclick="editbasic1()"
										style="padding-left: 0;"> Large Employer Status & Tracking </a>
								</h4>

								<div class="box-title col-xs-2 col-lg-3 pull-right"
									style="padding-top: 7px;">
									<p class="custom-bg summary-text pull-right"
										style="font-size: 12px;">Tell us about your company size</p>
								</div>

							</div>
							<div id="collapseTwo"
								class="panel-collapse collapse bg-white black">
								
									<?php $form = ActiveForm::begin(['action' => ['/client/reporting/largeempstatustrack?c_id='.$company_id.'#empstatustracking'],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'emp_status_form']]); ?>
									
								<div class="box-body padding-right-0">
									<p class="highlight-fancy">
										<span class="status"><i class="fa fa-info-circle"
											aria-hidden="true"></i></span> Specify if your company is an
										Applicable Large Employer

									</p>

									<div class="col-md-offset-1 col-md-10">
										
											<div class="form-group">
												<div class="col-sm-6">
													<span class="control-label"><h4>2.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['2.1'])){ echo Html::encode($arrsection_elements['2.1']); } ?></h4> <input
														type="radio" name="TblAcaEmpStatusTrack[ale_applicable]" value="1" 
														<?php if(isset($model_large_emp_status->ale_applicable) && $model_large_emp_status->ale_applicable == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
														
														></input><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;

														<input type="radio" name="TblAcaEmpStatusTrack[ale_applicable]"  value="2" 
														<?php if(isset($model_large_emp_status->ale_applicable) && $model_large_emp_status->ale_applicable == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
														></input><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
													</span>

												</div>

												<div class="col-sm-6">
													<span class="control-label"><h4>2.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['2.2'])){ echo Html::encode($arrsection_elements['2.2']); } ?></h4>
														<input type="radio" name="TblAcaEmpStatusTrack[ale_first_applicable]" value="1"
														<?php if(isset($model_large_emp_status->ale_first_applicable) && $model_large_emp_status->ale_first_applicable == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
														
														><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="radio" name="TblAcaEmpStatusTrack[ale_first_applicable]" value="2"
														
														<?php if(isset($model_large_emp_status->ale_first_applicable) && $model_large_emp_status->ale_first_applicable == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
														><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
													</span>
												</div>
											</div>
												<input type="hidden" name="TblAcaEmpStatusTrack['hidden']">
											<div class="form-group">
												<div class="col-sm-12">
													<span class="control-label"><h4
															style="margin-bottom: 25px;">2.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['2.3'])){ echo Html::encode($arrsection_elements['2.3']); } ?></h4>
														<h5 style="margin-bottom: 0px;">
															<input type="radio" name="TblAcaEmpStatusTrack[ale_category]" value="1" 
															<?php if(isset($model_large_emp_status->ale_applicable) && $model_large_emp_status->ale_category == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span
																class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;An ALE
																with fewer than 100 full time employees (including full
																time equivalent employees).</span>
														</h5> &nbsp;&nbsp;&nbsp;&nbsp;
														<h5 style="margin-top: 0px;">
															<input type="radio" name="TblAcaEmpStatusTrack[ale_category]" value="2" 
															<?php if(isset($model_large_emp_status->ale_applicable) && $model_large_emp_status->ale_category == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span
																class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;An ALE
																with more than 100 full time employees (including full
																time equivalent employees).</span>
														</h5> </span>

												</div>


											</div>




										
									</div>
									<div class=" box-footer pull-right padding-right-0">

										<a class="btn btn-default btn-default-cancel"
											href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
										
										<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success emp-status' ,'name' => 'button','value'=>'exit'])?>
    	
										<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success emp-status' ,'name' => 'button','value'=>'continue'])?>
    	
    	
									</div>

								</div>
								
								<?php ActiveForm::end(); ?>

							</div>
						</div>
						<div class="panel  box " id="planofferingcriteria">
							<div class="parent-tabs box-header with-border">
								<span id="step2" class="steps col-xs-2" onclick="editbasic2()">
									<span class="check " style="display: none;"> <i
										class="fa fa-check" aria-hidden="true"></i> <span class="">3</span>
								</span> <span style="display: none;" class="edit">Edit</span>
								</span>

								<h4 class="box-title col-xs-8">
									<div class="fixed-number col-md-1 col-xs-2" style="top: 3px;">
										<span class="block-number">3</span>
									</div>
									<a class="custom-bg col-md-11 col-xs-10" onclick="editbasic2()"
										style="padding-left: 0;"> Plan Offering Criteria </a>
								</h4>

								<div class="box-title col-xs-2 col-lg-3 pull-right"
									style="padding-top: 7px;">
									<p class="custom-bg summary-text pull-right"
										style="font-size: 12px;">Variable hour measuring</p>
								</div>

							</div>
							<div id="collapseThree"
								class="panel-collapse collapse bg-white black">
									<?php $form = ActiveForm::begin(['action' => ['/client/reporting/planofferingcriteria?c_id='.$company_id.'#planofferingcriteria'],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'plan_offering_form']]); ?>
								
								<div class="box-body padding-right-0">
									<p class="highlight-fancy">
										<span class="status"><i class="fa fa-info-circle"
											aria-hidden="true"></i></span> Fill the form below to measure
										variable hours and plan offering

									</p>

									<div class="col-md-offset-1 col-md-10">
										
											<div>
												<h3>Variable Hour Measuring</h3>


												<div class="form-group">
													<div class="col-sm-12">
														<span class="control-label span-label"><h4>3.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.1'])){ echo Html::encode($arrsection_elements['3.1']); } ?></h4> 
														<input name="TblAcaPlanCriteria[hours_tracking_method]"
															type="radio" value="1"
															<?php if(isset($model_plan_offering_criteria->hours_tracking_method) && $model_plan_offering_criteria->hours_tracking_method == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
															>&nbsp;&nbsp;&nbsp;&nbsp; <span
															class="control-checkbox">Look-Back Measurement Method</span>
															&nbsp;&nbsp;&nbsp;&nbsp; <input
															name="TblAcaPlanCriteria[hours_tracking_method]" type="radio" value="2"
															<?php if(isset($model_plan_offering_criteria->hours_tracking_method) && $model_plan_offering_criteria->hours_tracking_method == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
															>&nbsp;&nbsp;&nbsp;&nbsp;<span
															class="control-checkbox">Monthly Measurement Method</span>&nbsp;&nbsp;&nbsp;&nbsp;
															<input name="TblAcaPlanCriteria[hours_tracking_method]" type="radio"
															value="3"
															<?php if(isset($model_plan_offering_criteria->hours_tracking_method) && $model_plan_offering_criteria->hours_tracking_method == 3){
																			
																					?> 
																				checked
																				<?php  } ?>
															>&nbsp;&nbsp;&nbsp;&nbsp;<span
															class="control-checkbox">Not Currently Measuring Hours</span>
														</span>

													</div>
												</div>


												<div class="form-group initialmeasurement"
													style="<?php if(isset($model_plan_offering_criteria->hours_tracking_method) && $model_plan_offering_criteria->hours_tracking_method == 1){
																			
																					?> 
																				display: block;
																				<?php  }else{ ?>display: none;<?php }?>">
													<div class="col-sm-12">
														<label class="control-label"><h4>3.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.1.1'])){ echo Html::encode($arrsection_elements['3.1.1']); } ?></h4></label> 
														
															<?= $form->field ( $model_plan_offering_criteria, 'initial_measurement_period' )->textInput ( [ 'class' => 'form-control form-height numbers','maxlength'=>'5','style'=>'width:50%' ] )->label ( false )?>
													
													</div>

												</div>

												<div class="form-group initialmeasurement"
													style="<?php if(isset($model_plan_offering_criteria->hours_tracking_method) && $model_plan_offering_criteria->hours_tracking_method == 1){
																			
																					?> 
																				display: block;
																				<?php  }else{ ?>display: none;<?php }?>"
																				>
													<div class="col-sm-12">
														<label class="control-label"><h4>3.1.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.1.2'])){ echo Html::encode($arrsection_elements['3.1.2']); } ?></h4> <input
															type="radio" name="TblAcaPlanCriteria[initial_measurment_period_begin]" value="1" class="initialmeasurement-period-begin"
															<?php if(isset($model_plan_offering_criteria->initial_measurment_period_begin) && $model_plan_offering_criteria->initial_measurment_period_begin == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Date
																of Hire (DOH)</span>&nbsp;&nbsp;&nbsp;&nbsp; <input
															type="radio" name="TblAcaPlanCriteria[initial_measurment_period_begin]" value="2" class="initialmeasurement-period-begin"
															<?php if(isset($model_plan_offering_criteria->initial_measurment_period_begin) && $model_plan_offering_criteria->initial_measurment_period_begin == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
																of Month After DOH</span> </label>
													</div>
												</div>

											</div>


											<div class="col-sm-12 padding-left-0 padding-right-0">

												<h3>Plan Offering Criteria</h3>


												<div class="form-group">
													<div class="col-sm-12">
														<label class="control-label"><h4>3.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.2'])){ echo Html::encode($arrsection_elements['3.2']); } ?></h4></label>
														<?php 
														$arrplan_offering_criteria_type = array();
														$plan_offering_criteria_type = $model_plan_offering_criteria->plan_offering_criteria_type; 
														if(!empty($plan_offering_criteria_type))
														{
															$arrplan_offering_criteria_type = explode(',',rtrim($plan_offering_criteria_type,','));
														}
														
														?>
														<div class="checkbox">
															<label> <input type="checkbox" name="TblAcaPlanCriteria[plan_offering_criteria_type][1]" value="1" <?php if(in_array ( '1', $arrplan_offering_criteria_type, TRUE )){ ?> checked <?php }?>>
															<h4 class="margin-0">Qualifying Offer Method</h4>
															</label>
														</div>

														
														<div class="checkbox">
															<label> <input type="checkbox" name="TblAcaPlanCriteria[plan_offering_criteria_type][2]" value="2" <?php if(in_array ( '2', $arrplan_offering_criteria_type, TRUE )){ ?> checked <?php }?>>
															<h4 class="margin-0">98% Offer Method</h4>
															</label>
														</div>

													</div>
												</div>


												<div class="form-group">
													<div class="col-sm-12">
														<label class="control-label"><h4>3.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3'])){ echo Html::encode($arrsection_elements['3.3']); } ?></h4>
														</label>

														<div class="col-sm-12">
															<label class="control-label"><h4>(a)&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3.1'])){ echo Html::encode($arrsection_elements['3.3.1']); } ?></h4> <input
																class="company_certify company_certify_yes" type="radio"
																name="TblAcaPlanCriteria[company_certification_workforce]" value="1" 
																<?php if(isset($model_plan_offering_criteria->company_certification_workforce) && $model_plan_offering_criteria->company_certification_workforce == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
																>&nbsp;&nbsp;&nbsp;&nbsp; <span
																class="control-checkbox">Yes</span>
																&nbsp;&nbsp;&nbsp;&nbsp; <input  type="radio"
																class="company_certify company_certify_no" name="TblAcaPlanCriteria[company_certification_workforce]" value="2" 
																<?php if(isset($model_plan_offering_criteria->company_certification_workforce) && $model_plan_offering_criteria->company_certification_workforce == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
																>&nbsp;&nbsp;&nbsp;&nbsp;<span
																class="control-checkbox">No</span>&nbsp;&nbsp;&nbsp;&nbsp;
															</label>
														</div>
														<div class="col-sm-12">
															<label class="control-label"><h4>(b) &nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3.2'])){ echo Html::encode($arrsection_elements['3.3.2']); } ?></h4> <input
																 type="radio"
																class="company_certify company_certify_yes" name="TblAcaPlanCriteria[company_certification_medical_eligibility]" value="1"  
																<?php if(isset($model_plan_offering_criteria->company_certification_medical_eligibility) && $model_plan_offering_criteria->company_certification_medical_eligibility == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
																				>&nbsp;&nbsp;&nbsp;&nbsp;
																<span class="control-checkbox">Yes</span>
																&nbsp;&nbsp;&nbsp;&nbsp; <input  type="radio"
																class="company_certify company_certify_no" name="TblAcaPlanCriteria[company_certification_medical_eligibility]" value="2" 
																<?php if(isset($model_plan_offering_criteria->company_certification_medical_eligibility) && $model_plan_offering_criteria->company_certification_medical_eligibility == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
																>&nbsp;&nbsp;&nbsp;&nbsp;<span
																class="control-checkbox">No</span>&nbsp;&nbsp;&nbsp;&nbsp;
															</label>
														</div>
														<div class="col-sm-12">
															<label class="control-label"><h4>(c) &nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3.3'])){ echo Html::encode($arrsection_elements['3.3.3']); } ?></h4> <input type="radio"
																class="company_certify company_certify_yes" name="TblAcaPlanCriteria[company_certification_employer_contribution]" value="1" 
																<?php if(isset($model_plan_offering_criteria->company_certification_employer_contribution) && $model_plan_offering_criteria->company_certification_employer_contribution == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
																>&nbsp;&nbsp;&nbsp;&nbsp;
																<span class="control-checkbox">Yes</span>
																&nbsp;&nbsp;&nbsp;&nbsp; <input  type="radio"
																class="company_certify company_certify_no" name="TblAcaPlanCriteria[company_certification_employer_contribution]" value="2" 
																<?php if(isset($model_plan_offering_criteria->company_certification_employer_contribution) && $model_plan_offering_criteria->company_certification_employer_contribution == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
																>&nbsp;&nbsp;&nbsp;&nbsp;<span
																class="control-checkbox">No</span>&nbsp;&nbsp;&nbsp;&nbsp;
															</label>
														</div>
													</div>
												</div>




											</div>


									
									</div>

									<div class="box-footer pull-right padding-right-0">

										<a class="btn btn-default btn-default-cancel"
											href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
										<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success plan-offering' ,'name' => 'button','value'=>'exit'])?>
    	
										<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success plan-offering' ,'name' => 'button','value'=>'continue'])?>
    	
										
										</div>
								</div>
<?php ActiveForm::end(); ?>
							</div>
						</div>

						<div class="panel  box " id="designatedgovtentity">
							<div class="parent-tabs box-header with-border">
								<span id="step3" class="steps col-xs-2" onclick="editbasic3()">
									<span class="check " style="display: none;"> <i
										class="fa fa-check" aria-hidden="true"></i> <span class="">4</span>
								</span> <span style="display: none;" class="edit">Edit</span>
								</span>

								<h4 class="box-title col-xs-8">
									<div class="fixed-number col-md-1 col-xs-2" style="top: 3px">
										<span class="block-number">4</span>
									</div>
									<a class="custom-bg col-md-11 col-xs-10" onclick="editbasic3()"
										style="padding-left: 0;"> Designated Government Entity </a>
								</h4>

								<div class="box-title col-xs-2 col-lg-3 pull-right"
									style="padding-top: 7px;">
									<p class="custom-bg summary-text pull-right"
										style="font-size: 12px;">Assigning DGE for reporting purposes
									</p>
								</div>

							</div>
							<div id="collapseFour"
								class="panel-collapse collapse bg-white black">
									<?php $form = ActiveForm::begin(['action' => ['/client/reporting/designatedgovtentity?c_id='.$company_id.'#designatedgovtentity'],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'designated_entity_form']]); ?>
								
								<div class="box-body padding-right-0">
									<p class="highlight-fancy">
										<span class="status"><i class="fa fa-info-circle"
											aria-hidden="true"></i></span> Fill the form for your DGE

									</p>
									<div class="col-md-offset-1 col-md-10">
										
											<div class="form-group">
												<div class="col-sm-12">
													<label class="control-label"><h4>4.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1'])){ echo Html::encode($arrsection_elements['4.1']); } ?></h4> <input type="radio"
														name="TblAcaDesignatedGovtEntity[assign_dge]" value="1"
														<?php if(isset($model_designated_govt_entity->assign_dge) && $model_designated_govt_entity->assign_dge == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
														><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="radio" name="TblAcaDesignatedGovtEntity[assign_dge]" value="2"
														<?php if(isset($model_designated_govt_entity->assign_dge) && $model_designated_govt_entity->assign_dge == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
														><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
													</label>
												</div>
											</div>

											<div class="designation" style="<?php if(isset($model_designated_govt_entity->assign_dge) && $model_designated_govt_entity->assign_dge == 1){?> display: block;<?php }else{?>display: none;<?php }?>">

												<div class="form-group">
													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.1'])){ echo Html::encode($arrsection_elements['4.1.1']); } ?></h4></label>
														
														<?=$form->field ( $model_designated_govt_entity, 'dge_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear','maxlength'=>'75','onkeypress'=>'return companyname(event);' ] )->label ( false )?>
													</div>

													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.2'])){ echo Html::encode($arrsection_elements['4.1.2']); } ?></h4></label> 
														
														<?php echo $form->field($model_designated_govt_entity,'dge_ein')->label(false)->textInput(['class' => 'form-control form-height dge-clear','data-inputmask'=>'"mask": "99-9999999"','data-mask'=>'']); ?>
													</div>
												</div>

												<div class="form-group">
													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.3'])){ echo Html::encode($arrsection_elements['4.1.3']); } ?></h4></label> 
														
														<?=$form->field ( $model_designated_govt_entity, 'street_address_1' )->textInput ( [ 'class' => 'form-control form-height dge-clear','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													</div>

													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.4'])){ echo Html::encode($arrsection_elements['4.1.4']); } ?></h4></label>
														
														<?=$form->field ( $model_designated_govt_entity, 'street_address_2' )->textInput ( [ 'class' => 'form-control form-height dge-clear','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													</div>

												</div>

												<div class="form-group">
												
												<div class="col-sm-6">
														<label class="control-label"><h4>4.1.5&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.5'])){ echo Html::encode($arrsection_elements['4.1.5']); } ?></h4></label> 
														
														<?php 
                  
															                   echo $form->field($model_designated_govt_entity, 'dge_state')->dropdownList(
															                  		$usStates,
															                  		['prompt'=>'Select State','class'=>'form-control form-height dge-clear','onchange'=>'return statedgeChange(this.value)']
															                  )->label(false);
															                  ?>
													</div>
													
													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.6&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.6'])){ echo Html::encode($arrsection_elements['4.1.6']); } ?></h4></label> 
														
														<?php 
                  
															                   echo $form->field($model_designated_govt_entity, 'dge_city')->dropdownList(
															                  		$uscityStates,
															                  		['prompt'=>'Select City','class'=>'form-control form-height']
															                  )->label(false);
															                  ?>
																			  
													</div>
													

												</div>

												<div class="form-group">

													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.7&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.7'])){ echo Html::encode($arrsection_elements['4.1.7']); } ?></h4></label> 
														
														<?=$form->field($model_designated_govt_entity,'dge_zip' )->textInput([ 'class' => 'form-control numbers form-height dge-clear','maxlength'=>'5' ] )->label ( false )?>
													</div>
												</div>

												<div class="form-group">

													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.8&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.8'])){ echo Html::encode($arrsection_elements['4.1.8']); } ?></h4></label> 
														
														<?=$form->field ( $model_designated_govt_entity, 'dge_contact_first_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear','maxlength'=>'20','onkeypress'=>'return alpha(event);' ] )->label ( false )?>
													</div>

													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.9&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.9'])){ echo Html::encode($arrsection_elements['4.1.9']); } ?></h4></label> 
														<?=$form->field ( $model_designated_govt_entity, 'dge_contact_middle_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear','maxlength'=>'20','onkeypress'=>'return alpha(event);' ] )->label ( false )?>
													</div>

												</div>

												<div class="form-group">

													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.10&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.10'])){ echo Html::encode($arrsection_elements['4.1.10']); } ?></h4></label> 
														
														<?=$form->field ( $model_designated_govt_entity, 'dge_contact_last_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear','maxlength'=>'20','onkeypress'=>'return alpha(event);' ] )->label ( false )?> 
													</div>

													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.11&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.11'])){ echo Html::encode($arrsection_elements['4.1.11']); } ?></h4></label>
														
														<?php 
                  
															                   echo $form->field($model_designated_govt_entity, 'dge_contact_suffix')->dropdownList(
															                  		$suffix,
															                  		['prompt'=>'Select Suffix','class'=>'form-control form-height dge-clear']
															                  )->label(false);
															                  ?>
													</div>

												</div>
												<div class="form-group">
													<div class="col-sm-6">
														<label class="control-label"><h4>4.1.12&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.12'])){ echo Html::encode($arrsection_elements['4.1.12']); } ?></h4></label> 
														
														<?php echo $form->field($model_designated_govt_entity,'dge_contact_phone_number')->label(false)->textInput(['class' => 'form-control form-height dge-clear','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-12 plan-div-margin"
														>
														<label class="control-label"><h4>4.1.13&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.13'])){ echo Html::encode($arrsection_elements['4.1.13']); } ?></h4> <input type="radio"
															class="dge-clear-radio" name="TblAcaDesignatedGovtEntity[dge_reporting]" value="1" 
															<?php if(isset($model_designated_govt_entity->dge_reporting) && $model_designated_govt_entity->dge_reporting == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Enrollment
																Only</span>&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
															class="dge-clear-radio" name="TblAcaDesignatedGovtEntity[dge_reporting]"  value="2"
															<?php if(isset($model_designated_govt_entity->dge_reporting) && $model_designated_govt_entity->dge_reporting == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Enrollment
																and Offer of Coverage</span> </label>
													</div>
												</div>


											</div>


									
									</div>
									<div class="box-footer pull-right padding-right-0">

										<a class="btn btn-default btn-default-cancel"
											href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
										<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success designated-entity' ,'name' => 'button','value'=>'exit'])?>
    	
										<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success designated-entity' ,'name' => 'button','value'=>'continue'])?>
    	
									
										</div>

								</div>
								<?php ActiveForm::end(); ?>
							</div>
						</div>

						<div class="panel  box " id="aggregatedgroup">
							<div class="parent-tabs box-header with-border">
								<span id="step4" class="steps col-xs-2" onclick="editbasic4()">
									<span class="check " style="display: none;"> <i
										class="fa fa-check" aria-hidden="true"></i> <span class="">5</span>
								</span> <span style="display: none;" class="edit">Edit</span>
								</span>

								<h4 class="box-title col-xs-8">
									<div class="fixed-number col-md-1 col-xs-2" style="top: 3px">
										<span class="block-number">5</span>
									</div>
									<a class="custom-bg col-md-11 col-xs-10" onclick="editbasic4()"
										style="padding-left: 0;"> Aggregated Group </a>
								</h4>

								<div class="box-title col-xs-2 col-lg-3 pull-right"
									style="padding-top: 7px;">
									<p class="custom-bg summary-text pull-right"
										style="font-size: 12px;">Submit group name and EIN</p>
								</div>
							</div>
							<div id="collapseFive"
								class="panel-collapse collapse bg-white black">
								<?php $form = ActiveForm::begin(['action' => ['/client/reporting/saveaggregatedgroup?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'client_aggregated_group']]); ?>
								<div class="box-body padding-right-0">
									<p class="highlight-fancy">
										<span class="status"><i class="fa fa-info-circle"
											aria-hidden="true"></i></span> Enter the Aggregated Group
										information.
									</p>
									<div class="col-md-offset-1 col-md-10">
										<div class="form-group row"
											style="margin-top: 10px; margin-bottom: 20px;">
											<div class="col-sm-12">
												<label class="control-label"><h4>5.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.1'])){ echo Html::encode($arrsection_elements['5.1']); } ?></h4> </label>
											</div>
											<div class="col-sm-6">
												<input type="radio" name="TblAcaAggregatedGroup[is_authoritative_transmittal]" value="1"
												<?php if(isset($model_aggregated_group->is_authoritative_transmittal) && $model_aggregated_group->is_authoritative_transmittal == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
												
												 ><span
													class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" name="TblAcaAggregatedGroup[is_authoritative_transmittal]" value="2" 
												<?php if(isset($model_aggregated_group->is_authoritative_transmittal) && $model_aggregated_group->is_authoritative_transmittal == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
												><span
													class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>

											</div>
										</div>

											<div class="form-group row is-authoritative-transmittal-no"
													style="margin-top: 10px; margin-bottom: 20px; <?php if(isset($model_aggregated_group->is_authoritative_transmittal) && $model_aggregated_group->is_authoritative_transmittal == 2){
																			
																					?> display: block;<?php }else {?> display: none;<?php }?>">
													<div class="col-sm-12">
														<label class="control-label"><h4>5.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.1.1'])){ echo Html::encode($arrsection_elements['5.1.1']); } ?></h4> </label>
													</div>
												</div>

										<div class="form-group row"
											style="margin-top: 10px; margin-bottom: 20px;">
											<div class="col-sm-12">
												<label class="control-label"><h4>5.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2'])){ echo Html::encode($arrsection_elements['5.2']); } ?></h4> </label>
											</div>
											<div class="col-sm-6">
												<input type="radio" name="TblAcaAggregatedGroup[is_ale_member]" value="1"
												<?php if(isset($model_aggregated_group->is_ale_member) && $model_aggregated_group->is_ale_member == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
												
												><span
													class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" name="TblAcaAggregatedGroup[is_ale_member]" value="2" 
												 <?php if(isset($model_aggregated_group->is_ale_member) && $model_aggregated_group->is_ale_member == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
												 ><span
													class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>

											</div>
										</div>




										<div class="col-xs-12 filling_forms" style="<?php if(isset($model_aggregated_group->is_ale_member) && $model_aggregated_group->is_ale_member == 1){
																			
																					?> display: block;<?php } else {?> display: none;<?php }?>">
											<div class="col-xs-12" style="border: 1px solid #ddd;">
												<div class="form-group row"
													style="margin-top: 10px; margin-bottom: 20px;">
													<div class="col-sm-12">
														<label class="control-label"><h4>5.2.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.1'])){ echo Html::encode($arrsection_elements['5.2.1']); } ?></h4>
														</label>
													</div>
													<div class="col-sm-6">
														<input type="radio" name="TblAcaAggregatedGroup[is_other_entity]" class="aggregate-clear-radio" value="1" 
														<?php if(isset($model_aggregated_group->is_other_entity) && $model_aggregated_group->is_other_entity == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
														><span
															class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="radio" name="TblAcaAggregatedGroup[is_other_entity]" value="2" class="aggregate-clear-radio"
														
														<?php if(isset($model_aggregated_group->is_other_entity) && $model_aggregated_group->is_other_entity == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>

													</div>
												</div>

												<div class="form-group row other_entity_filling_yes"
													style="margin-top: 10px; margin-bottom: 20px; <?php if(isset($model_aggregated_group->is_other_entity) && $model_aggregated_group->is_other_entity == 1){
																			
																					?> display: block;<?php }else {?> display: none;<?php }?>">
													<div class="col-sm-12">
														<label class="control-label"><h4>5.2.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.1.1'])){ echo Html::encode($arrsection_elements['5.2.1.1']); } ?></h4> </label>
													</div>
													<div class="col-sm-6 padding_left_30">
													 <?=$form->field ( $model_aggregated_group, 'total_1095_forms' )->textInput ( [ 'class' => 'form-control form-height aggregate-clear','maxlength'=>'5','onkeypress'=>'return isNumberKey(event);'  ] )->label ( false )?>
													 
													

													</div>
												</div>


												<div class="form-group row"
													style="margin-top: 10px; margin-bottom: 20px;">
													<div class="col-sm-12">
														<label class="control-label"><h4>5.2.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.2'])){ echo Html::encode($arrsection_elements['5.2.2']); } ?></h4> </label>
													</div>
													<div class="col-sm-12"></div>
													<div class="col-sm-3">
													<?php 
													if(!empty($model_aggregated_group->total_aggregated_grp_months))
													{
														$arrmodel_aggregated_group = explode(',', $model_aggregated_group->total_aggregated_grp_months);
													}
													?>
														<div class="checkbox">
															<label><input type="checkbox" onclick="disableyear();"
																id="entire_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][0]" value="0" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '0', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span class="control-checkbox">Entire
																	Year</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][1]" value="1" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '1', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">January</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][2]" value="2" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '2', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">February</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][3]" value="3" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '3', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">March</span></label>
														</div>

														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][4]" value="4" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '4', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">April</span></label>
														</div>

														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][5]" value="5" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '5', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">May</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][6]" value="6" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '6', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">June</span></label>
														</div>
													</div>

													<div class="col-sm-3">
														<div class="checkbox">
															<label></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][7]" value="7" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '7', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">July</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][8]" value="8" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '8', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">August</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][9]" value="9" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '9', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">September</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][10]" value="10" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '10', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">October</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][11]" value="11" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '11', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">November</span></label>
														</div>
														<div class="checkbox">
															<label><input type="checkbox" class="specific_year" name="TblAcaAggregatedGroup[total_aggregated_grp_months][12]" value="12" <?php if(!empty($arrmodel_aggregated_group) && in_array ( '12', $arrmodel_aggregated_group, TRUE )){ ?> checked <?php }?>><span
																class="control-checkbox">December</span></label>
														</div>

													</div>
												</div>

												<div class="form-group row"
													style="margin-top: 10px; margin-bottom: 20px;">
													<div class="col-sm-12">
														<label class="control-label"><h4>5.2.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.3'])){ echo Html::encode($arrsection_elements['5.2.3']); } ?></h4> </label>
													</div>
													<div class="col-md-12" id="group_div">
													
													
														
														
													<?php
													$i = 1;
													 if(!empty($aggregated_list)){
														
														foreach($aggregated_list as $list){
														?>
														<div class="row" id="row_<?php echo $i; ?>"
															style="margin-bottom: 10px;">
															<div class="col-sm-3 padding-right-0 padding_left_30">
																<p>Group Name</p>
																 <?php //$form->field ( $model_aggregated_group_list, 'group_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'34','onkeypress'=>'return alpha(event);'  ] )->label ( false )?>
															 	<input type="text" class="form-control aggregate-clear" name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_name]" maxlength="34"
																	value="<?php if(!empty($list['group_name'])){ echo $list['group_name']; }?>" onkeypress="return companyname(event);" >

															</div>
															<div class="col-sm-3 padding-right-0 padding_left_30">
																<p>Group EIN</p>
																<?php //echo $form->field($model_aggregated_group_list,'group_ein')->label(false)->textInput(['data-inputmask'=>'"mask": "99-9999999"','data-mask'=>'','class'=>'form-control form-height width-92','id'=>'phone']); ?>
																  <input type="text" class="form-control aggregate-clear" name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_ein]"
																	value="<?php if(!empty($list['group_ein'])){ echo $list['group_ein']; }?>" 
																	data-inputmask='"mask": "99-9999999"' data-mask>

															</div>
															
															
															<div class="col-sm-2 padding-left-5">
																<p>&nbsp;&nbsp;</p>
																<button class="btn btn-danger" type="button"
																	onclick="removerow(<?php echo $i; ?>);" id="remove_more_btn_<?php echo $i; ?>">Remove</button>
															</div>
														</div>
														
														<?php $i++; } } ?>
														
														<div class="row" id="row_<?php echo $i; ?>"
															style="margin-bottom: 10px;">
															<div class="col-sm-3 padding-right-0 padding_left_30">
																<p>Group Name</p>
																 <?php //$form->field ( $model_aggregated_group_list, 'group_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'34','onkeypress'=>'return alpha(event);'  ] )->label ( false )?>
															 	<input type="text" class="form-control aggregate-clear" name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_name]" maxlength="34"
																	 onkeypress="return companyname(event);" >

															</div>
															<div class="col-sm-3 padding-right-0 padding_left_30">
																<p>Group EIN</p>
																<?php //echo $form->field($model_aggregated_group_list,'group_ein')->label(false)->textInput(['data-inputmask'=>'"mask": "99-9999999"','data-mask'=>'','class'=>'form-control form-height width-92','id'=>'phone']); ?>
																  <input type="text" class="form-control aggregate-clear" name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_ein]"
																	
																	data-inputmask='"mask": "99-9999999"' data-mask>

															</div>
															<div class="col-sm-2 padding-left-5">
																<p>&nbsp;&nbsp;</p>
																<button class="btn btn-primary no-wrap" type="button"
																	onclick="addnewrow(<?php echo $i; ?>);" id="add_more_btn">Add more</button>
															</div>
														</div>
														
														
														
													</div>
												</div>

											</div>
										</div>

									</div>
									<div class="box-footer pull-right padding-right-0">
										<a class="btn btn-default btn-default-cancel"
											href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
										
										<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success client-aggregated' ,'name' => 'button','value'=>'exit'])?>
											<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success client-aggregated' ,'name' => 'button','value'=>'continue'])?>
											
									</div>
								</div>
								<?php ActiveForm::end(); ?>
							</div>
						</div>

						<div class="panel  box " id="anythingelse">
							<div class="parent-tabs box-header with-border">
								<span id="step5" onclick="editbasic5();" class="steps col-xs-2"> <span
									class="check " style="display: none;"> <i class="fa fa-check"
										aria-hidden="true"></i> <span class="">6</span>
								</span> <span style="display: none;" class="edit">Edit</span></span>

								<h4 class="box-title col-xs-8">
									<div class="fixed-number col-md-1 col-xs-2" style="top: 3px">
										<span class="block-number">6</span>
									</div>
									<a class="custom-bg col-md-11 col-xs-10" onclick="editbasic5()"
										style="padding-left: 0;"> Anything Else to Tell Us </a>
								</h4>

								<div class="box-title col-xs-2 col-lg-3 pull-right"
									style="padding-top: 7px;">
									<p class="custom-bg summary-text pull-right"
										style="font-size: 12px;">Fill additional information</p>
								</div>

							</div>
							<div id="collapseSix"
								class="panel-collapse collapse bg-white black">
								<?php $form = ActiveForm::begin(['action' => ['/client/reporting/anythingelse?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'client_anything_alse']]); ?>
								<div class="box-body padding-right-0">

									<p class="highlight-fancy">
										<span class="status"><i class="fa fa-info-circle"
											aria-hidden="true"></i></span> Enter additional comments if
										any
									</p>
									<div class="col-md-offset-1 col-md-10">


										<div class="form-group row"
											style="margin-top: 10px; margin-bottom: 20px;">
											<div class="col-sm-12">
												<label class="control-label"><h4>6.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['6.1'])){ echo Html::encode($arrsection_elements['6.1']); } ?></h4> </label>
											</div>
											<?php 
											$model_basic_additional_details_array = array();
													if(!empty($model_basic_additional_details->hear_about_us))
													{
														$model_basic_additional_details_array = explode(',', $model_basic_additional_details->hear_about_us);
													}
													?>
													
											<div class="col-sm-12">
												<div class="checkbox">
													<label> <input type="checkbox" class="specific_heard" name="TblAcaBasicAdditionalDetail[hear_about_us][0]" value="0" <?php if(!empty($model_basic_additional_details_array) && in_array ( '0', $model_basic_additional_details_array, TRUE )){ ?>checked <?php }?>><span
														class="control-checkbox">Referred by a friend</span></label>
												</div>
												<div class="checkbox">
													<label> <input type="checkbox" class="specific_heard" name="TblAcaBasicAdditionalDetail[hear_about_us][1]" value="1" <?php if(!empty($model_basic_additional_details_array) && in_array ( '1',$model_basic_additional_details_array, TRUE )){ ?>checked <?php }?>><span
														class="control-checkbox">Internet Search</span></label>
												</div>
												<div class="checkbox">
													<label> <input type="checkbox" class="specific_heard" name="TblAcaBasicAdditionalDetail[hear_about_us][2]" value="2" <?php if(!empty($model_basic_additional_details_array) && in_array ( '2',$model_basic_additional_details_array, TRUE )){ ?>checked <?php }?>><span
														class="control-checkbox">Attended our conference</span></label>
												</div>
												<div class="checkbox">
													<label> <input type="checkbox" class="specific_heard"  id="selected_others" name="TblAcaBasicAdditionalDetail[hear_about_us][3]" value="3" <?php if(!empty($model_basic_additional_details_array) && in_array ( '3', $model_basic_additional_details_array, TRUE )){ ?>checked <?php }?>><span
														class="control-checkbox">Others</span></label>
												</div>

											</div>
                             
											<div class="col-sm-6 padding_left_30 others_comments" style=" <?php if(in_array ( '3', $model_basic_additional_details_array, TRUE )){
																			
																					?>display:block; <?php } else{ ?>display:none;<?php }?>">
												
												<?php echo $form->field($model_basic_additional_details, 'others')->label(false)->textarea(array('rows'=>4,'cols'=>6,'class'=>'form-control form-height','maxlength'=>'49','onkeypress'=>'return lookupoption(event);' )); ?>
												<!--<textarea class="form-control form-height"></textarea>-->
											</div>
											

										</div>



										<div class="form-group row"
											style="margin-top: 10px; margin-bottom: 20px;">
											<div class="col-sm-12">
												<label class="control-label"><h4>6.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['6.2'])){ echo Html::encode($arrsection_elements['6.2']); } ?></h4> </label>
											</div>
											<div class="col-sm-6 ">
											
											<input type="radio" name="TblAcaBasicAdditionalDetail[anything_else]" value="1"
												<?php if(isset($model_basic_additional_details->anything_else) && $model_basic_additional_details->anything_else == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
												
												><span
													class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" name="TblAcaBasicAdditionalDetail[anything_else]" value="2" 
												 <?php if(isset($model_basic_additional_details->anything_else) && $model_basic_additional_details->anything_else == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
												 ><span
													class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
													
												<?php //echo $form->field($model_basic_additional_details, 'anything_else')->label(false)->textarea(array('rows'=>4,'cols'=>6,'class'=>'form-control form-height','maxlength'=>'49','onkeypress'=>'return lookupoption(event);' )); ?>

											</div>
												<div class="text-anything-else <?php if(!empty($model_basic_additional_details->anything_else) && $model_basic_additional_details->anything_else == 1){
																			
										?> <?php }else{ ?>hide <?php }?>">
									<div class="col-sm-12">
									  <label class="control-label"><h4>Please contact the help desk for more information</h4></label>
										
									  </div>
									</div>

										</div>
										
										
				
									</div>
									<div class="box-footer pull-right padding-right-0">
										<a class="btn btn-default btn-default-cancel"
											href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
										
										
											<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success client-anything' ,'name' => 'button','value'=>'exit'])?>
											<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success client-anything' ,'name' => 'button','value'=>'continue'])?>
										<!--                 <button type="submit"  class="btn btn-success ">Save & Continue</button> -->
									</div>
								</div>
								
								<?php ActiveForm::end(); ?>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
	<!-- /.row -->
	<!-- END ACCORDION-->







</div>

</div>


<script>
$(window).load(function() {
	 
	 var contactstatehtml = '<input type="text" id="tblacabasicinformation-contact_state" class="form-control form-height" name="TblAcaBasicInformation[contact_state]" value="" maxlength="25" onkeypress="return alpha(event);">';
	var contactcity = '<input type="text" id="tblacabasicinformation-contact_city" class="form-control form-height" name="TblAcaBasicInformation[contact_city]" value="" maxlength="50" onkeypress="return alpha(event);">';
		

	checkarraydiv();
	
	<?php if(!empty($arrmodel_aggregated_group) && in_array ( '0', $arrmodel_aggregated_group, TRUE )){ ?>
	
		$(".specific_year").attr("disabled", true);

	<?php }?>
	
	<?php  $selected_Country = 'US';
$contact_state = '';
$contact_city = '';	
			if(!empty($model_basic_info->contact_country))
				{
					$selected_Country = $model_basic_info->contact_country;
				}
				else
				{
					$selected_Country = 'US';
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


function checkarraydiv()
{

 <?php 

 $plan_div = array();
	  if(!empty($model_basic_info->basic_info_id))
	  {
	  	$plan_div[] = "1";
		
		
	  }
	  
	  if(!empty($model_large_emp_status->emp_tracking_id))
	  {
	  	$plan_div[] = "2";
	  }
	  
	  if(!empty($model_plan_offering_criteria->plan_criteria_id))
	  {
	  	$plan_div[] = "3";
	  }
	  
	  if(!empty($model_designated_govt_entity->dge_id))
	  {
	  	$plan_div[] = "4";
	  }
	  
	  if(!empty($model_aggregated_group->aggregated_grp_id))
	  {
	  	$plan_div[] = "5";
	  }
	  
	  if(!empty($model_basic_additional_details->anything_else_id))
	  {
	  	$plan_div[] = "6";
	  }
	  ?>
	var plan_div = <?php echo json_encode($plan_div); ?>;

	var plan_div_array = Object.keys(plan_div).map(function(k) { return plan_div[k] });

	
    for($i=0;$i<=plan_div_array.length-1;$i++)
    {

     var n =  plan_div_array[$i] ; 
    
    switch(n) {
        case '1':
        	if (!$( "#collapseOne" ).hasClass ('in'))
        	{
	        	$( "#collapseOne" ).prev().find('.steps').css( "display", "block" );
	        	$( "#collapseOne" ).prev().find('.check').css( "display", "block" );
	        	$("#collapseOne" ).prev().find('.fixed-number').css( "display", "none");
        	}
        	 break;
        case '2':
        	if (!$( "#collapseTwo" ).hasClass ('in'))
        	{
        	$( "#collapseTwo" ).prev().find('.steps').css( "display", "block" );
        	$( "#collapseTwo" ).prev().find('.check').css( "display", "block" );
        	$("#collapseTwo" ).prev().find('.fixed-number').css( "display", "none");
        	}
            break;
        case '3':
        	if (!$( "#collapseThree" ).hasClass ('in'))
        	{
        	$( "#collapseThree").prev().find('.steps').css( "display", "block" );
        	$( "#collapseThree").prev().find('.check').css( "display", "block" );
        	$("#collapseThree").prev().find('.fixed-number').css( "display", "none");
        	}
            break;
        case '4':
        	if (!$( "#collapseFour" ).hasClass ('in'))
        	{
        	$( "#collapseFour").prev().find('.steps').css( "display", "block" );
        	$( "#collapseFour").prev().find('.check').css( "display", "block" );
        	$("#collapseFour").prev().find('.fixed-number').css( "display", "none");
        	}
            break;

        case '5':
        	if (!$( "#collapseFive" ).hasClass ('in'))
        	{
        	$( "#collapseFive").prev().find('.steps').css( "display", "block" );
        	$( "#collapseFive").prev().find('.check').css( "display", "block" );
        	$("#collapseFive").prev().find('.fixed-number').css( "display", "none");
        	}
            break;

        case '6':
        	if (!$( "#collapseSix" ).hasClass ('in'))
        	{
        	$( "#collapseSix").prev().find('.steps').css( "display", "block" );
        	$( "#collapseSix").prev().find('.check').css( "display", "block" );
        	$("#collapseSix").prev().find('.fixed-number').css( "display", "none");
        	}
            break;
        
    }

    }

	
		    
}

</script>
				

																		
