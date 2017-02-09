<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_clients").addClass("active");
});
</script>        
			
			<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\TblAcaUsers;
use app\models\TblAcaStaffUsers;
use app\models\TblAcaLookupOptions;
use yii\helpers\ArrayHelper;
use app\models\TblAcaCompanyReporitngPeriod;
use app\models\TblAcaBrands;
?>	
	      <link
 href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/client.css"
 rel="stylesheet">

	<div class=" box box-warning container-fluid">
	
	         <div class="box-header with-border">
              <h3 class="box-title">Add Client</h3>
               <span class="float-right" ><a href="<?php echo Yii::$app->homeUrl;?>admin/clients">Back to Manage Clients</a></span>
        
            </div>
						
			 <div class="col-xs-12 header-new-main width-98 hide"> 
				<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
				<p class="sub-header-new">You can add client from this screen.</p>
			</div> 
	<div class="col-md-12">
		 <?php echo $this->render('_form', [
		        'new_client' => $new_client,		'old_ein_count'=>'',	 	
		    ]); ?>
						</div>		
						</div>
						
						