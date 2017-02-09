<?php
use app\components\EncryptDecryptComponent;
?>

<script>
<?php
$session = \Yii::$app->session;
$logged_user_id = $session ['client_user_id'];

$get_company_id = \Yii::$app->request->get ();
$encrypt_component = new EncryptDecryptComponent ();
if (! empty ( $get_company_id )) {
	$encrypt_company_id = $get_company_id ['c_id'];
	if (! empty ( $encrypt_company_id )) {
		$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
	}
}

?>
// if add -true
// else if view - false	
<?php $editmedical = \Yii::$app->Permission->Checkclientpermission($logged_user_id,$company_id,'editmedical'); ?>	 	
var medical_permission='<?php echo $editmedical==1?true:false; ?>';
					
	</script>
	
<!-- Start JS and CSS Links -->
<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/dxgrid/jszip.min.js"></script>


<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/dxgrid/dx.viz-web.js"></script>

<?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/dx.common.css"); ?>
  <?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/dx.light.css"); ?>


<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/client/medical.js"></script>
	<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/client/browser.js"></script>
	
<!--End JS and CSS Links -->

<?php

if (! empty ( $this->encoded_company_id )) {
	$encoded_company_id = $this->encoded_company_id;
}
?>

<script type="text/javascript">



		jq(document).ready(function(){
			jq("#loadGif").show();
			
			fetchAllEmployees("<?php echo $encoded_company_id; ?>");
			
			$("#medical_plan_enrollment_data").addClass("active");
		});
		
		
		


	</script>
<!-- Div Body STart -->
<div
	class="box box-warning container-fluid padding-left-0  padding-right-0">


	<div class="box-header with-border padding-left-0  padding-right-0">
		<h3 class="box-title col-xs-8">Medical Plan Enrollment Data - <?php if(!empty($company_detals['company_name'])){echo htmlentities($company_detals['company_name']); }?> <small><?php if(!empty($company_detals['company_client_number'])){echo '('.htmlentities($company_detals['company_client_number']).')'; }?></small>
		</h3>
		<div class="col-xs-4 pull-right">
			<a class=" btn bg-orange btn-flat btn-social pull-right" data-toggle="tooltip" data-placement="bottom"
				title="Click to view help video"
				onclick="playVideo(6);"> <i class="fa fa-youtube-play"></i>View Help
				Video
			</a>
		</div>
	</div>

	<div class="col-xs-12 header-new-main width-98 hide">
		<span class="header-icon-band"><i class="fa fa-file-text-o icon-band"
			style="font-weight: lighter;"></i></span>
		<p class="sub-header-new">Enter the information below for ALL
			employees who were employed with your company for any day of the
			reporting calendar year. This includes all part time and full time
			employees.</p>
	</div>

	<!-- /.box-header -->
	<div class="box-body">



		<div class="col-md-12 padding-left-0  padding-right-0">

			<nav class="navbar " role="navigation"
				style="margin-bottom: 0px; float: left; width: 100%;">
				<div id="sticky-anchor"></div>
				<div class="col-md-12 padding-left-0 padding-right-0" id="sticky">

		<!-- Button Group div start -->
					<div class="" id="heading-navbar-collapse">
						<div class="navbar-left document-context-menu">
							<div class="btn-category pull-right">



								<div class="" style="">

									<div class="btn-group">
										<a data-toggle="tooltip" data-placement="bottom"
											title="Click to download medical plan template in CSV format."  id="download-btn" 
											data-files="<?php echo Yii::$app->homeUrl.'files/csv/medical.csv'?> <?php echo Yii::$app->homeUrl.'files/csv/Data_Template_Standards.pdf'?>"
											
											class="btn btn-default"><i
											class="fa fa-download fa-lg btn_icons pd-r-5"></i>Download
											Medical Plan Data Template</a>

									</div>
				<?php if($editmedical) {?>
				<div class="btn-group">
										<a data-toggle="tooltip" data-placement="bottom"
											title="Click to upload medical plan data in CSV format."
											href="<?php echo Yii::$app->homeUrl;?>client/medical/uploademployees?c_id=<?php echo $encoded_company_id; ?>"
											class="btn btn-default"><i
											class="fa fa-upload fa-lg btn_icons pd-r-5"></i>Upload
											Medical Plan Data</a>

									</div>
				<?php } ?>	
								

									
								</div>


							</div>

						</div>


					</div>
					
					<!-- Button Group div Ends -->
					
				</div>
			</nav>

		</div>


		<div class=" col-md-12 no-pd-rg  padding-left-0  padding-right-0"
			style="margin-top: 15px;">







			<div
				class="padding-left-0  padding-right-0 col-xs-12 panel-0 no-pd-rg">


				<div class="demo-container">
					<div id="gridContainer"></div>
				</div>


			</div>
		</div>








	</div>

	<div></div>

</div>
<!-- Div Body End -->


<!-- Loading GIF div starts -->
<div class="load-gif" id="loadGif" style="display: none;">
	<div class="procressing_plz_wait">
		Processing please wait .... <img class="gif-img-prop"
			src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/j-max-loader.gif" />
	</div>
</div>
<!-- Loading GIF div end -->

<script>
			document.querySelector('#download-btn').addEventListener('click', function (e) {
				var files = e.target.dataset.files.split(' ');
				multiDownload(files);
			});
		</script>








