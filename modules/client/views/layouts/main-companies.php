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
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
		<link rel="shortcut icon" type="image/png" href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/Images/favicon.png" >
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
       <link href="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/client-companies.css" rel="stylesheet">
	   <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
		<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    </head>
    <body class=" sidebar-mini skin-blue sidebar-collapse">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header-companies.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left-companies.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content-companies.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
	
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/input-mask/jquery.inputmask.extensions.js"></script>

<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/customfunctions.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/validation.js"></script>


<script>

	$(function() {
		$("[data-mask]").inputmask();
	});
</script>
	
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

    </body>
    </html>
    <?php $this->endPage() ?>
	
	<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/toastr.js"></script>
<?php } ?>
