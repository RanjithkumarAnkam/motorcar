<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use dmstr\widgets\Alert;
use app\models\TblAcaUsers;
use app\models\TblAcaBrands;
use app\models\TblAcaClients;
use app\models\TblAcaCompanyUsers;

AppAsset::register($this);

$get_user_details = \Yii::$app->request->get ();

if (! empty ( $get_user_details ['random_salt'] ) && ! empty ( $get_user_details ['id'] )) {
	$id = $get_user_details ['id'];
	$random_salt = $get_user_details ['random_salt'];
$model_users = new TblAcaUsers ();
$user_details = $model_users->setPasswordIdentity ( $id, $random_salt );
        
    
	if (!empty($user_details['success'])) {
				$users = $user_details['success'];
				
				if($users->usertype == 2){
					$client_model=TblAcaClients::Findbyuserid($users->user_id);	
				}else if($users->usertype == 3){
					$company_user_model=TblAcaCompanyUsers::Findbyuserid($users->user_id);	
					
					$client_model=TblAcaClients::Clientuniquedetails($company_user_model->client_id);	
				}
				
			
			
				if(!empty($client_model)){
					$brand_model=TblAcaBrands::Branduniquedetails($client_model->brand_id);
					$picture = 'profile_image/brand_logo/'.$brand_model->brand_logo;
				}else{
					$picture = 'ACA-Reporting-Logo.png';
				}
	}
}else{
	$picture = 'ACA-Reporting-Logo.png';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <title>ACA Reporting Service | Full Service ACA Reporting</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="description" content="ACA Reporting Service | Full Service ACA Reporting">
<meta name="keywords" content="4980h,aca reporting deadlines,aca reporting,aca reporting services,
aca reporting service,the affordable care act,aca section 4980h,1095c reporting companies,aca affordability safe harbor 2016,
aca filing deadlines 2016,variable hour employee calculator,1095 c reporting requirements,aca reporting penalties,
aca compliance services,aca compliance complaint,safe harbor calculation,aca filing deadline,form 1095 a 2016,
aca compliance 2016,ale aca reporting,1095 compliance,affordability safe harbors,aca reporting vendors,aca compliance,
aca 1095 penalties,determining affordability under aca,eligible for section 4980h,deadline for aca reporting 2016,
aca filing 1095,aca solution,aca consulting,2016 aca affordability safe harbor,1095 c penalties,aca deadlines 2016,
affordability safe harbor 2016,aca employer mandate matrix,aca safe harbor 9.5 30hours,1095c reporting,safe harbor rules aca,
2015 aca filing deadline,1095 filing requirements,affordability safe harbors,when are aca forms due,aca 1095 c,
applicable section 4980h safe harbor,aca fee for service,form 1095 2016 filing,form 1095c penalties,
responsible for 6056 reporting 1094 1095 reporting,1094 c filing,penalties for not filing 1095 c forms on time,
aca safe harbor 2016,1094 filing requirements,transition reflief for 2015,2015 aca reporting,variable hour employee aca,
aca ale reporting,aca affordability,aca affordability,1095c tax form,safe harbor aca,aca filing deadline,aca safe harbors,
aca providing of form 1095 b,1095a form for income tax,aca requirements,aca reporting forms,
6055 and 6056 reporting requirements,1094 and 1095 reporting,form 6055 and 6056 reporting,form 1095b,aca safe harbor,
aca filing requirements,aca 1095b,aca compliance reporting,employer shared responsibility eligibility and affordability safe harbors,
aca reporting requirements 2016,aca requirements for employers,aca form 1095 c,4980h,aca efile,1095 filing requirements,
aca filing deadlines,aca w2 safe harbor">
<meta name="author" content="Sky Insurance Technologies">
<!--<meta http-equiv="X-UA-Compatible" content="IE=9" /> -->


	<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/css/custom.css" rel="stylesheet" type="text/css" />
   
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
          
	<link rel="shortcut icon" type="image/png" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/favicon.png" />
   
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/validation.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>
<div class="wrap">
<header class="header" id="header_back" style="background:url(<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/loginpage-header.png);height:85px;">
<div class="" >



<div class="no-padding txt-center"  >
  <a  class="logo pl-0" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>"> <!-- Add the image.jpg and option.png class icon to your logo image or logo icon to add the margining -->
			<img alt="" class="logo-style"  src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();  ?>/Images/<?php echo $picture; ?>">

		</a>
</div>
<!-- <div class="col-md-8"></div>

 

<div id="header" class="container  col-xs-0 no-padding" >
		
		</div> -->
</div>
          
            <!-- Header Navbar: style can be found in header.less -->
            
        </header>

    <div class="container" style="padding: 70px 15px 20px;">       
    
      <section class="content">
        <?php echo Alert::widget(); ?>
        <?php echo $content; ?>
    </section>
    </div>
</div>


    <div class="container" >
        <p class="txt-center" > &#169;Copyright 2016 Sky Insurance Technologies. All rights reserved.</p>

     
    </div>
	
	
	<div class="modal fade" id="mychangepassword" tabindex="-1"
	role="dialog" aria-labelledby="myModalRecover" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="$('#recover-email-id').val('');">&times;</button>
				<h4 class="modal-title" id="myModalRecover">Recover Password</h4>
			</div>
			<form id="resetpassword">
			<div class="modal-body">
			<div class="form-group">
				<div class="col-sm-2 add-mem"  style="line-height: 33px;">
					<label class="add-member-label">Email:</label>
				</div>
				<div class=" col-sm-10">
					<input type="text" class="form-control add-member-input full-width" placeholder="Enter email...."
						id="recover-email-id" name="email"/> <span class="error-msg  red"
						id="recover-error-messages"></span> <span class="green error-msg"
						id="recover-success-message"></span>
				</div>
	</div>
			</div>
			<div class="modal-footer"
				style="border-top: none; margin-right: 15px;">
				<button type="button" class="btn btn-default btn-sm"
					data-dismiss="modal" >Close</button>
				<button type="button" class="btn btn-primary btn-sm"
					onclick="return validateforgotpassword();">Submit</button>
			</div>
			</form>
		</div>
	</div>
</div>


<div class="modal fade" id="myresetlink" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog pswd-pop" style="width: 450px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true" onclick="$('#recover-reset-link').val('');">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Reset Verification Link</h4>
			</div>
			<form id="resetlink">
			<div class="modal-body">
			<div class="form-group">
				<div class="col-sm-2 add-mem"  style="line-height: 33px;">
					<label class="add-member-label">Email:</label>
				</div>
				<div class=" col-sm-10">
					<input type="text" class="form-control add-member-input full-width"
						 placeholder="Enter email...."
						id="recover-reset-link" name="email"/> <span class="error-msg  red"
						id="recover-error-link"></span> <span class="green error-msg"
						id="recover-success-link"></span>
				</div>
	</div>
			</div>
			<div class="modal-footer"
				style="border-top: none; margin-right: 15px;">
				<button type="button" class="btn btn-default btn-sm"
					data-dismiss="modal" >Close</button>
				<button type="button" class="btn btn-primary btn-sm"
					onclick="return validateresetverification();">Submit</button>
			</div>
			</form>
		</div>
	</div>
</div>

</body>


	

		  
</html>

