<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use app\components\EncryptDecryptComponent;
?>
<div class="content-wrapper">
	<section class="content-header content-dashboard"
		style="z-index: 999 !important;">
		<div class="">
			<div class="row">
				<div class="col-md-12 no-padding">
					<ul class="nav nav-tabs standard-font top-navigation">						
  <?php
		$session = \Yii::$app->session;
		$logged_user_id = $session ['client_user_id'];
		
		$get_company_id = \Yii::$app->request->get ();
		$encrypt_component = new EncryptDecryptComponent ();
		if (! empty ( $get_company_id )) {
			$encrypt_company_id = $get_company_id ['c_id'];
			if (! empty ( $encrypt_company_id )) {
				$company_id = $encrypt_component->decryptUser ( $encrypt_company_id );
			}
		}
		?>   
     					
     <li id="companies-menu-id"><a class="white" data-toggle="tooltip" data-placement="bottom"
			title="Click to view companies list" 
							href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/companies">All
								Companies</a></li>	
     	
		<?php
		
$dashboardpermission = \Yii::$app->Permission->Checkclientpermission ( $logged_user_id, $company_id, 'dashboard' );
		if ($dashboardpermission) {
			?>
     	 <li id="dashboard-menu-id" class=""><a class="white" data-toggle="tooltip" data-placement="bottom"
			title="Click to view company dashboard" 
							href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard">Company
								Dashboard</a></li>			
		<?php }?>
     					</ul>
				</div>
				<div class="hide col-md-4">
					<div class="progress active">
						<div
							class="progress-bar progress-bar-primary progress-bar-striped"
							role="progressbar" aria-valuenow="40" aria-valuemin="0"
							aria-valuemax="100" style="width: 40%">
							<span class="sr-only">40% Complete (success)</span>
						</div>
					</div>

				</div>

			</div>

  <?php 
/*
		       * <?= Breadcrumbs::widget( [ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [], ] ) ?>
		       */
		?>
    
	
	</section>

	<section class="content padding-left-5 padding-right-5"
		style="margin-top: 55px;">
        <?= Alert::widget()?>
        <?= $content?>
    </section>
</div>



