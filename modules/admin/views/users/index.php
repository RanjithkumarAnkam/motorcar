<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_users").addClass("active");
	 
	 $('#1').css("pointer-events", "none");
	$('#1').css("color", "black");
});
</script>
<?php 
use app\models\TblAcaStaffUserPermission;
use yii\grid\GridView;
use yii\db\Query;
use app\components\EncryptDecryptComponent;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

 <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/users.css" rel="stylesheet">

<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Manage Users</h3>
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




			<div class=" table  grid-filter m-5 filter-div-back user-grid">
				<div class="col-lg-12 padding-left-0 padding-right-0">

<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
					<div class="col-lg-3 col-xs-4  padding-left-0 keyword-search">
						<span class="line-height">Keyword :</span>&nbsp;&nbsp;&nbsp;
						<?= $form->field($searchModel, 'first_name')->label(false); ?>
					</div>




					<div class="col-lg-3 col-xs-4 keyword-search">
						<?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-submit']) ?>
						<a class="btn btn-primary" href="<?php echo Yii::$app->homeUrl;?>admin/users">Clear</a>
					</div>
	 <?php ActiveForm::end(); ?>




					<div class="col-lg-3 pull-right col-xs-4  padding-right-0">

						<div>
							<a
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/users/addusers"><button
									type="reset"
									class="btn btn-success filter-btn-search pull-right">
									<i class="fa fa-plus btn-submit" aria-hidden="true"></i>Add Users
								</button></a>
						</div>
					</div>
				</div>




			</div>




			<div>

				<div class="row m-5">
					<div class="col-xs-12 panel-0">
						<div class="box">

							<!-- /.box-header -->
							<div class="box-body table-responsive">
								 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 
			'attribute' => 'first_name',
			'label' => 'First Name',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$first_name = '';
				if (! empty ( $model->first_name )) {
					$first_name = $model->first_name;
				}
				else
				{
					$first_name = 'NA';
				}
				return Html::encode($first_name);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca' 
			],
			'format' => 'raw' 
			],
			[ 
			'attribute' => 'last_name',
			'label' => 'Last Name',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$last_name = '';
				if (! empty ( $model->last_name )) {
					$last_name = $model->last_name;
				}
				else
				{
					$last_name = 'NA';
				}
			//	$encrypt_component = new EncryptDecryptComponent();
			//	$user_id = $encrypt_component->encrytedUser($client_id);
															
						
										                       
				return Html::encode($last_name);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca' 
			],
			'format' => 'raw' 
			],
			
			[
			'attribute' => 'useremail',
			'label' => 'Email',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$email = '';
				if (! empty ( $model->user->useremail )) {
					$email = $model->user->useremail;
				}
				else
				{
					$email = 'NA';
				}
				return Html::encode($email);
			},
			'headerOptions' => [
			'style' => 'background-color:#428bca;color:white'
					],
					'format' => 'raw'
							],
							
							
				
		
							
            [ 
			'attribute' => 'staff_id',
			'label' => 'Permissions',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
			
                $model_permissions = new TblAcaStaffUserPermission ();
				$permissions = $model_permissions->findPermissionsstring($model->staff_id);
															
				
				if (! empty ( $permissions )) {
                        $user_id = $model->user->user_id;
						$encrypt_component = new EncryptDecryptComponent();
						$user_id = $encrypt_component->encrytedUser($user_id);
					$permissions1 = preg_replace('/, $/', '', $permissions);
				//	$permissions2 = Html::a($permissions1, ['/admin/users/permission/', 'id' =>$user_id]);
					$permissions2 = '<a class="pointer" data-toggle="tooltip" data-placement="bottom" title="Click to update user permissions" href="/admin/users/permission/" >'.$permissions1.'</a>';
				}
				else
				{
					$permissions2 = '<a class="pointer" data-toggle="tooltip" data-placement="bottom" title="Click to update user permissions"  href="/admin/users/permission/" >No Permissions assigned</a>';
				}
				return $permissions2;
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca;color:#fff;' 
			],
			'format' => 'raw' 
			],
			
			
			[
			'attribute' => 'tbl_aca_users.user.is_active',
			'label' => 'Status',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
$status = $model->user->is_active;
$user_id = $model->user_id;
$session = \Yii::$app->session;
$logged_user_id = $session ['admin_user_id'];
if($logged_user_id != $user_id){
	switch ($model->user->is_active){
	case '1': $status_label = '<a class="pointer" data-toggle="tooltip" data-placement="bottom" title="Click to update user status to Inactive" id="'.$user_id.'" onclick="activateUser('.$user_id.',1);">Active</a>';
	break;
	case '0': $status_label = '<a class="pointer" data-toggle="tooltip" data-placement="bottom" title="Click to update user status to Active" style="color:red;" onclick="activateUser('.$user_id.',0);">Inactive</a>';
	break;
	default: $status_label = '';
	break;
            }
return $status_label;
}else{
switch ($model->user->is_active){
	case '1': $status_label = '<span id="'.$user_id.'">Active</span>';
	break;
	case '0': $status_label = '<span style="color:red;">Inactive</span>';
	break;
	default: $status_label = '';
	break;
}
return $status_label;
}
				
			},
			'headerOptions' => [
			'style' => 'background-color:#428bca;color:#fff;'
					],
					'format' => 'raw'
							],
							
							

            ['class' => 'yii\grid\ActionColumn',
			'header' => 'Update',
			'template' => '{my_button}', 
			'headerOptions' => [ 
					'style' => 'background-color:#428bca;color:#fff;' 
			],
'buttons' => [
    'my_button' => function ($url, $model, $key) {
		$user_id = $model->user->user_id;
		$encrypt_component = new EncryptDecryptComponent();
		$user_id = $encrypt_component->encrytedUser($user_id);
        return Html::a('<span class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Click to update user"></span>',['/admin/users/updateusers', 'id' => $user_id], ['class' => 'pointer']) ;
    },
]
			],
        ],
    ]); ?>
							</div>

						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
</div>

