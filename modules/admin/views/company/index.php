	<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_companies").addClass("active");
});
</script>
<?php 
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use yii\grid\GridView;
use yii\db\Query;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
  <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/companies.css" rel="stylesheet">
<div class="box box-warning">

	<div class="box-header with-border">
		<h3 class="box-title">Manage Companies</h3>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band lighter"
			></i></span>
		<p class="sub-header-new">Managing all the companies of the
			application is done from the list below.</p>
	</div>
	<div class="box-body">

		<div>
			<div class=" table  grid-filter m-5 filter-div-back filter-class">
				
				
				<div class="col-lg-12 padding-left-0 padding-right-0">

		<div class="tbl-aca-companies-search">

						<?php $form = ActiveForm::begin([
								'action' => ['index'],
								'method' => 'get',
							]); ?>
							<div class="col-lg-3  col-xs-12 padding-left-0 display-class"id=" w0-filters">
								<span style="line-height: 1.9;">Company Name :</span>&nbsp;&nbsp;&nbsp;
								
								<?= $form->field($searchModel, 'company_name')->label(false); ?>
									
							</div>

							
							<div class="col-lg-3 col-xs-4 display-class">
								 <?= Html::submitButton('Search', ['class' => 'btn btn-primary marginright']) ?>
								<a  class="btn btn-primary" href="<?php echo Yii::$app->homeUrl;?>admin/company">Cancel</a>
							</div>

						 <?php ActiveForm::end(); ?>
						 
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
			'attribute' => 'company_client_number',
			'label' => 'Company ID',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$company_client_number = '';
				if (! empty ( $model->company_client_number )) {
					$company_client_number = $model->company_client_number;
				}
				else
				{
					$company_client_number = 'NA';
				}
				return Html::encode($company_client_number);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca' 
			],
			'format' => 'raw' 
			],
			[ 
			'attribute' => 'company_name',
			'label' => 'Company Name',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$company_name = '';
				if (! empty ( $model->company_name )) {
					$company_name = $model->company_name;
				}
				else
				{
					$company_name = 'NA';
				}
				return Html::encode($company_name);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca' 
			],
			'format' => 'raw' 
			],
            [ 
			'attribute' => 'company_ein',
			'label' => 'Company EIN',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$company_ein = '';
				if (! empty ( $model->company_ein )) {
					$company_ein = $model->company_ein;
				}
				else
				{
					$company_ein = 'NA';
				}
				return Html::encode($company_ein);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca;color:#fff;' 
			],
			'format' => 'raw' 
			],
			[
			'attribute' => 'tbl_aca_company_reporting_period.year.lookup_value',
			'label' => 'Reporting Year',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$reporting_year = '';
				if (! empty ( $model->tbl_aca_company_reporting_period->year->lookup_value )) {
					$reporting_year = $model->tbl_aca_company_reporting_period->year->lookup_value;
				}
				
				return Html::encode($reporting_year);
			},
			'headerOptions' => [ 
					'style' => 'background-color:#428bca;color:#fff;' 
			],
			'format' => 'raw' 
			],
			[ 
			'attribute' => 'reporting_status',
			'label' => 'Reporting Status',
			'filter' => false,
			'value' => function ($model, $key, $index, $widget) {
				$reporting_status = '';
				if (! empty ( $model->reporting_status )) {
					
					$form = ActiveForm::begin();
					$listData= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 6])->andwhere(['=', 'lookup_status', 1])->all(), 'lookup_id', 'lookup_value');
					$reporting_status =  $form->field($model, 'reporting_status')->dropDownList($listData, ['prompt'=>'Select','class'=>'form-control form-height','id'=>'status_value_'.$model->company_id.''])->label(false);
					ActiveForm::end();
				}
				
				return $reporting_status;
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
			'contentOptions' => ['class' => 'text-center'],
'buttons' => [
    'my_button' => function ($url, $model, $key) {
		$company_id = $model->company_id;
        return Html::tag('p', '<a><span class="fa fa-floppy-o" data-toggle="tooltip" data-placement="bottom" title="Click to update company"></span></a>', ['class' => 'pointer','onclick'=>'changeStatus('.$model->company_id.')']) ;
    },
]
			],
        ],
    ]); ?>

		
<?php Pjax::end(); ?>						
								
							</div>

						</div>

					</div>
				</div>
			</div>



		</div>

	</div>
</div>