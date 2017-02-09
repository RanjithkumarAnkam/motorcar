<?php use app\components\EncryptDecryptComponent;
use yii\helpers\ArrayHelper;
use app\models\TblAcaLookupOptions;
use yii\grid\GridView;
use yii\db\Query;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/client/companies.css"); ?>


<div class="box box-warning container-fluid">

	<div class="box-header with-border">
		<h3 class="box-title col-xs-6">
			Your Companies List <span class="font15">( Number of EIN's bought : <?php if(!empty($all_companies)){ echo count($all_companies);}else { echo '0'; } ?> )</span>
		</h3>
		<div class="col-xs-6 pull-right padding-right-0">
			<a class=" btn bg-orange btn-social pull-right " data-toggle="tooltip" data-placement="bottom" title="Click to view help video" onclick="playVideo(1);"> <i
				class="fa fa-youtube-play"></i>View Help Video
			</a>
		</div>
	</div>

	<div class="col-xs-12 header-new-main width-98 ">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band lighter"></i></span>
		<p class="sub-header-new">Select Company to Get Started</p>
	</div>

	<div class="box-body">

		<div>
			<div class=" table  grid-filter m-5 filter-div-back similar-css">
			
			<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
				<div class="col-lg-12 padding-right-0">

					<div class="col-lg-3 col-md-6 keyword">
						<span class="lineheight">Select Company Name :</span>&nbsp;&nbsp;&nbsp;<?php 
						
					
						if(!empty($all_companies)){
							$listcompanies= ArrayHelper::map($all_companies, function($model, $defaultValue) {
								$encrypt_component = new EncryptDecryptComponent();
								return $encrypt_component->encrytedUser($model['company_id']);;
							},
							function($model, $defaultValue) {
								return $model['company_name'].' ('.$model['company_client_number'].')';
							});
							
						}
						if(!empty($listcompanies)){
							echo $form->field($searchModel, 'company_id')->dropDownList($listcompanies, ['prompt'=>'Select','class'=>'form-control '])->label(false);
						}
						?>
					</div>

					


					<div class="col-lg-3 col-md-6 keyword">
						 <?= Html::submitButton('Search', ['class' => 'btn btn-primary','style'=>'margin-right:5px;']) ?>
						<a class="btn  btn-primary"
															href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/companies">Cancel</a>
					</div>










				</div>

<?php ActiveForm::end(); ?>


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
			'attribute' => 'company_client_number',
			'label' => 'Company Id',
			'filter' => false,
			
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
										$encrypt_component = new EncryptDecryptComponent();
										$encrypt_id = $encrypt_component->encrytedUser($model->company_id);
										if (! empty ( $model->company_name )) {
											$company_name = $model->company_name;
											
											
											return '<span style="">'.''.Html::tag('span', '<a href="/client/dashboard?c_id='.$encrypt_id.'" data-toggle="tooltip" data-placement="bottom" title="Click to view company dashboard">'.$company_name.'</a>', ['class' => 'pointer']).'</span>' ;
										}
										else
										{
												return '<span style="">'.''.Html::tag('span', '<a data-toggle="tooltip" data-placement="bottom" title="Click to update company details"><span class="fa fa-edit pointer marginr-6"></span></a>', ['class' => 'pointer','onclick'=>'showupdatemodal("'.$encrypt_id.'")']).''.'Update'.''.'</span>' ;
										}
										
									},										
				'headerOptions' => [
					'style' => 'background-color:#428bca'
							],
						'format' => 'raw'
							],
											
									[
									'attribute' => 'tbl_aca_company_reporting_period.year.lookup_value',
									'label' => 'Reporting Year',
									'filter' => false,
									'value' => function ($model, $key, $index, $widget) {
										$aca_year = '';
										if (! empty ( $model->tbl_aca_company_reporting_period->year)) {
											$aca_year = $model->tbl_aca_company_reporting_period->year->lookup_value;
										}
										else
										{
											$aca_year = 'NA';
										}
										return $aca_year;
									},
									'headerOptions' => [
									'style' => 'background-color:#428bca;color:#fff;'
											],
											'format' => 'raw'
									],
												
												[
												'attribute' => 'company_ein',
												'label' => 'EIN',
												'filter' => false,
												'value' => function ($model, $key, $index, $widget) {
													$ein = '';
													if (! empty ( $model->company_ein )) {
														return $model->company_ein;
													}
													else
													{
														$encrypt_component = new EncryptDecryptComponent();
														$encrypt_id = $encrypt_component->encrytedUser($model->company_id);
														
														return '<span style="">'.''.Html::tag('span', '<a data-toggle="tooltip" data-placement="bottom" title="Click to update company details"><span class="fa fa-edit marginr-6 pointer"></span></a>', ['class' => 'pointer','onclick'=>'showupdatemodal("'.$encrypt_id.'")']).''.'Update'.''.'</span>' ;
														 // return 'Update'.' '.Html::a('<span class="fa fa-edit pointer"></span>', ['class' => 'pointer','onclick'=>'showupdatemodal('.$encrypt_id.');']) ;
													}
													
												},
												'headerOptions' => [
												'style' => 'background-color:#428bca;color:#fff;'
														],
														'format' => 'raw'
																],
		
		
						
								[	'attribute' => 'reporting_status',
									'label' => 'Reporting Status',
									'filter' => false,
									'value' => function ($model, $key, $index, $widget) {
										$reporting_status = '';
										if (! empty ( $model->reportingstatus )) {
											$reporting_status =  $model->reportingstatus->lookup_value ;
										}
										else
										{
											$reporting_status = 'NA';
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
'buttons' => [
    'my_button' => function ($url, $model, $key) {
		$company_id = $model->company_id;
		$encrypt_component = new EncryptDecryptComponent();
		$company_id = $encrypt_component->encrytedUser($company_id);
       // return Html::a('<span class="fa fa-edit pointer"></span>', ['class' => 'pointer','onclick'=>'showupdatemodal('.$company_id.');']) ;
		return Html::tag('p', '<a data-toggle="tooltip" data-placement="bottom" title="Click to update company details"><span class="fa fa-edit pointer marginr-6"></span></a>', ['class' => 'pointer','onclick'=>'showupdatemodal("'.$company_id.'")']) ;
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


<form id="update_cmpny_form">
			<div class="modal fade" id="update_company_modal" tabindex="-1"
				role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog pswd-pop">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
								aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Update Company Details</h4>
						</div>
						<div class="modal-body float-left">

							<div class="form-group col-md-12">
							<div class="col-sm-4 add-mem">
								<label class="add-member-label">Company Name<span class="red">*</span></label>
							</div>
							<div class="col-sm-8">
								<input class="form-control add-member-input" placeholder="" maxlength="75" onkeypress="return companyname(event);"
									id="company-name" value="" name="company_name" /> <span
									class="error-msg red" id="company-name-error"></span>
							</div>

</div>
<div class="form-group col-md-12">
							<div class="col-sm-4 add-mem">
								<label class="add-member-label">Company EIN<span class="red">*</span></label>
							</div>
							<div class="col-sm-8">
								<input class="form-control add-member-input phone"
									placeholder="" id="company-ein" value="" name="company_ein"
									data-inputmask='"mask": "99-9999999"' data-mask />
								<p class="fsize14">(Note: EIN should be in the format
									XX-XXXXXXX and in numbers only)</p>
								<span class="error-msg red" id="company-ein-error"></span>
							</div>
							</div>
<div class="form-group col-md-12 hide">

							<div class="col-sm-4 add-mem">
								<label class="add-member-label">Reporting Year</label>
							</div>
							<div class="col-sm-8">
							
								<select class="form-control" id="company-reporting-year" name="company_reporting_year">
									<?php 
                    $listData= ArrayHelper::map(TblAcaLookupOptions::find()->where(['=', 'code_id', 5])->andwhere(['<>', 'lookup_status', 2])->all(), 'lookup_id', 'lookup_value');
                   
                    ?>
									<?php if(!empty($listData)) {
										
										
									foreach($listData as $key=>$value)
									{
										?>
									<option value="<?php echo $key; ?>" ><?php echo $value; ?></option>
									<?php }} ?>
								</select> 
								
								<span class="error-msg" id="company-reporting-year-error"></span>
							</div>

</div>
						</div>
						<div class="modal-footer bordertop">

							<div class="col-md-12">
								<button type="button" class="btn btn-success" id="update_cmpny_btn"
									 onclick ="return validateupdatecompany();">Update</button>
								<button type="button" class="btn btn-default"
									data-dismiss="modal"  onclick ="resetupdatecompany();">Close</button>

							</div>

						</div>
					</div>
				</div>
			</div>
</form>

			<div class="modal fade" id="modal-container-430199" tabindex="-1"
				role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog pswd-pop">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"
								aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="myModalLabel">Add Additional EIN</h4>
						</div>
						<div class="modal-body float-left">


							<div class="col-sm-4 add-mem">
								<label class="add-member-label">Company Name<span class="red">*</span></label>
							</div>
							<div class="col-sm-8">
								<input class="form-control add-member-input" placeholder="" onkeypress="return option(event);"
									id="company_name" /> <label class="error-msg"
									id="current-password-error"></label>
							</div>


							<div class="col-sm-4 add-mem">
								<label class="add-member-label">Company EIN<span class="red">*</span></label>
							</div>
							<div class="col-sm-8">
								<input class="form-control add-member-input phone"
									placeholder="" id="current-password"
									data-inputmask='"mask": "99-9999999"' data-mask />
								<p class="fsize14">(Note: EIN should be in the format
									XX-XXXXXXX and in numbers only)</p>

								<label class="error-msg" id="current-password-error"></label>
							</div>


							<div class="col-sm-4 add-mem">
								<label class="add-member-label">Reporting Year</label>
							</div>
							<div class="col-sm-8">
								<select class="form-control">
									<option>Select</option>
									<option selected>2016</option>
								</select> <label class="error-msg" id="current-password-error"></label>
							</div>

							<div class="col-sm-4 add-mem hide">
								<label class="add-member-label">Reporting Status<span
									class="red">*</span></label>
							</div>
							<div class="col-sm-8 hide">
								<select class="form-control"><option>Select</option>
									<option>Created</option>
									<option>Forms Generated</option>
									<option>E-Filed</option>
									<option>Data Validated</option>
								</select>
							</div>


						</div>
						<div class="modal-footer bordertop">
							<div class="col-md-12">
								<button type="button" class="btn btn-success" id="chng_pwd_btn"
									data-dismiss="modal">Save</button>
								<button type="button" class="btn btn-default"
									data-dismiss="modal" onclick="clearChangePasswordFields();">Close</button>


							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>
</div>
