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
	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/planinfo.js"></script>

<link rel="stylesheet"
	href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/planinfo.css">

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
			<div class="col-md-12">
				<div class="box box-solid">

					<!-- /.box-header -->
					<div class="box-body">

						<div class="box-group" id="accordion">
							<div class="" id="meccoverage">




<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/generalplaninfo?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'general_plan_information']]); ?>
					
								<div class="box-body">


									<div class="">
										<div class="">
											<div class="col-md-6 box-footer">
												<font size="4"><b>Validate Report ( General Plan Info )</b></font>
											</div>
											<div class=" col-md-6 box-footer pull-right padding-right-0"
												style="text-align: right;">


												<button type="submit"
													class="btn btn-primary mec-coverage-btn" name="button"
													value="continue">Update</button>
												<a class="btn btn-default btn-default-cancel"
													href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms?c_id=<?php echo $company_id;?>">Cancel</a>

											</div>
											<div class="col-md-12" style="border: 1px solid #ada7a7;">

												<!-- /.box-header -->
												<!-- form start -->

												<div class="">
													<div class="">


														<div class="form-group">
															<div class="col-sm-12">
																<label class="control-label"><h4>7.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.1'])){ echo Html::encode($arrsection_elements['7.1']); } ?></h4>
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[is_first_year]" value="1"
																	<?php if(!empty($model_general_plan_info->is_first_year) && $model_general_plan_info->is_first_year==1){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[is_first_year]" value="2"
																	<?php if(!empty($model_general_plan_info->is_first_year) && $model_general_plan_info->is_first_year==2){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
																</label> 
																<?php if(!empty($arrvalidation_errors[55]['error_code'])){?>
																<span
																	class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[55]['error_code'].' : '; ?><?php echo $arrvalidation_errors[55]['error_message']; ?></span>
																	<?php }?>
															</div>
														</div>




														<div class="form-group">
															<div class="col-sm-12">
																<label class="control-label"><h4>7.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.2'])){ echo Html::encode($arrsection_elements['7.2']); } ?>
                  </h4></label> <select class="form-control form-height"
																	style="width: 50%;"
																	name="TblAcaGeneralPlanInfo[renewal_month]">
																	<option value="">Select a Value</option>
																		<option value="1"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==1){ ?>
																			selected <?php }?>>January</option>
																		<option value="2"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==2){ ?>
																			selected <?php }?>>February</option>
																		<option value="3"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==3){ ?>
																			selected <?php }?>>March</option>
																		<option value="4"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==4){ ?>
																			selected <?php }?>>April</option>
																		<option value="5"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==5){ ?>
																			selected <?php }?>>May</option>
																		<option value="6"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==6){ ?>
																			selected <?php }?>>June</option>
																		<option value="7"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==7){ ?>
																			selected <?php }?>>July</option>
																		<option value="8"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==8){ ?>
																			selected <?php }?>>August</option>
																		<option value="9"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==9){ ?>
																			selected <?php }?>>September</option>
																		<option value="10"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==10){ ?>
																			selected <?php }?>>October</option>
																		<option value="11"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==11){ ?>
																			selected <?php }?>>November</option>
																		<option value="12"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==12){ ?>
																			selected <?php }?>>December</option>
																		<option value="13"
																			<?php if(!empty($model_general_plan_info->renewal_month) && $model_general_plan_info->renewal_month==13){ ?>
																			selected <?php }?>>Not Applicable</option>
																</select> 
															</div>
