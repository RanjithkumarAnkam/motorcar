<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_clients").addClass("active");
});

</script>
 <?php
use app\models\TblAcaClients;
use app\components\EncryptDecryptComponent;
use yii\grid\GridView;
use yii\db\Query;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\TblAcaBrands;
use yii\widgets\Pjax;
?>
	      <link
 href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/client.css"
 rel="stylesheet">

<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Manage Clients</h3>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Managing all the clients of the application
			is done from the list below.</p>
	</div>

	<!-- /.box-header -->
	<div class="box-body">

		<div>
		<div class=" table  grid-filter m-5 filter-div-back" style="float: left;padding: 12px;
    border-top: 1px solid #ddd;">
				<div class="col-lg-12 padding-left-0" style="    padding-right: 0;">
				
				
			<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>	
		
				
				<div class="col-lg-3 col-md-6 padding-left-0 col-xs-12"  style="display: inline-flex;white-space: nowrap;">
			<span style="line-height:1.9;">Search by Client :</span>&nbsp;&nbsp;&nbsp;<!--<input type="search" id="global_filter" class="form-control global_filter" placeholder="" aria-controls="exampleClients">-->
			
			
			<?php $client = TblAcaClients::find()->where(['is_deleted'=>'0'])
			->orderBy(['client_name'=>SORT_ASC])
			->all();
			$listData= ArrayHelper::map($client, 'client_id', 'client_name');
               echo $form->field($searchModel, 'client_id')->dropDownList($listData, ['prompt'=>'Select','class'=>'form-control form-height'])->label(false);
 ?>
		
						
						
			</div>
				
				
				
				<div class="col-lg-3 col-md-6 col-xs-4" style="display: inline-flex;white-space: nowrap;">
				<?= Html::submitButton('Search', ['class' => 'btn btn-primary','style'=>'margin-right:5px;']) ?>
				<a class="btn btn-primary" href="<?php echo Yii::$app->homeUrl;?>admin/clients">Clear</a>
				</div>
				
	 <?php ActiveForm::end(); ?>	
				
				
				
				
				
				<div class="col-lg-3 pull-right col-md-6 col-xs-4 padding-right-0">
				
				<div>
				<a href="<?php echo Yii::$app->homeUrl;?>admin/clients/addform"><button type="reset" class="btn btn-success filter-btn-search pull-right">
										<i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;"></i>Add Client
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
							<?php Pjax::begin(); ?>
								 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [ 
			'attribute' => 'brand_id',
			'label' => 'Brand Name',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$brand_name = '';
				if (! empty ( $model->brand->brand_name )) {
					$brand_name = $model->brand->brand_name;
				}
				else
				{
					$brand_name = 'NA';
				}
				return Html::encode($brand_name);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca' 
			],
			'format' => 'raw' 
			],
			[ 
			'attribute' => 'client_id',
			'label' => 'Client Id',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$client_id = '';
				if (! empty ( $model->client_id )) {
					$client_id = $model->client_id;
					
				}
				else
				{
					$client_id = 'NA';
				}
				
				$model_brands=TblAcaBrands::Branduniquedetails($model->brand_id);
				if(! empty ($model_brands->brand_name)){
					$myBrand=$model_brands->brand_name;
					$result = substr($myBrand, 0, 3);
				}else{
					$result='';
				}
				$clientno = $result.''.'-'.''.$client_id;
				
				$encrypt_component = new EncryptDecryptComponent();
				$user_id = $encrypt_component->encrytedUser($model->user_id);
															
						
               return '<a class="pointer" data-toggle="tooltip" data-placement="bottom" title="Click to shadow login to client" onclick=openGridshadowlogin("'.$user_id.'");>'.$clientno.'</a>'  ;            
			
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca' 
			],
			'format' => 'raw' 
			],
			
			[
			'attribute' => 'client_name',
			'label' => 'Client Name',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$client_id = '';
				if (! empty ( $model->client_name )) {
					$client_name = $model->client_name;
				}
				else
				{
					$client_name = 'NA';
				}
				return Html::encode($client_name);
			},
			'headerOptions' => [
			'style' => 'background-color:#428bca'
					],
					'format' => 'raw'
							],
							
							
				
		
							
            [ 
			'attribute' => 'account_manager',
			'label' => 'Account Manager',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$account_manager = '';
				if (! empty ( $model->accountManager['tblAcaStaffUsers'][0]['first_name'] )) {
					$account_manager = $model->accountManager['tblAcaStaffUsers'][0]['first_name'];
				}
				else
				{
					$account_manager = 'NA';
				}
				return Html::encode($account_manager);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca;color:#fff;' 
			],
			'format' => 'raw' 
			],
			
			
			[
			'attribute' => 'contact_first_name',
			'label' => 'Contact First Name',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$contact_first_name = '';
				if (! empty ( $model->contact_first_name )) {
					$contact_first_name = $model->contact_first_name;
				}
				else
				{
					$contact_first_name = 'NA';
				}
				return Html::encode($contact_first_name);
			},
			'headerOptions' => [
			'style' => 'background-color:#428bca;color:#fff;'
					],
					'format' => 'raw'
							],
							
							
							[
							'attribute' => 'contact_last_name',
							'label' => 'Contact Last Name',
							'filter' => false,
							'value' => function ($model, $key, $index, $widget) {
								$contact_last_name = '';
								if (! empty ( $model->contact_last_name )) {
									$contact_last_name = $model->contact_last_name;
								}
								else
								{
									$contact_last_name = 'NA';
								}
								 return Html::encode($contact_last_name);
							},
							'headerOptions' => [
							'style' => 'background-color:#428bca;color:#fff;'
									],
									'format' => 'raw'
											],

											
											[
											'attribute' => 'package_type',
											'label' => 'Package Type',
											'filter' => false,
											'value' => function ($model, $key, $index, $widget) {
												$package_type = '';
												if (! empty ( $model->package->lookup_value )) {
													$package_type = $model->package->lookup_value;
												}
												else
												{
													$package_type = 'NA';
												}
												return Html::encode($package_type);
											},
											'headerOptions' => [
											'style' => 'background-color:#428bca;color:#fff;'
													],
													'format' => 'raw'
															],											
											
															[
															'attribute' => 'aca_year',
															'label' => 'ACA Year',
															'filter' => false,
															'value' => function ($model, $key, $index, $widget) {
																$aca_year = '';
																if (! empty ( $model->year->lookup_value )) {
																	$aca_year = $model->year->lookup_value;
																}
																else
																{
																	$aca_year = 'NA';
																}
																return Html::encode($aca_year);
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
		$client_id = $model->client_id;
		$encrypt_component = new EncryptDecryptComponent();
		$user_id = $encrypt_component->encrytedUser($client_id);
        return Html::a('<span class="fa fa-edit" data-toggle="tooltip" data-placement="bottom" title="Click to update client" ></span>',['/admin/clients/editclient', 'id' => $user_id], ['class' => 'pointer']) ;
    },
]
			],
        ],
    ]); ?>
	
							</div>
							
							
						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>

<?php Pjax::end(); ?>
		
		</div>

	</div>
	<!-- /.box-body -->
</div>
