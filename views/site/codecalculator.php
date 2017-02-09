<script type="text/javascript">
$(document).ready(function(){
	 $("#admin_master_data").addClass("active");
	 $("#admin_master_data_tree").addClass("open");
	 $("#admin_brands").addClass("active");
});
</script>
 <?php

use app\components\EncryptDecryptComponent;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<style>
.radio-line14{
vertical-align:sub;
}
.padding-bottom-15{
padding-bottom:15px;
}
.border{
border-right:1px solid black;
border-top:1px solid black;
border-left:1px solid black;
border-bottom:1px solid black;
}
.padding-top-30{
padding-top:30px;
}
</style>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin/masterdata.css" rel="stylesheet">
 <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

	
<div class="box box-warning container">
            <div class="box-header with-border padding-bottom-15">
              <h3 class="box-title padding-bottom-15"><b>Form 1095-C Code Calculator</b></h3>
              
              <div class="col-xs-12 padding-bottom-15 padding-left-0"> 
			<h4>Here is how it works.. Simply select the codes below for lines 14 and 16 below and then press search.  You will then see the full logic as to why certain code combinations work or do not work.
			</h4>
			</div> 
            </div>
			
			

            <!-- /.box-header -->
            <div class="box-body border">
            <div>
            <h4><b>Enter Line 14 Code:</b><span class="red">*</span></h4>

			<?php $line_14_count=count($allline14); $x=0; foreach($allline14 as $line14){ $x++; ?>
			<input type="radio" class="radio-line14" value="<?php echo $line14['lookup_id'];?>" name="line14"><b><?php echo $line14['lookup_value'];?></b><?php if($x<$line_14_count){ ?>&nbsp;|&nbsp;&nbsp; <?php }?>
			<?php }?>
			
            
            <h4 class="padding-top-30"><b>Enter Line 16 Code (if any):</b></h4>
           			<input type="radio" class="radio-line16" checked value="" name="line16"><b> Blank</b>&nbsp;|&nbsp;&nbsp;
			<?php $line_16_count=count($allline16); $x=0; foreach($allline16 as $line16){ $x++;?>
			<input type="radio" class="radio-line16" value=<?php echo $line16['lookup_id'];?> name="line16"><b><?php echo $line16['lookup_value'];?></b> <?php if($x<$line_16_count){ ?>&nbsp;|&nbsp;&nbsp; <?php }?>
			<?php }?>
			<div class="footer">
			<button class="btn btn-primary" onclick="getCodecombination();">Search</button>
			</div>
		      </div>
		      
		      <div class="col-md-12 hide" id="code_calculator">
		      <div class="header"><h3>
		      Pro-Version Code Calculator
		      </h3>
		      </div>
		      <div class="col-md-12">
		      <div class="col-md-4"><h5><b>Selected Line 14 Code:</b></h5></div>
		      <div class="col-md-8"><h5 id="line_14_value"></h5></div>
		      </div>
		      
		      <div class="col-md-12">
		      <div class="col-md-4"><h5><b>Selected Line 16 Code:</b></h5></div>
		      <div class="col-md-8" ><h5 id="line_16_value"></h5></div>
		      </div>
		      
		      <div class="col-md-12">
		      <div class="col-md-4"><h5><b>Here Is What This Code Combination Means:</b></h5></div>
		      <div class="col-md-8" ><h5 id="here_is_what"></h5></div>
		      </div>
		      
		      <div class="col-md-12">
		      <div class="col-md-4"><h5><b>Employers & Organizations: What you need to know:</b></h5></div>
		      <div class="col-md-8" ><h5 id="employer_organisation"></h5></div>
		      </div>
		      
		      <div class="col-md-12">
		      <div class="col-md-4"><h5><b>Individuals & Families: What you need to know:</b></h5></div>
		      <div class="col-md-8" ><h5 id="individual_family"></h5></div>
		      </div>
		      </div>
		       </div>
            <!-- /.box-body -->
          </div>
          
		<script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/jquery-2.2.3.min.js"></script>
	 <script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/managecode.js"></script>
		 <script type="text/javascript"
	src="<?php  echo Yii::$app->homeUrl;?>js/validation.js"></script>
	
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/toastr.js"></script>  
	