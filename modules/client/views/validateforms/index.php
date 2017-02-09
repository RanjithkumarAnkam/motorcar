<div class="box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title col-xs-8">Validate &amp; Create Forms - <?php if(!empty($company_detals['company_name'])){echo htmlentities($company_detals['company_name']); }?> <small><?php if(!empty($company_detals['company_client_number'])){echo '('.htmlentities($company_detals['company_client_number']).')'; }?></small>
		</h3>
		<div class="col-xs-4 pull-right padding-right-0">
			<a class=" btn bg-orange btn-social pull-right " data-toggle="tooltip" data-placement="bottom" title="Click to view help video"
				onclick="playVideo(7);"> <i class="fa fa-youtube-play"></i>View Help
				Video
			</a>
		</div>
	</div>

	<div class="col-md-12">
		<div class="col-xs-12 header-new-main">
			<span class="header-icon-band"><i
				class="fa fa-file-text-o icon-band lighter"></i></span>
			<p class="sub-header-new">You can validate data by clicking on
				"Validate Complete Data" button and can generate 1095 forms after
				successful validation</p>
		</div>
	</div>

	<!-- /.box-header -->
	<div class="box-body">
		<div class="col-md-12 ">
			<nav class="navbar " role="navigation"
				style="margin-bottom: 0px; float: left; width: 100%;">
				<div id="sticky-anchor"></div>
				<div class="col-md-12 padding-left-0 padding-right-0" id="sticky">
					<div class="" id="heading-navbar-collapse">
						<div class="navbar-left document-context-menu">
							<div class="btn-category pull-right">
								<div class="" style="">

									<div class="btn-group">
										<button id="start_validation" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Click to validate complete data"
											<?php if(!empty($company_validation)){?>
											<?php if(!in_array ( 'editpayroll', $arruserpermission, true ) || !in_array ( 'editmedical', $arruserpermission, true )){ ?>
											disabled
											<?php }elseif(!in_array ( 'all', $arruserpermission, true )){?>
											disabled <?php } ?> <?php } ?>
											<?php  if(!in_array ( 'notsigned', $arruserpermission, TRUE )) {
												if(empty($company_detals->company_ein)){
												?>
												 onclick="showeinError();"
												<?php  }else{ ?>
											onclick="return startValidation('<?php echo $encoded_company_id; ?>');"
											<?php 
												}
											} else{ ?> onclick="showError();" <?php } ?>>
											Validate
											Complete Data
										</button>
									</div>

									<div class="btn-group hide">
										<button data-toggle="tooltip" data-placement="bottom" title="Click to generate 1095 forms"
											<?php if(!empty($validation_status) &&$validation_status->is_initialized == 1 && $validation_status->is_completed == 1 && $is_all_validated == 1 && !empty($arr_validations['plan_class']) && !empty($arr_validations['payroll_data']) && !empty($arr_validations['medical_data']) ){?>
											href="#" <?php } else{ ?> disabled <?php } ?>
											class="btn btn-default">
											<i class="fa fa-file fa-lg btn_icons pd-r-5"></i>Generate
											1095 Forms
										</button>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>
		<div class="col-md-12">
			<h4 style="font-weight: bold;">
				Validation Status: <span id="validation_status">
			<?php if(!empty($validation_status)){?>
			<?php if($validation_status->is_initialized == 0){ ?>
			<font color="orange">Validation Pending</font>
			<?php }elseif($validation_status->is_initialized == 1 && $validation_status->is_completed == 0){ ?>
			<font class="text-yellow">Validation is in progress, please check
						back again</font>
			<?php }elseif($validation_status->is_initialized == 1 && $validation_status->is_completed == 1 && $is_all_validated == 1 ){ ?>
			
			<?php if(!empty($arr_validations['plan_class']) && !empty($arr_validations['payroll_data']) && !empty($arr_validations['medical_data'])){ ?>
			<font color="green">Validation Complete</font>
			<?php }else{?>
			<font color="orange">Validation Pending</font>
			<?php }?>
			<?php }elseif($validation_status->is_initialized == 1 && $validation_status->is_completed == 1 && $is_all_validated == 0){ ?>
			<font color="orange">Validation complete, Please fix the issues below</font>
			<?php } ?>
			<?php
			} else {
				?>
			<font color="orange">Validation Pending</font>
			<?php } ?>
			</span>
			</h4>
			<div id="errors_block" style="float: left; width: 100%;">
				<?php if(!empty($new_validation_status)) {?>
				
				
				
				
				
				<div class="col-lg-8" style="line-height: 28px; padding: 0;">
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Basic Reporting Information</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>
				<div class="col-xs-12 padding-left-0 padding-right-0">	
					<div class="col-xs-6" style="padding: 0;">
						<b>Benefit Plan Info</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Plan Class Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
					
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Payroll Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Medical Plan Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
				</div>
				
				
				
				
				
				
				<?php }else if(!empty($validation_results) && !empty($validation_status)){ ?>
				
				
				
				
				
				<div class="col-lg-8" style="line-height: 28px; padding: 0;">



				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Basic Reporting Information</b>
					</div>
					<div class="col-xs-6" style="">
						<?php if(!empty($arr_validations['basic_info']) && $arr_validations['basic_info']>0){ ?>
						<span class="red" data-toggle="collapse"
							data-target="#basic_reporting_info" style="font-weight: bold;"><?php echo $arr_validations['basic_info']; ?> Issue(s)</span>
						<?php }else if(!empty($validation_status) && $validation_status->is_basic_info==0){?>
						<span style="color: orange; font-weight: bold;">Not Validated</span>						
						<?php } else{?>
						<span style="color: green; font-weight: bold;">Validated</span>
						<?php }?>
					</div>
					
					</div>
					<div class="col-xs-12 padding-left-0 padding-right-0">
					
					<?php if(!empty($arr_validations['basic_info']) && $arr_validations['basic_info']>0){ ?>
					<div id="basic_reporting_info" class="collapse in col-xs-12 "
						style="padding: 0; border: 1px solid #ccc; margin-bottom: 10px;">				 
						 <?php if(!empty($arr_validations['basic_information']) && $arr_validations['basic_information']>0){ ?>
						 <div class="col-xs-6" style="background: #eee;">Basic Information</div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view basic info issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/savebasicinfo?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['basic_information']; ?> Issue(s)</a></span>
						</div> 
						 <?php }?>
						 
						 <?php if(!empty($arr_validations['large_emp_status']) && $arr_validations['large_emp_status']>0){ ?>
						 <div class="col-xs-6" style="background: #eee;">Large Emp. Status
							& Tracking</div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view Large Emp. Status & Tracking issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/largeempstatustrack?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['large_emp_status']; ?> Issue(s)</a></span>
						</div> 
						 <?php }?>
						 
						 <?php if(!empty($arr_validations['plan_offering_criteria']) && $arr_validations['plan_offering_criteria']>0){ ?>
						 <div class="col-xs-6" style="background: #eee;">Plan Offering
							Criteria</div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view plan offering criteria issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/planofferingcriteria?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['plan_offering_criteria']; ?> Issue(s)</a></span>
						</div> 
						 <?php }?>
						 
						 <?php if(!empty($arr_validations['dge']) && $arr_validations['dge']>0){ ?>
						 <div class="col-xs-6" style="background: #eee;">Designated
							Government Entity</div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view Large designated govt. entity issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/designatedgovtentity?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['dge']; ?> Issue(s)</a></span>
						</div> 
						 <?php }?>
						 
						 <?php if(!empty($arr_validations['aggregate_group']) && $arr_validations['aggregate_group']>0){ ?>
						 <div class="col-xs-6" style="background: #eee;">Aggregated Group</div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view aggregated group issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/saveaggregatedgroup?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['aggregate_group']; ?> Issue(s)</a></span>
						</div> 
						 <?php }?>
					 </div>
					<?php } ?>
					</div>
					<div class="col-xs-12 padding-left-0 padding-right-0">
					
					
					
					
					
					
					
					<div class="col-xs-6" style="padding: 0;">
						<b>Benefit Plan Info</b>
					</div>
					<div class="col-xs-6">
						<?php if(!empty($arr_validations['benefit_plan']) && $arr_validations['benefit_plan']>0){ ?>
						<span class="red" data-toggle="collapse"
							data-target="#benefit_plan_info" style="font-weight: bold;"><?php echo $arr_validations['benefit_plan']; ?> Issues</span>
						<?php }else if(!empty($validation_status) && $validation_status->is_benefit_info==0){?>
						<span style="color: orange; font-weight: bold;">Not Validated</span>						
						<?php } else{?>
						<span style="color: green; font-weight: bold;">Validated</span>
						<?php }?>
					</div>
					
					</div>
					<div class="col-xs-12 padding-left-0 padding-right-0">
					
					<?php if(!empty($arr_validations['benefit_plan']) && $arr_validations['benefit_plan']>0){ ?>
					<div id="benefit_plan_info" class="collapse in  col-xs-12 "
						style="padding: 0; border: 1px solid #ccc; margin-bottom: 10px;">				 
						 <?php if(!empty($arr_validations['general_plan_info']) && $arr_validations['general_plan_info']>0){ ?>
						 <div class="col-xs-6" style="background: #eee;">General Plan
							Information</div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view general plan information issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/generalplaninfo?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['general_plan_info']; ?> Issue(s)</a></span>
						</div> 
						 <?php }?>
						 
						 <?php if(!empty($arr_validations['mec']) && $arr_validations['mec']>0){ ?>
						 <div class="col-xs-6" style="background: #eee;">MEC Coverage</div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view mec coverage issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/meccoverage?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['mec']; ?> Issues</a></span>
						</div> 
						 <?php }?>				
					 </div>
					<?php } ?>
					
					</div>
					<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Plan Classes Data</b>
					</div>
					<div class="col-xs-6">
						<?php
					if (! empty ( $arr_validations ['plan_class'] )) {
						if (! empty ( $arr_validations ['plan_class_validation'] ) && $arr_validations ['plan_class_validation'] > 0) {
							?>
						<span class="red" data-toggle="collapse"
							data-target="#plan_class_info" style="font-weight: bold;"><?php echo $arr_validations['plan_class_validation']; ?> Issue(s)</span>
						<?php }else if(!empty($validation_status) && $validation_status->is_plan_class==0){?>
						<span style="color: orange; font-weight: bold;">Not Validated</span>						
						<?php } else{?>
						<span style="color: green; font-weight: bold;">Validated</span>						
						 <?php } }else{?>
						<span class="red" style="font-weight: bold;">No Plan Classes
							Available</span>
						
						<?php } ?>
					
					</div>
					
					</div>
					<div class="col-xs-12 padding-left-0 padding-right-0">
					<?php
					if (! empty ( $arr_validations ['plan_class'] )) {
						if (! empty ( $arr_validations ['plan_class_validation'] ) && $arr_validations ['plan_class_validation'] > 0) {
							?>
					<div id="plan_class_info" class="collapse in col-xs-12 "
						style="padding: 0; border: 1px solid #ccc; margin-bottom: 10px;">				 
						<?php
							
if (! empty ( $arr_validations ['plan_class_validation'] ) && $arr_validations ['plan_class_validation'] > 0) {
								foreach ( $arr_plan_class_individual_issues as $arr_plan_class_individual_issue ) {
									?>
						 <div class="col-xs-6" style="background: #eee;"><?php echo $arr_plan_class_individual_issue['plan_class']; ?></div>
						<div class="col-xs-6 " style="background: #eee;">
							<span class="validate_disable_buttons"><a data-toggle="tooltip" data-placement="right" title="Click to view <?php echo $arr_plan_class_individual_issue['plan_class']; ?> issue(s)"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/planclassesvalidation?c_id=<?php echo $encoded_company_id; ?>&plan_class_id=<?php echo $arr_plan_class_individual_issue['plan_class_id'];; ?>"><?php echo $arr_plan_class_individual_issue['issue_count']; ?> Issue(s)</a></span>
						</div> 
						<?php } }?>					 			
					 </div>
						<?php } }?>
					</div>
					<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Payroll Data</b>
					</div>
					<div class="col-xs-6">
						<?php
					if (! empty ( $arr_validations ['payroll_data'] )) {
						if (! empty ( $arr_validations ['payroll_data_validation'] ) && $arr_validations ['payroll_data_validation'] > 0) {
							?>
						<span class="red validate_disable_buttons"
							style="font-weight: bold;"><a data-toggle="tooltip" data-placement="right" title="Click to view payroll data issue(s)"
							href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/payrollvalidation?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['payroll_data_validation']; ?> Issue(s)</a></span>
						<?php }else if(!empty($validation_status) && $validation_status->is_payroll_data==0){?>
						<span style="color: orange; font-weight: bold;">Not Validated</span>	
                  <?php } else{?>						
						<span style="color: green; font-weight: bold;">Validated</span>
						 <?php } }else{?>
						<span class="red" style="font-weight: bold;">No Payroll Data
							Available</span>					
						<?php } ?>
					
					</div>

</div>
					<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Medical Data</b>
					</div>
					<div class="col-xs-6">
					<?php
					if (! empty ( $arr_validations ['medical_data'] )) {
						if (! empty ( $arr_validations ['medical_data_validation'] ) && $arr_validations ['medical_data_validation'] > 0) {
							?>
						<span class="red validate_disable_buttons"
							style="font-weight: bold;"><a data-toggle="tooltip" data-placement="right" title="Click to view medical data issue(s)"
							href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/medicalvalidation?c_id=<?php echo $encoded_company_id; ?>"><?php echo $arr_validations['medical_data_validation']; ?> Issue(s)</a></span>
						<?php }else if(!empty($validation_status) && $validation_status->is_medical_data==0){?>
						<span style="color: orange; font-weight: bold;">Not Validated</span>						
						<?php } else{?>
						<span style="color: green; font-weight: bold;">Validated</span>					
						 <?php } }else{?>
						<span class="red" style="font-weight: bold;">No Medical Data
							Available</span>					
						<?php } ?>
					
					</div>
</div>

				</div>
				
				
				
				
				<?php } else{ ?>
				
				
				
				
				
				
				
				<div class="col-lg-8" style="line-height: 28px; padding: 0;">
					
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Basic Reporting Information</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>
				<div class="col-xs-12 padding-left-0 padding-right-0">	
					<div class="col-xs-6" style="padding: 0;">
						<b>Benefit Plan Info</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Plan Class Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
					
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Payroll Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Medical Plan Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
				</div>
				<?php } ?>
				
				
				
				
				
				
			</div>
			<div class="col-lg-8"
				style="line-height: 28px; padding: 0; display: none;"
				id="default_block">
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Basic Reporting Information</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>
				<div class="col-xs-12 padding-left-0 padding-right-0">	
					<div class="col-xs-6" style="padding: 0;">
						<b>Benefit Plan Info</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Plan Class Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
					
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Payroll Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>
				
				<div class="col-xs-12 padding-left-0 padding-right-0">
					<div class="col-xs-6" style="padding: 0;">
						<b>Medical Plan Data</b>
					</div>
					<div class="col-xs-6" style="padding: 0;">
						<span style="color: orange;">Not Validated</span>
					</div>
				</div>	
			</div>

		</div>

	</div>
</div>

<div class="load-gif" id="loadGif" style="display: none;">
	<div class="procressing_plz_wait">
		Processing please wait .... <img class="gif-img-prop"
			src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/j-max-loader.gif" />
	</div>
</div>

<script>
function showProcessing(){
	$("#loadGif").show();
}

function showError(){
	toastr.error('Please have the agreement signed before you can validate the data');
}

function showeinError()
{
	toastr.error('Please update company ein');
}
</script>
