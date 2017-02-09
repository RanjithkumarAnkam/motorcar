<?php use app\components\EncryptDecryptComponent;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use yii\grid\GridView;
use yii\db\Query;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<script>
window.onload= function(){
 $("#no_client_selected").attr('disabled','disabled');
}
</script>
<style>
.text-order{
color:red;
text-align:center;
}
.padding-bottom-10{
	padding-bottom:10px;
}
.width-12{
	width:12%;
}
.padding-0{
	padding:0px;
}
.width-1{
	width:1%;
}
</style>
<div>
<div class="box-header with-border">
		<h3 class="box-title">Copy Companies</h3>
	</div>
	<div class="col-xs-12 header-new-main width-98 ">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band lighter"></i></span>
		<p class="sub-header-new">This screen is used to copy the company details of one(has data) to another(Doesn't have data).</p>
	</div>
	
	<?php $form = ActiveForm::begin([
        'action' => ['copy/copydetails'],
        'method' => 'post',
		'id'=>'copycompany-form',
    ]); ?>
	<div class=" table  grid-filter m-5 filter-div-back similar-css">
			
		
				<div class="col-lg-12 padding-right-0 padding-bottom-10">

					<div class="col-lg-2 keyword padding-0  width-12">
						<span class="lineheight">Select Client Name :&nbsp;&nbsp;&nbsp;</span>
					</div>
					 <div class="col-lg-2 keyword"> 
					 <select class="form-control" id="client_list" onchange="getCompany();">
					<?php if($encryptclient_id ==''){?><option value="">Select Client</option><?php }?>
					<?php 
						if(!empty($model_clients)){
                               foreach($model_clients as $model_client){
                          $encrypt_component = new EncryptDecryptComponent ();
                          $encrypt_client_id = $encrypt_component->encrytedUser($model_client->client_id);;?>
							<option id="client_<?php echo $encrypt_client_id;?>" value="<?php echo $encrypt_client_id;?>" name="client-id"
							<?php if($encryptclient_id == $encrypt_client_id){echo 'selected';}?> ><?php echo $model_client->client_name.'-'. $model_client->year->lookup_value;?></option>
							
							<?php }}?>
						</select>
					</div>
					<div class="col-lg-1 width-1">
					</div>
					<?php if($encryptclient_id !=''){?>
					<div class="col-lg-2 keyword padding-0 width-12">
						<span class="lineheight">Select Company Name :&nbsp;&nbsp;&nbsp;</span>
					</div>
					 <div class="col-lg-2 keyword"> 
					 <select class="form-control" id="company_list" name="data-company-id">
				<option value="">Select Company</option>
				<?php 
						if(!empty($model_datacompanies)){
                               foreach($model_datacompanies as $model_data){
                          $encrypt_component = new EncryptDecryptComponent ();
                          $encrypt_company_id = $encrypt_component->encrytedUser($model_data->company_id);?>
							<option id="company_<?php echo $encrypt_company_id;?>" value="<?php echo $encrypt_company_id;?>" ><?php if(!empty($model_data->company_name)){echo $model_data->company_name;}else{echo 'Not set';} ?></option>
							
							<?php }}?>
							
						</select>
					</div>
                     <?php }?>
					<div class="col-lg-2 keyword">
					
					  <?php echo Html::submitButton('Copy', ['class' => 'btn btn-primary','id' => $encryptclient_id ? 'copy_company':'no_client_selected',"data-toggle"=>"tooltip","data-placement"=>"bottom","title"=>"Click to Copy Company Details"]); ?>
						<!-- <a class="btn  btn-primary" onclick="return copyDetails();">Copy</a>-->
						<a class="btn  btn-primary"
							href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/copy">Cancel</a>
					</div>

				</div>

						
	<div class="row m-5">
		<div class="col-xs-12 panel-0">
			<div class="box">

				<!-- /.box-header -->
				<div class="box-body table-responsive">
			<?php if($encryptclient_id !='' && !empty($arrayCompanynodata) && !empty($model_datacompanies)){?>	<div class="col-sm-offset-10 col-md-offset-10"><div style=" font-weight: 700;"><input class="company-check-all" style="vertical-align: top;" type="checkbox"> Select All </div></div><?php }?>
									<table id="" class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">
																					
											<th>Company Name</th>
											<th>Select</th>
											
											
										<!-- 	<th>Update</th> -->
											
										</tr>
									</thead>
									<tbody>
										
									<?php if($encryptclient_id !=''){
									if(!empty($model_datacompanies)){
									if(!empty($arrayCompanynodata)){
										foreach($arrayCompanynodata as $companydetails){
										$encrypt_component = new EncryptDecryptComponent ();
										$encrypt_company_id = $encrypt_component->encrytedUser($companydetails['company_id']);
										?>
										<tr>											
											
											<td style="" ><?php if(!empty($companydetails['company_name'])){echo $companydetails['company_name']; }else{ echo 'Company Id :   '.$companydetails['company_client_number'];}?> </td>
											<td style=""><?php if(!empty($companydetails['company_name'])){?><input type="checkbox" class="company-checkbox" value="<?php echo $encrypt_company_id;?>" name="nodata-company[<?php echo $encrypt_company_id;?>]"/><?php }else{?><span style="color:red">Please Update Company name</span><?php }?></td>
										</tr>
										
										<?php }}else{?>
										<tr>
								<td colspan="2" class="text-order" > No records found with null company data </td>
								</tr>
										<?php } } else{ ?>
										<tr>
								<td colspan="2" class="text-order" > Please fill atleast one company in this client. </td>
								</tr>
									<?php }}else{?>
									<tr>
								<td colspan="2" class="text-order" > Please Select a Client to Copy Company details. </td>
								</tr>
									<?php }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				
			</div>
			
			
			</div>

			
    <?php ActiveForm::end(); ?>
						</div>