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
		
		
		<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/medicalindividualvalidation?c_id='.$encrypt_company_id.'&medical_id='.$encrypt_medical_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'','id'=>'medical_individual_form']]); ?>
		<div class="col-md-12">
			<div class="col-xs-12" style="float: left; width: 100%; padding: 0">
				<h4 style="font-weight: bold; margin-bottom: 10px; float: left;">Validate Report (<?php if(!empty($medical_details)){echo $medical_details['first_name'].' '.$medical_details['middle_name'].' '.$medical_details['last_name'].' - '.$medical_details['ssn']; }?>)</h4>


				<a class="btn btn-default btn-default-cancel pull-right"
					onclick="showProcessing();"
					href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms/medicalvalidation?c_id=<?php echo $encoded_company_id;?>">Cancel</a>


				<button type="submit"
					class="btn btn-primary mec-coverage-btn pull-right" name="button"
					value="continue">Update</button>
			</div>
			<div class="col-xs-12"
				style="line-height: 28px; padding: 10px; border: 1px solid #ccc;">




				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">First Name</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $medical_details, 'first_name' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'75','onkeypress'=>'return companyname(event);' ] )->label ( false )?>
						
						<?php if(!empty($arrvalidation_errors[104]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[104]['error_code'].' : '; ?><?php echo $arrvalidation_errors[104]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[105]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[105]['error_code'].' : '; ?><?php echo $arrvalidation_errors[105]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[106]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[106]['error_code'].' : '; ?><?php echo $arrvalidation_errors[106]['error_message']; ?></span>
																			<?php }?>
					</div>
				</div>


				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">Last Name</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $medical_details, 'last_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'75','onkeypress'=>'return companyname(event);' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[107]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[107]['error_code'].' : '; ?><?php echo $arrvalidation_errors[107]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[108]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[108]['error_code'].' : '; ?><?php echo $arrvalidation_errors[108]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[109]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[109]['error_code'].' : '; ?><?php echo $arrvalidation_errors[109]['error_message']; ?></span>
																			<?php }?>
				
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">SSN</div>
					<div class="col-xs-6" style="padding: 0;">
						<?php echo $form->field($medical_details,'ssn')->label(false)->textInput(['class' => 'form-control form-height  col-sm-6','data-inputmask'=>'"mask": "999-99-9999"','data-mask'=>'']); ?>
						
						<?php if(!empty($arrvalidation_errors[110]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[110]['error_code'].' : '; ?><?php echo $arrvalidation_errors[110]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[111]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[111]['error_code'].' : '; ?><?php echo $arrvalidation_errors[111]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[112]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[112]['error_code'].' : '; ?><?php echo $arrvalidation_errors[112]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">Address</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $medical_details, 'address1' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[113]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[113]['error_code'].' : '; ?><?php echo $arrvalidation_errors[113]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[114]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[114]['error_code'].' : '; ?><?php echo $arrvalidation_errors[114]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[115]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[115]['error_code'].' : '; ?><?php echo $arrvalidation_errors[115]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">City</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $medical_details, 'city' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'75' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[116]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[116]['error_code'].' : '; ?><?php echo $arrvalidation_errors[116]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[117]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[117]['error_code'].' : '; ?><?php echo $arrvalidation_errors[117]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[118]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[118]['error_code'].' : '; ?><?php echo $arrvalidation_errors[118]['error_message']; ?></span>
																			<?php }?>
						<?php if(!empty($arrvalidation_errors[119]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[119]['error_code'].' : '; ?><?php echo $arrvalidation_errors[119]['error_message']; ?></span>
																			<?php }?>
						<?php if(!empty($arrvalidation_errors[155]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[119]['error_code'].' : '; ?><?php echo $arrvalidation_errors[155]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">State</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $medical_details, 'state' )->textInput ( [ 'class' => 'form-control form-height  col-sm-6','maxlength'=>'2','onkeypress'=>'return companyname(event);' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[120]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //e/cho $arrvalidation_errors[120]['error_code'].' : '; ?><?php echo $arrvalidation_errors[120]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[121]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[121]['error_code'].' : '; ?><?php echo $arrvalidation_errors[121]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[122]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[122]['error_code'].' : '; ?><?php echo $arrvalidation_errors[122]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">Zip</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $medical_details, 'zip' )->textInput ( [ 'class' => 'form-control numbers form-height col-sm-6','maxlength'=>'5' ] )->label ( false )?>
						<?php if(!empty($arrvalidation_errors[123]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[123]['error_code'].' : '; ?><?php echo $arrvalidation_errors[123]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[124]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[124]['error_code'].' : '; ?><?php echo $arrvalidation_errors[124]['error_message']; ?></span>
																			<?php }?>
						
						</div>
				</div>

				<div class="form-group col-md-12">
					<div class="col-xs-3" style="">DOB</div>
					<div class="col-xs-6" style="padding: 0;">
						<?=$form->field ( $medical_details, 'dob' )->widget ( DatePicker::classname (),  ['pluginOptions' => [
							'autoclose'=>true,
							'format' => 'yyyy-mm-dd'
						]]// 'language' => 'ru',// 'dateFormat' => 'yyyy-MM-dd', 
					)->label ( false )?>
						
						<?php if(!empty($arrvalidation_errors[125]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[125]['error_code'].' : '; ?><?php echo $arrvalidation_errors[125]['error_message']; ?></span>
																			<?php }?>
																			
						<?php if(!empty($arrvalidation_errors[126]['error_code'])){?>
						<span
							class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[126]['error_code'].' : '; ?><?php echo $arrvalidation_errors[126]['error_message']; ?></span>
																			<?php }?>
																			
						
						</div>
				</div>


				<!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="exampleCompanyusers"
						class="table table-bordered table-hover">
						<thead>
							<tr class="tr-grid-header" style="background: none; color: #aaa;">

								<th>Coverage Start Date</th>
								<th>Coverage End Date</th>
								<th>Person Type</th>
								<th>Connected Employee SSN</th>
								<th>Use Dependent DOB</th>
								<th>DOB</th>
								<?php if ( empty ( $enrollment_periods )) {?>
								<th>Action</th>
								<?php } ?>
							</tr>
						</thead>
						<tbody>
						<?php
						
if (! empty ( $enrollment_periods )) {
							foreach ( $enrollment_periods as $periods ) {
								
								$encrypt_component = new EncryptDecryptComponent ();
								
								$encrypted_period_id = $encrypt_component->encrytedUser ( $periods->period_id );
								?>							
							<tr>
								<td><input type="date"
									name="TblAcaMedicalEnrollmentPeriod[<?php echo $encrypted_period_id; ?>][coverage_start_date]"
									class="form-control"
									value="<?php echo $periods->coverage_start_date; ?>" />
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][127]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][127]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][127]['error_message']; ?></span>
																			<?php }?>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][128]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //e/cho $arrperiodvalidation_errors[$periods->period_id][128]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][128]['error_message']; ?></span>
																			<?php }?>
							<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][129]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][129]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][129]['error_message']; ?></span>
																			<?php }?>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][130]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][130]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][130]['error_message']; ?></span>
																			<?php }?>
								
								</td>
								<td><input type="date"
									name="TblAcaMedicalEnrollmentPeriod[<?php echo $encrypted_period_id; ?>][coverage_end_date]"
									class="form-control"
									value="<?php echo $periods->coverage_end_date;?>" />
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][131]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][131]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][131]['error_message']; ?></span>
																			<?php }?>
								
								</td>
								<td><select class="form-control"
									name="TblAcaMedicalEnrollmentPeriod[<?php echo $encrypted_period_id; ?>][person_type]">
										<option value="">Select Person Type</option>
								<?php
								
