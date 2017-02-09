<?php



use yii\helpers\Html;

use yii\widgets\ActiveForm;

use yii\base\Configurable;

use yii\base\ViewContextInterface;

use yii\helpers\ArrayHelper;

use app\models\UsaStates;

use app\models\StaffDetails;



/* @var $this yii\web\View */

/* @var $model common\models\OrderHeader */

/* @var $form yii\widgets\ActiveForm */
// $this->title = Yii::t('app', 'Single Point Reporting | Add Staff User');

?>

<script type="text/javascript">


$(document).ready(function() {
	
	
		//   $('.display-loading-gif').html('<img style="width:30px;height:30px;" src="/images/loading25.gif">');		  
		//   $('#dashboard-li').css("background","#000000");
		//   $('#dashboard-li').css("color","#ffffff");
		//   $('#date_select').datepicker();
		  // $('#to_date').datepicker();
		 //  $('#report-from-date').datepicker();
		  // $('#report-to-date').datepicker();

		   $("#update_profile").addClass('active');
	
		   
});

</script>


<!-- jQuery UI 1.11.4 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
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
</style>

<div class="box box-warning">


            <div class="box-header with-border">
              <h3 class="box-title">Update Profile - ABC Corp <small>(ACA-10000-1)</h3>
            </div>
			
<div class="col-xs-12 header-new-main width-98">
	<span class="header-icon-band"><i class="fa fa-file-text-o icon-band" style="font-weight: lighter;"></i></span>
	<p class="sub-header-new">Agent can update the contact information in this page.</p>
</div>

            <!-- /.box-header -->
            <div class="box-body">
             <form id="w0" action="/admin/staff_users" method="post" enctype="multipart/form-data" validateonsubmit="">
<input type="hidden" name="_csrf" value="cE9SX2N3R3YiJTM5VwBxPQIWKzgBQTMGSRcFOAgVBC8ROwNpIhQ0MA==">                <!-- text input -->
				
				
				
				<div class="box-body">
          <div class="row">
            <div class="col-md-8 padding-0">
               <div class="col-xs-12 padding-0">
                  
				  <div class="form-group field-staffdetails-first_name required col-xs-12 padding-0" >
				  
<label class="control-label col-xs-3 pull-left" for="staffdetails-first_name">First Name</label>
<div class="col-xs-6 pull-left">
<input type="text" id="staffdetails-first_name" value="Jack" class="form-control" name="StaffDetails[first_name]">
</div>
<div class="help-block"></div>
</div>                
                </div>
                <div class="col-xs-12 padding-0">
                  <div class="form-group field-staffdetails-last_name required col-xs-12 padding-0">
<label class="control-label col-xs-3  pull-left" value="McSweeney" for="staffdetails-last_name  ">Last Name</label>

<div class="col-xs-6 pull-left">
<input type="text" id="staffdetails-last_name" class="form-control " name="StaffDetails[last_name]">
</div>

<div class="help-block"></div>
</div>                </div>

             
          
            

              
                
				
				 <!-- phone -->
				<div class="col-xs-12 padding-0">
                

               
                 <div class="form-group field-users-phone required col-xs-12 padding-0">
<label class="control-label col-xs-3 pull-left" for="users-phone">Phone</label>
<div class="col-xs-6 pull-left">
<input type="text" id="users-phone" class="form-control col-xs-3" value="+16526578952" name="Users[phone]" data-plugin-inputmask="inputmask_e4f2ec36">
</div>
<div class="help-block"></div>
</div>                
          
              </div>
			  
			   <!-- email -->
			  <div class="padding-0 col-xs-12">
                  <div class="form-group field-users-email col-xs-12 required padding-0">
<label class="control-label col-xs-3" for="users-email">Email</label>
<div class="col-xs-6 pull-left">
<input type="text" id="users-email" value="McSweeney@gmail.com" class="form-control" name="Users[email]">
</div>
<div class="help-block"></div>
</div>                </div>
				
				  <!-- email -->
			  <div class="padding-0 col-xs-12">
                <div class="form-group field-staffdetails-imagefile col-xs-12 padding-0">
<label class="control-label col-xs-3 pull-left" for="staffdetails-imagefile">Profile Picture</label>
<div class="col-xs-6 pull-left">
<input type="hidden" name="StaffDetails[imageFile]" value=""><input type="file" id="staffdetails-imagefile" name="StaffDetails[imageFile]">
</div>
<div class="help-block"></div>
</div>                </div>
				
				
				
				<div class="padding-0 col-xs-12">
                  <div class="form-group field-staffdetails-city col-xs-12 required padding-0">
<label class="control-label col-xs-3 pull-left" for="staffdetails-city">Brokerage</label>
<div class="col-xs-6 pull-left">
<input type="text" id="staffdetails-city" value="Silent homes" class="form-control" name="StaffDetails[city]">
</div>
<div class="help-block"></div>
</div>                </div>
				
				
				<div class="padding-0 col-xs-12">
                  <div class="form-group field-staffdetails-city required col-xs-12 padding-0">
<label class="control-label col-xs-3 pull-left" for="staffdetails-city">Business Address</label>
<div class="col-xs-6 pull-left">
<input type="text" id="staffdetails-city" value="Pensacola Beach, Florida" class="form-control" name="StaffDetails[city]">
</div>
<div class="help-block"></div>
</div>                </div>

				
					
				
				
				
				<div class="box-footer col-xs-9 pull-right">
             <button type="button" class="btn btn-success" style="    margin: 0px 12px 0px 5px;">Submit</button>				
				<button type="button" class="btn btn-default" onclick="location.reload();">Clear</button>
              </div>
			  
              <!-- /.form-group -->
            </div>
         
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
				
				
				
				
				
				
				
				
				
				
              
				
				
				

              </form>            </div>
            <!-- /.box-body -->
          </div>
		  