<?php
use yii\helpers\Html;
use app\models\StaffDetails;
use yii\helpers\Url;
use app\models\TblAcaClients;
use app\models\TblAcaStaffUsers;
use app\components\EncryptDecryptComponent;
/* @var $this \yii\web\View */
/* @var $content string */
?>
<link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/admin.css" rel="stylesheet">
<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script
	src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>


	<?php
$session = Yii::$app->session;
$admin_user_id = $session ['admin_user_id'];
$admin_permissions = $session ['admin_permissions'];
$model_staff_users = new TblAcaStaffUsers ();

$staff_user_details = $model_staff_users->findById ( $admin_user_id );
$name = $staff_user_details->first_name.' '.$staff_user_details->last_name;
$member_since = date ( "j M Y", strtotime ( $staff_user_details->created_date ) );
$getdata = array ();
?>
<header class="main-header">

    <?= Html::a('<div class="col-md-2 padding-0"><img style="width: 180px; height: 50px;" src="/Images/ACA-Reporting-Logo.png" class=" "  ></div>', Yii::$app->homeUrl.'admin', ['class' => 'logo','style'=>'padding: 0 2px;'])?>

    <nav class="navbar navbar-static-top" role="navigation">
		
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas"
			role="button"> <span class="sr-only">Toggle navigation</span>
		</a>
		
		
		
		 <?php if((in_array ( '3', $admin_permissions ) == true) && (in_array ( '11', $admin_permissions ) == true))   	{ ?>
		<div class=" col-lg-8 col-sm-6 col-xs-7">
			<div class=" col-lg-5 col-sm-8 col-xs-8 padding-left-0 padding-right-0">
				<select class="form-control margin-one-three" id="shadow_login_id"
					><option value="">Select Client</option>
					<?php $model_clients = new TblAcaClients(); 
					$all_clients = $model_clients->Findallclients();
					
					if(!empty($all_clients))
					{
					foreach ($all_clients as $clients)
					{
						$encrypt_component = new EncryptDecryptComponent();
						$user_id = $encrypt_component->encrytedUser($clients->user_id);
					?>
					<option value="<?php echo $user_id; ?>"><?php echo Html::encode($clients->client_name .'-'. $clients->year->lookup_value); ?></option>
					<?php }}?>
					</select>
			</div>
			<div class=" col-lg-1 col-sm-2 col-xs-3 padding-right-0" style="padding-left: 5px;">
				<button class="form-control btn btn-success margin-one-three"
					 onclick="shadowlogin();">Go</button>
			</div>
		</div>
		 <?php } ?>
		<div class="navbar-custom-menu pull-right col-lg-3 col-sm-4 col-xs-3">

			<ul class="nav navbar-nav pull-right">

				<!-- Messages: style can be found in dropdown.less-->


				<!-- Tasks: style can be found in dropdown.less -->

				<!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu"><a href="#"
					class="dropdown-toggle" data-toggle="dropdown" id="dropd">
					<?php if(!empty($staff_user_details->profile_pic)){?>
                        <img
						src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/<?php echo $staff_user_details->profile_pic; ?>"
						class="user-image" alt="User Image" />
						<?php }else{ ?>
						
						 <img
						src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/report_1_28146_default.png"
						class="user-image" alt="User Image" />
						<?php } ?>
                        <span style="color: white !important;"
						class="hidden-xs"> <?php  $string = (strlen($name) > 15) ? substr($name,0,13).'...' : Html::encode($name);?> 
						     <?php  echo $string; ?></span> <span class="caret"></span>
				</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<div>
						<?php if(!empty($staff_user_details->profile_pic)){?>
                            <img
									src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/profile_image/<?php echo $staff_user_details->profile_pic; ?>"
									class="img-circle img-class"
									alt=" User Image"/>
								 
								 <?php }else{ ?>
						
						 <img
									src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/report_1_28146_default.png"
									class="user-image img-class" alt="User Image"
									/>
						<?php } ?>
						</div>
							<p>
                     <?php  $string = (strlen($name) > 15) ? substr($name,0,13).'...' : Html::encode($name);    
                      ?>      <?php  echo $string; ?>
                                <small>Member since <?php  echo Html::encode($member_since) ;?></small>
							</p>
						</li>
						<!-- Menu Body -->

						<!-- Menu Footer-->
						<li class="user-footer">
							<!--<div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>-->
							<div class="col-xs-3" style="padding-left: 0px;">
                            <?php $user_id = $admin_user_id;
		$encrypt_component = new EncryptDecryptComponent();
		$user_id = $encrypt_component->encrytedUser($user_id);
		?>
                                <a
									href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/profile/index?id=<?php echo $user_id;?>"
									class="btn btn-default btn-flat no-wrap padding-five" >Profile</a>
							</div>
							<div class="col-xs-6" style="padding-left: 0px;">
								<a data-toggle="modal" data-target="#myModal-change-pswd"
									class="btn btn-default btn-flat no-wrap padding-five" >Change
									Password</a>
							</div>
							<div class="col-xs-3" style="padding-left: 0px;">
								<a class="btn btn-default btn-flat no-wrap padding-five"
									href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/adminlogout"
									data-method="post" >Sign out</a>
							</div>
						</li>
					</ul></li>

				<!-- User Account: style can be found in dropdown.less -->
				<!-- <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>-->
			</ul>
		</div>
	</nav>
</header>
<noscript>
        <div id="noscript-warning">ACA Reporting Service works best with JavaScript enabled<img  alt="" class="dno"></div>
    </noscript>
