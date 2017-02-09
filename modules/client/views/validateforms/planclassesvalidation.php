<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
?>
<script
	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/planclass.js"></script>
<link rel="stylesheet"
	href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/planclass.css">
<style>
.form-height {
	width: 100%;
}

.help-block {
	float: left;
}
</style>


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
		<div class="col-md-12">
			
			
			<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/planclassesvalidation?c_id='.$encoded_company_id.'&plan_class_id='.$encrypt_plan_class_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'plan_class_validation']]); ?>
			<div class="col-xs-12" style="float: left; width: 100%; padding: 0">
				<h4 style="font-weight: bold; margin-bottom: 10px; float: left;">Validate Report (<?php if(!empty($plan_class_details)){echo $plan_class_details->plan_class_number; }?>)</h4>
				<a class="btn btn-default btn-default-cancel pull-right"
					href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms?c_id=<?php echo $encoded_company_id;?>">Cancel</a>


				<button type="submit"
					class="btn btn-primary mec-coverage-btn pull-right" name="button"
					value="continue">Update</button>

			</div>

			<div class="col-xs-12" style="padding: 20px; border: 1px solid #ccc;">




				<div class="form-group row plan-div-margin">
					<div class="col-md-12">
						<label class="control-label"><h4>9.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['9.3'])){ echo Html::encode($arrsection_elements['9.3']); } ?></h4>
						</label>
					</div>
					<div class="col-md-12">
						<div class="">
							<input type="radio" name="TblAcaPlanCoverageType[plantype]"
								value="1"
								<?php
								
if ($model_plan_coverage_type->plan_offer_type == 1) {
									
									?>
								checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No
								Qualifying Plan Offered </span>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						<div class="">
							<input type="radio" name="TblAcaPlanCoverageType[plantype]"
								value="2"
								<?php
								
if ($model_plan_coverage_type->plan_offer_type == 2) {
									?>
								checked <?php } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Self
								Insured </span>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>



						<div class="">
							<input type="radio" name="TblAcaPlanCoverageType[plantype]"
								value="3"
								<?php
								
if ($model_plan_coverage_type->plan_offer_type == 3) {
									?>
								checked <?php } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Fully
								Insured </span>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
						<div class="">
							<input type="radio" name="TblAcaPlanCoverageType[plantype]"
								value="4"
								<?php
								
if ($model_plan_coverage_type->plan_offer_type == 4) {
									?>
								checked <?php } ?>> <span class="control-checkbox">&nbsp;&nbsp;&nbsp;Multi
								Employer Plan </span>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>


						<div class="">
							<input type="radio" name="TblAcaPlanCoverageType[plantype]"
								value="5"
								<?php
								
if ($model_plan_coverage_type->plan_offer_type == 5) {
									?>
								checked <?php } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Combination
								of the options above during the year</span>&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
					</div>
																		<?php if(!empty($arrvalidation_errors[63]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[63]['error_code'].' : '; ?><?php echo $arrvalidation_errors[63]['error_message']; ?></span>
																			<?php }?>
																	</div>

				<div class="" id="combination_div1"
					<?php if($model_plan_coverage_type->plan_offer_type == 5){ ?>
					style="display: block;" <?php }else{ ?> style="display: none;"
					<?php }?>>
																		<?php  $coveragetype= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 8])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');?>
																		<div class="col-xs-12" style="border: 1px solid #ddd;">
						<div class="col-sm-4 padding-left-0">
							<div class="row plan-div-margin">
								<div class="col-sm-3">January</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][1]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['1']) && $arr_offer_types['1']['1'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">January</div>
								<div class="col-sm-9">
																						<?php  $waitingperiod= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 9])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');?>	
																						<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][1]">
										<option value="">Select waiting Period</option>
																							<?php
																							
