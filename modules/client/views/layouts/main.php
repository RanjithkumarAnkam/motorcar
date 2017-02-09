<?php
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
    //	print_r($this); die();
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags(); ?>
		<link rel="shortcut icon" type="image/png" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/favicon.png" >
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
        <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client.css" rel="stylesheet"/>
<link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/datepicker3.css">
  
 
 
    </head>
    <body class=" sidebar-mini skin-blue fixed">
    <?php $this->beginBody(); ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody(); ?>
	<script type="text/javascript">
	$( document ).ready(function() {
		
	
 /*
$( ".sidebar-toggle" ).click(function() {
 if($("body.sidebar-mini").hasClass("sidebar-collapse")){
  $(".main-sidebar>section>div.user-panel").css("min-height","0px");
 }else{
  $(".main-sidebar>section>div.user-panel").css("min-height","59px");
 }
});
*/
});
	</script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.extensions.js"></script>


<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/bootstrap-datepicker.js"></script>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/customfunctions.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/validation.js"></script>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/basicscroll.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/jquery.slimscroll.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/client/client-ajax.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/toastr.js"></script>	
<!-- jQuery 2.1.4 -->



<div id="pswd_info">
								<h4>Suggested Password Combinations:</h4>
								<ul style="list-style: none;">
									<li id="letter" class="invalid">At least <strong>one letter</strong></li>
									<li id="capital" class="invalid">At least <strong>one capital letter</strong></li>
									<li id="number" class="invalid">At least <strong>one number</strong></li>
									<li id="specialchar" class="invalid">At least <strong>one special character</strong></li>
									<li id="length" class="invalid">Be at least <strong>8 characters</strong></li>
								</ul>
							</div>


<script type="text/javascript">
	$( document ).ready(function() {

		<?php $get_id = Yii::$app->request->get();
			$company_id  = '';
			if(!empty($get_id['c_id']))
			{
			$company_id = $get_id['c_id'];
			}
		?>
var company_id = '<?php echo $company_id?>';
var menu_ids = [];
$('.sidebar-menu li').each(function(i)
{
	$ids = $(this).attr('id');
	
	if($ids=="basic_reporting" || $ids=="benefit_plan_info_menu_main"){
		// do nothing
	}else{
	//	console.log($ids);
  menu_ids.push($ids); // This is your rel value
	}
	
	
	
});


$('.top-navigation li').each(function(i)
{
	$ids = $(this).attr('id');
	
	if($ids=="companies-menu-id"){
		// do nothing
	}else{
	//	console.log($ids);
  menu_ids.push($ids); // This is your rel value
	}
	
	
	
});


     

       for($i=0;$i<=menu_ids.length-1 ;$i++)
       {
    	   var new_href = '';
    	   var old_href = '';
    	   var menu_id = '';
    	   
			menu_id = menu_ids[$i];
			
			var old_href = $('#'+menu_id).find( "a" ).attr( "href");
			
			if (old_href.indexOf("?") >= 0)
			{
				if (old_href.indexOf("#") >= 0)
				{
					var old_href_array = old_href.split('#');
					new_href = old_href_array[0]+'&c_id='+company_id+'#'+old_href_array[1];
				}
				else
				{
					new_href = old_href+'&c_id='+company_id;
				}
				
				$('#'+menu_id).find( "a" ).attr( "href",new_href);
			}
			else
			{
				if (old_href.indexOf("#") >= 0)
				{
					var old_href_array = old_href.split('#');
					new_href = old_href_array[0]+'?c_id='+company_id+'#'+old_href_array[1];
				}
				else
				{
					new_href = old_href+'?c_id='+company_id;
				}
				
				
				$('#'+menu_id).find( "a" ).attr( "href",new_href);
			}
			
       }     
		
});
	</script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/select2.min.js"></script>
    </body>
    
    <script>
    $(document).ready(function() {
    toastr.options = {
    "closeButton": true,
    "timeOut": 10000,
    }
    });
    </script>
	
	<?php $this->endPage() ?>
    
      

 


	
<?php } ?>

</html>
