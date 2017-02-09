<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\UploadfileForm;
use app\models\TblAcaCompanyUsers;
use app\models\TblAcaClients;
use app\models\TblAcaCompanies;
use app\models\TblAcaCompanyUserPermission;
use app\models\TblAcaVideoLinks;

?>
<script type="text/javascript">

$(document).ready(function() {
	$("#loadGif").show();
	var doc_signed = <?php echo $doc_signed; ?>;
	//alert(doc_signed);
    if (doc_signed == 1) {
         location.reload();    }
	else{
		$("#loadGif").hide();
	}
});
$(function() {
	$( "#dashboard-menu-id" ).addClass( "active" );
}); 

function checkDocsign(){
	
}
</script>

<?php  $baseurl=Yii::$app->getUrlManager()->getBaseUrl(true);?>

<?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/client/dashboard.css"); ?>

<?php $this->registerCssFile("https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"); ?>



<?php 
if(!empty($session['is_client']) &&  $session['is_client'] == 'companyuser'){	
	if(empty($right_sign_docs)){
		
		if($right_sign_permission != TRUE){ ?>	
	<div class="col-xs-12" style="padding: 0;background: #f39c12;margin-bottom: 10px;z-index: 1;">
		<p style="margin: 0;padding: 10px;color: #fff;font-weight: bold;">The BAA is not signed yet. Please contact <?php echo $users_list;?></p>
	</div>
<?php }
	}
}?>	
	