if (! empty ( $person_type_Data )) {
									foreach ( $person_type_Data as $key => $value ) {
										?>
								<option value="<?php echo $key; ?>"
											<?php if(!empty($periods->person_type) && $periods->person_type == $key){?>
											selected <?php } ?>><?php echo $value; ?></option>
								<?php } } ?>
								</select>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][132]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][132]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][132]['error_message']; ?></span>
																			<?php }?>
								</td>
								<td><input type="text"
									name="TblAcaMedicalEnrollmentPeriod[<?php echo $encrypted_period_id; ?>][ssn]"
									class="form-control" value="<?php echo $periods->ssn;?>"
									data-inputmask="'mask': '999-99-9999'" data-mask/>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][133]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][133]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][133]['error_message']; ?></span>
																			<?php }?>
																			<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][134]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][134]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][134]['error_message']; ?></span>
																			<?php }?>
																			<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][135]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][135]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][135]['error_message']; ?></span>
																			<?php }?>
																			<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][136]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][136]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][136]['error_message']; ?></span>
																			<?php }?>
								
								</td>



								<td><input type="checkbox"
									name="TblAcaMedicalEnrollmentPeriod[<?php echo $encrypted_period_id; ?>][dependent_dob]"
									class="" value="1"
									<?php if(!empty($periods->dependent_dob) && $periods->dependent_dob == 1){?>
									checked <?php }?> />
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][137]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][137]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][137]['error_message']; ?></span>
																			<?php }?>
																			
																			
								
								</td>

								<td><input type="date"
									name="TblAcaMedicalEnrollmentPeriod[<?php echo $encrypted_period_id; ?>][dob]"
									class="form-control" value="<?php echo $periods->dob; ?>" />
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][138]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][138]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][138]['error_message']; ?></span>
																			<?php }?>
								<?php if(!empty($arrperiodvalidation_errors[$periods->period_id][139]['error_code'])){?>
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrperiodvalidation_errors[$periods->period_id][139]['error_code'].' : '; ?><?php echo $arrperiodvalidation_errors[$periods->period_id][139]['error_message']; ?></span>
																			<?php }?>
							
								
								</td>

							</tr>
							<?php }} else
							{ 	

if(!empty($arrvalidation_errors[156]['error_code'])){
	
	?>
<tr>
						<td
							class="red " colspan="7" id="employee_periods_error"><?php //echo $arrvalidation_errors[96]['error_code'].' : '; ?><?php echo $arrvalidation_errors[156]['error_message']; ?></td>
																	
																			</tr>
																			<?php }?>	
																			
																			 <tr id="period_row" >
								<td><input type="date" id="coverage_start_date"
									name="TblAcaMedicalEnrollmentPeriod[new][coverage_start_date]"
									class="form-control" value="" />
									<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right" id="coverage_start_date_error"></span>
								
								</td>
								<td><input type="date" id="coverage_end_date"
									name="TblAcaMedicalEnrollmentPeriod[new][coverage_end_date]"
									class="form-control"
									value="" />
								<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right" id="coverage_end_date_error"></span>
								
								</td>
								<td><select class="form-control"
									name="TblAcaMedicalEnrollmentPeriod[new][person_type]" id="person_type">
										<option value="">Select Person Type</option>
								<?php
								
if (! empty ( $person_type_Data )) {
									foreach ( $person_type_Data as $key => $value ) {
										?>
								<option value="<?php echo $key; ?>"
											<?php if(!empty($periods->person_type) && $periods->person_type == $key){?>
											selected <?php } ?>><?php echo $value; ?></option>
								<?php } } ?>
								</select>
								
						<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"  id="person_type_error"></span>
																		
								</td>
								<td>
								<input type="text" name="TblAcaMedicalEnrollmentPeriod[new][ssn]"   id="ssn"
								class="form-control" value="" data-inputmask="'mask': '999-99-9999'" data-mask/>
									<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"  id="ssn_error"></span>																																																																
								</td>
								
								<td>
								<input type="checkbox" name="TblAcaMedicalEnrollmentPeriod[new][dependent_dob]" id="dependent_dob"
								class="" value="1">
																											
									<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right"  id="dependent_dob_error"></span>										
								
								</td>
								<td><input type="date" id="dob"
									name="TblAcaMedicalEnrollmentPeriod[new][dob]"
									class="form-control" value="" />
									<span
									class="red col-sm-12 padding-left-0 padding-right-0 pull-right" id="dob_error"></span>
								
								</td>
								
								
								
								<td>
								
								<button class="btn btn-sm btn-success" type="button" id="btn_enrollment_period" onclick="return saveenrollmentperiod('<?php echo $_GET ['c_id']; ?>','<?php echo $_GET ['medical_id']; ?>');">Save</button>
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