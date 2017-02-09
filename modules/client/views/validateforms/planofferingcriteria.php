<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;

$get_id = Yii::$app->request->get ();
$company_id = $get_id ['c_id'];

?>
<script
	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/reporting.js"></script>
<link rel="stylesheet"
	href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/reporting.css">
<div class="box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title col-xs-6">Validate &amp; Create Forms - <?php if(!empty($company_detals['company_name'])){echo htmlentities($company_detals['company_name']); }?> <small><?php if(!empty($company_detals['company_client_number'])){echo '('.htmlentities($company_detals['company_client_number']).')'; }?></small></h3>
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
	
	<!--<div class="col-md-12 ">			
			<nav class="navbar " role="navigation" style="margin-bottom: 0px; float: left; width: 100%;">
				<div id="sticky-anchor"></div>
				<div class="col-md-12 padding-left-0 padding-right-0" id="sticky" >
					<div class="" id="heading-navbar-collapse">
						<div class="navbar-left document-context-menu" style="width:100%;"> 
							<div class="btn-category">
								<div class="" style="">
								
									<div class="btn-group">
									  <button class="btn btn-default" <?php //if(!empty($company_validation)){?> 
										disabled
									  <?php //} ?>
									  onclick="return startValidation('<?php //echo $encoded_company_id; ?>');"><i
													class="fa fa-edit fa-lg btn_icons pd-r-5"></i>Validate Complete Data</button>									 
									</div>
				
									<div class="btn-group">
									  <button disabled
									  href="<?php //echo Yii::$app->homeUrl;?>client/validateforms/validated?c_id=<?php //echo $encoded_company_id; ?>" class="btn btn-default"><i
													class="fa fa-file fa-lg btn_icons pd-r-5"></i>Generate 1095 Forms</button>									 
									</div>						
								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>			
		</div> -->

	<div class="col-md-12 ">



		<div class="row">
			<div class="">
				<div class="box box-solid">

					<!-- /.box-header -->
					<div class="box-body">

						<div class="box-group" id="accordion">
							<div class="" id="meccoverage">





								<div class="box-body">


									<div class="">
									<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/planofferingcriteria?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'plan_offering_form']]); ?>
					
										 <div class="col-md-6 box-footer">
											<font size="4"><b>Validate Report ( Plan Offering Criteria )</b></font>
										</div>
										<div class=" col-md-6 box-footer pull-right padding-right-0"
											style="text-align: right;">


											<button type="submit"
												class="btn btn-primary mec-coverage-btn" name="button"
												value="continue">Update</button>
											<a class="btn btn-default btn-default-cancel"
												href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms?c_id=<?php echo $company_id;?>">Cancel</a>

										</div>
										<div class="col-md-12 " style="border: 1px solid #ada7a7;">

											<div class="">

												<div class="">
										
											<?php if(in_array ( 27, $arrvalidations, TRUE ) || in_array ( 28, $arrvalidations, TRUE ) || in_array ( 29, $arrvalidations, TRUE )){?>
											<div>
														<h3>Variable Hour Measuring</h3>


														<div class="form-group">
															<div class="col-sm-12">
																<span class="control-label span-label"><h4>3.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.1'])){ echo Html::encode($arrsection_elements['3.1']); } ?></h4>
																	<input name="TblAcaPlanCriteria[hours_tracking_method]"
																	type="radio" value="1"
																	<?php
												
if (isset ( $model_plan_offering_criteria->hours_tracking_method ) && $model_plan_offering_criteria->hours_tracking_method == 1) {
													
													?>
																	checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp; <span
																	class="control-checkbox">Look-Back Measurement Method</span>
																	&nbsp;&nbsp;&nbsp;&nbsp; <input
																	name="TblAcaPlanCriteria[hours_tracking_method]"
																	type="radio" value="2"
																	<?php
												
if (isset ( $model_plan_offering_criteria->hours_tracking_method ) && $model_plan_offering_criteria->hours_tracking_method == 2) {
													
													?>
																	checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<span
																	class="control-checkbox">Monthly Measurement Method</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	<input name="TblAcaPlanCriteria[hours_tracking_method]"
																	type="radio" value="3"
																	<?php
												
if (isset ( $model_plan_offering_criteria->hours_tracking_method ) && $model_plan_offering_criteria->hours_tracking_method == 3) {
													
													?>
																	checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<span
																	class="control-checkbox">Not Currently Measuring Hours</span>
																</span>
<?php if(!empty($arrvalidation_errors[27]['error_code'])){?>
																<span
																	class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[27]['error_code'].' : '; ?><?php echo $arrvalidation_errors[27]['error_message']; ?></span>
																	<?php }?>
													</div>
														</div>



														<div class="form-group initialmeasurement"
													style="<?php
												
if (isset ( $model_plan_offering_criteria->hours_tracking_method ) && $model_plan_offering_criteria->hours_tracking_method == 1) {
													
													?> 
																				display: block;
																				<?php  }else{ ?>display: none;<?php }?>">
															<div class="col-sm-12">
																<label class="control-label"><h4>3.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.1.1'])){ echo Html::encode($arrsection_elements['3.1.1']); } ?></h4></label> 
														
															<?= $form->field ( $model_plan_offering_criteria, 'initial_measurement_period' )->textInput ( [ 'class' => 'form-control form-height numbers col-md-12','maxlength'=>'5','style'=>'width:50%' ] )->label ( false )?>
													
													</div>
													
													<?php if(!empty($arrvalidation_errors[28]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[28]['error_code'].' : '; ?><?php echo $arrvalidation_errors[28]['error_message']; ?></span>
																	<?php }?>

												</div>



														<div class="form-group initialmeasurement"
													style="<?php
												
if (isset ( $model_plan_offering_criteria->hours_tracking_method ) && $model_plan_offering_criteria->hours_tracking_method == 1) {
													
													?> 
																				display: block;
																				<?php  }else{ ?>display: none;<?php }?>"
																				>
															<div class="col-sm-12">
																<label class="control-label"><h4>3.1.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.1.2'])){ echo Html::encode($arrsection_elements['3.1.2']); } ?></h4>
																	<input type="radio"
																	name="TblAcaPlanCriteria[initial_measurment_period_begin]"
																	value="1" class="initialmeasurement-period-begin"
																	<?php
												
if (isset ( $model_plan_offering_criteria->initial_measurment_period_begin ) && $model_plan_offering_criteria->initial_measurment_period_begin == 1) {
													
													?>
																	checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Date
																		of Hire (DOH)</span>&nbsp;&nbsp;&nbsp;&nbsp; <input
																	type="radio"
																	name="TblAcaPlanCriteria[initial_measurment_period_begin]"
																	value="2" class="initialmeasurement-period-begin"
																	<?php
												
if (isset ( $model_plan_offering_criteria->initial_measurment_period_begin ) && $model_plan_offering_criteria->initial_measurment_period_begin == 2) {
													
													?>
																	checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
																		of Month After DOH</span> </label>
															</div>
													
													<?php if(!empty($arrvalidation_errors[29]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[29]['error_code'].' : '; ?><?php echo $arrvalidation_errors[29]['error_message']; ?></span>
																	<?php }?>
												</div>

													</div>
<?php }?>

<?php if(in_array ( 30, $arrvalidations, TRUE ) ){?>
											<div class="col-sm-12 padding-left-0 padding-right-0">

														<h3>Plan Offering Criteria</h3>





														<div class="form-group">
															<div class="col-sm-12">
																<label class="control-label"><h4>3.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3'])){ echo Html::encode($arrsection_elements['3.3']); } ?></h4>
																</label>

																<div class="col-sm-12">
																	<label class="control-label"><h4>(a)&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3.1'])){ echo Html::encode($arrsection_elements['3.3.1']); } ?> (Optional)</h4>
																		<input class="company_certify company_certify_yes"
																		type="radio"
																		name="TblAcaPlanCriteria[company_certification_workforce]"
																		value="1"
																		<?php
	
if (isset ( $model_plan_offering_criteria->company_certification_workforce ) && $model_plan_offering_criteria->company_certification_workforce == 1) {
		
		?>
																		checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp; <span
																		class="control-checkbox">Yes</span>
																		&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
																		class="company_certify company_certify_no"
																		name="TblAcaPlanCriteria[company_certification_workforce]"
																		value="2"
																		<?php
	
if (isset ( $model_plan_offering_criteria->company_certification_workforce ) && $model_plan_offering_criteria->company_certification_workforce == 2) {
		
		?>
																		checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<span
																		class="control-checkbox">No</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	</label>
																</div>
																<div class="col-sm-12">
																	<label class="control-label"><h4>(b) &nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3.2'])){ echo Html::encode($arrsection_elements['3.3.2']); } ?> (Optional)</h4>
																		<input type="radio"
																		class="company_certify company_certify_yes"
																		name="TblAcaPlanCriteria[company_certification_medical_eligibility]"
																		value="1"
																		<?php
	
if (isset ( $model_plan_offering_criteria->company_certification_medical_eligibility ) && $model_plan_offering_criteria->company_certification_medical_eligibility == 1) {
		
		?>
																		checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp; <span
																		class="control-checkbox">Yes</span>
																		&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
																		class="company_certify company_certify_no"
																		name="TblAcaPlanCriteria[company_certification_medical_eligibility]"
																		value="2"
																		<?php
	
if (isset ( $model_plan_offering_criteria->company_certification_medical_eligibility ) && $model_plan_offering_criteria->company_certification_medical_eligibility == 2) {
		
		?>
																		checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<span
																		class="control-checkbox">No</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	</label>
																</div>
																<div class="col-sm-12">
																	<label class="control-label"><h4>(c) &nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['3.3.3'])){ echo Html::encode($arrsection_elements['3.3.3']); } ?> (Optional)</h4>
																		<input type="radio"
																		class="company_certify company_certify_yes"
																		name="TblAcaPlanCriteria[company_certification_employer_contribution]"
																		value="1"
																		<?php
	
if (isset ( $model_plan_offering_criteria->company_certification_employer_contribution ) && $model_plan_offering_criteria->company_certification_employer_contribution == 1) {
		
		?>
																		checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp; <span
																		class="control-checkbox">Yes</span>
																		&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
																		class="company_certify company_certify_no"
																		name="TblAcaPlanCriteria[company_certification_employer_contribution]"
																		value="2"
																		<?php
	
if (isset ( $model_plan_offering_criteria->company_certification_employer_contribution ) && $model_plan_offering_criteria->company_certification_employer_contribution == 2) {
		
		?>
																		checked <?php  } ?>>&nbsp;&nbsp;&nbsp;&nbsp;<span
																		class="control-checkbox">No</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	</label>
																</div>
														
														<?php if(!empty($arrvalidation_errors[30]['error_code'])){?>
																<span
																	class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[30]['error_code'].' : '; ?><?php echo $arrvalidation_errors[30]['error_message']; ?></span>
																	<?php }?>
													</div>
														</div>




													</div>


									<?php }?>
									</div>


											</div>

										</div>
									</div>
<?php ActiveForm::end(); ?>
								</div>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>
		</div>
	</div>