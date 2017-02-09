<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper" style="min-height:1000px;">
    <section class="content-header" style=" color: white; border-top: 1px solid #f39c12; background: #222d32;">
     <div class="">			<div class="row">				
     <div class="col-md-12 no-padding">					
     <ul class="nav nav-tabs standard-font" >						
    
     					
     <li id="companies-menu-id" class="active ">	
     	<a class="white active hide" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/client/companies">Companies</a>	
     	</li>				
 
     					</ul>			
           </div>		
     										</div>

  <?php /*       <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?> */ ?>
    </section>

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>


