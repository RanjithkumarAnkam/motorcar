<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_users").addClass("active");
});
</script>
 <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/users.css" rel="stylesheet">
<div class=" box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title">Update User</h3>
		<span class="float-right"><a
			href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/users/index">Back
				to Manage Users</a></span>

	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band lighter"><i class="fa fa-file-text-o icon-band"></i></span>
		<p class="sub-header-new">You can update user from this screen.</p>
	</div>
	<div class="col-md-12">
		<div class=" box-info">

		 <?=$this->render ( '_form', [ 'model_users' => $model_users,'model_staff_users' => $model_staff_users ,'staff_rights_details'=>$staff_rights_details,'staff_permissions_details'=>$staff_permissions_details] )?>
		</div>
	</div>
</div>