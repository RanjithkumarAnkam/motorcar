	<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_clients").addClass("active");
});
</script>
	      <link
 href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/client.css"
 rel="stylesheet">

	<div class=" box box-warning container-fluid">
	
	         <div class="box-header with-border">
              <h3 class="box-title">Update Client</h3>
              <span class="float-right" ><a href="<?php echo Yii::$app->homeUrl;?>admin/clients">Back to Manage Clients</a></span>
        
            </div>
						
			 <div class="col-xs-12 header-new-main width-98 hide"> 
				<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
				<p class="sub-header-new">You can update client from this screen.</p>
			</div> 
	<div class="col-md-12">
		
		 <?= $this->render('_form', [
		        'new_client' => $new_client,
				'old_ein_count'=>$old_ein_count			 	
		    ]) ?>
		    
          </div>
          
          </div>
						