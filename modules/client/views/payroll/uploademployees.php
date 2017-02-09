<?php



use yii\helpers\Html;

use yii\widgets\ActiveForm;

//use yii\base\Configurable;

//use yii\base\ViewContextInterface;

use yii\helpers\ArrayHelper;

//use app\models\UsaStates;

//use app\models\StaffDetails;



/* @var $this yii\web\View */

/* @var $model common\models\OrderHeader */

/* @var $form yii\widgets\ActiveForm */
// $this->title = Yii::t('app', 'Single Point Reporting | Add Staff User');

?>

<!-- jQuery UI 1.11.4 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


<style>
div.required label.control-label:after {
    content: " *";
    color: red;
}

div#users-role label,div#users-form_access label,div#users-status label {
    font-weight: 200;
    margin-right: 10px;
    font-family: wf_segoe-ui_normal, "Segoe UI", "Segoe WP", Tahoma, Arial, sans-serif;
    color: #505050;
    font-weight: 400;
    line-height: 1.5em;
}
.pagination{
	
padding-left: 10px;	
}
.pagination >li>a{
	
	    background-color: rgb(247, 245, 230);
}
</style>

<div class="box box-warning">


            <div class="box-header with-border">
              <h3 class="box-title">Upload Employees</h3>
            </div>
<?php  /*if(Yii::$app->session->hasFlash('error')){ ?>       
<div class="alert alert-success alert-dismissable success_msg_block"
	style="float: left; width: 98%;">
	<i class="fa fa-check"></i>
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">&times;</button>
	<b><?php echo  Yii::$app->session->getFlash('error'); ?></b>
</div>
<?php }*/ ?>		
<div class="col-xs-12 header-new-main width-98 hide">
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">Admin can upload agents csv from here.</p>
</div>

            <!-- /.box-header -->
            <div class="box-body">
            
            <div>

<div>

	<div class="page-content-wrapper">
  <div class="page-content" style="min-height:544px;margin-left:0px;">
  
    <!-- BEGIN PAGE HEADER-->
    
    <!-- END PAGE HEADER -->
    
    <div id="ajax_alerts"></div>

        <div class="row">
        <div class="col-xs-12">
          <div class="note note-warning" style="padding: 10px 0px 15px 15px;background: #eee;border-left: 5px solid #f2cf87;margin-bottom: 15px;">Please note, the file you upload must be a .csv file.  If you have an Excel file, you can go to File &gt; Save As and choose Comma Delimited (.csv).</div>
        </div>
      </div>
      <div class="portlet box blue-hoki" style="    border: 1px solid #428bca">
        <div class="portlet-title" style="background-color: #428bca; padding: 10px;">
          <div class="caption" style="color: #fff;font-size: 16px;"><i class="fa fa-search"></i> CSV Upload</div>
        </div>
        <div class="portlet-body form">
		
          <!-- BEGIN FORM-->
         <?php $form = ActiveForm::begin(['id' => 'import-contact-form','enableClientValidation' => false,'enableAjaxValidation' => true]); ?>
		 <div class="form-actions">
            <div class="form-body  compulsary-background" style="padding: 30px;">
              <div class="form-group" style="float: left;width: 100%;">
                <label class="control-label col-md-2">CSV File To Upload</label>
                <div class="col-md-6">
					
					<?= $form->field($model_import, 'employee_id')
								->label(false)	
								->fileInput(['accept'=>'.csv','id'=>'csv_file','class'=>'filestyle','data-buttonNam'=>'btn-primary']); ?>
								
                    
					<input type="hidden" id="hidden_field" value="" name="new_file_name" />
                </div>
              </div>
			
            
              <div class="row">
                <div class="col-md-offset-2 col-md-9">
				<?= Html::submitButton('Submit', ['class'=> 'btn btn-success','style'=>'margin-right:10px;margin-left: 9px;' ,'onclick'=>'return uploadCsv();']) ; ?>     
                
				<button type="button" class="btn default" onclick="location.href='<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/client/payroll?c_id=<?php echo $_GET['c_id']; ?>'">Cancel</button>
                  <span class="error-msg red" id="error-csv" style="margin-left: 9px;width: 100%;float: left;margin-top: 7px;font-size: 15px;"> </span>	
                </div>
              </div>
			    </div>
            </div>
        <?php ActiveForm::end(); ?>
		
        </div>
      </div>
       

  </div>
  
    <div class="load-gif" id="loadGif" style="display:none;">
	<div class="procressing_plz_wait">Processing please wait ....
		<img class="gif-img-prop" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/j-max-loader.gif" /> 
	</div>
</div>


</div>
</div>
		</div>
            
                        </div>
            <!-- /.box-body -->
          </div>
