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
<script
	src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/mecvalidation.js"></script>
<link rel="stylesheet"
	href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/planinfo.css">

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



<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/largeempstatustrack?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'emp_status_form']]); ?>

								<div class="box-body">


									<div class="">
										<div class="col-md-6 box-footer">
											<font size="4"><b>Validate Report ( Large Emp. Status & Track
													)</b></font>
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
										<?php if(in_array ( 24, $arrvalidations, TRUE ) ){?>
											<div class="form-group">
														<div class="col-sm-12">
															<span class="control-label"><h4>2.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['2.1'])){ echo Html::encode($arrsection_elements['2.1']); } ?></h4>
																<input type="radio"
																name="TblAcaEmpStatusTrack[ale_applicable]" value="1"
																<?php
											
if (isset ( $model_large_emp_status->ale_applicable ) && $model_large_emp_status->ale_applicable == 1) {
												
												?>
																checked <?php  } ?>></input><span
																class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;

																<input type="radio"
																name="TblAcaEmpStatusTrack[ale_applicable]" value="2"
																<?php
											
if (isset ( $model_large_emp_status->ale_applicable ) && $model_large_emp_status->ale_applicable == 2) {
												
												?>
																checked <?php  } ?>></input><span
																class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
															</span>
													<?php if(!empty($arrvalidation_errors[24]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[24]['error_code'].' : '; ?><?php echo $arrvalidation_errors[24]['error_message']; ?></span>
																	<?php }?>
												</div>
													</div>
											<?php } ?>
											<?php if(in_array ( 25, $arrvalidations, TRUE ) ){?>
									<div class="form-group">
														<div class="col-sm-12">
															<span class="control-label"><h4>2.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['2.2'])){ echo Html::encode($arrsection_elements['2.2']); } ?></h4>
																<input type="radio"
																name="TblAcaEmpStatusTrack[ale_first_applicable]"
																value="1"
																<?php
												
if (isset ( $model_large_emp_status->ale_first_applicable ) && $model_large_emp_status->ale_first_applicable == 1) {
													
													?>
																checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
																<input type="radio"
																name="TblAcaEmpStatusTrack[ale_first_applicable]"
																value="2"
																<?php
												
if (isset ( $model_large_emp_status->ale_first_applicable ) && $model_large_emp_status->ale_first_applicable == 2) {
													
													?>
																checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
															</span>
													
													<?php if(!empty($arrvalidation_errors[25]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[25]['error_code'].' : '; ?><?php echo $arrvalidation_errors[25]['error_message']; ?></span>
																	<?php }?>
												</div>
													</div>
											<?php } ?>
												<?php if(in_array ( 26, $arrvalidations, TRUE ) ){?>
											<div class="form-group">
														<div class="col-sm-12">
															<span class="control-label"><h4
																	style="margin-bottom: 25px;">2.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['2.3'])){ echo Html::encode($arrsection_elements['2.3']); } ?></h4>
																<div class="col-sm-12 padding-left-0 padding-right-0" style="padding-bottom: 10px;">
																	<input type="radio"
																		name="TblAcaEmpStatusTrack[ale_category]" value="1"
																		<?php
													
if (isset ( $model_large_emp_status->ale_applicable ) && $model_large_emp_status->ale_category == 1) {
														
														?>
																		checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;An
																		ALE with fewer than 100 full time employees (including
																		full time equivalent employees).</span>
																 &nbsp;&nbsp;&nbsp;&nbsp;
																</div>
																<div class="col-sm-12 padding-left-0 padding-right-0">
																	<input type="radio"
																		name="TblAcaEmpStatusTrack[ale_category]" value="2"
																		<?php
													
if (isset ( $model_large_emp_status->ale_applicable ) && $model_large_emp_status->ale_category == 2) {
														
														?>
																		checked <?php  } ?>><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;An
																		ALE with more than 100 full time employees (including
																		full time equivalent employees).</span>
																 </span>
											<?php if(!empty($arrvalidation_errors[26]['error_code'])){?>
																<span class="red col-sm-12"><?php //echo $arrvalidation_errors[26]['error_code'].' : '; ?><?php echo $arrvalidation_errors[26]['error_message']; ?></span>
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