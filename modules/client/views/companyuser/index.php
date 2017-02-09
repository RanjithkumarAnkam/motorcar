<?php
use app\models\TblAcaCompanyUserPermission;
use app\components\EncryptDecryptComponent;
use yii\helpers\Html;
$get_id = Yii::$app->request->get ();
$company_id = $get_id ['c_id'];

?>

 <?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/client/companyuser.css"); ?>

<!-- Start Div -->
<div class="box box-warning">


	<div class="box-header with-border">
		<h3 class="box-title col-sm-6">Company Users - <?php echo Html::encode($company_details->company_name); ?> <small> (<?php echo Html::encode($company_details->company_client_number); ?>) </small>
		</h3>

		<a class="col-sm- btn bg-orange btn-flat btn-social pull-right"
			data-toggle="tooltip" data-placement="bottom"
			title="Click to view help video" onclick="playVideo(2);"> <i
			class="fa fa-youtube-play"></i>View Help Video
		</a>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Managing all the users of the application is
			done from the list below.</p>
	</div>

	<!-- /.box-header -->
	<div class="box-body">

		<div>
			<div class="table-responsive grid-filter m-5 pull-right">
				<table class="table filter-table middle-align mb-0">
					<tbody>
						<tr class="">




							<td title="Add User" class="border-top-none"><a type="reset"
								class="btn btn-success btn-sm filter-btn-search"
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/client/companyuser/adduser?c_id=<?php echo $company_id; ?>">
									<i class="fa fa-plus mar-r-5" aria-hidden="true"></i>Add User
							</a></td>




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

								<!-- Start Table -->
								<table id="exampleCompanyusers"
									class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">

											<th>First Name</th>
											<th>Last Name</th>


											<th>Email</th>
											<th>Phone</th>
											<th>Role</th>
											<th class="hide">Status</th>
											<th>Access</th>

											<!-- <th>Companies</th>
								<th>Periods</th> -->
											<th>Update</th>


										</tr>
									</thead>
									<tbody>
							<?php
							
							if (! empty ( $all_company_users )) {
								$model_permissions = new TblAcaCompanyUserPermission ();
								$encrypt_component = new EncryptDecryptComponent ();
								foreach ( $all_company_users as $users ) {
									?>
							<tr>

											<td><?php echo Html::encode($users->first_name); ?></td>
											<td><?php echo Html::encode($users->last_name); ?></td>
											<td><?php echo Html::encode($users->email); ?></td>
											<td><?php echo Html::encode($users->phone); ?></td>
											<td><?php echo Html::encode($users->role_notes); ?></td>

											<td class="hide">
								<?php
									$encrypt_user_id = $encrypt_component->encrytedUser ( $users->user->user_id );
									
									if ($users->user->is_active == 1) {
										
										?>
								<a class="pointer"
												onclick="activateUserstatus('<?php echo $encrypt_user_id;?>','<?php echo $company_id?>');">Active</a>
								<?php }else{?> 
								<span class="red pointer"
												onclick="activateUserstatus('<?php echo $encrypt_user_id;?>','<?php echo $company_id?>');">Inactive</span>
								 <?php }?>
								 </td>

											<td><?php $permissions = $model_permissions->findPermissionsstring($users->company_user_id,$company_details->company_id); if(!empty($permissions)){ echo  preg_replace('/, $/', '', $permissions); } ?></td>
								<?php
									$encrypt_company_user_id = $encrypt_component->encrytedUser ( $users->company_user_id );
									?>
								<td style="text-align: center;"><a data-toggle="tooltip"
												data-placement="bottom" title="Click to update company user"
												href="<?php echo Yii::$app->homeUrl;?>client/companyuser/updateuser?c_id=<?php echo $company_id; ?>&company_user_id=<?php echo $encrypt_company_user_id; ?>"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>


										</tr>	
							
							<?php }} ?>
																			
						</tbody>

								</table>

								<!-- End Table -->
							</div>


						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>

		</div>

	</div>
</div>
<!-- End Div -->

<!--Script Start  -->

<script type="text/javascript">
	$(document).ready(function(){
			    $('#exampleCompanyusers').DataTable({

			    	"aoColumnDefs": [

										{

										"bSortable": false,

										"aTargets": [ -1 ]

										}

										],
										
											"bFilter" : false,               
			    	"bLengthChange": false
			    });
				

	 $("#company_users").addClass("active");


			});
			
			
</script>
<!--Script End  -->