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
	href="<?php // echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/planinfo.css">

<div class="box box-warning container-fluid padding-responsive">
	<div class="box-header with-border">
		<h3 class="box-title col-xs-6">General Plan Information - <?php echo Html::encode($company_details->company_name); ?> <small>(<?php echo Html::encode($company_details->company_client_number);?>)</small>
		</h3>
		<div class="col-xs-6 pull-right">
			<a class=" btn bg-orange btn-flat btn-social pull-right" data-toggle="tooltip" data-placement="bottom" title="Click to view help video"
				onclick="playVideo(4);"> <i class="fa fa-youtube-play"></i>View Help
				Video
			</a>
		</div>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i
			class="fa fa-file-text-o icon-band lighter"></i></span>
		<p class="sub-header-new">Below is the form to capture general plan
			information.</p>
	</div>
	<div class="col-md-12 ">



		<div class="row">
			<div class="col-md-12">
				<div class="box box-solid">

					<!-- /.box-header -->
					<div class="box-body">
						<div class="box-group" id="accordion">
							<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
							<div class="panel  box " id="generalplaninformation">
								<div
									class="parent-tabs box-header with-border accordian-band-color">

									<span id="step" class="steps col-xs-2" onclick="editbasic();">
										<span class="check display-none"> <i class="fa fa-check"
											aria-hidden="true"></i> <span class="">7</span>
									</span> <span class="edit display-none">Edit</span>
									</span>

									<h4 class="box-title col-sm-6 col-xs-10">
										<div class="fixed-number col-sm-1 col-xs-2" style="top: 3px;">
											<span class="block-number">7</span>
										</div>
										<a class="custom-bg col-sm-11 col-xs-10 padding-left-0"
											onclick="editbasic();" data-parent="#accordion"> General Plan
											Information </a>
									</h4>

									<div class="box-title col-xs-3 pull-right pad-top-7">
										<p class="custom-bg summary-text pull-right font-size-12"></p>
									</div>

								</div>
								<div id="collapseOne"
									class="panel-collapse collapse in bg-white black panel-collapse">
									<div class="box-body">
										<p class="highlight-fancy">
											<span class="status"><i class="fa fa-info-circle"
												aria-hidden="true"></i></span> Fill the General Plan
											information

										</p>

										<div class="row">
											<div class="col-md-12">
							<?php $form = ActiveForm::begin(['action' => ['/client/benefit/saveplaninformation?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'general_plan_information']]); ?>
							<div class=" box-info">

													<!-- /.box-header -->
													<!-- form start -->

													<div class="box-body padding-right-0">
														<div class="col-xs-offset-1 col-xs-10">
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
																</div>
															</div>

															<div class="form-group">
																<div class="col-sm-12">
																	<label class="control-label"><h4>7.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.2'])){ echo Html::encode($arrsection_elements['7.2']); } ?>
                  </h4> </label><select class="form-control form-height"
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
															</div>

															<div class="form-group">
																<div class="col-sm-12">
																	<label class="control-label"><h4>7.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.3'])){ echo Html::encode($arrsection_elements['7.3']); } ?>
                  </h4></label>
																	<div class="col-md-5">
                    <?php echo $form->field($model_general_plan_info, 'plan_type_description')->label(false)->textarea(array('rows'=>2,'cols'=>4,'class'=>'form-control form-height','maxlength'=>'100','onkeypress'=>'return lookupoption(event);' )); ?>
					</div>
																</div>
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

															<div class="form-group explain" style="<?php if(!empty($model_general_plan_info->is_multiple_waiting_periods) && $model_general_plan_info->is_multiple_waiting_periods==1){ ?>display:block; <?php }else{?>display:none;<?php }?>">
																<div class="col-sm-12">
																	<div class="col-md-5 padding-left-0">
																		<label class="control-label"><h4>7.4.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.4.1'])){ echo $arrsection_elements['7.4.1']; } ?></h4></label>
                   
                    <?php echo $form->field($model_general_plan_info, 'multiple_description')->label(false)->textarea(array('rows'=>2,'cols'=>4,'class'=>'form-control form-height','maxlength'=>'100','onkeypress'=>'return lookupoption(event);' )); ?>
                  </div>
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
																</div>
															</div>



															<div class="form-group text_hra" style="
				<?php if(!empty($model_general_plan_info->is_employees_hra) && $model_general_plan_info->is_employees_hra==1){ ?>display:block; <?php }else{?>display:none;<?php }?>">
																<div class="col-sm-12">
																	<label class="control-label"><h4>7.5.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['7.5.1'])){ echo Html::encode($arrsection_elements['7.5.1']); } ?></h4></label>

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
																</div>

															</div>

														</div>


													</div>

													<div class="box-footer pull-right padding-right-0">
														<a class="btn btn-default btn-default-cancel"
															href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
				<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success coverage-type-btn' ,'name' => 'button','value'=>'exit'])?>
    	
				<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success coverage-type-btn' ,'name' => 'button','value'=>'continue'])?>
    	
    	
			<!-- 	<a  class="btn btn-default btn-default-cancel"  href="#">Cancel</a>
				<a  class="btn btn-success " href="#">Save and Exit</a>
                <button type="button" data-toggle="collapse" href="#collapseOne" onclick="basic()" class="btn btn-success">Save and Continue</button> -->
													</div>
												</div>
              								<?php ActiveForm::end(); ?>
              <!-- /.box-body -->

												<!-- /.box-footer -->

											</div>

										</div>



									</div>
								</div>



							</div>
						</div>
						<div class="box-group" id="accordion">
							<div class="panel box " id="meccoverage">
								<div class="parent-tabs box-header with-border">
									<span id="step1" class="steps col-xs-2" onclick="editbasic1()">
										<span class="check display-none"> <i class="fa fa-check"
											aria-hidden="true"></i> <span class="">8</span>
									</span> <span class="edit display-none">Edit</span>
									</span>

									<h4 class="box-title col-sm-6 col-xs-10">
										<div class="fixed-number col-sm-1 col-xs-2" style="top: 3px;">
											<span class="block-number">8</span>
										</div>
										<a class="custom-bg col-sm-11 col-xs-10 padding-left-0"
											onclick="editbasic1();" data-parent="#accordion"> MEC
											Coverage </a>
									</h4>

									<div class="box-title col-xs-3 pull-right pad-top-7">
										<p class="custom-bg summary-text pull-right font-size-12"></p>
									</div>

								</div>



								<div id="collapseTwo"
									class="panel-collapse collapse bg-white black panel-collapse">
									<div class="box-body">
										<p class="highlight-fancy">
											<span class="status"><i class="fa fa-info-circle"
												aria-hidden="true"></i></span> Specify the MEC Coverage
											period

										</p>

										<div class="row">
											<div class="col-md-12">
					 <?php $form = ActiveForm::begin(['action' => ['/client/benefit/savemeccoverage?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'mec_coverage_information']]); ?>
                   
                   		<div class=" box-info">

													<div class="box-body padding-right-0">


														<div class="col-md-offset-1 col-md-10 padding-right-0">

															<div class="form-group">
																<div class="col-sm-12 padding-right-0 padding_left-0">
																	<label class="control-label"><h4 class="margin">8.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['8.1'])){ echo Html::encode($arrsection_elements['8.1']); } ?></h4>
																	</label>
																	<ul>
																		<li>
																			<h4 class="margin control-label">For 2015 reporting,
																				you must have offered MEC to at least 70% of your
																				full time employees during the month.</h4>
																		</li>
																		<li>
																			<h4 class="margin control-label bullet2">For 2016
																				reporting, you must have offered MEC to at least 95%
																				of your full time employees during the month</h4>
																		</li>
																	</ul>
				   	<?php
								if (! empty ( $model_mec_coverage->mec_months )) {
									$model_mec_coverage_array = explode ( ',', $model_mec_coverage->mec_months );
								}
								
								?>
				   <div class="col-sm-12">
																		<div class="checkbox">
																			<label><input type="checkbox"
																				onclick="disableyear();" id="entire_year"
																				name="TblAcaMecCoverage[mec_months][0]" value="0"
																				<?php if($model_mec_coverage->mec_months!='' && $model_mec_coverage->mec_months==0){ ?>
																				checked <?php }?>><span class="control-checkbox">Entire
																					Year</span></label>
																		</div>
																	</div>
																	<div class="col-sm-3">


																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][1]" value="1"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '1', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php  }?>><span class="control-checkbox">January</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][2]" value="2"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '2', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php }?>><span class="control-checkbox">February</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][3]" value="3"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '3', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php }?>><span class="control-checkbox">March</span></label>
																		</div>

																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][4]" value="4"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '4', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php }?>><span class="control-checkbox">April</span></label>
																		</div>

																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][5]" value="5"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '5', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php  }?>><span class="control-checkbox">May</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][6]" value="6"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '6', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php  }?>><span class="control-checkbox">June</span></label>
																		</div>
																	</div>

																	<div class="col-sm-3">
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][7]" value="7"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '7', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php  }?>><span class="control-checkbox">July</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][8]" value="8"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '8', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php  }?>><span class="control-checkbox">August</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][9]" value="9"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '9', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php }?>><span class="control-checkbox">September</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][10]" value="10"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '10', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php }?>><span class="control-checkbox">October</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][11]" value="11"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '11', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php }?>><span class="control-checkbox">November</span></label>
																		</div>
																		<div class="checkbox">
																			<label><input type="checkbox" class="specific_year"
																				name="TblAcaMecCoverage[mec_months][12]" value="12"
																				<?php if(!empty($model_mec_coverage_array) && in_array ( '12', $model_mec_coverage_array, TRUE )){ ?>
																				checked <?php }?>><span class="control-checkbox">December</span></label>
																		</div>

																	</div>

																</div>
															</div>





														</div>



													</div>

												</div>

												<div class=" box-footer pull-right padding-right-0">

													<a class="btn btn-default btn-default-cancel"
														href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard?c_id=<?php echo $company_id;?>">Cancel</a>
				<?= Html::submitButton('Save and Exit' , ['class' =>   'btn btn-success mec-coverage-btn' ,'name' => 'button','value'=>'exit'])?>
    	
				<?= Html::submitButton('Save and Continue' , ['class' =>   'btn btn-success mec-coverage-btn' ,'name' => 'button','value'=>'continue'])?>
    	
              </div>
											</div>
                  <?php ActiveForm::end(); ?>
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

<script>
$( document ).ready(function() {
   <?php if($model_mec_coverage->mec_months!='' && $model_mec_coverage->mec_months==0){?>
$(".specific_year").attr("disabled",true)
   <?php }?>
   

	 $("#benefit_plan_info_menu_main").addClass("active");
	 $("#benefit_plan_info_menu_main_treeview").addClass("open");
	

});





$(window).load(function() {
	checkarraydiv();
});


function checkarraydiv()
{

 <?php 

 $plan_div = array();
	  if(!empty($model_general_plan_info->general_plan_id))
	  {
	  	$plan_div[] = "1";
		
		
	  }
	
	  if(!empty($model_mec_coverage->mec_id))
	  {
	  	$plan_div[] = "2";
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
       
        
    }

    }

	
		    
}

</script>



