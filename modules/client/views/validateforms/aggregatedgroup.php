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
			<div class="">
				<div class="box box-solid">

					<!-- /.box-header -->
					<div class="box-body">

						<div class="box-group" id="accordion">
							<div class="" id="meccoverage">



<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/saveaggregatedgroup?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'emp_status_form']]); ?>

								<div class="box-body">


									<div class="">
										<div class="col-md-6 box-footer">
											<font size="4"><b>Validate Report ( Aggregated Group )</b></font>
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


											<div class="">


												<div class="">
									
									<?php
									
									//if (in_array ( 49, $arrvalidations, TRUE )) {
										?>
										<div class="form-group row"
														style="margin-top: 10px; margin-bottom: 20px;">
														<div class="col-sm-12">
															<label class="control-label"><h4>5.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.1'])){ echo Html::encode($arrsection_elements['5.1']); } ?></h4>
															</label>
														</div>
														<div class="col-sm-6">
															<input type="radio"
																name="TblAcaAggregatedGroup[is_authoritative_transmittal]"
																value="1"
																<?php
										
if (isset ( $model_aggregated_group->is_authoritative_transmittal ) && $model_aggregated_group->is_authoritative_transmittal == 1) {
											
											?>
																checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio"
																name="TblAcaAggregatedGroup[is_authoritative_transmittal]"
																value="2"
																<?php
										
if (isset ( $model_aggregated_group->is_authoritative_transmittal ) && $model_aggregated_group->is_authoritative_transmittal == 2) {
											
											?>
																checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>

														</div>
											<?php if(!empty($arrvalidation_errors[49]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[49]['error_code'].' : '; ?><?php echo $arrvalidation_errors[49]['error_message']; ?></span>
																	<?php }?>
										</div>

													<div class="form-group row is-authoritative-transmittal-no"
													style="margin-top: 10px; margin-bottom: 20px; <?php
										
if (isset ( $model_aggregated_group->is_authoritative_transmittal ) && $model_aggregated_group->is_authoritative_transmittal == 2) {
											
											?> display: block;<?php }else {?> display: none;<?php }?>">
														<div class="col-sm-12">
															<label class="control-label"><h4>5.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.1.1'])){ echo Html::encode($arrsection_elements['5.1.1']); } ?> (Optional)</h4>
															</label>
														</div>
													</div>
<?php //}?>
	<?php if(in_array ( 50, $arrvalidations, TRUE ) || in_array ( 51, $arrvalidations, TRUE ) || in_array ( 52, $arrvalidations, TRUE ) || in_array ( 53, $arrvalidations, TRUE )  || in_array ( 54, $arrvalidations, TRUE )){?>
										<div class="form-group row"
														style="margin-top: 10px; margin-bottom: 20px;">
														<div class="col-sm-12">
															<label class="control-label"><h4>5.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2'])){ echo Html::encode($arrsection_elements['5.2']); } ?></h4>
															</label>
														</div>
														<div class="col-sm-6">
															<input type="radio"
																name="TblAcaAggregatedGroup[is_ale_member]" value="1"
																<?php
		
if (isset ( $model_aggregated_group->is_ale_member ) && $model_aggregated_group->is_ale_member == 1) {
			
			?>
																checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
															<input type="radio"
																name="TblAcaAggregatedGroup[is_ale_member]" value="2"
																<?php
		
if (isset ( $model_aggregated_group->is_ale_member ) && $model_aggregated_group->is_ale_member == 2) {
			
			?>
																checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>

														</div>
											
											<?php if(!empty($arrvalidation_errors[50]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[50]['error_code'].' : '; ?><?php echo $arrvalidation_errors[50]['error_message']; ?></span>
																	<?php }?>
										</div>




													<div class="col-xs-12 filling_forms" style="<?php
		
if (isset ( $model_aggregated_group->is_ale_member ) && $model_aggregated_group->is_ale_member == 1) {
			
			?> display: block;<?php } else {?> display: none;<?php }?>">
														<div class="col-xs-12" style="border: 1px solid #ddd;">


															<div class="form-group row"
																style="margin-top: 10px; margin-bottom: 20px;">
																<div class="col-sm-12">
																	<label class="control-label"><h4>5.2.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.1'])){ echo Html::encode($arrsection_elements['5.2.1']); } ?></h4>
																	</label>
																</div>
																<div class="col-sm-6">
																	<input type="radio"
																		name="TblAcaAggregatedGroup[is_other_entity]"
																		class="aggregate-clear-radio" value="1"
																		<?php
		
if (isset ( $model_aggregated_group->is_other_entity ) && $model_aggregated_group->is_other_entity == 1) {
			
			?>
																		checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
																	<input type="radio"
																		name="TblAcaAggregatedGroup[is_other_entity]"
																		value="2" class="aggregate-clear-radio"
																		<?php
		
if (isset ( $model_aggregated_group->is_other_entity ) && $model_aggregated_group->is_other_entity == 2) {
			
			?>
																		checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>

																</div>
													<?php if(!empty($arrvalidation_errors[51]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[51]['error_code'].' : '; ?><?php echo $arrvalidation_errors[51]['error_message']; ?></span>
																	<?php }?>
												</div>

															<div class="form-group row other_entity_filling_yes"
													style="margin-top: 10px; margin-bottom: 20px; <?php
		
if (isset ( $model_aggregated_group->is_other_entity ) && $model_aggregated_group->is_other_entity == 1) {
			
			?> display: block;<?php }else {?> display: none;<?php }?>">
																<div class="col-sm-12">
																	<label class="control-label"><h4>5.2.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.1.1'])){ echo Html::encode($arrsection_elements['5.2.1.1']); } ?></h4>
																	</label>
																</div>
																<div class="col-sm-6 padding_left_30">
													 <?=$form->field ( $model_aggregated_group, 'total_1095_forms' )->textInput ( [ 'class' => 'form-control form-height aggregate-clear','maxlength'=>'5','onkeypress'=>'return isNumberKey(event);'  ] )->label ( false )?>
													 
													

													</div>
													
													<?php if(!empty($arrvalidation_errors[52]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[52]['error_code'].' : '; ?><?php echo $arrvalidation_errors[52]['error_message']; ?></span>
																	<?php }?>
																	
												</div>


															<div class="form-group row"
																style="margin-top: 10px; margin-bottom: 20px;">
																<div class="col-sm-12">
																	<label class="control-label"><h4>5.2.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.2'])){ echo Html::encode($arrsection_elements['5.2.2']); } ?></h4>
																	</label>
																</div>
																<div class="col-sm-12"></div>
																<div class="col-sm-3">
													<?php
		if (! empty ( $model_aggregated_group->total_aggregated_grp_months )) {
			$arrmodel_aggregated_group = explode ( ',', $model_aggregated_group->total_aggregated_grp_months );
		}
		?>
														<div class="checkbox">
																		<label><input type="checkbox" onclick="disableyear();"
																			id="entire_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][0]"
																			value="0"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '0', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">Entire
																				Year</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][1]"
																			value="1"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '1', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">January</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][2]"
																			value="2"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '2', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">February</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][3]"
																			value="3"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '3', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">March</span></label>
																	</div>

																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][4]"
																			value="4"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '4', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">April</span></label>
																	</div>

																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][5]"
																			value="5"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '5', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">May</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][6]"
																			value="6"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '6', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">June</span></label>
																	</div>
																</div>

																<div class="col-sm-3">
																	<div class="checkbox">
																		<label></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][7]"
																			value="7"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '7', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">July</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][8]"
																			value="8"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '8', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">August</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][9]"
																			value="9"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '9', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">September</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][10]"
																			value="10"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '10', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">October</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][11]"
																			value="11"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '11', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">November</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox" class="specific_year"
																			name="TblAcaAggregatedGroup[total_aggregated_grp_months][12]"
																			value="12"
																			<?php if(!empty($arrmodel_aggregated_group) && in_array ( '12', $arrmodel_aggregated_group, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">December</span></label>
																	</div>

																</div>
													
													<?php if(!empty($arrvalidation_errors[53]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[53]['error_code'].' : '; ?><?php echo $arrvalidation_errors[53]['error_message']; ?></span>
																	<?php }?>
																	
												</div>

															<div class="form-group row"
																style="margin-top: 10px; margin-bottom: 20px;">
																<div class="col-sm-12">
																	<label class="control-label"><h4>5.2.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['5.2.3'])){ echo Html::encode($arrsection_elements['5.2.3']); } ?></h4>
																	</label>
																</div>
																<div class="col-md-12" id="group_div">
													
													
														
														
													<?php
		$i = 1;
		if (! empty ( $aggregated_list )) {
			
			foreach ( $aggregated_list as $list ) {
				?>
														<div class="row" id="row_<?php echo $i; ?>"
																		style="margin-bottom: 10px;">
																		<div class="col-sm-3 padding-right-0 padding_left_30">
																			<p>Group Name</p>
																 <?php //$form->field ( $model_aggregated_group_list, 'group_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'34','onkeypress'=>'return alpha(event);'  ] )->label ( false )?>
															 	<input type="text" class="form-control aggregate-clear"
																				name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_name]"
																				maxlength="34"
																				value="<?php if(!empty($list['group_name'])){ echo $list['group_name']; }?>"
																				onkeypress="return groupname(event);">

																		</div>
																		<div class="col-sm-3 padding-right-0 padding_left_30">
																			<p>Group EIN</p>
																<?php //echo $form->field($model_aggregated_group_list,'group_ein')->label(false)->textInput(['data-inputmask'=>'"mask": "99-9999999"','data-mask'=>'','class'=>'form-control form-height width-92','id'=>'phone']); ?>
																  <input type="text"
																				class="form-control aggregate-clear"
																				name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_ein]"
																				value="<?php if(!empty($list['group_ein'])){ echo $list['group_ein']; }?>"
																				data-inputmask='"mask": "99-9999999"' data-mask>

																		</div>


																		<div class="col-sm-2 padding-left-5">
																			<p>&nbsp;&nbsp;</p>
																			<button class="btn btn-danger" type="button"
																				onclick="removerow(<?php echo $i; ?>);"
																				id="remove_more_btn_<?php echo $i; ?>">Remove</button>
																		</div>
																	</div>
														
														<?php $i++; } } ?>
														
														<div class="row" id="row_<?php echo $i; ?>"
																		style="margin-bottom: 10px;">
																		<div class="col-sm-3 padding-right-0 padding_left_30">
																			<p>Group Name</p>
																 <?php //$form->field ( $model_aggregated_group_list, 'group_name' )->textInput ( [ 'class' => 'form-control form-height','maxlength'=>'34','onkeypress'=>'return alpha(event);'  ] )->label ( false )?>
															 	<input type="text" class="form-control aggregate-clear"
																				name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_name]"
																				maxlength="34" onkeypress="return groupname(event);">

																		</div>
																		<div class="col-sm-3 padding-right-0 padding_left_30">
																			<p>Group EIN</p>
																<?php //echo $form->field($model_aggregated_group_list,'group_ein')->label(false)->textInput(['data-inputmask'=>'"mask": "99-9999999"','data-mask'=>'','class'=>'form-control form-height width-92','id'=>'phone']); ?>
																  <input type="text"
																				class="form-control aggregate-clear"
																				name="TblAcaAggregatedGroupList[<?php echo $i; ?>][group_ein]"
																				data-inputmask='"mask": "99-9999999"' data-mask>

																		</div>
																		<div class="col-sm-2 padding-left-5">
																			<p>&nbsp;&nbsp;</p>
																			<button class="btn btn-primary no-wrap" type="button"
																				onclick="addnewrow(<?php echo $i; ?>);"
																				id="add_more_btn">Add more</button>
																		</div>
																	</div>



																</div>
													
													
													<?php if(!empty($arrvalidation_errors[54]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[54]['error_code'].' : '; ?><?php echo $arrvalidation_errors[54]['error_message']; ?></span>
																	<?php }?>
																	
												</div>

														</div>
													</div>
										<?php } ?>
										
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