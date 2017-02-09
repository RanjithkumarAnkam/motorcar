<?php

use yii\helpers\Html;
use app\models\StaffDetails;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */
?>
<style>

.box-title {
    display: inline-block !important;
   font-size: 22px !important;
    color: #222D32 !important
    margin: 0 !important;
    line-height: 1 !important;
}
@media (min-width: 768px)
{
.sidebar-mini.sidebar-collapse .main-header .navbar {
    margin-left: 230px !important;
}
}

@media (min-width: 768px)
{
.sidebar-mini.sidebar-collapse .main-header .logo {
    width: 230px !important;
}
}


@media (min-width: 768px)
{
.sidebar-mini.sidebar-collapse .sidebar-menu>li:hover>a>span:not(.pull-right), .sidebar-mini.sidebar-collapse .sidebar-menu>li:hover>.treeview-menu {
    display: block !important;
    position: absolute;
    width: 220px !important;
    left: 50px;
}
}

.main-header .logo{
	height: 60px;
	line-height: 60px;
}
.main-header .sidebar-toggle
{
line-height: 30px;	
}

.navbar-nav>.user-menu .user-image
{
	margin-top:2px;
}
#dropd{
	line-height: 30px;	
}
.main-sidebar, .left-side{
	padding-top: 60px;
}
</style>
<header class="main-header">

    <?= Html::a('<div class="col-md-2 padding-0"><img src="/../uploads/USLawShieldLogo copy.png" class=" hidden-xs hidden-sm" style="width: 52px;"></div><div class="col-md-10 padding-0"><span class="logo-lg" style="font-size:16px;">' . Yii::$app->name . '</span></div>', Yii::$app->homeUrl.'admin', ['class' => 'logo','style'=>'padding: 0 2px;']) ?>

    <nav class="navbar navbar-static-top" role="navigation" >

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <!-- Messages: style can be found in dropdown.less-->
               
        
                <!-- Tasks: style can be found in dropdown.less -->
               
                <!-- User Account: style can be found in dropdown.less -->
<?php 
$session = Yii::$app->session;
$logged_id = $session['logged_id'];
//$getdata= StaffDetails::find()->where(['=','user_id', $logged_id])->one();
$getdata=array();
?>
                <li class="dropdown user user-menu" >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropd">
					<?php if(!empty($getdata->imageFile)){?>
                        <img src="http://reporting.uslawshield.com/uploads/<?php echo $logged_id; ?>/<?php echo $getdata->imageFile; ?>" class="user-image" alt="User Image"/>
						<?php }else{ ?>
						
						 <img src="http://reporting.uslawshield.com/uploads/1/report_1_28146_default.png" class="user-image" alt="User Image"/>
						<?php } ?>
                        <span class="hidden-xs">John Smith</span>
						<span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" >
                        <!-- User image -->
                        <li class="user-header">
						<div>
						<?php if(!empty($getdata->imageFile)){?>
                            <img src="http://reporting.uslawshield.com/uploads/<?php echo $logged_id; ?>/<?php echo $getdata->imageFile; ?>" class="img-circle" style="    height: 80px;width: 80px;float: initial;
                                 alt="User Image"/>
								 
								 <?php }else{ ?>
						
						 <img src="http://reporting.uslawshield.com/uploads/1/report_1_28146_default.png" class="user-image" alt="User Image" style="    height: 80px;width: 80px;float: initial;"/>
						<?php } ?>
						</div>
                            <p>
                                <?php // echo $getdata->first_name.' '.$getdata->last_name ?>
                                <small>Member since <?php // echo $getdata->created_date;?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                      
                        <!-- Menu Footer-->
                        <li class="user-footer">
						<!--<div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>-->
                            <div class="col-md-3" style="padding-left: 0px;">
                                <a href="<?php echo Yii::$app->homeUrl; ?>admin/manage_users/update?id=<?php echo $logged_id;?>" class="btn btn-default btn-flat" style="    padding: 5px;">Profile</a>
                            </div>
							<div class="col-md-6" style="padding-left: 0px;">
                                <a href="http://reporting.uslawshield.com/admin/changepassword" class="btn btn-default btn-flat" style="    padding: 5px;">Change Password</a>
                            </div>
                           <div class="col-md-3" style="padding-left: 0px;">
                                <a class="btn btn-default btn-flat" href="http://reporting.uslawshield.com/site/logout" data-method="post" style="style=&quot;    padding: 5px;&quot;">Sign out</a>                            </div>
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
