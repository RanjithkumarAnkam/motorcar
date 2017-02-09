
<aside class="main-sidebar">

    <section class="sidebar">

       <?php 
	$session = \Yii::$app->session;
	$admin_permissions = $session ['admin_permissions'];?>

          <ul class="sidebar-menu">
      
    <?php //if(in_array ( '1', $admin_permissions ) == true) 	{ ?>
								 
        <li class=" " id="admin_dashboard"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin"><i class="fa fa-tachometer"></i>  <span>Dashboard</span></a></li>
     
     <?php //} ?>
     
        <?php if(in_array ( '3', $admin_permissions ) == true)  	{ ?>
  
		<li id="admin_clients"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/clients"><i class="fa fa-building"></i>  <span>Manage Clients</span></a></li>
		
		 <?php } ?>
		 
		 <?php if(in_array ( '4', $admin_permissions ) == true)  	{ ?>
		<li id="admin_companies"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/company"><i class="fa fa-industry"></i>  <span>Manage Companies</span></a></li>
		 <?php } ?>
		 
		 <?php if(in_array ( '5', $admin_permissions ) == true)  	{ ?>
		<li id="admin_users"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/users"><i class="fa fa-users"></i>  <span>Manage Users</span></a></li>
		 <?php } ?>
		
		 <?php if((in_array ( '6', $admin_permissions ) == true) || (in_array ( '7', $admin_permissions ) == true) || (in_array ( '8', $admin_permissions ) == true) || (in_array ( '9', $admin_permissions ) == true)|| (in_array ( '12', $admin_permissions ) == true))  	{ ?>
			<li id="admin_master_data"><a href="#"><i class="fa fa-cogs"></i>  <span>Master Data</span> <i class="fa fa-angle-left pull-right"></i></a>
			<ul class="treeview-menu" id="admin_master_data_tree">
			 <?php if(in_array ( '6', $admin_permissions ) == true)  	{ ?>
			<li id="admin_brands"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata"><i class="fa fa-angle-double-right"></i>  <span>Manage Brands </span></a></li>
		 <?php } ?>
		 
		 <?php if(in_array ( '7', $admin_permissions ) == true)  	{ ?>
			<li id="admin_lookupoptions"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/lookupoptions"><i class="fa fa-angle-double-right"></i>  <span>Lookup Options</span></a></li>
		 <?php } ?>
		 
		<?php if(in_array ( '8', $admin_permissions ) == true)  	{ ?>
			<li id="admin_account_settings"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/accountsettings"><i class="fa fa-angle-double-right"></i>  <span>Account Settings</span></a></li>
		 <?php } ?>
		 
		<?php if(in_array ( '9', $admin_permissions ) == true)  	{ ?>
			<li id="admin_elements"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/elements"><i class="fa fa-angle-double-right"></i>  <span>Element Master</span></a></li>
			 <?php } ?>
			 
		<?php if(in_array ( '12', $admin_permissions ) == true)  	{ ?>
			 <li id="admin_errors"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/errors"><i class="fa fa-angle-double-right"></i>  <span>Error Master</span></a></li>
		 <?php } ?>	 
			 <li id="admin_formpricing"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/formpricing"><i class="fa fa-angle-double-right"></i>  <span>Form Pricing</span></a></li>
			 <li id="admin_managecodes"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/masterdata/manage1095c"><i class="fa fa-angle-double-right"></i>  <span>Manage 1095c Codes</span></a></li>
			</ul>
	        </li>
		 <?php } ?>
		 
		<?php if(in_array ( '2', $admin_permissions ) == true)  	{ ?>
		<li class="red hide" id="admin_reports"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/report"><i class="fa fa-file"></i>  <span>Reports</span></a></li>
		 <?php } ?>
		<?php if(in_array ( '10', $admin_permissions ) == true)  	{ ?>
		<li class="red hide" id="admin_transactions"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/transaction"><i class="fa fa-money"></i>  <span>View Transactions</span></a></li>
		   <?php } ?>
		<?php if(in_array ( '13', $admin_permissions ) == true)  	{ ?>
		<li id="mng_efile"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/efile"><i class="fa fa-edit"></i>  <span>Manage E-File Clients</span></a></li>
		 <?php } ?>    
		 
		<li id="admin_jobschedule"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/schedulejobs"><i class="fa fa-cog"></i>  <span>Schedule Jobs</span></a></li>
		
			 <li id="admin_dashboard"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/video"><i class="fa fa-video-camera"></i>  <span>Videos</span></a></li>
			 <li id="admin_copy"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/admin/copy"><i class="fa fa-industry"></i>  <span>Copy Company data</span></a></li>
		      <li id="admin_logout"><a href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/adminlogout"><i class="fa fa-power-off" aria-hidden="true"></i> <span>Logout</span></a></li>
		</ul>

    </section>

</aside>
