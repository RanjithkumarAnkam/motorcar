<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_jobschedule").addClass("active");
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
              <h3 class="box-title">Schedule Jobs</h3>
            </div>
			
	<div class="col-xs-12 header-new-main width-98 ">  
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Managing all the errors of the application is done from the list below.</p>
	</div>
	
	
	<div class="col-md-12" style="padding-top:10px;">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#form_validation">Form Validation</a></li>
			<li><a data-toggle="tab" href="#form_creation">Form Creation</a></li>
			<li><a data-toggle="tab" href="#pdf_generation">Pdf Generation</a></li>
			<li><a data-toggle="tab" href="#xml_generation">Xml Generation</a></li>
			
		</ul>

		<div class="tab-content">
						
			<div id="form_validation" class="tab-pane fade  in active">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th style="width:28%;">Company Name</th>
											<th>Client Name</th>
											<th style="width:28%;">Scheduled Time</th>
											<th>Error Message</th>
											
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
									<?php $i=1;?>
									<?php if(!empty($model_validation_status)){
										foreach($model_validation_status as $model_validation){?>
										<tr>											
											<td style=""><?php echo $model_validation->company->company_name;?></td>
											<td style="" ><?php echo $model_validation->company->client->client_name; ?></td>
											<td style="" ><?php echo $model_validation->start_date_time;?></td>
											<td style=""><?php echo $model_validation->exception;?></td>

										</tr>
											<?php $i++?>
										<?php }} else{ ?>
										<tr>
								<td colspan="5" class="text-order" > No records found </td>
								</tr>
										<?php }?>
									

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="form_creation" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
									<table id="" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th style="width:28%;">Company Name</th>
											<th>Client Name</th>
											<th style="width:28%;">Scheduled Time</th>
											<th>Error Message</th>
											
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
										<?php $i=1;?>
									<?php if(!empty($model_generate_forms)){
										foreach($model_generate_forms as $model_generate){?>
										<tr>											
											<td style=""><?php if(!empty($model_generate['company_name'])){echo $model_generate['company_name'];}?></td>
											<td style="" ><?php if(!empty($model_generate['client_name'])){echo $model_generate['client_name']; }?></td>
											<td style="" ><?php if(!empty($model_generate['created_date'])){echo $model_generate['created_date'];}?></td>
											<td style=""><?php 
											if($model_generate['cron_status']==0){
												echo '';
											}else {
											if(!empty($model_generate['error_desc'])){
												
												echo $model_generate_form->errortype($model_generate['error_type']).' '. $model_generate['error_desc'];}
												}
												?>
												
												
												</td>

										</tr>
										<?php $i++?>
										<?php }} else{ ?>
										<tr>
								<td colspan="5" class="text-order" > No records found </td>
								</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="pdf_generation" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
									<table id="" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th style="width:28%;">Company Name</th>
											<th>Client Name</th>
											<th style="width:28%;">Scheduled Time</th>
											<th>Error Message</th>
											
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
										<?php $i=1;?>
									<?php if(!empty($model_generate_pdf)){
										foreach($model_generate_pdf as $model_pdfgenerate){?>
										<tr>											
											<td style=""><?php if(!empty($model_pdfgenerate['company_name'])){echo $model_pdfgenerate['company_name'];}?></td>
											<td style="" ><?php if(!empty($model_pdfgenerate['client_name'])){echo $model_pdfgenerate['client_name']; }?></td>
											<td style="" ><?php if(!empty($model_pdfgenerate['created_date'])){echo $model_pdfgenerate['created_date'];}?></td>
											<td style=""><?php 
											
											if($model_pdfgenerate['status']==0){
												echo '';
											}else {
											if(!empty($model_pdfgenerate['error_desc']) && $model_pdfgenerate['error_type'] == 4){
												echo $model_generate_form->errortype($model_pdfgenerate['error_type']).' '.$model_pdfgenerate['error_desc'];}
												}
												?></td>

										</tr>
										<?php $i++?>
										<?php }} else{ ?>
										<tr>
								<td colspan="5" class="text-order" > No records found </td>
								</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="xml_generation" class="tab-pane fade">
				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								<table id="" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th style="width:28%;">Company Name</th>
											<th>Client Name</th>
											<th style="width:28%;">Scheduled Time</th>
											<th>Error Message</th>
											
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
										<?php $i=1;?>
									<?php if(!empty($model_generate_xml)){
										foreach($model_generate_xml as $model_generate){?>
										<tr>											
											<td style=""><?php if(!empty($model_generate['company_name'])){echo $model_generate['company_name'];}?></td>
											<td style="" ><?php if(!empty($model_generate['client_name'])){echo $model_generate['client_name'];} ?></td>
											<td style="" ><?php if(!empty($model_generate['created_date'])){echo $model_generate['created_date'];}?></td>
											<td style=""><?php 
											
											if($model_generate['error_type']==5){
												
												if(!empty($model_generat['error_desc'])){
													echo $model_generate_form->errortype($model_generate['error_type']).' '.$model_generate['error_desc'];}
																							
											}else {
											echo '';
												}?>
												
												</td>

										</tr>
										<?php $i++?>
										<?php }} else{ ?>
										<tr>
								<td colspan="5" class="text-order" > No records found </td>
								</tr>
										<?php }?>
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

