<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_brands").addClass("active");
});
</script>
 <?php

use app\components\EncryptDecryptComponent;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
?>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/masterdata.css" rel="stylesheet">
 
<div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Manage Brands</h3>
            </div>
			
 <div class="col-xs-12 header-new-main width-98 hide"> 
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">Managing all the brands of the client is done from the list below.</p>
</div> 

            <!-- /.box-header -->
            <div class="box-body">
            
            <div>
<div class="table-responsive grid-filter m-5 pull-right">
	<table class="table filter-table middle-align mb-0">
		<tbody>
			<tr >


				
				<td title="Add Brand" class="bordertop"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/addbrand">
				<button type="reset" class="btn btn-success filter-btn-search" style="">
				<i class="fa fa-plus" aria-hidden="true" style="margin-right:5px;"></i>Add Brand</button></a></td>

				
			</tr>
		</tbody>
	</table>
</div>
<div>

	<div class="row m-5">
		<div class="col-xs-12 panel-0">
			<div class="box">

				<!-- /.box-header -->
				<div class="box-body table-responsive">
					<table id="exampleManagedata" class="table table-bordered table-hover">
						<thead>
							<tr class="tr-grid-header">

								<th>Thumbnail</th>
								<th>Brand Name</th>
								<th>Support Email</th>
								<th>Support Phone Number</th>
								<th>Terms and Condition URL</th>
								<th>Right Signature URL</th>
								<th>Status</th>
								
								
								<th>Edit</th>
								<th>Delete</th>
								

							</tr>
						</thead>
						<tbody>
				
							<?php if(!empty($model)){?>
							<?php  foreach($model as $brands){?>
							<tr>
								<td class="img-width-td"><img class="img-width" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/brand_logo/<?php echo Html::encode($brands['brand_logo']);?>"></td>
								<td><?php echo Html::encode($brands['brand_name']);?></td>
								<td><?php echo Html::encode($brands['support_email']);?></td>
								<td><?php echo Html::encode($brands['support_number']);?></td>
								<td><?php if($brands['brand_url']!=NULL){echo Html::encode($brands['brand_url']);} else {echo "-";}?></td>
								<td><?php echo Html::encode($brands['right_sign_url']);?></td>
								<td><a href="#" onclick="activateBrand(<?php echo $brands['brand_id'];?>,<?php echo $brands['brand_status'];?>);"><?php if($brands['brand_status']==1){?>Active<?php }elseif($brands['brand_status']==2){ ?><span style="color:red;">Inactive</span></a><?php }?></td>
							<?php 	$encrypt_component = new EncryptDecryptComponent();
			                      	$brand_id = $encrypt_component->encrytedUser($brands['brand_id']);?>
								<td><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/editbrand?id=<?php echo $brand_id?>" title="edit" style="margin-left: 13px;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
							 	<td><a title="delete"  data-toggle="confirmation" onclick="deleteModal(<?php echo $brands['brand_id'];?>);" href="#" style="margin-left:13px ;color:red;"><i class="fa fa-times" aria-hidden="true"></i></a></td>
								 
							</tr>
							
						<?php }} else{ ?>
							<tr>
								<td colspan="5" class="text-order" > No records found </td>
								</tr>
								<?php } ?>
																		
						</tbody>

					</table>
				</div>
			
			</div>
			<!-- /.box -->
		</div>
	</div>
</div>

		</div>
		       </div>
            <!-- /.box-body -->
          </div>
          
		  
		  
<form id="brand-delete">
<div class="modal fade" id="mybrandlink" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Delete Brand Confirmation</h4>
			</div>
			
			<div class="modal-body">
			<div class="form-group">
				<div class="col-sm-12 add-mem"  style="line-height: 33px;">
					<label class="add-member-label">Are you sure , you want to delete the brand ?</label>
				</div>
				
	</div>
			</div>
			<div class="modal-footer footer">
				<button type="button" class="btn btn-default btn-sm"
					data-dismiss="modal" >Close</button>
					   <a id="MasterBrand" class="btn btn-primary btn-sm" >Delete</a>
				
			</div>
			
		</div>
	</div>
</div></form>

<script type="text/javascript">

	$(document).ready(function(){
			    $('#exampleManagedata').DataTable({

			    	"aoColumnDefs": [
										{
										"bSortable": false,

										"aTargets": [ -1,-2 ]
										}
										],
										
											"bFilter" : false,               
			    	"bLengthChange": false
			    });
			});





</script>
          