if (! empty ( $waitingperiod )) {
																								foreach ( $waitingperiod as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['1']) && $arr_offer_types['3']['1'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">April</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][4]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['4']) && $arr_offer_types['1']['4'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">April</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][4]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['4']) && $arr_offer_types['3']['4'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">July</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][7]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['7']) && $arr_offer_types['1']['7'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">July</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][7]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['7']) && $arr_offer_types['3']['7'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">October</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][10]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['10']) && $arr_offer_types['1']['10'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">October</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][10]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['10']) && $arr_offer_types['3']['10'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>
						</div>
						<div class="col-md-4 padding-left-0">

							<div class="row plan-div-margin">
								<div class="col-sm-3">February</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][2]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['2']) && $arr_offer_types['1']['2'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">February</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][2]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['2']) && $arr_offer_types['3']['2'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">May</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][5]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['5']) && $arr_offer_types['1']['5'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">May</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][5]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['5']) && $arr_offer_types['3']['5'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">August</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][8]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['8']) && $arr_offer_types['1']['8'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">August</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][8]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['8']) && $arr_offer_types['3']['8'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>
							<div class="row plan-div-margin">
								<div class="col-sm-3">November</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][11]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['11']) && $arr_offer_types['1']['11'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">November</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][11]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['11']) && $arr_offer_types['3']['11'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>

						</div>
						<div class="col-md-4 padding-left-0 padding-right-0">

							<div class="row plan-div-margin">
								<div class="col-sm-3">March</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][3]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['3']) && $arr_offer_types['1']['3'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">March</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][3]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['3']) && $arr_offer_types['3']['3'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>
							<div class="row plan-div-margin">
								<div class="col-sm-3">June</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][6]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['6']) && $arr_offer_types['1']['6'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">June</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][6]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['6']) && $arr_offer_types['3']['6'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">September</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][9]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['9']) && $arr_offer_types['1']['9'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">September</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][9]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['9']) && $arr_offer_types['3']['9'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>
							<div class="row plan-div-margin">
								<div class="col-sm-3">December</div>
								<div class="col-sm-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[1][12]">
										<option value="">Select Coverage Type</option>
																							<?php
																							
if (! empty ( $coveragetype )) {
																								foreach ( $coveragetype as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['1']['12']) && $arr_offer_types['1']['12'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
								</div>
							</div>

							<div class="row plan-div-margin">
								<div class="col-sm-3">December</div>
								<div class="col-md-9">

									<select class="form-control reset-coverage-type"
										name="Planoffertypeyears[3][12]">
										<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
											<?php if(!empty($arr_offer_types['3']['12']) && $arr_offer_types['3']['12'] == $key) {?>
											selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
								</div>
							</div>

						</div>
					</div>
				</div>




				<div class="" id="combination_div2"
					<?php if($model_plan_coverage_type->plan_offer_type == 2 || $model_plan_coverage_type->plan_offer_type == 3 || $model_plan_coverage_type->plan_offer_type == 4 ){ ?>
					style="display: block;" <?php }else{ ?> style="display:none; "
					<?php }?>>
					<div class="col-md-12" style="border: 1px solid #ddd;">
						<div class="form-group plan-div-margin">

							<div class="col-md-6">
								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 1) {
											
											?>
										checked <?php  } ?> value="1"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Date
										of hire (DOH)</span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>
								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 2) {
											?>
										checked <?php } ?> value="2"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;30
										Days after DOH </span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>
								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 3) {
											?>
										checked <?php } ?> value="3"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;60
										Days after DOH </span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>
								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 4) {
											?>
										checked <?php } ?> value="4"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;90
										Days after DOH </span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>

							</div>

							<div class="col-md-6">
								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 5) {
											?>
										checked <?php } ?> value="5"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
										of Month after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>
								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 6) {
											?>
										checked <?php } ?> value="6"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
										of Month after 30 days after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>

								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 7) {
											?>
										checked <?php } ?> value="7"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
										of Month after 60 days after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>

								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 8) {
											?>
										checked <?php } ?> value="8"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;1st
										of Month after 90 days after DOH</span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>

								<div class="">
									<input type="radio" name="TblAcaPlanCoverageType[doh]"
										class="reset-coverage-type-radio"
										<?php
										