<div class="box box-warning container-fluid">

	<div class="box-header with-border padding-left-0 padding-right-0">
		<h3 class="box-title col-xs-6 padding-left-0">
			<?php echo Html::encode($model_companies_year->company_name); ?> <small>(<?php echo Html::encode($model_companies_year->company_client_number); ?>)</small>
		</h3>
		<div class="col-xs-6 pull-right padding-right-0">
			<span class="col-xs-7 pull-right padding-right-0 help-call"><b>Need help? Call
					<?php echo Html::encode($model_companies_year->client->brand->support_number);?></b></span>

		</div>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band lighter"></i></span>
		<p class="sub-header-new">You can see the statistics of company from
			this screen.</p>
	</div>

	<div class="row mtop21">
		<div class="col-md-3 col-sm-6 col-xs-12 padding-right-0">
			<div class="info-box" title="Current ACA Reporting Year">
				<span class="info-box-icon "><i class="fa fa-calendar-check-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Current ACA Reporting Year</span> <span
						class="info-box-number"><?php echo $model_companies_year->tbl_aca_company_reporting_period->year->lookup_value;?> </span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- ./col -->
		<div class="col-md-3 col-sm-6 col-xs-12 padding-right-0">
			<div class="info-box" title="Reporting Package Purchased">
				<span class="info-box-icon "><i class="fa  fa-user"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Reporting Package Purchased</span> <span
						class="info-box-number"><?php echo $model_companies_year->client->package->lookup_value;?></span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- ./col -->
		<div class="col-md-3 col-sm-6 col-xs-12 padding-right-0">
			<div class="info-box"  title="Deadline to Provide Employees 1095">
				<span class="info-box-icon "><i class="fa fa-file-o"></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Deadline to Provide Employees 1095</span>
					<span class="info-box-number"><?php echo($aca_days); ?> Days</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- ./col -->
		<div class="col-md-3 col-sm-6 col-xs-12 ">
			<div class="info-box"  title="Deadline to E-File with IRS">
				<span class="info-box-icon "><i class="ion-flash fa-rotate-45 "></i></span>

				<div class="info-box-content">
					<span class="info-box-text">Deadline to E-File with IRS</span> <span
						class="info-box-number"><?php echo($efile_days); ?> Days</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- ./col -->
	</div>

	<div class="col-md-12 padding-left-0 padding-right-0">
		<div class="col-md-8 padding-left-0">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h5 class="box-title project-stage">Project
						Stage</h5>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					<!--	<button type="button" class="btn btn-box-tool"
							data-widget="remove">
							<i class="fa fa-times"></i>
						</button>-->
					</div>
				</div>
				<div class="box-body">


					<div class="table-responsive">
						<table class="table no-margin">
							<thead>
								<tr>
									<th>Item</th>
									<th>Status</th>
									<th>Date of Completion</th>
									<th style="width: 32%;"><span class="hide">Progress Bar</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Client Agreement Signature</td>
									<td><?php if($right_sign_docs){?><span class="label label-success">Completed</span><?php }else{ ?><span  class="label label-warning">Pending</span><?php }?></td>

									<td><?php if($right_sign_docs){echo $right_sign_docs->created_date;}else{?><?php }?></td>
									<td><div class="progress sm hide">
											<div class="progress-bar progress-bar-green"
												style="width: 100%"></div>
										</div></td>
								</tr>
								<tr>
									<td>Basic Reporting Info</td>
								     <td><?php if(!empty($validation_status)){ ?>
									 
									 <?php if($is_basic_info_validated==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($initialized==1 && $executed == 0 && $completed == 0){?><span class="label label-info">Validation In Progress</span>
									<?php }elseif(!empty($validation_status) && $validation_status->is_basic_info==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($is_basic_info_validated == 1 && $model_basic_info!='' && $validation_status->is_basic_info==1){?><span class="label label-success">Validation Successful</span><?php }?>
										
								    <?php }else{?><span class="label label-warning">Validation Pending</span><?php }?>
									</td>
									<td><?php if(!empty($validation_status) && $is_basic_info_validated == 1 && $model_basic_info!='' && $validation_status->is_basic_info==1){echo $basic_info_date;}?></td>
									<td><div class="progress sm hide">
											<div class="progress-bar progress-bar-aqua"
												style="width: 100%"></div>
										</div></td>
								</tr>
								<tr>
									<td>Benefit Plan Info</td>
									<td><?php if(!empty($validation_status)){ ?>
									
									<?php if($is_benefit_plan_validated==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($initialized==1 && $executed == 0 && $completed == 0){?><span class="label label-info">Validation In Progress</span>
									<?php }elseif(!empty($validation_status) && $validation_status->is_benefit_info==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($is_benefit_plan_validated == 1 && $model_general_plan_info!='' && $validation_status->is_benefit_info==1){?><span class="label label-success">Validation Successful</span><?php }?>
									
									<?php }else{?><span class="label label-warning">Validation Pending</span><?php }?>
									</td>
									<td><?php if(!empty($validation_status) && $is_benefit_plan_validated == 1 && $model_general_plan_info!='' && $validation_status->is_benefit_info==1){echo $benefit_info_date;}?></td>
									<td><div class="progress sm hide">
											<div class="progress-bar progress-bar-aqua"
												style="width: 30%"></div>
										</div></td>
								</tr>
								<tr>
									<td>Payroll Data</td>
                                       <td><?php if(!empty($validation_status)){ ?>
									   
									   <?php if($is_payroll_data_validation_validated==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($initialized==1 && $executed == 0 && $completed == 0){?><span class="label label-info">Validation In Progress</span>
									<?php }elseif(!empty($validation_status) && $validation_status->is_payroll_data==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($is_payroll_data_validation_validated == 1 && $model_payroll_data!='' && $validation_status->is_payroll_data==1){?><span class="label label-success">Validation Successful</span><?php }else{?><span class="label label-warning">Validation Pending</span><?php }?>
								
								<?php }else{?><span class="label label-warning">Validation Pending</span><?php }?>
									</td>
									<td><?php if(!empty($validation_status) && $is_payroll_data_validation_validated == 1 && $model_payroll_data!='' && $validation_status->is_payroll_data==1){echo $validation_status->payroll_info_date;}?></td>
									<td></td>
								</tr>
								<tr>
									<td>Medical Plan Data</td>
									<td><?php if(!empty($validation_status)){ ?>
									
									<?php if($is_medical_data_validation_validated==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($initialized==1 && $executed == 0 && $completed == 0){?><span class="label label-info">Validation In Progress</span>
									<?php }elseif(!empty($validation_status) && $validation_status->is_medical_data==0){?><span class="label label-warning">Validation Pending</span><?php }elseif($is_medical_data_validation_validated == 1 && $model_medical_data!='' && $validation_status->is_medical_data==1){?><span class="label label-success">Validation Successful</span><?php }else{?><span class="label label-warning">Validation Pending</span><?php }?>
								
								<?php }else{?><span class="label label-warning">Validation Pending</span><?php }?>
								</td>

								<td><?php if(!empty($validation_status) && $is_medical_data_validation_validated == 1 && $model_medical_data!='' && $validation_status->is_medical_data==1 ){echo $validation_status->medical_info_date;}?></td>
								</tr>
								<tr>
									<td>ACA Form Generation</td>
									<td><span class="label label-warning">Pending</span></td>


									<td></td>
									<td></td>
								</tr>
							
								<tr>
									<td>ACA Form Approval</td>
									<td><span class="label label-warning">Pending</span></td>

									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>E-Filing</td>
									<td><span class="label label-warning">Pending</span></td>

									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>



				</div>


			</div>


		</div>

		<div class="col-md-4 padding-left-0">

			<div class="box box-primary">
				<div class="box-header with-border">
					<h5 class="box-title project-stage">Full
						Service Support</h5>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
						<!--<button type="button" class="btn btn-box-tool"
							data-widget="remove">
							<i class="fa fa-times"></i>
						</button>-->
					</div>
				</div>

				
				<div class="box-body">
				<?php	if(!empty($model_companies_year->client->staffusers->first_name)){ ?>
					<div class="col-xs-4 padding-left-0 padding-right-0">
					
					<?php	if(!empty($model_companies_year->client->staffusers->profile_pic)){ ?>
						<img class="img-responsive img-circle img_height_width"
							src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/<?php  echo $model_companies_year->client->staffusers->profile_pic;?>">
					<?php }else{?>
					<img class="img-responsive img-circle img_height_width"
							src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/report_1_28146_default.png">
				
					<?php }?>
					</div>
				
					<div class="col-xs-8 padding-left-0 padding-right-0">
						<div style="padding: 21px;">
							<b><?php echo Html::encode($model_companies_year->client->staffusers->first_name .' '.$model_companies_year->client->staffusers->last_name);?></b></br> <i>Senior Account Manager</i></br>
							<?php $data=Html::encode($model_companies_year->client->staffusers->phone); echo "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6).' extn '.$model_companies_year->client->staffusers->phone_ext; ?>
						</div>
					</div>
					<?php }?>
<!--<div class="col-lg-12 padding-left-0 padding-right-0 col-md-hidden" style=" height: 98px;">

</div>-->

					<div class="col-xs-12 padding-left-0 padding-right-0">

						<div class="col-xs-12 padding-left-0 padding-right-0 mtoppading">
							<div class="col-xs-6 padding-left-0">
								<b>Client Support Hotline:</b>
							</div>

							<div class="col-xs-6 padding-left-0 padding-right-0 ">
								<span class="pull-right"><?php echo $model_companies_year->client->brand->support_number; ?></span>
							</div>
						</div>
						<div class="col-xs-12 padding-left-0 padding-right-0"
							style="padding: 10px;">
							<div class="col-xs-6 padding-left-0">
								<b>Client Support Email:</b>
							</div>

							<div class="col-xs-6 padding-left-0 padding-right-0 ">
							
							<span class="pull-right"><a class="no-padding"  href='mailto:" .<?php echo $model_companies_year->client->brand->support_email; ?>  . "?body=" . $body . "'><?php if(strlen($model_companies_year->client->brand->support_email)>25){ echo substr($model_companies_year->client->brand->support_email, 0, 25).'..'; }else{echo $model_companies_year->client->brand->support_email;} ; ?></a></span>
							
								
							</div>
						</div>
						
						
						
						
						
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<div class="col-xs-12 padding-left-0 padding-right-0">
	
	<?php if($signdocumentpermission) { ?>
	<div class="col-md-3  padding-right-0">
	<div class="box box-primary">
	<div class="box-header with-border">
					<h5 class="box-title" style="font-size: 18px !important;">Sign Agreement</h5>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
						<!--<button type="button" class="btn btn-box-tool"
							data-widget="remove">
							<i class="fa fa-times"></i>
						</button>-->
					</div>
				</div>
				<div class="box-body col-xs-12 padding-left-0 padding-right-0 mtoppading">
							<div class="info-box  info-box1 bg-aqua" style="margin-bottom: 0px;">
								<span class="info-box-icon info-box-icon1"><i
									class="glyphicon glyphicon-pencil"></i></span>

								<div class="info-box-content info-box-content1">
									<span class="info-box-text">Sign Client Agreements</span>
									
									<?php if($right_sign_permission == TRUE){ 
											if(!empty($right_sign_docs) && $right_sign_docs->type != 1){ ?> 									
											<span class="progress-description" data-toggle="tooltip" data-placement="bottom" title="Please click the button to view the signed document." > Please click the button to
												view the signed document. </span>
											<a href="<?php echo $right_sign_docs->signed_doc_url;?>" target="_blank"><button style="color:black;">View</button></a>
											<?php } else if(!empty($right_sign_docs) && $right_sign_docs->type == 1){?>
											<span class="progress-description" data-toggle="tooltip" data-placement="bottom" title="Please click the button to view the signed document." > Please click the button to
												view the signed document. </span>
											<button style="color:black;">View</button>
											<?php } else{ ?>
											<span class="progress-description"  data-toggle="tooltip" data-placement="bottom" title="Please click the button to securely sign our client agreement document."> Please click the button to
												securely sign our client agreement document. </span>
											<?php if($brand_right_sign_url != ''){?>	
											<a href="<?php echo $brand_right_sign_url.'?signer[name]='.Html::encode($model_companies_year->company_client_number).'&signer[email]='.$session['client_email']; ?>" target="_blank"><button style="color:black;">Continue</button></a>
											<?php } else{?>
											<button style="color:black;" onclick="toastr.error('No URL found for this brand');">Continue</button>
											<?php } ?>
									<?php } } 
										else{
												if(!empty($session['is_client']) &&  $session['is_client'] == 'companyuser'){?>
													<span style="font-size: 13px;"> the BAA is not signed yet. Please contact <?php echo $users_list;?> </span>
									<?php 		} else{ ?>
										<span class="progress-description" data-toggle="tooltip" data-placement="bottom" title="Please click the button to securely sign our client agreement document."> Please click the button to
											securely sign our client agreement document. </span>
										<button style="color:black;cursor: not-allowed;" disabled>Continue</button>
										
									<?php 			} 
											}?>
								</div>

							</div>


							<!-- /.info-box-content -->
						</div>
	 
	</div>
	</div>
	<?php } ?>
	
	
	<?php if($document_upload_permission === TRUE) { ?>
	<div class="col-md-3  padding-right-0">
	<div class="box box-primary">
				<div class="box-header with-border">
					<h5 class="box-title" style="font-size: 18px !important;">Upload Secure Documents</h5>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
						<!--<button type="button" class="btn btn-box-tool"
							data-widget="remove">
							<i class="fa fa-times"></i>
						</button>-->
					</div>
				</div>
				<?php $model_upload_form = new UploadfileForm(); ?>
				<div class="box-body">
					<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data','id' => 'upload-to-sharefile-form','method' => 'POST', 'enableClientValidation' => false],'action'=>'/client/dashboard/uploaddocuments?c_id='.Yii::$app->request->get ( 'c_id' ),]); ?>
					<div class="form-group">
						<div class="">
							<label class="control-label"><h4>Choose document to upload securely</h4></label>
							<?=$form->field ( $model_upload_form, 'Document' )->fileInput ( [ 'class' => 'form-control form-height' ] )->label ( false )?>
    		
						</div>
					</div>
					<div class="form-group" style="margin-bottom:10px;">
						<div class="">
							<div class=" ">
								<?= Html::submitButton('Submit',  ['class'=> 'btn btn-primary btn-sm','onclick'=>'uploadsecuredocs();','id'=>'upload-doc-button']) ;?>
							</div>
						</div>
					</div>
					<?php  ActiveForm::end(); ?>
				</div>
	 
	</div>
	</div>
	<?php } if($document_download_permission === TRUE) { ?>
	<div class="col-md-3  padding-right-0">
	<div class="box box-primary">
				<div class="box-header with-border">
					<h5 class="box-title" style="font-size: 18px !important;">Download Secure Documents</h5>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
						<!--<button type="button" class="btn btn-box-tool"
							data-widget="remove">
							<i class="fa fa-times"></i>
						</button>-->
					</div>
				</div>
				<div class="box-body">
				
				
					<h5><u>Securely download documents including:</u></h5>
					
					<ul class="box_ul" style="list-style: none;
    padding: 0px;">
					  <li>Completed 1095 forms</li>
					  <li>Completed 1094 forms</li>
					  <li>Change request documents</li>
					  <li>IRS Acknowledgements</li>
					</ul>
					<div class="form-group" style="margin-bottom:10px;">
				<div class="">
				<div class=" ">
				<button type="submit" class="btn btn-primary btn-sm " data-toggle="modal" data-target="#download-documents" onclick="deleteDownloadedFiles('<?php echo Yii::$app->request->get('c_id'); ?>');" >Continue to secure area</button>
					
				</div>
				</div>
				</div>
	</div>
	</div>
	</div>
	<?php } ?>
	
	
	
	<div class="col-md-3 ">
	<div class="box box-primary">
				<div class="box-header with-border">
					<h5 class="box-title" style="font-size: 18px !important;">Application Overview</h5>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool"
							data-widget="collapse">
							<i class="fa fa-minus"></i>
						</button>
					<!--	<button type="button" class="btn btn-box-tool"
							data-widget="remove">
							<i class="fa fa-times"></i>
						</button>-->
					</div>
				</div>
				<div class="box-body">
	 <iframe width="100%" src="<?php 
	  $model_videolinks=new TblAcaVideoLinks();
	  $model_videos=$model_videolinks->dashboardurl(10); echo $model_videos; ?>" frameborder="0" allowfullscreen></iframe></div>
  	</div>
	</div>
	</div>

</div>


<!-- Modal -->
<div id="download-documents" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Available Documents</h4>
      </div>
      <div class="modal-body" style="float:left;width:100%;">
	  <?php if(!empty($folder_children)){foreach($folder_children as $files){ ?>
        <div class="col-xs-12" style="padding:0;margin-bottom:10px;">
			<div class="col-xs-1" style="padding:0;"><input type="checkbox" class="checked_files" id="<?php echo $files->Id; ?>" value="<?php echo $files->FileName; ?>"/></div>
			<div class="col-xs-10" style="padding:0;"><label><?php echo $files->FileName; ?></label></div>
		</div>
	  <?php }}
	  else{?>
		<div class="col-xs-12" style="padding:0;margin-bottom:10px;">
			<label>There are no secure documents available to download.</label>
		</div>
	  <?php } ?>
      </div>
      <div class="modal-footer">
	    <?php if(!empty($folder_children)){ ?>
			<button type="button" class="btn btn-primary"  onclick="downloadSelectedDocuments('<?php echo Yii::$app->request->get('c_id'); ?>');">Download</button>
		<?php } ?>
      </div>
    </div>

  </div>
</div>

<div class="load-gif" id="loadGif" style="display:none;">
	<div class="procressing_plz_wait">Processing please wait ....
		<img class="gif-img-prop" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/j-max-loader.gif" /> 
	</div>
</div>
<script>
function uploadsecuredocs(){	
	if(document.getElementById('uploadfileform-document').value!=''){
		//alert($('#uploadfileform-document').files[0].size);
		if($('.help-block-error').text() == '' || $('.help-block-error').text() != 'Only files with these extensions are allowed: doc, docx, pdf, png, jpg, jpeg, csv, xlsx, zip, rar, txt, pub, pptx, jnt, bmp.'){
			$("#loadGif").show();
		}
	}
}

$('#uploadfileform-document').bind('change', function() {

	  //this.files[0].size gets the size of your file.  
	  if(((this.files[0].size/1024/1024).toFixed(2)) > 69){
		  toastr.error('Uploaded file size should not be more than 70MB');
		  $('#upload-doc-button').attr('disabled','disabled');
		  return false;
	  }
	  else{
		  $('#upload-doc-button').prop("disabled", false); 
	  }

	});
</script> 