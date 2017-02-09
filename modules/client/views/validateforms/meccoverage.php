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




<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/meccoverage?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'mec_coverage_information']]); ?>
								<div class="box-body">


									<div class="">
										<div class="">
											<div class="col-md-6 box-footer">
												<font size="4"><b>Validate Report ( MEC Coverage )</b></font>
											</div>
											<div class=" col-md-6 box-footer pull-right padding-right-0"
												style="text-align: right;">


												<button type="submit"
													class="btn btn-primary mec-coverage-btn" name="button"
													value="continue"
													onclick="return validatemec('<?php echo $validation_results->validationRule->error_code; ?> : <?php echo $validation_results->validationRule->error_message; ?>');">Update</button>
												<a class="btn btn-default btn-default-cancel"
													href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms?c_id=<?php echo $company_id;?>">Cancel</a>

											</div>
											<div class="col-md-12" style="border: 1px solid #ada7a7;">

												<div class="">


													<div class="">

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
																		<label><input type="checkbox" class="year-checkbox"
																			onclick="disableyear();" id="entire_year"
																			name="TblAcaMecCoverage[mec_months][0]" value="0"
																			<?php if($model_mec_coverage->mec_months!='' && $model_mec_coverage->mec_months==0){ ?>
																			checked <?php }?>><span class="control-checkbox ">Entire
																				Year</span></label>
																	</div>
																</div>
																<div class="col-sm-3">


																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][1]" value="1"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '1', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php  }?>><span class="control-checkbox ">January</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][2]" value="2"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '2', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox ">February</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][3]" value="3"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '3', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox ">March</span></label>
																	</div>

																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][4]" value="4"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '4', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox ">April</span></label>
																	</div>

																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][5]" value="5"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '5', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php  }?>><span class="control-checkbox ">May</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][6]" value="6"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '6', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php  }?>><span class="control-checkbox ">June</span></label>
																	</div>
																</div>

																<div class="col-sm-3">
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][7]" value="7"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '7', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php  }?>><span class="control-checkbox ">July</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][8]" value="8"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '8', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php  }?>><span class="control-checkbox ">August</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][9]" value="9"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '9', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox ">September</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][10]" value="10"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '10', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox ">October</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][11]" value="11"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '11', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox ">November</span></label>
																	</div>
																	<div class="checkbox">
																		<label><input type="checkbox"
																			class="specific_year year-checkbox"
																			name="TblAcaMecCoverage[mec_months][12]" value="12"
																			<?php if(!empty($model_mec_coverage_array) && in_array ( '12', $model_mec_coverage_array, TRUE )){ ?>
																			checked <?php }?>><span class="control-checkbox">December</span></label>
																	</div>

																</div>

																<span class="col-xs-12 red" id="mec_error"> Error <?php echo $validation_results->validationRule->error_code; ?> : <?php echo $validation_results->validationRule->error_message; ?></span>

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
						</div>
						<!-- /.box-body -->
					</div>
					<!-- /.box -->
				</div>
			</div>
		</div>
	</div>
</div>



