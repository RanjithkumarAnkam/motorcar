<?php
use app\components\EncryptDecryptComponent;
use yii\helpers\Html;
$get_id = Yii::$app->request->get ();
$company_id = $get_id ['c_id'];

?>

<script type="text/javascript">
$(document).ready(function(){
	 $("#benefit_plan_info_menu_main").addClass("active");
	 $("#benefit_plan_info_menu_main_treeview").addClass("open");
	 $("#benefit_plan_info_menu_3").addClass("active");
	 
	 
});
</script>
<!-- Div start  -->
<div class="box box-warning">


	<div class="box-header with-border">
		<h3 class="box-title col-sm-8">Current Available Plan Classes - <?php echo Html::encode($company_details->company_name); ?> <small> (<?php echo Html::encode($company_details->company_client_number); ?>) </small>
		</h3>

		<a class="col-sm- btn bg-orange btn-flat btn-social pull-right" data-toggle="tooltip" data-placement="bottom" title="Click to view help video"
			onclick="playVideo(4);"> <i class="fa fa-youtube-play"></i>View Help
			Video
		</a>
	</div>

	<div class="col-xs-12 header-new-main width-98 ">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">To define a plan class, please click Add
			Plan Class button</p>
	</div>

	<!-- /.box-header -->
	<div class="box-body">

		<div>
			<div class="table-responsive grid-filter m-5 pull-right"
				style="margin-bottom: 10px;">
				<table class="">
					<tbody>
						<tr class="filter-div-back">




							<td title="Add Plan Class"><a
								href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/client/planclass/addplanclass?c_id=<?php echo $company_id; ?>"><button
										type="reset" class="btn btn-success btn-sm filter-btn-search"
										style="">
										<i class="fa fa-plus" aria-hidden="true"
											style="margin-right: 5px;"></i>Add Plan Class
									</button></a></td>




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
							
							<!-- Start Table  -->
								<table id="examplePlanclass"
									class="table table-bordered table-hover">
									<thead>
										<tr class="tr-grid-header">

											<th>Plan Class #</th>
											<th>Plan Class Name</th>
											<th>Plan Type</th>
											<th>Waiting Period</th>

											<th>MV Coverage</th>
											<th>MV months</th>
											<th>MEC</th>
											<th>Edit</th>

										</tr>
									</thead>
									<tbody>
							
							<?php
							
if (! empty ( $all_plan_class )) {
								foreach ( $all_plan_class as $plan ) {
									?>
							<tr>

											<td><?php echo Html::encode($plan->plan_class_number); ?></td>
											<td><?php echo Html::encode($plan->plan_class_name); ?></td>
											<td><?php
									switch ($plan->plan_offer_type) {
										case '1' :
											$plan_type = 'No Qualifying Plan Offered';
											break;
										case '2' :
											$plan_type = 'Self Insured ';
											break;
										case '3' :
											$plan_type = 'Fully Insured';
											break;
										case '4' :
											$plan_type = 'Multi Employer Plan';
											break;
										case '5' :
											$plan_type = 'Combination';
											break;
										default :
											$plan_type = '';
											break;
									}
									
									echo Html::encode ( $plan_type );
									
									?></td>
											<td><?php
									$plan_type_doh = '';
									switch ($plan->plan_type_doh) {
										case '1' :
											$plan_type_doh = 'Date of hire (DOH)';
											break;
										case '2' :
											$plan_type_doh = '30 Days after DOH';
											break;
										case '3' :
											$plan_type_doh = '60 Days after DOH';
											break;
										case '4' :
											$plan_type_doh = '90 Days after DOH';
											break;
										case '5' :
											$plan_type_doh = '1st of Month after DOH';
											break;
										case '6' :
											$plan_type_doh = '1st of Month after 30 days after DOH';
											break;
										case '7' :
											$plan_type_doh = '1st of Month after 60 days after DOH';
											break;
										case '8' :
											$plan_type_doh = '1st of Month after 90 days after DOH';
											break;
										case '9' :
											$plan_type_doh = 'Combination';
											break;
										default :
											$plan_type_doh = '';
											break;
									}
									
									echo Html::encode ( $plan_type_doh );
									
									?></td>

											<td><?php
									$mv_coverage = '';
									if (isset ( $plan->tblAcaPlanCoverageTypeOffereds->employee_mv_coverage ) && $plan->tblAcaPlanCoverageTypeOffereds->employee_mv_coverage == 1) {
										$mv_coverage = 'Yes';
									} elseif (isset ( $plan->tblAcaPlanCoverageTypeOffereds->employee_mv_coverage ) && $plan->tblAcaPlanCoverageTypeOffereds->employee_mv_coverage == 2) {
										$mv_coverage = 'No';
									}
									
									echo $mv_coverage;
									?></td>
											<td><?php
									
$months = $model_plan_coverage_type_offered->findMvmonthsstring ( $plan->plan_class_id );
									echo rtrim ( $months, ', ' );
									?></td>
											<td><?php
									
$mec = $model_plan_coverage_type_offered->findMecstring ( $plan->plan_class_id );
									echo rtrim ( $mec, ', ' );
									?></td>
								
								<?php
									$encrypt_plan_id = $encrypt_component->encrytedUser ( $plan->plan_class_id );
									
									?>
								<td style="text-align: center;"><a data-toggle="tooltip" data-placement="bottom" title="Click to update plan class"
												href="<?php echo Yii::$app->homeUrl;?>client/planclass/updateplanclass?c_id=<?php echo $company_id; ?>&plan_id=<?php echo $encrypt_plan_id; ?>#coveragetypewaitingperiod"><i
													class="fa fa-edit" style="cursor: pointer;"></i></a></td>

										</tr>
							
							<?php } }?>													
						</tbody>

								</table>
								
								<!-- End Table  -->
							</div>


						</div>
						<!-- /.box -->
					</div>
				</div>
			</div>


			<script type="text/javascript">


$(document).ready(function(){
			    $('#examplePlanclass').DataTable({

			    	"aoColumnDefs": [

										{

										"bSortable": false,

										"aTargets": [ -1 ]

										}

										],
										
											"bFilter" : false,               
			    	"bLengthChange": false
			    });
			});


</script>
		</div>

	</div>
	<!-- /.box-body -->
</div>

<!-- Div End  -->