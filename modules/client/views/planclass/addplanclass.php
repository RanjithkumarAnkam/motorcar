<?php 
use app\models\TblAcaCompanyUserPermission;
use app\components\EncryptDecryptComponent;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use yii\widgets\ActiveForm;
$get_id = Yii::$app->request->get();
$company_id = $get_id['c_id'];
		?>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/planclass.js"></script>
<link rel="stylesheet" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/planclass.css">

<div class="box box-warning container-fluid padding-responsive">
	<div class="box-header with-border ">
		<h3 class="box-title col-xs-6">
			Add Plan Class - <?php echo Html::encode($company_details->company_name); ?> <small> (<?php echo Html::encode($company_details->company_client_number); ?>) </small>
		</h3>
		<div class="col-xs-6 pull-right">
			<a class=" btn bg-orange btn-flat btn-social pull-right" onclick="playVideo(4);"> <i
				class="fa fa-youtube-play"></i>View Help Video
			</a>
		</div>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Below is the form to add plan class.</p>
	</div>
	<div class="col-md-12 ">



		<div class="">
			<div class="">
				<div class="box box-solid">

					<!-- /.box-header -->
					<div class="box-body">
						<div class="box-group" id="accordion">
							<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
							<div class="panel  box ">
								<div class="parent-tabs box-header with-border accordian-band-color"
									>

									<span id="step_coverage" class="steps col-xs-2 " onclick="editbasic();">
										<span class="check " > <i
											class="fa fa-check" aria-hidden="true"></i> <span class="">9</span>
									</span> <span  style="display: none;" class="edit" >Edit</span>
									</span>

									<h4 class="box-title col-sm-6 col-xs-12">
										<div id="step_coverage_number_div"class="fixed-number col-sm-1 col-xs-2  " style="top: 3px;">
											<span class="block-number">9</span>
										</div>
										<a class="custom-bg col-sm-11 col-xs-10"
											data-parent="#accordion"
											style="color: white; padding-left: 0;"> Coverage Type and
											Waiting Period </a>
									</h4>

									<div class="box-title col-xs-3 pull-right"
										style="padding-top: 7px;">
										<p class="custom-bg summary-text pull-right"
											style="font-size: 12px; color: white;"></p>
									</div>

								</div>
								<div id="collapseOne"
									class="panel-collapse collapse in bg-white black">
									<div class="box-body">
										<p class="highlight-fancy">
											<span class="status"><i class="fa fa-info-circle"
												aria-hidden="true"></i></span> Fill the information about
											your Plan Class

										</p>
										<div class="col-md-12 padding-right-0">
											<div class="">
											<?php $form = ActiveForm::begin(['enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'coverage-type']]); ?>
												
												<div class="">

													<div class=" box-info">

														<!-- /.box-header -->
														<!-- form start -->
														
															<div class="col-md-offset-1 col-md-10">
																<div class="col-xs-12">
																	<div class="form-group ">
																		<div class="col-md-5">
																			<label class="control-label"><h4>9.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['9.1'])){ echo Html::encode($arrsection_elements['9.1']); } ?></h4> </label>
																		</div>
																		<div class="col-md-7">
																			<input type="text" class="form-control form-height"
																				id="" placeholder="" value="Plan Class #<?php echo $all_plans_count+1; ?>"
																				readonly disabled>

																		</div>
																	</div>


																	<div class="form-group ">
																		<div class="col-md-5">
																			<label class="control-label"><h4>9.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['9.1'])){ echo Html::encode($arrsection_elements['9.2']); } ?></h4> </label>
																		</div>
																		<div class="col-md-7">
																		 <?=$form->field ( $model_plan_coverage_type, 'plan_class_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'34','onkeypress'=>'return alpha(event);' ] )->label ( false )?>
    		
																			<span id="plan_class_name_error" class="red"></span>
																		</div>
																	</div>

																	<div class="form-group row plan-div-margin">
																		<div class="col-md-5">
																			<label class="control-label"><h4>9.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['9.3'])){ echo Html::encode($arrsection_elements['9.3']); } ?></h4> </label>
																		</div>
																		<div class="col-md-3">
																			<div class="row">
																				<input type="radio" name="TblAcaPlanCoverageType[plantype]" value="1" 
																				
																				<?php if($model_plan_coverage_type->plan_offer_type == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
																				 ><span
																					class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No
																					Qualifying Plan Offered </span>&nbsp;&nbsp;&nbsp;&nbsp;
																			</div>
																			<div class="row">
																				<input type="radio" name="TblAcaPlanCoverageType[plantype]" value="2"
																				<?php if($model_plan_coverage_type->plan_offer_type == 2){
																					?> 
																				checked
																				<?php } ?>
																				><span
																					class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Self
																					Insured </span>&nbsp;&nbsp;&nbsp;&nbsp;
																			</div>


																		</div>

																		<div class="col-md-4">
																			<div class="row">
																				<input type="radio" name="TblAcaPlanCoverageType[plantype]" value="3"
																				<?php if($model_plan_coverage_type->plan_offer_type == 3){
																					?> 
																				checked
																				<?php } ?>
																				><span
																					class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Fully
																					Insured </span>&nbsp;&nbsp;&nbsp;&nbsp;
																			</div>
																			<div class="row">
																				<input type="radio" name="TblAcaPlanCoverageType[plantype]" value="4"
																				<?php if($model_plan_coverage_type->plan_offer_type == 4){
																					?> 
																				checked
																				<?php } ?>
																				>
																				<span class="control-checkbox">&nbsp;&nbsp;&nbsp;Multi
																					Employer Plan </span>&nbsp;&nbsp;&nbsp;&nbsp;
																			</div>

																		</div>
																		<div class="col-md-6"></div>
																		<div class="col-md-6">
																			<div class="row">
																				<input type="radio" name="TblAcaPlanCoverageType[plantype]" value="5"
																				<?php if($model_plan_coverage_type->plan_offer_type == 5){
																					?> 
																				checked
																				<?php } ?>
																				><span
																					class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Combination
																					of the options above during the year</span>&nbsp;&nbsp;&nbsp;&nbsp;
																			</div>
																		</div>
																	</div>

																	<div class="" id="combination_div1" <?php if($model_plan_coverage_type->plan_offer_type == 5){ ?> style="display: block;" <?php }else{ ?>style="display: none;" <?php }?>>
																		<?php  $coveragetype= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 8])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');?>
																		<div class="col-xs-12" style="border: 1px solid #ddd;">
																			<div class="col-sm-4 padding-left-0">
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">January</div>
																					<div class="col-sm-9">
																							
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][1]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>"  <?php if(!empty($jan_1) && $jan_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>

																				 <div class="row plan-div-margin">
																					<div class="col-sm-3">January</div>
																					<div class="col-sm-9">
																					
																						<?php  $waitingperiod= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 9])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');?>	
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][1]">
																							<option value="">Select waiting Period</option>
																							<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>
																				
																				
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">April</div>
																					<div class="col-sm-9">
																				
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][4]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>"  <?php if(!empty($apr_1) && $apr_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>

																				<div class="row plan-div-margin">
																							<div class="col-sm-3">April</div>
																							<div class="col-sm-9">

																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][4]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">July</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][7]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>"  <?php if(!empty($jul_1) && $jul_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>

																				<div class="row plan-div-margin">
																							<div class="col-sm-3">July</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][7]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">October</div>
																					<div class="col-sm-9">
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][10]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($oct_1) && $oct_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>
																				
																				<div class="row plan-div-margin">
																							<div class="col-sm-3">October</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][10]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						
																			</div>
																			<div class="col-md-4 padding-left-0">

																				<div class="row plan-div-margin">
																					<div class="col-sm-3">February</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][2]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($feb_1) && $feb_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>
																				
																				<div class="row plan-div-margin">
																							<div class="col-sm-3">February</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][2]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">May</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][5]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($may_1) && $may_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>
																				
																				<div class="row plan-div-margin">
																							<div class="col-sm-3">May</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][5]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">August</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][8]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($aug_1) && $aug_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>
																				
																				<div class="row plan-div-margin">
																							<div class="col-sm-3">August</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][8]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																				
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">November</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][11]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($nov_1) && $nov_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>
																				
																				<div class="row plan-div-margin">
																							<div class="col-sm-3">November</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][11]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						
																			</div>
																			<div class="col-md-4 padding-left-0 padding-right-0">

																				<div class="row plan-div-margin">
																					<div class="col-sm-3">March</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][3]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($mar_1) && $mar_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>

																				 <div class="row plan-div-margin">
																							<div class="col-sm-3">March</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][3]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">June</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][6]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($jun_1) && $jun_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>

																				
																				<div class="row plan-div-margin">
																							<div class="col-sm-3">June</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][6]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						
																						
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">September</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][9]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($sept_1) && $sept_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>

																				<div class="row plan-div-margin">
																							<div class="col-sm-3">September</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][9]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						
																						
																				<div class="row plan-div-margin">
																					<div class="col-sm-3">December</div>
																					<div class="col-sm-9">
																					
																						<select class="form-control reset-coverage-type" name="Planoffertypeyears[1][12]">
																							<option value="">Select Coverage Type</option>
																							<?php if(!empty($coveragetype))
																							{ 
																							foreach ($coveragetype as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($dec_1) && $dec_1 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																					</div>
																				</div>
																				
																				<div class="row plan-div-margin">
																							<div class="col-sm-3">December</div>
																							<div class="col-md-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[3][12]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																			</div>
																		</div>
																	</div>




																	<div class="" id="combination_div2" <?php if($model_plan_coverage_type->plan_offer_type == 2 || $model_plan_coverage_type->plan_offer_type == 2 || $model_plan_coverage_type->plan_offer_type == 3 ){ ?> style="display:block; "<?php }else{ ?>style="display:none; "<?php }?>>
																		<div class="col-md-12" style="border: 1px solid #ddd;">
																			<div class="form-group plan-div-margin">
																				
																				<div class="col-md-6">
																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio" 
																						
																				<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
																				
																							value="1" ><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Date
																							of hire (DOH)</span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>
																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 2){
																					?> 
																				checked
																				<?php } ?>
																							value="2"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;30
																							Days after DOH </span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>
																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 3){
																					?> 
																				checked
																				<?php } ?>
																							value="3"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;60
																							Days after DOH </span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>
																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 4){
																					?> 
																				checked
																				<?php } ?>
																							value="4"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;90
																							Days after DOH </span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>

																				</div>

																				<div class="col-md-6">
																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 5){
																					?> 
																				checked
																				<?php } ?>
																							value="5"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
																							of Month after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>
																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 6){
																					?> 
																				checked
																				<?php } ?>
																							value="6"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
																							of Month after 30 days after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>

																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 7){
																					?> 
																				checked
																				<?php } ?>
																							value="7"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
																							of Month after 60 days after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>

																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 8){
																					?> 
																				checked
																				<?php } ?>
																							value="8"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
																							of Month after 90 days after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>
																					
																					<div class="">
																						<input type="radio" name="TblAcaPlanCoverageType[doh]" class="reset-coverage-type-radio"
																						<?php if(isset($model_plan_coverage_type->plan_type_doh) && $model_plan_coverage_type->plan_type_doh == 9){
																					?> 
																				checked
																				<?php } ?>
																							value="9"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Combination
																							of the options above during the year</span>&nbsp;&nbsp;&nbsp;&nbsp;
																					</div>
																				</div>
																				
																			</div>

																			<div class="" id="combination_div3" <?php if($model_plan_coverage_type->plan_type_doh == 9 ){ ?> style="display:block; "<?php }else{ ?>style="display:none; "<?php }?>>
																				<div class="col-xs-12"
																					style="border: 1px solid #ddd; margin-bottom: 15px;">
																					<div class="col-md-4 padding-left-0">
																					<?php  $waitingperiod= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 9])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');?>
																		
																						<div class="row plan-div-margin">
																							<div class="col-sm-3">January</div>
																							<div class="col-sm-9">
																									
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][1]">
																									<option value="" >Select Waiting Period</option>
																									<?php 
																									
																									if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($jan_2) && $jan_2 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">April</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][4]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($apr_2) && $apr_2 == $key) {?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">July</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][7]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>"  <?php if(!empty($jul_2) && $jul_2 == $key) {?> selected<?php }?> ><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">October</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][10]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($oct_2) && $oct_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-4 padding-left-0">

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">February</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][2]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($feb_2) && $feb_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						<div class="row plan-div-margin">
																							<div class="col-sm-3">May</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][5]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($may_2) && $may_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						<div class="row plan-div-margin">
																							<div class="col-sm-3">August</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][8]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($aug_2) && $aug_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																						<div class="row plan-div-margin">
																							<div class="col-sm-3">November</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][11]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($nov_2) && $nov_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-4 padding-left-0 padding-right-0">

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">March</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][3]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($mar_2) && $mar_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">June</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][6]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($jun_2) && $jun_2 == $key){?> selected<?php }?> ><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">September</div>
																							<div class="col-sm-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][9]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($sep_2) && $sep_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>

																						<div class="row plan-div-margin">
																							<div class="col-sm-3">December</div>
																							<div class="col-md-9">
																							
																								<select class="form-control reset-coverage-type" name="Planoffertypeyears[2][12]">
																									<option value="" >Select Waiting Period</option>
																									<?php if(!empty($waitingperiod))
																							{ 
																							foreach ($waitingperiod as $key=>$value){?>
																							<option value="<?php echo $key; ?>" <?php if(!empty($dec_2) && $dec_2 == $key){?> selected<?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>




																		</div>

																	</div>

																	<div class="form-group row plan-div-margin">
																		<div class="col-md-8">
																			<label class="control-label"><h4>9.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['9.4'])){ echo Html::encode($arrsection_elements['9.4']); } ?></h4> </label>
																		</div>
																		<div class="col-md-4" style="margin-top: 10px;">
																			<input type="radio"  name="TblAcaPlanCoverageType[employeemedicalplan]" 
																				<?php if(isset($model_plan_coverage_type->employee_medical_plan) && $model_plan_coverage_type->employee_medical_plan == 1){
																			
																					?> 
																				checked
																				<?php  } ?> value="1"><span
																				class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
																			<input type="radio" name="TblAcaPlanCoverageType[employeemedicalplan]" value="2"
																			<?php if(isset($model_plan_coverage_type->employee_medical_plan) &&$model_plan_coverage_type->employee_medical_plan == 2){
																			
																					?> 
																				checked
																				<?php  } ?> 
																			><span
																				class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>


																		</div>
																	</div>




																</div>



															</div>
													
													</div>
													<!-- /.box-body -->

													<!-- /.box-footer -->
													
													<div class="box-footer pull-right padding-right-0">
														<a class="btn btn-default btn-default-cancel"
															href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/planclass?c_id=<?php echo $company_id;?> ">Cancel</a>
														<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success coverage-type-btn' ,'name' => 'button','value'=>'exit'])?>
    	
													<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success coverage-type-btn' ,'name' => 'button','value'=>'continue'])?>
    	
															
														
													</div>
													
													
												</div>
							<?php ActiveForm::end(); ?>
											</div>
										</div>


									</div>
								</div>




							</div>

							<div class="panel box ">
								<div class="parent-tabs box-header with-border">
									<span id="step1" class="steps col-xs-2 no-wrap"
										onclick="editbasic1()"> <span class="check "
										style="display: none;"> <i class="fa fa-check"
											aria-hidden="true"></i> <span class="">10</span>
									</span> <span style="display: none;" class="edit">Edit</span></span>

									<h4 class="box-title col-sm-6 col-xs-12">
										<div class="fixed-number col-sm-1 col-xs-2" style="top: 3px;">
											<span class="block-number">10</span>
										</div>
										<a class="custom-bg col-sm-11 col-xs-10"
											data-parent="#accordion" style="padding-left: 0;">Type of
											Coverage Offered </a>
									</h4>

									<div class="box-title col-xs-3 pull-right"
										style="padding-top: 7px;">
										<p class="custom-bg summary-text pull-right"
											style="font-size: 12px;"></p>
									</div>

								</div>
								

							</div>


							<div class="panel box ">
								<div class="parent-tabs box-header with-border"
									>
									<span id="step1" class="steps col-xs-2 no-wrap" onclick="editbasic2()">
										<span class="check " style="display: none;"> <i
											class="fa fa-check" aria-hidden="true"></i> <span class="">11</span>
									</span> <span style="display: none;" class="edit">Edit</span>
									</span>

									<h4 class="box-title col-sm-6 col-xs-12" style="">
										<div class="fixed-number col-sm-1 col-xs-2" style="top: 3px;">
											<span class="block-number">11</span>
										</div>
										<a class="custom-bg col-sm-11 col-xs-10"
											data-parent="#accordion" style="padding-left: 0;">Employee
											Contributions </a>
									</h4>

									<div class="box-title col-xs-3 pull-right"
										style="padding-top: 7px;">
										<p class="custom-bg summary-text pull-right"
											style="font-size: 12px;"></p>
									</div>

								</div>
								

							</div>
						</div>



					</div>



				</div>


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
																	
