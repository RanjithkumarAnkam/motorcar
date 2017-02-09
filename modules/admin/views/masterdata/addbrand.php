<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_brands").addClass("active");
	 
	 
});
</script>
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/masterdata.css" rel="stylesheet" />

	<div class=" box box-warning container-fluid">
	
	         <div class="box-header with-border">
              <h3 class="box-title">Add Brand</h3>
              <span style="float:right;"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/index">Back to Manage Brand</a></span>
            </div>
						
			 <div class="col-xs-12 header-new-main width-98 hide"> 
				<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
				<p class="sub-header-new">You can add new brand from this screen.</p>
			</div> 
	
			
			<div class="col-md-12">
		<div class=" box-info">
		
          
			 <?php  echo $this->render('_form', [
		        'model' => $model,			 	
		    ]); ?>
	  
		</div>
	</div>		
	   		
						</div>