if (isset ( $model_plan_coverage_type->plan_type_doh ) && $model_plan_coverage_type->plan_type_doh == 9) {
											?>
										checked <?php } ?> value="9"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Combination
										of the options above during the year</span>&nbsp;&nbsp;&nbsp;&nbsp;
								</div>
							</div>

						</div>

						<div class="" id="combination_div3"
							<?php if($model_plan_coverage_type->plan_type_doh == 9 ){ ?>
							style="display: block;" <?php }else{ ?> style="display:none; "
							<?php }?>>
							<div class="col-xs-12"
								style="border: 1px solid #ddd; margin-bottom: 15px;">
								<div class="col-md-4 padding-left-0">
																					<?php  $waitingperiod= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 9])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');?>
																		
																						<div class="row plan-div-margin">
										<div class="col-sm-3">January</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][1]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
																									if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['1']) && $arr_offer_types['2']['1'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>

									<div class="row plan-div-margin">
										<div class="col-sm-3">April</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][4]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['4']) && $arr_offer_types['2']['4'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>

									<div class="row plan-div-margin">
										<div class="col-sm-3">July</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][7]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['7']) && $arr_offer_types['2']['7'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>

									<div class="row plan-div-margin">
										<div class="col-sm-3">October</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][10]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['10']) && $arr_offer_types['2']['10'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>
								</div>
								<div class="col-md-4 padding-left-0">

									<div class="row plan-div-margin">
										<div class="col-sm-3">February</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][2]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['2']) && $arr_offer_types['2']['2'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>
									<div class="row plan-div-margin">
										<div class="col-sm-3">May</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][5]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['5']) && $arr_offer_types['2']['5'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>
									<div class="row plan-div-margin">
										<div class="col-sm-3">August</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][8]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['8']) && $arr_offer_types['2']['8'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>
									<div class="row plan-div-margin">
										<div class="col-sm-3">November</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][11]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['11']) && $arr_offer_types['2']['11'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>
								</div>
								<div class="col-md-4 padding-left-0 padding-right-0">

									<div class="row plan-div-margin">
										<div class="col-sm-3">March</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][3]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['3']) && $arr_offer_types['2']['3'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>

									<div class="row plan-div-margin">
										<div class="col-sm-3">June</div>
										<div class="col-sm-9">


											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][6]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['6']) && $arr_offer_types['2']['6'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>

									<div class="row plan-div-margin">
										<div class="col-sm-3">September</div>
										<div class="col-sm-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][9]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['9']) && $arr_offer_types['2']['9'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>

									<div class="row plan-div-margin">
										<div class="col-sm-3">December</div>
										<div class="col-md-9">

											<select class="form-control reset-coverage-type"
												name="Planoffertypeyears[2][12]">
												<option value="">Select Waiting Period</option>
																									<?php
																									
if (! empty ( $waitingperiod )) {
																										foreach ( $waitingperiod as $key => $value ) {
																											?>
																							<option value="<?php echo $key; ?>"
													<?php if(!empty($arr_offer_types['2']['12']) && $arr_offer_types['2']['12'] == $key) {?>
													selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>

																								</select>
										</div>
									</div>
								</div>
							</div>
						</div>



<?php if(!empty($arrvalidation_errors[148]['error_code'])){?>
																		
																				<span class="red col-sm-12"><?php //echo $arrvalidation_errors[65]['error_code'].' : '; ?><?php echo $arrvalidation_errors[148]['error_message']; ?></span>
																			<?php }?>
					</div>

				</div>


				<div class="form-group row plan-div-margin">
					<div class="col-md-12">
						<label class="control-label"><h4>9.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['9.4'])){ echo Html::encode($arrsection_elements['9.4']); } ?></h4>
						</label>
					</div>
					<div class="col-md-12">
						<input type="radio"
							name="TblAcaPlanCoverageType[employeemedicalplan]"
							<?php
							
if (isset ( $model_plan_coverage_type->employee_medical_plan ) && $model_plan_coverage_type->employee_medical_plan == 1) {
								
								?>
							checked <?php  } ?> value="1"><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio"
							name="TblAcaPlanCoverageType[employeemedicalplan]" value="2"
							<?php
							
if (isset ( $model_plan_coverage_type->employee_medical_plan ) && $model_plan_coverage_type->employee_medical_plan == 2) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>


					</div>
																		
																		<?php if(!empty($arrvalidation_errors[64]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[64]['error_code'].' : '; ?><?php echo $arrvalidation_errors[64]['error_message']; ?></span>
																			<?php }?>
																			
																	</div>





				<div class="form-group row plan-div-margin">
					<div class="col-md-12">
						<label class="control-label"><h4>10.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['10.1'])){ echo Html::encode($arrsection_elements['10.1']); } ?></h4>
						</label>
					</div>
					<div class="col-md-12">
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[employee_mv_coverage]"
							value="1"
							<?php
							
if ($model_plan_coverage_type_offered->employee_mv_coverage == 1) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[employee_mv_coverage]"
							value="2"
							<?php
							
if ($model_plan_coverage_type_offered->employee_mv_coverage == 2) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>


					</div>
													<?php if(!empty($arrvalidation_errors[65]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[65]['error_code'].' : '; ?><?php echo $arrvalidation_errors[65]['error_message']; ?></span>
																			<?php }?>
												</div>



				<div class="form-group row years1 plan-div-margin"
													style=" <?php
													
if ($model_plan_coverage_type_offered->employee_mv_coverage == 1) {
														
														?> display: block;<?php }else{ ?> display: none;<?php }?>">
					<div class="col-md-12">
						<label class="control-label"><h4>10.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['10.1.1'])){ echo Html::encode($arrsection_elements['10.1.1']); } ?></h4>
						</label>
					</div>
													
													<?php
													if (! empty ( $model_plan_coverage_type_offered->mv_coverage_months )) {
														$mv_coverage_months_array = explode ( ',', $model_plan_coverage_type_offered->mv_coverage_months );
													}
													?>
													<div class="col-sm-3">

						<div class="checkbox">
							<label><input type="checkbox" onclick="disableyear();"
								id="entire_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][0]"
								value="0"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '0', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>Entire Year</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][1]"
								value="1"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '1', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>January</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][2]"
								value="2"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '2', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>February</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][3]"
								value="3"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '3', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>March</label>
						</div>

						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][4]"
								value="4"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '4', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>April</label>
						</div>

						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][5]"
								value="5"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '5', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>May</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][6]"
								value="6"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '6', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>June</label>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="checkbox">
							<label></label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][7]"
								value="7"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '7', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>July</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][8]"
								value="8"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '8', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>August</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][9]"
								value="9"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '9', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>September</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][10]"
								value="10"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '10', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>October</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][11]"
								value="11"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '11', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>November</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year"
								name="TblAcaPlanCoverageTypeOffered[mv_coverage_months][12]"
								value="12"
								<?php if(!empty($mv_coverage_months_array) && in_array ( '12', $mv_coverage_months_array, TRUE )){ ?>
								checked <?php }?>>December</label>
						</div>

					</div>
													<?php if(!empty($arrvalidation_errors[66]['error_code'])){?>
																		
																				<span class="red col-sm-12"><?php //echo $arrvalidation_errors[66]['error_code'].' : '; ?><?php echo $arrvalidation_errors[66]['error_message']; ?></span>
																			<?php }?>
												</div>



				<div class="form-group row plan-div-margin">
					<div class="col-md-12">
						<label class="control-label"><h4>10.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['10.2'])){ echo Html::encode($arrsection_elements['10.2']); } ?>
															</h4> </label>
					</div>
					<div class="col-md-12">
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[employee_essential_coverage]"
							value="1"
							<?php
							
