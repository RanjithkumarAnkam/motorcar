<?php

use yii\helpers\Html;
use app\models\StaffDetails;
use app\models\TblAcaClients;
use yii\helpers\Url;
use app\models\TblAcaCompanies;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\TblAcaLookupOptions;
use app\components\EncryptDecryptComponent;
use app\models\TblAcaBrands;
use app\models\TblAcaCompanyUsers;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
 <?php 
$session = Yii::$app->session;
$logged_id = $session['client_user_id'];
$model_clients = new TblAcaClients();
$encrypt_component = new EncryptDecryptComponent ();
$model_companies = new TblAcaCompanies ();
$model_company_users = new TblAcaCompanyUsers ();
$profile_image = 'report_1_28146_default.png';

if($session['is_client'] == 'client')
{
$client_details = $model_clients->findbyuserid($logged_id);

if(!empty($client_details->profile_image)){
$profile_image = $client_details->profile_image;
}

$name = $client_details->contact_first_name.' '.$client_details->contact_last_name;
$member_since = date ( "j M Y", strtotime ( $client_details->created_date ) );
}
else 
{
	$company_user_details = $model_company_users->FindByuserId($logged_id);
	
	if(!empty($company_user_details->profile_image)){
		$profile_image = $client_details->profile_image;
	}
	
	$name = $company_user_details->first_name.' '.$company_user_details->last_name;
	$member_since = date ( "j M Y", strtotime ( $company_user_details->created_date ) );
}

$get_company_id = \Yii::$app->request->get ();
if (! empty ( $get_company_id )) {
$encrypt_company_id = $get_company_id ['c_id'];
			if (! empty ( $encrypt_company_id )) {
					$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
					$check_company_details = $model_companies->Companyuniquedetails ( $company_id );
					$client_id = $check_company_details->client_id;
				}
				
				$brand_company_details = $model_clients->Clientuniquedetails($client_id);
				$brand_details = TblAcaBrands::Branduniquedetails ($brand_company_details->brand_id );
				$brand_logo = $brand_details->brand_logo;
}
else
{
	$brand_details = TblAcaBrands::Branduniquedetails (1);
			$brand_logo = $brand_details->brand_logo;
}
$getdata=array();
?>
    
<header class="main-header">

    	<a class="logo" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/companies" style="padding: 0 2px;"><div class="col-md-12 padding-0"><img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/brand_logo/<?php echo $brand_logo;?>" class="" style="width:100%;"></div></a>
  
    <nav class="navbar navbar-static-top" role="navigation" >

        <a  href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a> 
        <?php
        $session = \Yii::$app->session;
        $company_ids = $session ['company_ids'];
        $model_companies = new TblAcaCompanies();
         $all_companies = $model_companies->FindallwherecompanyIds($company_ids);
         ?>
       
<div class=" col-lg-6 col-xs-9 col-md-9 ">
         <div class=" col-xs-7 col-md-5 padding-right-0 padding-left-0">
         
         <select class="form-control" style="margin-top: 13px;" id="company_id">
        
							<?php if(!empty($all_companies)){
							$encrypt_component = new EncryptDecryptComponent();
							foreach ($all_companies as $companies)
							{
							
if($companies->company_name){
$user_id = $encrypt_component->encrytedUser($companies->company_id);
								?>
							<option value="<?php echo Html::encode($user_id); ?>" <?php if($user_id == $encrypt_company_id){?> selected <?php }?>><?php echo Html::encode($companies->company_name); ?> (<?php echo Html::encode($companies->company_client_number); ?>) - <?php echo $companies->tbl_aca_company_reporting_period->year->lookup_value;?></option>
<?php } } } ?>
         </select>
         	
         </div>
         
         
         
         <div class=" col-xs-4 col-md-2" style="padding-left: 4px;">
         <button class="form-control btn btn-success" style="margin-top: 13px;" onclick="openCompanydashboard();">Go</button>
         </div>
         </div>

        <div class="navbar-custom-menu pull-right col-xs-2 col-lg-3 col-md-2">

            <ul class="nav navbar-nav pull-right">

                <!-- Messages: style can be found in dropdown.less-->
               
        
                <!-- Tasks: style can be found in dropdown.less -->
               
                <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu" >
                    <a href="#" class="dropdown-toggle no-wrap xs-login" data-toggle="dropdown" id="dropd">
					<?php if(!empty($profile_image)){?>
                        <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/<?php echo $profile_image;?>" class="user-image" alt="User Image"/>
						<?php } ?>
                        <span  class="white hidden-xs"><?php  $string = (strlen($name) > 10) ? substr($name,0,13).'...' : $name;?> 
						     <?php  echo Html::encode($string); ?></span>
						<span class="caret hidden-xs"></span>
                    </a>
                    <ul class="dropdown-menu" >
                        <!-- User image -->
                        <li class="user-header">
						<div>
						<?php if(!empty($profile_image)){?>
                        <img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/<?php echo $profile_image;?>" class="user-image" alt="User Image" class="img-circle" style="    height: 80px;width: 80px;float: initial;"/>
						<?php } ?>
						
						</div>
                            <p>
							 <?php  $string = (strlen($name) > 15) ? substr($name,0,13).'...' : $name;?> 
						     <?php  echo Html::encode($string); ?>
                               
                                <small>Member since <?php  echo $member_since;?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                      
                        <!-- Menu Footer-->
                        <li class="user-footer">
						<!--<div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>-->
                            <div class="col-xs-3 padding-left-0" >
                           <a  class="btn btn-default btn-flat no-wrap" onclick="openEditmodal();" style="padding: 5px;">Profile</a>
                            </div>
                            
                          
							<div class="col-xs-6 padding-left-0" >
                                <a  href="#modal-container-430197" data-toggle="modal" class="btn btn-default btn-flat no-wrap" style="    padding: 5px;">Change Password</a>
                            </div>
                           <div class="col-xs-3 padding-left-0" >
                                <a class="btn btn-default btn-flat no-wrap" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/clientlogout" data-method="post" style="padding: 5px;">Sign out</a>                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
               <!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
            </ul>
        </div>
    </nav>
