<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_users").addClass("active");
});
</script>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class=" box box-warning container-fluid">
  <div class="box-header with-border">
              <h3 class="box-title">Assign Permissions to <?php echo $staff_name;?></h3>
			  	<span style="float:right;"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/users/index">Back to Manage Users</a></span>
	
            </div>
	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">You can manage permissions from this screen.</p>
	</div>
	<div class="col-md-12">
		<div class=" box-info">

			<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data','class'=>'form-horizontal']]); ?>
		
				<div class="box-body">
				

					<div class="form-group">
						<div class="col-sm-6">
							<label class="control-label"><h4>Assign Permissions</h4></label>
							
	<table id="example2" class="table table-bordered table-hover ">

		<thead>
			<tr class="tr-grid-header">
				<th style="width: 10%;">Select</th>
				<th>Pages</th>
			</tr>
		</thead>

		<tbody>
		         <tr>
				<td style="text-align: center;"><input type="checkbox" id="selectall" ></td>
				<td><span id="changeText">Administrator</span> </td>
			     </tr>

				<?php if(!empty($staff_rights_details)) {
					foreach($staff_rights_details as $rights){
						?>
					<tr>
						<td style="text-align: center;"><input type="checkbox"
							class="permission_check" value="<?php echo $rights->staff_permission_id; ?>" name="staffpermissions[]" <?php if(!empty($staff_permissions_details)) if(in_array($rights->staff_permission_id,$staff_permissions_details)) {?>checked<?php }?>></td>
						<td><span ><?php echo $rights->permission_name; ?></span></td>
					</tr>
					<?php } } ?>					

								
			</tbody>
	</table>	
						
			</div>
		      </div>


				</div>
				<!-- /.box-body -->
				<div class="form-group" style="margin-bottom:10px;">
				<div class="col-md-6">
				<div class=" pull-right">
				<button type="submit" class="btn btn-success ">Save Changes</button>
					<a type="submit" class="btn btn-default" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/users">Cancel</a>
					
				</div>
				</div>
				</div>
				<!-- /.box-footer -->
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>