if ($model_plan_coverage_type_offered->employee_essential_coverage == 1) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[employee_essential_coverage]"
							value="2"
							<?php
							
if ($model_plan_coverage_type_offered->employee_essential_coverage == 2) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>


					</div>
													<?php if(!empty($arrvalidation_errors[67]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[67]['error_code'].' : '; ?><?php echo $arrvalidation_errors[67]['error_message']; ?></span>
																			<?php }?>
												</div>


				<div class="form-group row years2 plan-div-margin"
													style=" <?php
													
if ($model_plan_coverage_type_offered->employee_essential_coverage == 1) {
														
														?> display: block;<?php }else{ ?> display: none;<?php }?>">
					<div class="col-md-12">
						<label class="control-label"><h4>10.2.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['10.2.1'])){ echo Html::encode($arrsection_elements['10.2.1']); } ?></h4>
						</label>
					</div>
													
													<?php
													if (! empty ( $model_plan_coverage_type_offered->essential_coverage_months )) {
														$employee_essential_coverage_array = explode ( ',', $model_plan_coverage_type_offered->essential_coverage_months );
													}
													?>
													
													<div class="col-sm-3">

						<div class="checkbox">
							<label><input type="checkbox" onclick="disableyear1();"
								id="entire_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][0]"
								value="0"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '0', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>Entire Year</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][1]"
								value="1"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '1', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>January</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][2]"
								value="2"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '2', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>February</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][3]"
								value="3"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '3', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>March</label>
						</div>

						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][4]"
								value="4"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '4', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>April</label>
						</div>

						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][5]"
								value="5"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '5', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>May</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][6]"
								value="6"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '6', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>June</label>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="checkbox">
							<label></label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][7]"
								value="7"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '7', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>July</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][8]"
								value="8"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '8', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>August</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][9]"
								value="9"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '9', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>September</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][10]"
								value="10"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '10', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>October</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][11]"
								value="11"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '11', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>November</label>
						</div>
						<div class="checkbox">
							<label><input type="checkbox" class="specific_year1"
								name="TblAcaPlanCoverageTypeOffered[essential_coverage_months][12]"
								value="12"
								<?php if(!empty($employee_essential_coverage_array) && in_array ( '12', $employee_essential_coverage_array, TRUE )){ ?>
								checked <?php }?>>December</label>
						</div>

					</div>
													
													<?php if(!empty($arrvalidation_errors[68]['error_code'])){?>
																		
																				<span class="red col-sm-12"><?php //echo $arrvalidation_errors[68]['error_code'].' : '; ?><?php echo $arrvalidation_errors[68]['error_message']; ?></span>
																			<?php }?>
												</div>


				<div class="form-group row plan-div-margin">
					<div class="col-md-12">
						<label class="control-label"><h4>10.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['10.3'])){ echo Html::encode($arrsection_elements['10.3']); } ?>
															</h4> </label>
					</div>
					<div class="col-md-12">
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[spouse_essential_coverage]"
							value="1"
							<?php
							
