<?php
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use app\models\TblAcaCountries;
use app\models\TblUsaStates;
use app\models\TblCityStatesUnitedStates;


$get_id = Yii::$app->request->get ();
$company_id = $get_id ['c_id'];



?>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/reporting.js"></script>
<link rel="stylesheet" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/reporting.css">

<?php


$country_list =  ArrayHelper::map(TblAcaCountries::find()->All(), 'country_code', 'country_name');

$usStates =  ArrayHelper::map(TblUsaStates::find()->All(), 'state_code', 'state_code');

$uscityStates =  array();

$suffix= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 7])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');

?>
<style>
.form-height {
    
    width: 50%;
}
.help-block{
float: left;
}
</style>
<div class="box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title col-xs-6">Validate &amp; Create Forms - <?php if(!empty($c_detals['company_name'])){echo htmlentities($c_detals['company_name']); }?> <small><?php if(!empty($c_detals['company_client_number'])){echo '('.htmlentities($c_detals['company_client_number']).')'; }?></small></h3>
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



<?php $form = ActiveForm::begin(['action' => ['/client/validateforms/designatedgovtentity?c_id='.$company_id],'enableClientValidation' => true,'options' => ['enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'','id'=>'basic_info_form']]); ?>

								<div class="box-body">


									<div class="">
									 <div class="col-md-6 box-footer" ><font size="4" ><b>Validate Report ( Designated Govt. Entity )</b></font></div>
                   <div class=" col-md-6 box-footer pull-right padding-right-0" style="text-align: right;">


												<button type="submit"
													class="btn btn-primary mec-coverage-btn" name="button"
													value="continue"
													>Update</button>
												<a class="btn btn-default btn-default-cancel"
													href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/validateforms?c_id=<?php echo $company_id;?>">Cancel</a>

											</div>
										<div class="col-md-12" style="border: 1px solid #ada7a7;">
					
									
								<div class="">
									

									<div class="">
									
									
											<div class="form-group col-md-12 padding-left-0 padding-right-0">
												<div class="col-sm-12">
													<label class="control-label"><h4>4.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1'])){ echo Html::encode($arrsection_elements['4.1']); } ?></h4> <input type="radio"
														name="TblAcaDesignatedGovtEntity[assign_dge]" value="1"
														<?php if(isset($model_designated_govt_entity->assign_dge) && $model_designated_govt_entity->assign_dge == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
														><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Yes</span>&nbsp;&nbsp;&nbsp;&nbsp;
														<input type="radio" name="TblAcaDesignatedGovtEntity[assign_dge]" value="2"
														<?php if(isset($model_designated_govt_entity->assign_dge) && $model_designated_govt_entity->assign_dge == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
														><span
														class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;No</span>
													</label>
													
													<?php if(!empty($arrvalidation_errors[31]['error_code'])){?>
																				<span
																			class="red col-sm-12 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[31]['error_code'].' : '; ?><?php echo $arrvalidation_errors[31]['error_message']; ?></span>
																			<?php }?>
																			
												</div>
											</div>

											<div class="designation" style="<?php if(isset($model_designated_govt_entity->assign_dge) && $model_designated_govt_entity->assign_dge == 1){?> display: block;<?php }else{?>display: none;<?php }?>">

												<div class="form-group col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.1&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.1'])){ echo Html::encode($arrsection_elements['4.1.1']); } ?> </h4></label>
														
														<?=$form->field ( $model_designated_govt_entity, 'dge_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'75','onkeypress'=>'return designatedgovt(event);' ] )->label ( false )?>
													<?php if(!empty($arrvalidation_errors[32]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[32]['error_code'].' : '; ?><?php echo $arrvalidation_errors[32]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[33]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[33]['error_code'].' : '; ?><?php echo $arrvalidation_errors[33]['error_message']; ?></span>
																			<?php }?>
																			
													<?php if(!empty($arrvalidation_errors[34]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[34]['error_code'].' : '; ?><?php echo $arrvalidation_errors[34]['error_message']; ?></span>
																			<?php }?>
													</div>
													</div>
											<div class="form-group col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.2&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.2'])){ echo Html::encode($arrsection_elements['4.1.2']); } ?></h4></label> 
														
														<?php echo $form->field($model_designated_govt_entity,'dge_ein')->label(false)->textInput(['class' => 'form-control form-height dge-clear col-sm-6','data-inputmask'=>'"mask": "99-9999999"','data-mask'=>'']); ?>
													
													<?php if(!empty($arrvalidation_errors[35]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[35]['error_code'].' : '; ?><?php echo $arrvalidation_errors[35]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[36]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[36]['error_code'].' : '; ?><?php echo $arrvalidation_errors[36]['error_message']; ?></span>
																			<?php }?>
																			
													<?php if(!empty($arrvalidation_errors[37]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[37]['error_code'].' : '; ?><?php echo $arrvalidation_errors[37]['error_message']; ?></span>
																			<?php }?>
																			
													</div>
												</div>

												<div class="form-group col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.3&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.3'])){ echo Html::encode($arrsection_elements['4.1.3']); } ?></h4></label> 
														
														<?=$form->field ( $model_designated_govt_entity, 'street_address_1' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													<?php if(!empty($arrvalidation_errors[38]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[38]['error_code'].' : '; ?><?php echo $arrvalidation_errors[38]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[39]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[39]['error_code'].' : '; ?><?php echo $arrvalidation_errors[39]['error_message']; ?></span>
																			<?php }?>
													</div>
												</div>
											<div class="form-group col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.4&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.4'])){ echo Html::encode($arrsection_elements['4.1.4']); } ?> (Optional)</h4></label>
														
														<?=$form->field ( $model_designated_govt_entity, 'street_address_2' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'200','onkeypress'=>'return addressone(event);' ] )->label ( false )?>
													
												</div>

												</div>

												<div class="form-group col-md-12 padding-left-0 padding-right-0">
												
												<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.5&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.5'])){ echo Html::encode($arrsection_elements['4.1.5']); } ?></h4></label> 
														
														<?php 
                  
															                   echo $form->field($model_designated_govt_entity, 'dge_state')->dropdownList(
															                  		$usStates,
															                  		['prompt'=>'Select State','class'=>'form-control form-height dge-clear col-sm-6','onchange'=>'return statedgeChange(this.value)']
															                  )->label(false);
															                  ?>
															                  
															                  <?php if(!empty($arrvalidation_errors[40]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[40]['error_code'].' : '; ?><?php echo $arrvalidation_errors[40]['error_message']; ?></span>
																			<?php }?>
													
													</div>
													</div>
											<div class="form-group col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.6&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.6'])){ echo Html::encode($arrsection_elements['4.1.6']); } ?></h4></label> 
														
														<?php 
                  
															                   echo $form->field($model_designated_govt_entity, 'dge_city')->dropdownList(
															                  		$uscityStates,
															                  		['prompt'=>'Select City','class'=>'form-control form-height col-sm-6']
															                  )->label(false);
															                  ?>
															                  
															                   <?php if(!empty($arrvalidation_errors[41]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[41]['error_code'].' : '; ?><?php echo $arrvalidation_errors[41]['error_message']; ?></span>
																			<?php }?>
																			  
													</div>
													

												</div>

												<div class="form-group  col-md-12 padding-left-0 padding-right-0">

													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.7&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.7'])){ echo Html::encode($arrsection_elements['4.1.7']); } ?></h4></label> 
														
														<?=$form->field ( $model_designated_govt_entity, 'dge_zip' )->textInput ( [ 'class' => 'form-control numbers form-height dge-clear col-sm-6','maxlength'=>'5' ] )->label ( false )?>
													
													<?php if(!empty($arrvalidation_errors[42]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[42]['error_code'].' : '; ?><?php echo $arrvalidation_errors[42]['error_message']; ?></span>
																			<?php }?>
													</div>
												</div>

												<div class="form-group  col-md-12 padding-left-0 padding-right-0">

													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.8&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.8'])){ echo Html::encode($arrsection_elements['4.1.8']); } ?></h4></label> 
														
														<?=$form->field ( $model_designated_govt_entity, 'dge_contact_first_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'20','onkeypress'=>'return alpha(event);' ] )->label ( false )?>
													<?php if(!empty($arrvalidation_errors[43]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[43]['error_code'].' : '; ?><?php echo $arrvalidation_errors[43]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[44]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[44]['error_code'].' : '; ?><?php echo $arrvalidation_errors[44]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[45]['error_code'])){?>
														<span
													class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php echo $arrvalidation_errors[45]['error_code'].' : '; ?><?php echo $arrvalidation_errors[45]['error_message']; ?></span>
													<?php }?>
													
													</div>
													</div>
														<div class="form-group  col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.9&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.9'])){ echo Html::encode($arrsection_elements['4.1.9']); } ?> (Optional)</h4></label> 
														<?=$form->field ( $model_designated_govt_entity, 'dge_contact_middle_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'20','onkeypress'=>'return alpha(event);' ] )->label ( false )?>
													</div>

												</div>

												<div class="form-group  col-md-12 padding-left-0 padding-right-0">

													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.10&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.10'])){ echo Html::encode($arrsection_elements['4.1.10']); } ?></h4></label> 
														
														<?=$form->field ( $model_designated_govt_entity, 'dge_contact_last_name' )->textInput ( [ 'class' => 'form-control form-height dge-clear col-sm-6','maxlength'=>'20','onkeypress'=>'return alpha(event);' ] )->label ( false )?> 
												<?php if(!empty($arrvalidation_errors[143]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[143]['error_code'].' : '; ?><?php echo $arrvalidation_errors[143]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[144]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[144]['error_code'].' : '; ?><?php echo $arrvalidation_errors[144]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[145]['error_code'])){?>
														<span
													class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[145]['error_code'].' : '; ?><?php echo $arrvalidation_errors[145]['error_message']; ?></span>
													<?php }?>
													</div>
</div>
														<div class="form-group  col-md-12 padding-left-0 padding-right-0">
													
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.11&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.11'])){ echo Html::encode($arrsection_elements['4.1.11']); } ?>(Optional)</h4></label>
														
														<?php 
                  
															                   echo $form->field($model_designated_govt_entity, 'dge_contact_suffix')->dropdownList(
															                  		$suffix,
															                  		['prompt'=>'Select Suffix','class'=>'form-control form-height dge-clear col-sm-6']
															                  )->label(false);
															                  ?>
													</div>

												</div>
												<div class="form-group  col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12">
														<label class="control-label col-sm-6"><h4>4.1.12&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.12'])){ echo Html::encode($arrsection_elements['4.1.12']); } ?></h4></label> 
														
														<?php echo $form->field($model_designated_govt_entity,'dge_contact_phone_number')->label(false)->textInput(['class' => 'form-control form-height dge-clear col-sm-6','data-inputmask'=>'"mask": "(999) 999-9999"','data-mask'=>'']); ?>
													<?php if(!empty($arrvalidation_errors[46]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[46]['error_code'].' : '; ?><?php echo $arrvalidation_errors[46]['error_message']; ?></span>
																			<?php }?>
													<?php if(!empty($arrvalidation_errors[47]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[47]['error_code'].' : '; ?><?php echo $arrvalidation_errors[47]['error_message']; ?></span>
																			<?php }?>
													
													</div>
												</div>
												<div class="form-group  col-md-12 padding-left-0 padding-right-0">
													<div class="col-sm-12 plan-div-margin"
														>
														<label class="control-label col-sm-6"><h4>4.1.13&nbsp;&nbsp;&nbsp;<?php if(!empty($arrsection_elements['4.1.13'])){ echo Html::encode($arrsection_elements['4.1.13']); } ?></h4>  </label>
														<div class="col-sm-6 padding-left-0 padding-right-0">
														<input type="radio"
															class="dge-clear-radio" name="TblAcaDesignatedGovtEntity[dge_reporting]" value="1" 
															<?php if(isset($model_designated_govt_entity->dge_reporting) && $model_designated_govt_entity->dge_reporting == 1){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Enrollment
																Only</span>&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
															class="dge-clear-radio" name="TblAcaDesignatedGovtEntity[dge_reporting]"  value="2"
															<?php if(isset($model_designated_govt_entity->dge_reporting) && $model_designated_govt_entity->dge_reporting == 2){
																			
																					?> 
																				checked
																				<?php  } ?>
															><span class="control-checkbox">&nbsp;&nbsp;&nbsp;&nbsp;Enrollment
																and Offer of Coverage</span>
																
																</div>
																
																<?php if(!empty($arrvalidation_errors[48]['error_code'])){?>
																				<span
																			class="red col-sm-6 padding-left-0 padding-right-0 pull-right"><?php //echo $arrvalidation_errors[48]['error_code'].' : '; ?><?php echo $arrvalidation_errors[48]['error_message']; ?></span>
																			<?php }?>
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