</header>


		
		
 <?php
	$session = \Yii::$app->session;
	$email = $session ['client_email'];
	
	?>
	
<div class="modal fade" id="modal-container-430197" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Change Password</h4>
			</div>
			<form  class="" id="change-password-form">
			<div class="modal-body pull-left" >
				
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Email:</label>
				</div>
				<div class="col-sm-8">
					<span class="form-control"><?php echo $email; ?></span> 
				</div>
				</div>
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Current Password:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">

					<input type="password" class="form-control add-member-input"
						placeholder="Current Password.." id="current-password" name="oldpass"/> <span
						class="error-msg red" id="current-password-error"></span>
				</div>
				</div>
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">New Password:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">
					<input type="password" class="form-control add-member-input"
						placeholder="New Password.." id="new-password" name="newpass"/> <span
						class="error-msg red" id="new-password-error"></span>
				</div>
				</div>
				<div class="form-group col-md-12">
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Confirm Password:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">
					<input type="password" class="form-control add-member-input"
						placeholder="Confirm Password.." id="new-confirm-password" name="repeatnewpass"/> <span
						class="error-msg red" id="confirm-password-error"></span> <label
						class="error-msg" id="display-password-error"></label>
				</div>
				</div>
				
			</div>
			<div class="modal-footer" style="border-top: none;">
				<button type="button" class="btn btn-primary" id="chng_pwd_btn" onclick="return changeclientpassword();">Save
					Changes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal"
					onclick="resetchangepassword();">Close</button>



			</div>
			</form>
		</div>
	</div>
</div>



<div class="modal fade in" id="modal_update_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
	<div class="modal-dialog pswd-pop">
	<?php 
	$modelclient=new TblAcaClients();
	$modelcompanyusers=new TblAcaCompanyUsers(); ?>
	<?php  $form = ActiveForm::begin(['action' => ['/client/default/updateprofilename'],'enableClientValidation' => false,'options' => ['method' => 'post','enctype'=>'multipart/form-data','validateOnSubmit' => true,'class'=>'form-horizontal','id'=>'updateclient-form']]);?>
	
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 class="modal-title" id="myModalLabel">Update Profile</h4>
			</div>
			<div class="modal-body pull-left" >
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">First Name:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">
				<?php 
				if($session['is_client'] == 'client')
					{
				echo $form->field($modelclient,'contact_first_name')->label(false)->textInput(['class'=>'form-control','maxlength'=>'34','id'=>'profile-first-name']); 
					}
					else
					{
					echo $form->field($modelcompanyusers,'first_name')->label(false)->textInput(['class'=>'form-control','maxlength'=>'34','id'=>'profile-first-name']); 
					
					}
				?>
					
				</div>
				
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Last Name:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">
				<?php 
				if($session['is_client'] == 'client')
					{
				echo $form->field($modelclient,'contact_last_name')->label(false)->textInput(['class'=>'form-control','maxlength'=>'34','id'=>'profile-last-name']); 
					}
					else
					{
					echo $form->field($modelcompanyusers,'last_name')->label(false)->textInput(['class'=>'form-control','maxlength'=>'34','id'=>'profile-last-name']); 
					
					}
				?>	
				</div>
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Email:<span class="red">*</span></label>
				</div>
				<div class="col-sm-8">
				<div class="form-group field-profile-email required">
				<span class="form-control" id="profile-email">ankamranjithkumar@gmail.com</span> 
				<div class="help-block"></div>
				</div>
				</div>
				
				<div class="col-sm-4 add-mem">
					<label class="add-member-label">Profile Image:</label>
				</div>
				<div class="col-sm-8">
				
				 <?= $form->field($modelclient, 'profile_image')->fileInput(['class'=>'form-control'])->label(false); ?>
				 </div>
				
			</div>
			<div class="modal-footer" style="border-top: none;">
			 <?= Html::submitButton('Update', ['class' =>'btn btn-success','id' => 'updateclient_form']) ?>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="">Close</button>
				


			</div>
		</div>
		<?php ActiveForm::end(); ?> 
	</div>
</div>


  <div id="ModalVideo" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header video-link-header">
                    <button type="button" class="close" data-dismiss="modal"  onclick="closeVideo();">x</button>
                </div>
                <div class="modal-body">
                

                <iframe width="100%" height="317" src=""  class="user-picked-video" frameborder="0" allowfullscreen></iframe>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"  onclick="closeVideo();">Close</button>
                </div>
            </div>

        </div>
    </div>
<noscript>
        <div id="noscript-warning">ACA Reporting Service works best with JavaScript enabled<img  alt="" class="dno"></div>
    </noscript>
