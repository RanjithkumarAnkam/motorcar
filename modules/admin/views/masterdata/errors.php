<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_errors").addClass("active");
});
</script>
<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use app\components\EncryptDecryptComponent;
?>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/masterdata.css" rel="stylesheet">
 
<div class="box box-warning container-fluid">
	
	<div class="box-header with-border">
              <h3 class="box-title">Error Master</h3>
            </div>
			
	<div class="col-xs-12 header-new-main width-98 ">  
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Managing all the errors of the application is done from the list below.</p>
	</div>
	
	
	<div class="col-md-12" style="padding-top:10px;">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#basic_reporting_info">Basic Reporting Info</a></li>
			<li><a data-toggle="tab" href="#benefit_plan_info">Benefit Plan Info</a></li>
			<li><a data-toggle="tab" href="#plan_class">Plan Class</a></li>
			<li><a data-toggle="tab" href="#payroll">Payroll Data</a></li>
			<li><a data-toggle="tab" href="#medical">Medical Data</a></li>
		</ul>

		<div class="tab-content">
						
			<div id="basic_reporting_info" class="tab-pane fade  in active">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th style="width:28%;">Element Name</th>
											<th>Error Code</th>
											<th style="width:28%;">Validation</th>
											<th>Error Message</th>
											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									<?php $i=1;?>
									<?php foreach($basic_report_errors as $basic_report_error){?>
										<tr>											
											<td style=""><?php echo \Yii::$app->Permission->Getelement($basic_report_error->element_id,'basic') ;?></td>
											<td style="" ><?php echo($basic_report_error->error_code); ?></td>
											<td style="" id="validation_<?php echo $basic_report_error->rule_id;?>"><?php echo $basic_report_error->validation;?></td>
											<td style=""><textarea  class="form-control" id="error_<?php echo $basic_report_error->rule_id;?>" ><?php echo $basic_report_error->error_message;?></textarea></td>

											<td style="text-align: center;"><a	  data-toggle="tooltip" data-placement="bottom" title="Click to update basic reporting info error" onclick="updateErrormessage(<?php echo $basic_report_error->rule_id;?>)" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php //echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										<?php $i++?>
										<?php } ?>
									

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="benefit_plan_info" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th style="width:28%;">Element Name</th>
											<th>Error Code</th>
											<th style="width:28%;">Validation</th>
											<th>Error Message</th>
											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									<?php $i=1;?>
									<?php foreach($benefit_plan_errors as $benefit_plan_error){?>
										<tr>											
											<td style=""><?php echo \Yii::$app->Permission->Getelement($benefit_plan_error->element_id,'basic') ;?></td>
											<td style="" ><?php echo($benefit_plan_error->error_code); ?></td>
											<td style="" id="validation_<?php echo $benefit_plan_error->rule_id;?>"><?php echo $benefit_plan_error->validation;?></td>
											<td style=""><textarea  class="form-control" id="error_<?php echo $benefit_plan_error->rule_id;?>" ><?php echo $benefit_plan_error->error_message;?></textarea></td>

											<td style="text-align: center;"><a	 data-toggle="tooltip" data-placement="bottom" title="Click to update benefit plan info error" onclick="updateErrormessage(<?php echo $benefit_plan_error->rule_id;?>)" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php //echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										<?php $i++?>
										<?php } ?>
									

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="plan_class" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th style="width:28%;">Element Name</th>
											<th>Error Code</th>
											<th style="width:28%;">Validation</th>
											<th>Error Message</th>
											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									<?php $i=1;?>
									<?php foreach($planclass_errors as $planclass_error){?>
										<tr>											
											<td style=""><?php echo \Yii::$app->Permission->Getelement($planclass_error->element_id,'basic') ;?></td>
											<td style="" ><?php echo($planclass_error->error_code); ?></td>
											<td style="" id="validation_<?php echo $planclass_error->rule_id;?>" ><?php echo $planclass_error->validation;?></td>
											<td style=""><textarea  class="form-control" id="error_<?php echo $planclass_error->rule_id;?>" ><?php echo $planclass_error->error_message;?></textarea></td>

											<td style="text-align: center;"><a	 data-toggle="tooltip" data-placement="bottom" title="Click to update plan class error" onclick="updateErrormessage(<?php echo $planclass_error->rule_id;?>)" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php //echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										<?php $i++?>
										<?php } ?>
									

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="payroll" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th>Element Name</th>
											<th>Error Code</th>
											<th style="width:28%;">Validation</th>
											<th>Error Message</th>
											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									<?php $i=1;?>
									<?php foreach($payroll_errors as $payroll_error){?>
										<tr>											
											<td style=""><?php echo \Yii::$app->Permission->Getelement($payroll_error->element_id,'payroll') ;?></td>
											<td style="" ><?php echo($payroll_error->error_code); ?></td>
											<td style="" id="validation_<?php echo $payroll_error->rule_id;?>" ><?php echo $payroll_error->validation;?></td>
											<td style=""><textarea  class="form-control" id="error_<?php echo $payroll_error->rule_id;?>" ><?php echo $payroll_error->error_message;?></textarea></td>

											<td style="text-align: center;"><a  data-toggle="tooltip" data-placement="bottom" title="Click to update payroll data error"	onclick="updateErrormessage(<?php echo $payroll_error->rule_id;?>)" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php //echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										<?php $i++?>
										<?php } ?>
									

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="medical" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="exampleCompany" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th>Element Name</th>
											<th>Error Code</th>
											<th style="width:28%;">Validation</th>
											<th>Error Message</th>
											<th>Update</th>
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									<?php $i=1;?>
									<?php foreach($medical_errors as $medical_error){?>
										<tr>											
											<td style=""><?php echo \Yii::$app->Permission->Getelement($medical_error->element_id,'medical') ;?></td>
											<td style="" ><?php echo($medical_error->error_code); ?></td>
											<td style="" id="validation_<?php echo $medical_error->rule_id;?>" ><?php echo $medical_error->validation;?></td>
											<td style=""><textarea  class="form-control" id="error_<?php echo $medical_error->rule_id;?>" ><?php echo $medical_error->error_message;?></textarea></td>

											<td style="text-align: center;"><a  data-toggle="tooltip" data-placement="bottom" title="Click to update medical data error"	onclick="updateErrormessage(<?php echo $medical_error->rule_id;?>)" ><i
													class="fa fa-floppy-o" style="cursor: pointer;"></i></a></td>
									<!-- 		<td style="text-align: center;"><a
												href="<?php //echo Yii::$app->homeUrl;?>admin/company/editform"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>
											-->
										</tr>
										<?php $i++?>
										<?php } ?>
									

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		  </div>
	</div>
	
</div>




	<script type="text/javascript">
			
		window.onload = function() {<?php 
		$get=\Yii::$app->request->get ();
		if(!empty($get['keyword'])){ ?>
		$elements = '<?php if(!empty($get['keyword'])){ echo $get['keyword']; }?>';
		$('#filter_elements').val($elements);
		<?php }?>
			};	

	
    </script>