if ($model_plan_coverage_type_offered->spouse_essential_coverage == 1) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[spouse_essential_coverage]"
							value="2"
							<?php
							
if ($model_plan_coverage_type_offered->spouse_essential_coverage == 2) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>


					</div>
													
													<?php if(!empty($arrvalidation_errors[69]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[69]['error_code'].' : '; ?><?php echo $arrvalidation_errors[69]['error_message']; ?></span>
																			<?php }?>
												</div>


				<div
					class="form-group row plan-div-margin 
												<?php
												
if (! empty ( $model_plan_coverage_type_offered->spouse_essential_coverage ) && $model_plan_coverage_type_offered->spouse_essential_coverage == 2) {
													
													?> 
												hide <?php }elseif (empty($model_plan_coverage_type_offered->spouse_essential_coverage)){ ?>hide<?php }?>"
					id="spouse_conditional_coverage_div">
					<div class="col-md-12">
						<label class="control-label"><h4>10.3.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['10.3.1'])){ echo Html::encode($arrsection_elements['10.3.1']); } ?></h4></label>
					</div>
					<div class="col-md-12">
						<input type="radio" class="spouse-conditional-coverage-radio"
							name="TblAcaPlanCoverageTypeOffered[spouse_conditional_coverage]"
							value="1"
							<?php
							
if ($model_plan_coverage_type_offered->spouse_conditional_coverage == 1) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" class="spouse-conditional-coverage-radio"
							name="TblAcaPlanCoverageTypeOffered[spouse_conditional_coverage]"
							value="2"
							<?php
							