<?php if(!empty($arrvalidation_errors[56]['error_code'])){?>
															<span class="red col-sm-12 "><?php //echo $arrvalidation_errors[56]['error_code'].' : '; ?><?php echo $arrvalidation_errors[56]['error_message']; ?></span>
														<?php } ?>
														</div>



														<div class="form-group">
															<div class="col-sm-12">
																<label class="control-label"><h4>7.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.4'])){ echo Html::encode($arrsection_elements['7.4']); } ?></h4>
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[is_multiple_waiting_periods]"
																	value="1"
																	<?php if(!empty($model_general_plan_info->is_multiple_waiting_periods) && $model_general_plan_info->is_multiple_waiting_periods==1){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[is_multiple_waiting_periods]"
																	value="2"
																	<?php if(!empty($model_general_plan_info->is_multiple_waiting_periods) && $model_general_plan_info->is_multiple_waiting_periods==2){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
																</label>
															</div>
														</div>
														<?php if(!empty($arrvalidation_errors[57]['error_code'])){?>
														<span class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[57]['error_code'].' : '; ?><?php echo $arrvalidation_errors[57]['error_message']; ?></span>
              											<?php } ?>
              
              
			 <div class="form-group explain" style="<?php if(!empty($model_general_plan_info->is_multiple_waiting_periods) && $model_general_plan_info->is_multiple_waiting_periods==1){ ?>display:block; <?php }else{?>display:none;<?php }?>">
															<div class="col-sm-12">
																<div class="col-md-5 padding-left-0">
																	<label class="control-label"><h4>7.4.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.4.1'])){ echo $arrsection_elements['7.4.1']; } ?></h4></label>
                   
                    <?php echo $form->field($model_general_plan_info, 'multiple_description')->label(false)->textarea(array('rows'=>2,'cols'=>4,'class'=>'form-control form-height','maxlength'=>'100','onkeypress'=>'return lookupoption(event);' )); ?>
                  </div><?php if(!empty($arrvalidation_errors[58]['error_code'])){?>
																<span
																	class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[58]['error_code'].' : '; ?><?php echo $arrvalidation_errors[58]['error_message']; ?></span>
															<?php } ?>
															</div>
														</div>



														<div class="form-group">
															<div class="col-sm-12">
																<label class="control-label"><h4>7.5&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.5'])){ echo Html::encode($arrsection_elements['7.5']); } ?></h4>
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[is_employees_hra]"
																	value="1"
																	<?php if(!empty($model_general_plan_info->is_employees_hra) && $model_general_plan_info->is_employees_hra==1){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[is_employees_hra]"
																	value="2"
																	<?php if(!empty($model_general_plan_info->is_employees_hra) && $model_general_plan_info->is_employees_hra==2){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
																</label> 
																<?php if(!empty($arrvalidation_errors[59]['error_code'])){?>
																<span
																	class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[59]['error_code'].' : '; ?><?php echo $arrvalidation_errors[59]['error_message']; ?></span>
																	<?php } ?>
															</div>
														</div>



														<div class="form-group text_hra" style="
				<?php if(!empty($model_general_plan_info->is_employees_hra) && $model_general_plan_info->is_employees_hra==1){ ?>display:block; <?php }else{?>display:none;<?php }?>">
															<div class="col-sm-12">
																<label class="control-label"><h4>7.5.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.5.1'])){ echo Html::encode($arrsection_elements['7.5.1']); } ?> (Optional)</h4></label>

															</div>
														</div>


														<div class="form-group">
															<div class="col-sm-12">
																<label class="control-label"><h4>7.6&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.6'])){ echo Html::encode($arrsection_elements['7.6']); } ?></h4>
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[offer_type]" value="1"
																	<?php if(!empty($model_general_plan_info->offer_type) && $model_general_plan_info->offer_type==1){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	<input type="radio"
																	name="TblAcaGeneralPlanInfo[offer_type]" value="2"
																	<?php if(!empty($model_general_plan_info->offer_type) && $model_general_plan_info->offer_type==2){ ?>
																	checked <?php }?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
																</label> 
																<?php if(!empty($arrvalidation_errors[60]['error_code'])){?>
																<span
																	class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[60]['error_code'].' : '; ?><?php echo $arrvalidation_errors[60]['error_message']; ?></span>
																<?php } ?>

															</div>

															<div class="col-sm-12" id="combination_div1" style="margin-top: 15px;<?php if(!empty($model_general_plan_info->offer_type) && $model_general_plan_info->offer_type==1){ ?>display:block;<?php }else{?>display:none; <?php }?>">
																<div class="col-xs-12 padding-left-0 padding-right-0"
																	style="border: 1px solid #ddd;">
																	<div class="col-sm-4">
																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">January</div>
																					<?php  $planoffer= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 8])->andwhere(['<>', 'lookup_id', 62])->all(), 'lookup_id', 'lookup_value');?>	
																					<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][1]">
																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['1']) && $arrsection_months['1'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																							
																						</select>
																			</div>
																		</div>

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">April</div>
																			<div class="col-sm-9">



																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][2]">

																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['2']) && $arrsection_months['2'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																			</div>
																		</div>

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">July</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][3]">
																					<option value="0">Select a Plan</option>																					
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['3']) && $arrsection_months['3'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																							</select>
																			</div>
																		</div>

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">October</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][4]">

																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['4']) && $arrsection_months['4'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																							
																						</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4 padding-left-0">

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">February</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][5]">
																					<option value="0">Select a Plan</option>																					
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['5']) && $arrsection_months['5'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																							</select>
																			</div>
																		</div>
																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">May</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][6]">

																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['6']) && $arrsection_months['6'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																			</div>
																		</div>
																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">August</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][7]">

																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['7']) && $arrsection_months['7'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																							
																						</select>
																			</div>
																		</div>
																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">November</div>
																			<div class="col-sm-9">



																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][8]">

																					<option value="0">Select a Plan</option>
																								<?php
																								
																								if (! empty ( $planoffer )) {
																									foreach ( $planoffer as $key => $value ) {
																										?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['8']) && $arrsection_months['8'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																			</div>
																		</div>
																	</div>
																	<div class="col-md-4 padding-left-0">

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">March</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value "
																					name="TblAcaGeneralPlanMonths[plan_value][9]">

																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['9']) && $arrsection_months['9'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																			</div>
																		</div>

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">June</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][10]">
																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['10']) && $arrsection_months['10'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																			</div>
																		</div>

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">September</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][11]">
																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['11']) && $arrsection_months['11'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																			</div>
																		</div>

																		<div class="row mar-top-bottom">
																			<div class="col-sm-3">December</div>
																			<div class="col-sm-9">

																				<select class="form-control plan_value"
																					name="TblAcaGeneralPlanMonths[plan_value][12]">
																					<option value="0">Select a Plan</option>
																							<?php
																							
																							if (! empty ( $planoffer )) {
																								foreach ( $planoffer as $key => $value ) {
																									?>
																							<option value="<?php echo $key; ?>"
																						<?php if(!empty($arrsection_months['12']) && $arrsection_months['12'] == $key) {?>
																						selected <?php }?>><?php echo $value; ?></option>
																							<?php }} ?>
																						</select>
																			</div>
																		</div>
																	</div>
																</div>
																		<?php if(!empty($arrvalidation_errors[61]['error_code'])){?>
																		<span
																	class="red col-sm-12 padding-left-0 padding-right-0"><?php //echo $arrvalidation_errors[61]['error_code'].' : '; ?><?php echo $arrvalidation_errors[61]['error_message']; ?></span>
																		<?php } ?>
																	</div>

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