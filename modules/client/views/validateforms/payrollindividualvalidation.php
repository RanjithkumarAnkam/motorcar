<?php
use kartik\widgets\DatePicker;
use yii\widgets\ActiveForm;
use app\components\EncryptDecryptComponent;
?>
<script
	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/reporting.js"></script>
<div class="box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title col-xs-6">Validate &amp; Create Forms - <?php if(!empty($company_detals['company_name'])){echo htmlentities($company_detals['company_name']); }?> <small><?php if(!empty($company_detals['company_client_number'])){echo '('.htmlentities($company_detals['company_client_number']).')'; }?></small>
		</h3>
		<div class="col-xs-6 pull-right padding-right-0">
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
			<p class="sub-header-new">You can update with the correct information
				from this screen</p>
		</div>
	</div>

	<!-- /.box-header -->
	<div class="box-body">
		
		
		<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/payrollindividualvalidation?c_id='.$encrypt_company_id.'&payroll_id='.$encrypt_payroll_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'','id'=>'payroll_individual_form']]); ?>
		<div class="col-md-12">
			<div class="col-xs-12" style="float: left; width: 100%; padding: 0">
				<h4 style="font-weight: bold; margin-bottom: 10px; float: left;">Validate Report (<?php if(!empty($payroll_details)){echo $payroll_details['first_name'].' '.$payroll_details['middle_name'].' '.$payroll_details['last_name'].' - '.$payroll_details['ssn']; }?>)</h4>


				<a class="btn btn-default btn-default-cancel pull-right"
					onclick="showProcessing();"
					href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/payrollvalidation?c_id=<?php echo $encoded_company_id;?>">Cancel</a>


				<button type="submit"
					class="btn btn-primary mec-coverage-btn pull-right"  id="submit_btn" name="button"
					value="continue">Update</button>
			</div>
			<div class="col-xs-12"
				style="line-height: 28px; padding: 10px; border: 1px solid #ccc;">




				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">First Name</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $payroll_details, 'first_name' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'75','onkeypress'=>'return companyname(event);' ] )->label ( false )?>
						
						<?php if(!empty($arrvalidation_errors[75]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[75]['error_code'].' : '; ?><?php echo $arrvalidation_errors[75]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[76]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[76]['error_code'].' : '; ?><?php echo $arrvalidation_errors[76]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[77]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[77]['error_code'].' : '; ?><?php echo $arrvalidation_errors[77]['error_message']; ?></span>
																			<?php }?>
					</div>
				</div>


				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">Last Name</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $payroll_details, 'last_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'75','onkeypress'=>'return companyname(event);' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[78]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[78]['error_code'].' : '; ?><?php echo $arrvalidation_errors[78]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[79]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[79]['error_code'].' : '; ?><?php echo $arrvalidation_errors[79]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[80]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[80]['error_code'].' : '; ?><?php echo $arrvalidation_errors[80]['error_message']; ?></span>
																			<?php }?>
				
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">SSN</div>
					<div class="col-xs-6" style="padding: 0;">
						<?php echo $form->field($payroll_details,'ssn')->label(false)->textInput(['class' => 'form-control form-height  col-sm-6','data-inputmask'=>'"mask": "999-99-9999"','data-mask'=>'']); ?>
						
						<?php if(!empty($arrvalidation_errors[81]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[81]['error_code'].' : '; ?><?php echo $arrvalidation_errors[81]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[82]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[82]['error_code'].' : '; ?><?php echo $arrvalidation_errors[82]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[83]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[83]['error_code'].' : '; ?><?php echo $arrvalidation_errors[83]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">Address</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $payroll_details, 'address1' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[84]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[84]['error_code'].' : '; ?><?php echo $arrvalidation_errors[84]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[85]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[85]['error_code'].' : '; ?><?php echo $arrvalidation_errors[85]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[86]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[86]['error_code'].' : '; ?><?php echo $arrvalidation_errors[86]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">City</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $payroll_details, 'city' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'75' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[87]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[87]['error_code'].' : '; ?><?php echo $arrvalidation_errors[87]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[88]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[88]['error_code'].' : '; ?><?php echo $arrvalidation_errors[88]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[89]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[89]['error_code'].' : '; ?><?php echo $arrvalidation_errors[89]['error_message']; ?></span>
																			<?php }?>
						<?php if(!empty($arrvalidation_errors[90]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[90]['error_code'].' : '; ?><?php echo $arrvalidation_errors[90]['error_message']; ?></span>
																			<?php }?>
						<?php if(!empty($arrvalidation_errors[146]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[146]['error_code'].' : '; ?><?php echo $arrvalidation_errors[146]['error_message']; ?></span>
																			<?php }?>
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">State</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $payroll_details, 'state' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'2','onkeypress'=>'return companyname(event);' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[91]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[91]['error_code'].' : '; ?><?php echo $arrvalidation_errors[91]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[92]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[92]['error_code'].' : '; ?><?php echo $arrvalidation_errors[92]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[93]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[93]['error_code'].' : '; ?><?php echo $arrvalidation_errors[93]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">Zip</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $payroll_details, 'zip' )->textInput ( [ 'class' => 'form-control numbers form-height col-sm-6','maxlength'=>'5' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[94]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[94]['error_code'].' : '; ?><?php echo $arrvalidation_errors[94]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[95]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[95]['error_code'].' : '; ?><?php echo $arrvalidation_errors[95]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">DOB</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $payroll_details, 'dob' )->widget ( DatePicker::classname (),  ['pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd'
    ]]// 'language' => 'ru',// 'dateFormat' => 'yyyy-MM-dd', 
)->label ( false )?>
						
						<?php if(!empty($arrvalidation_errors[96]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[96]['error_code'].' : '; ?><?php echo $arrvalidation_errors[96]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[97]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[97]['error_code'].' : '; ?><?php echo $arrvalidation_errors[97]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[98]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[98]['error_code'].' : '; ?><?php echo $arrvalidation_errors[98]['error_message']; ?></span>
																			<?php }?>
						</div>
				</div>


				<!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="exampleCompanyusers"
						class="table table-bordered table-hover">
						<thead>
							<tr class="tr-grid-header" style="background: none; color: #aaa;">

								<th>Hire Date</th>
								<th>Termination Date</th>
								<th>Medical Plan Class Name</th>
								<th>FT/PT Status</th>
								
								<?php if ( empty ( $employee_periods )) {?>
								<th>Actions</th>
								<?php } ?>
								
							</tr>
						</thead>
						<tbody>
						<?php
						
						if (! empty ( $employee_periods )) {
							foreach ( $employee_periods as $periods ) {
								
								$encrypt_component = new EncryptDecryptComponent ();
								
								$encrypted_period_id = $encrypt_component->encrytedUser ( $periods->period_id );
								?>							
							<tr>
								<td><input type="date"
									name="TblAcaPayrollEmploymentPeriod[<?php echo $encrypted_period_id; ?>][hire_date]"
									class="form-control" value="<?php echo $periods->hire_date; ?>" />
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][99]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][99]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][99]['error_message']; ?></span>
																			<?php }?>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][100]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][100]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][100]['error_message']; ?></span>
																			<?php }?>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][149]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][100]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][149]['error_message']; ?></span>
																			<?php }?>											
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][151]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][100]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][151]['error_message']; ?></span>
																			<?php }?>
								</td>
								<td><input type="date"
									name="TblAcaPayrollEmploymentPeriod[<?php echo $encrypted_period_id; ?>][termination_date]"
									class="form-control"
									value="<?php echo $periods->termination_date;?>" />
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][101]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][101]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][101]['error_message']; ?></span>
																			<?php }?>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][150]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][100]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][150]['error_message']; ?></span>
																			<?php }?>
																			
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][152]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][100]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][152]['error_message']; ?></span>
																			<?php }?>
								
								</td>
								<td><select class="form-control"
									name="TblAcaPayrollEmploymentPeriod[<?php echo $encrypted_period_id; ?>][plan_class]">
										<option value="">Select Plan Class</option>
								<?php
								
								if (! empty ( $plan_classes )) {
									foreach ( $plan_classes as $plan ) {
										?>
								<option value="<?php echo $plan->plan_class_id; ?>"
											<?php if(!empty($periods->plan_class) && $plan->plan_class_id == $periods->plan_class){?>
											selected <?php } ?>><?php echo $plan->plan_class_number; ?></option>
								<?php } } ?>
								</select>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][102]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][102]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][102]['error_message']; ?></span>
																			<?php }?>
								</td>
								<td><select class="form-control"
									name="TblAcaPayrollEmploymentPeriod[<?php echo $encrypted_period_id; ?>][status]">
										<option value="">Status</option>
										<option value="1"
											<?php if(!empty($periods->status) && $periods->status == 1){ ?>
											selected <?php }?>>FT</option>
										<option value="2"
											<?php if(!empty($periods->status) && $periods->status == 2){ ?>
											selected <?php }?>>PT</option>
								</select>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][103]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][103]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][103]['error_message']; ?></span>
																			<?php }?>
								</td>

							</tr>
							<?php }}else{ ?>	

<?php if(!empty($arrvalidation_errors[147]['error_code'])){?>
<tr>
						<td
							class="red " colspan="5" id="employee_periods_error"><?php //echo $arrvalidation_errors[96]['error_code'].' : '; ?><?php echo $arrvalidation_errors[147]['error_message']; ?></td>
																			
																			</tr>
																			<?php }?>	
																			
																			 <tr id="period_row" >
								<td><input type="date" id="hire_date"
									name="TblAcaPayrollEmploymentPeriod[new][hire_date]"
									class="form-control" value="" />
									<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right" id="hire_date_error"></span>
								
								</td>
								<td><input type="date" id="termination_date"
									name="TblAcaPayrollEmploymentPeriod[new][termination_date]"
									class="form-control"
									value="" />
								<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right" id="termination_date_error"></span>
								
								</td>
								<td><select class="form-control"
									name="TblAcaPayrollEmploymentPeriod[new][plan_class]" id="plan_class">
										<option value="">Select Plan Class</option>
								<?php
								
								if (! empty ( $plan_classes )) {
									foreach ( $plan_classes as $plan ) {
										?>
								<option value="<?php  echo $plan->plan_class_id; ?>"
											><?php echo $plan->plan_class_number; ?></option>
								<?php  } 
								 } ?>
								</select>
								
								<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right" id="plan_class_error"></span>
								
								</td>
								<td><select class="form-control"
									name="TblAcaPayrollEmploymentPeriod[new][status]" id="status">
										<option value="">Status</option>
										<option value="1"
											>FT</option>
										<option value="2"
											>PT</option>
								</select>
								<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right" id="status_error"></span>
								</td>
								
								<td>
								
								<button class="btn btn-sm btn-success" type="button" id="btn_employment_period" onclick="return saveemploymentperiod('<?php echo $_GET ['c_id']; ?>','<?php echo $_GET ['payroll_id']; ?>');">Save</button>
								</td>

							</tr>
							<?php } ?>																			
						</tbody>

					</table>
				</div>






			</div>
			<?php ActiveForm::end(); ?>
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

</script>