if ($model_plan_coverage_type_offered->spouse_conditional_coverage == 2) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>


					</div>
													<?php if(!empty($arrvalidation_errors[70]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[70]['error_code'].' : '; ?><?php echo $arrvalidation_errors[70]['error_message']; ?></span>
																			<?php }?>
												</div>

				<div class="form-group row plan-div-margin" id="">
					<div class="col-md-12">
						<label class="control-label"><h4>10.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['10.4'])){ echo Html::encode($arrsection_elements['10.4']); } ?></h4>
						</label>
					</div>
					<div class="col-md-12">
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[dependent_essential_coverage]"
							value="1"
							<?php
							
if ($model_plan_coverage_type_offered->dependent_essential_coverage == 1) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio"
							name="TblAcaPlanCoverageTypeOffered[dependent_essential_coverage]"
							value="2"
							<?php
							
if ($model_plan_coverage_type_offered->dependent_essential_coverage == 2) {
								
								?>
							checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>


					</div>
													
													<?php if(!empty($arrvalidation_errors[71]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[71]['error_code'].' : '; ?><?php echo $arrvalidation_errors[71]['error_message']; ?></span>
																			<?php }?>

												</div>


				<div>
<?php
if (! ($model_plan_coverage_type_offered->isNewRecord)) {
	?>
													<div class="form-group">
						<div class="col-sm-12">
							<span class="control-label">
								<h4>"Pay or Play" rule require employees to offer coverage that
									is affordable based upon a percentage of each employee's
									household income. Employers would rarely know this number, so
									the IRS allows for assumptions to be made called "safe harbors"</h4>
								<h4>11.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['11.1'])){ echo Html::encode($arrsection_elements['11.1']); } ?></h4>

								<div>
									<input name="TblAcaEmpContributions[safe_harbor]"
										id="lock-back-method"
										<?php
	
if ($model_plan_emp_contributions->safe_harbor == 1) {
		
		?>
										checked <?php  } ?> type="radio" value="1">&nbsp;&nbsp;&nbsp;&nbsp;
									<span class="control-checkbox">Assume W2 earnings is household
										earnings (W2 safe harbor)</span> &nbsp;&nbsp;&nbsp;&nbsp;
								</div>

								<div>
									<input name="TblAcaEmpContributions[safe_harbor]" type="radio"
										<?php
	
if ($model_plan_emp_contributions->safe_harbor == 2) {
		
		?>
										checked <?php  } ?> value="2">&nbsp;&nbsp;&nbsp;&nbsp; <span
										class="control-checkbox">Assume household earnings meets
										federal poverty line (federal poverty line safe harbor)</span>
								</div>

								<div>
									<input name="TblAcaEmpContributions[safe_harbor]" type="radio"
										<?php
	
if ($model_plan_emp_contributions->safe_harbor == 3) {
		
		?>
										checked <?php  } ?> value="3">&nbsp;&nbsp;&nbsp;&nbsp; <span
										class="control-checkbox">Use employee's rate of pay to
										determine household earnings (rate of pay safe harbor)</span>
								</div>

								<div>
									<input name="TblAcaEmpContributions[safe_harbor]" type="radio"
										<?php
	
if ($model_plan_emp_contributions->safe_harbor == 4) {
		
		?>
										checked <?php  } ?> value="4">&nbsp;&nbsp;&nbsp;&nbsp; <span
										class="control-checkbox">Do not apply a safe harbor to this
										plan class</span>
								</div>

							</span>

						</div>
														<?php if(!empty($arrvalidation_errors[72]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[72]['error_code'].' : '; ?><?php echo $arrvalidation_errors[72]['error_message']; ?></span>
																			<?php }?>
													</div>
													<?php } ?>

													<?php
													
													if (! ($model_plan_coverage_type_offered->isNewRecord)) {
														
														?>
													<div class="form-group">
						<div class="col-sm-12">
							<label class="control-label"><h4>11.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['11.2'])){ echo Html::encode($arrsection_elements['11.2']); } ?></h4>

								<input type="radio"
								name="TblAcaEmpContributions[employee_plan_contribution]"
								class="" value="1"
								<?php
														
														if ($model_plan_emp_contributions->employee_plan_contribution == 1) {
															
															?>
								checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio"
								name="TblAcaEmpContributions[employee_plan_contribution]"
								class="" value="2"
								<?php
														
if ($model_plan_emp_contributions->employee_plan_contribution == 2) {
															
															?>
								checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
							</label>
						</div>
														
														<?php if(!empty($arrvalidation_errors[73]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[73]['error_code'].' : '; ?><?php echo $arrvalidation_errors[73]['error_message']; ?></span>
																			<?php }?>
													</div>

					<div class="form-group" id="lowest_cost_div"
														style="<?php if($model_plan_emp_contributions->employee_plan_contribution == 1){?>display: block;<?php }else{ ?>display: none;<?php }?>">
						<div class="col-sm-12">
							<span class="control-label"><h4>11.2.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['11.2.1'])){ echo Html::encode($arrsection_elements['11.2.1']); } ?></h4>
								<div class="col-sm-12 padding-left-0">

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>January</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_jan = '0.00';
														} else {
															;
															$emp_jan = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '1' );
														}
														?>
																					
																			<input type="text"
												name="TblAcaEmpContributionsPremium[premium_value][1]"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												value="<?php echo $emp_jan; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>February</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_feb = '0.00';
														} else {
															$emp_feb = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '2' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][2]"
												value="<?php echo $emp_feb; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>March</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span>
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_mar = '0.00';
														} else {
															$emp_mar = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '3' );
														}
														?>
																			 <input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][3]"
												value="<?php echo $emp_mar; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>April</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_apr = '0.00';
														} else {
															$emp_apr = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '4' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][4]"
												value="<?php echo $emp_apr; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0 ">
										<span class=""><h4>May</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_may = '0.00';
														} else {
															$emp_may = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '5' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][5]"
												value="<?php echo $emp_may; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>June</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_jun = '0.00';
														} else {
															$emp_jun = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '6' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][6]"
												value="<?php echo $emp_jun; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>July</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_jul = '0.00';
														} else {
															$emp_jul = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '7' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][7]"
												value="<?php echo $emp_jul; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>August</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span>
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_aug = '0.00';
														} else {
															$emp_aug = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '8' );
														}
														?>
																			 <input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][8]"
												value="<?php echo $emp_aug; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>September</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span>
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_sep = '0.00';
														} else {
															$emp_sep = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '9' );
														}
														?>
																			 <input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][9]"
												value="<?php echo $emp_sep; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>October</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_oct = '0.00';
														} else {
															$emp_oct = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '10' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][10]"
												value="<?php echo $emp_oct; ?>" maxlength="10">
										</div>
									</div>

									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>November</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_nov = '0.00';
														} else {
															$emp_nov = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '11' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][11]"
												value="<?php echo $emp_nov; ?>" maxlength="10">
										</div>
									</div>
									<div class="col-sm-6 padding-left-0">
										<span class=""><h4>December</h4></span>
										<div class="input-group ">
											<span class="input-group-addon">$ </span> 
																			<?php
														if (! empty ( $model_plan_emp_contributions_premium->isNewRecord )) {
															$emp_dec = '0.00';
														} else {
															$emp_dec = $model_plan_emp_contributions_premium->getPremiumvalue ( $model_plan_emp_contributions->emp_contribution_id, '12' );
														}
														?>
																			<input type="text"
												class="form-control form-height price reset-emp-contribution"
												onClick="clearamount(this.name);"
												onfocusout="defaultamount(this.name);"
												name="TblAcaEmpContributionsPremium[premium_value][12]"
												value="<?php echo $emp_dec; ?>" maxlength="10">
										</div>
									</div>




								</div> </span>
						</div>
														
														<?php if(!empty($arrvalidation_errors[74]['error_code'])){?>
																		
																				<span class="red col-sm-6"><?php //echo $arrvalidation_errors[74]['error_code'].' : '; ?><?php echo $arrvalidation_errors[74]['error_message']; ?></span>
																			<?php }?>
													</div>
<?php } ?>
												</div>
				<div></div>

			</div>
			
										<?php ActiveForm::end(); ?>
		</div>

	</div>
</div>
