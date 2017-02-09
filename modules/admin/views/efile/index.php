<script type="text/javascript">
$(document).ready(function(){
	 $("#mng_efile").addClass("active");	
datepickerintialise();	 
});
</script>
<style>
.active.day
{
	 background: #428bca !important
    color: #fff;
}
</style>
<?php 
use app\models\TblAcaStaffUserPermission;
use yii\grid\GridView;
use yii\db\Query;
use app\components\EncryptDecryptComponent;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

 <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/users.css" rel="stylesheet">

<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Manage E-File Clients</h3>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Managing all the e-files approved by clients of the application is
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
					<div class="col-lg-3 col-xs-4  padding-left-0 keyword-search width-12">
						<span class="line-height">Company Name :</span>&nbsp;&nbsp;&nbsp;
					</div>

					<div class="col-lg-2 col-xs-4  padding-left-0 keyword-search">
		              
						<?= $form->field($searchModel, 'approved_by_name')->label(false); ?>
					</div>




					<div class="col-lg-3 col-xs-4 keyword-search">
						<?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-submit']) ?>
						<a class="btn btn-primary" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/admin/efile">Clear</a>
					</div>
	 <?php ActiveForm::end(); ?>




					<!--<div class="col-lg-3 pull-right col-xs-4  padding-right-0">

						<div>
							<a
								href="<?php //echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/users/addusers"><button
									type="reset"
									class="btn btn-success filter-btn-search pull-right">
									<i class="fa fa-plus btn-submit" aria-hidden="true"></i>Add Users
								</button></a>
						</div>
					</div> -->
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
											'attribute' => 'company.company_name',
											'label' => 'Company Name',
											'filter' => false,
											/*'value' => function ($model, $key, $index, $widget) {
											
												if (! empty ( $model->company->company_name )) {
													$reporting_year = $model->company->company_name	;
												}
												
												return Html::encode($reporting_year);
											},*/
											'headerOptions' => [ 
													'class' => 'tr-grid-header' 
											],
											'format' => 'raw' 
											],
											[ 
											'attribute' => 'company.company_client_number',
											'label' => 'Company ID',
											'filter' => false,
											/*'value' => function ($model, $key, $index, $widget) {
												$company_client_number = '';
												if (! empty ( $model->company_client_number )) {
													$company_client_number = $model->company_client_number;
												}
												else
												{
													$company_client_number = 'NA';
												}
												return Html::encode($company_client_number);
											},*/
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'format' => 'raw' 
											],
											[ 
											'attribute' => 'approved_by_name',
											'label' => 'E-File Approved By',
											'filter' => false,
											'value' => function ($model, $key, $index, $widget) {
												$approved_by_name = '';
												if (! empty ( $model->username->first_name ) && ! empty ( $model->username->last_name )) {
													$approved_by_name = $model->username->first_name .' '.$model->username->last_name;
												}
												else
												{
													$approved_by_name = 'NA';
												}
												return Html::encode($approved_by_name);
											},
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'format' => 'raw' 
											],
											[
											'attribute' => 'approved_date',
											'label' => 'E-File Approved Date',
											'filter' => false,
											'value' => function ($model, $key, $index, $widget) {
												$approved_date = '';
												if (! empty ( $model->approved_date )) {
													$approved_date = date('m-d-Y, H:i A',strtotime($model->approved_date));
												}
												
												return Html::encode($approved_date);
											},
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'format' => 'raw' 
											],
											/*['class' => 'yii\grid\ActionColumn',
											'header' => 'Generate XML',
											'template' => '{my_xml_button}', 
											'headerOptions' => [ 
													'style' => 'background-color:#428bca;color:#fff;' 
											],
											'contentOptions' => ['class' => 'text-center'],
												'buttons' => [
													'my_xml_button' => function ($url, $model, $key) {
														$form_id = $model->id;
														if(!empty($model->xml_file)){
															
														return Html::tag('p', '<a><span class="fa fa-download" data-toggle="tooltip" data-placement="bottom" title="Click to Generate XML"></span></a>', ['class' => 'pointer-events']) ;
														}else{
														return Html::tag('p', '<a><span class="fa fa-download" data-toggle="tooltip" data-placement="bottom" title="Click to Generate XML"></span></a>', ['class' => 'pointer','onclick'=>'generateXML('.$form_id.')']) ;
														}
													},
												]
											],
											['class' => 'yii\grid\ActionColumn',
											'header' => 'Download XLS',
											'template' => '{my_xls_button}', 
											'headerOptions' => [ 
													'style' => 'background-color:#428bca;color:#fff;' 
											],
											'contentOptions' => ['class' => 'text-center'],
												'buttons' => [
													'my_xls_button' => function ($url, $model, $key) {
														$company_id = $model->company_id;
														return Html::tag('p', '<a><span class="fa fa-download" data-toggle="tooltip" data-placement="bottom" title="Click to download XLS"></span></a>', ['class' => 'pointer','onclick'=>'downloadXLS('.$model->company_id.')']) ;
													},
												]
											],*/
											[ 
											'attribute' => 'efile_status',
											'label' => 'E-File Status',
											'filter' => false,
											'value' => function ($model, $key, $index, $widget) {
												$efile_status = '';
												if (! empty ( $model->efile_status )) {
													
													/*$efile_status = '<select id="efile_status" class="form-control">
														<option value="">Select</option>
														<option value="Approved"'if($model->efile_status == "Approved"){"Selected"}'>Approved</option>
														<option value="Processing"'if($model->efile_status == 'Processing'){'Selected'}'>Processing</option>
														<option value="IRS Pending"'if($model->efile_status == 'IRS Pending'){'Selected'}'>IRS Pending</option>
														<option value="File completed"'if($model->efile_status == 'File completed'){'Selected'}'>File completed</option>
													</select>';*/
													$form = ActiveForm::begin();
													$listData= array('Approved'=>'Approved','IRS Processing'=>'IRS Processing','Accepted'=>'Accepted','Accepted with Errors'=>'Accepted with Errors','Rejected'=>'Rejected');
													$efile_status =  $form->field($model, 'efile_status')->dropDownList($listData, ['class'=>'form-control ','id'=>'status_value_'.$model->id.''])->label(false);
													ActiveForm::end();
												}
												else{
													$form = ActiveForm::begin();
													$listData= array('Approved'=>'Approved','IRS Processing'=>'IRS Processing','Accepted'=>'Accepted','Accepted with Errors'=>'Accepted with Errors','Rejected'=>'Rejected');
													$efile_status =  $form->field($model, 'efile_status')->dropDownList($listData, ['class'=>'form-control ','id'=>'status_value_'.$model->id.''])->label(false);
													ActiveForm::end();
												}
												
												return $efile_status;
											},
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'format' => 'raw' 
											],
											
												[ 
											'attribute' => 'csv_file',
											'label' => 'Download Csv',
											'filter' => false,
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'format' => 'raw' ,
											'value' => function ($model, $key, $index, $widget) {
												 return Html::tag('h5', '<a><span class="fa fa-download" data-toggle="tooltip" data-placement="bottom" title="Click to update"></span></a>', ['class' => 'pointer','onclick'=>'downloadCsv('.$model->id.')']) ; ;
											},
											],
											
											['class' => 'yii\grid\ActionColumn',
											'header' => 'Original E-File Date',
											'template' => '{my_date_button}', 
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'contentOptions' => ['class' => 'text-center'],
												'buttons' => [
													'my_date_button' => function ($url, $model, $key) {
														$company_id = $model->company_id;
														$receipt_date = '';
														$receipt_date = $model->efile_receipt_date;
														if($receipt_date != '')
														{
														$receipt_date =	date('m/d/Y',strtotime($model->efile_receipt_date));
														}
														return Html::tag('p', '<input  maxlength="15" id="date_number_'.$model->id.'" class="form-control datepicker" value="'.$receipt_date.'" />', ['class' => 'pointer']) ;
													},
												]
											],
											
											['class' => 'yii\grid\ActionColumn',
											'header' => 'E-File Receipt Number',
											'template' => '{my_receipt_button}', 
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'contentOptions' => ['class' => 'text-center'],
												'buttons' => [
													'my_receipt_button' => function ($url, $model, $key) {
														$company_id = $model->company_id;
														return Html::tag('p', '<input type="text" maxlength="15" id="receipt_number_'.$model->id.'" class="form-control" value="'.$model->efile_receipt_number.'" onkeypress="return companyname(event);"/>', ['class' => 'pointer']) ;
													},
												]
											],

											['class' => 'yii\grid\ActionColumn',
											'header' => 'Actions',
											'template' => '{my_button}', 
											'headerOptions' => [ 
													'class' => 'tr-grid-header'
											],
											'contentOptions' => ['class' => 'text-center'],
											'buttons' => [
												'my_button' => function ($url, $model, $key) {
													$company_id = $model->company_id;
													
													$updatebutton = Html::tag('h5', '<a><span class="fa fa-floppy-o" data-toggle="tooltip" data-placement="bottom" title="Click to update"></span></a>', ['class' => 'pointer','onclick'=>'updateEfileDetails('.$model->id.')']) ; 
													$downloadbutton = Html::tag('h5', '<a><span class="fa fa-download" data-toggle="tooltip" data-placement="top" title="Click to download XML"></span></a>', ['class' => 'pointer','onclick'=>'downloadXML('.$model->id.')']) ;
													if(!empty($model->xml_file)){
													   return '<div class="row"> <div class="col-md-6">'.$updatebutton.'</div><div class="col-md-6">'.$downloadbutton.'</div> </div>';
													}else{
														 return Html::tag('h5', '<a><span class="fa fa-floppy-o" data-toggle="tooltip" data-placement="bottom" title="Click to update"></span></a>', ['class' => 'pointer','onclick'=>'updateEfileDetails('.$model->id.')']) ; ;
													    
													}
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

