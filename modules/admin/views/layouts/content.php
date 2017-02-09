<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper" style="min-height:1000px;">
    <section class="content-header" style=" color: white; ">
     <!-- 			<div class="row"> 				<div class="col-md-8 no-padding">					<ul class="nav nav-tabs standard-font" >						<li id="dashboard-menu-id" class="">							<a class="white" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard/company">Dashboard</a>						</li>						<li id="companies-menu-id">							<a class="white" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/dashboard">Companies</a>						</li>						<li id="settings-menu-id" class="">							<a class="white" href="#">Settings</a>						</li>						<li id="help-menu-id" class="">							<a class="white" href="#">Help</a>						</li>																	</ul>				</div>				<div class="col-md-4">					 <div class="progress active">                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">                  <span class="sr-only">40% Complete (success)</span>                </div>				</div>			</div>		</div>-->

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>  
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>



