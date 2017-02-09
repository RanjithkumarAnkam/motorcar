<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_managecode").addClass("active");
});
</script>


<?php
use app\components\EncryptDecryptComponent;
?>



<!-- Start JS and CSS Links -->

<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/dxgrid/jszip.min.js"></script>


<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/dxgrid/dx.viz-web.js"></script>

<?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/dx.common.css"); ?>
  <?php $this->registerCssFile(Yii::$app->getUrlManager()->getBaseUrl()."/css/dx.light.css"); ?>


<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/managecode.js"></script>
<!--End JS and CSS Links -->
<?php

if (! empty ( $this->encoded_company_id )) {
	$encoded_company_id = $this->encoded_company_id;
}
?>

<script type="text/javascript">



		jq(document).ready(function(){
			 //jq("#loadGif").show();
			fetchAllData();
			
          $("#admin_managecodes").addClass("active");
		
		});
		
		
		


	</script>
<!-- Div Body STart -->
<div
	class="box box-warning container-fluid padding-left-0  padding-right-0">


	<div class="box-header with-border padding-left-0  padding-right-0">
		<h3 class="box-title col-xs-8">Manage 1095 Codes
		</h3>
		<div class="col-xs-4 pull-right">
			<!-- <a class=" btn bg-orange btn-flat btn-social pull-right"
				data-toggle="tooltip" data-placement="bottom"
				title="Click to view help video" onclick="playVideo(5);"> <i
				class="fa fa-youtube-play"></i>View Help Video
			</a>-->
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
	<div class="box-body ">



		<div class="col-md-12  padding-left-0  padding-right-0">

		</div>


		<div class=" col-md-12 no-pd-rg  padding-left-0  padding-right-0"
			style="margin-top: 15px;">







			<div
				class=" col-xs-12 panel-0 no-pd-rg padding-left-0  padding-right-0">


				<div class="demo-container">
					<div id="gridContainer"></div>
				</div>


			</div>
		</div>








	</div>



</div>
<!-- Div Body End -->

<!-- Loading GIF Div start -->
<div class="load-gif" id="loadGif" style="display: none;">
	<div class="procressing_plz_wait">
		Processing please wait .... <img class="gif-img-prop"
			src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/j-max-loader.gif" />
	</div>
</div>

<!-- Loading GIF Div end -->












