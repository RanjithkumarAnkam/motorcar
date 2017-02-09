<?php 
use yii\helpers\Html;

	 
		?>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client/companyuser.css" rel="stylesheet">

<script>
$(document).ready(function(){
			    $('#exampleAddusers').DataTable({

			    	"aoColumnDefs": [

										{

										"bSortable": false,

										"aTargets": [ -1,-2,-3,-4,-5,-6 ]

										}

										],
										
											"bFilter" : false,               
			    	"bLengthChange": false
			    });
			});
</script>

<div class="box box-warning">


	<div class="box-header with-border">
	<div class="col-md-12">
            <h3 class="box-title col-sm-6">Update User - <?php echo Html::encode($company_details->company_name); ?> <small> (<?php echo Html::encode($company_details->company_client_number); ?>) </small></h3>
               <div class="col-xs-6 pull-right">
			<a class=" btn bg-orange btn-flat btn-social pull-right"  data-toggle="tooltip" data-placement="bottom" title="Click to view help video" onclick="playVideo(2);"> <i
				class="fa fa-youtube-play"></i>View Help Video
			</a>
		</div>
            </div>
			</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band lighter"></i></span>
		<p class="sub-header-new">User can be updated from below screen.</p>
	</div>

	<!-- /.box-header -->
	<div class="box-body">

		 <?=$this->render ( '_form', [ 'model_company_users' => $model_company_users,'company_details' => $company_details,'all_companies'=>$all_companies,'client_rights'=>$client_rights,'model_users'=>$model_users,'company_user_permissions'=>$company_user_permissions] )?>
			
	</div>
	<!-- /.box-body -->
</div>

<script>
		window.onload= function(){

			var select = $("#select_all_0").is(":checked");
			if(select)
				{
				$("#select_all_0").removeClass('permission_check');
				$('.permission_check').prop('checked', true);
				$('.permission_check').css("pointer-events", "none");
				}
			
		}
		</script>