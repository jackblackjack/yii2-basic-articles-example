<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $ar_items = [];
 

    if (!\Yii::$app->user->isGuest && \Yii::$app->user->can('articleCreateNew')) {
        $ar_items[] =  ['label' => 'Add article', 'url' => ['/article/create']];
    }

    if (!\Yii::$app->user->isGuest && \Yii::$app->user->can('userCreateNew')) {
        $ar_items[] =  ['label' => 'Add user', 'url' => ['/user/create']];
    }

    if (! \Yii::$app->user->isGuest) {
        $ar_items[] =  ['label' => 'Notice options', 'url' => ['/user-notice/index']];
    }
    
    $ar_items = array_merge($ar_items, [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],
        ['label' => 'Contact', 'url' => ['/site/contact']]
    ]);

    if (\Yii::$app->user->isGuest) {
        $ar_items = array_merge($ar_items, [
            ['label' => 'Login', 'url' => ['/site/login']],
            ['label' => 'Sign up', 'url' => ['/site/sign-up']]
        ]);
    }
    else {
        $ar_items[] = '<li>'
        . Html::beginForm(['/site/logout'], 'post')
        . Html::submitButton(
            'Logout (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-link logout']
        )
        . Html::endForm()
        . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $ar_items
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>

<?php //print_r(\Yii::$app->authManager->getPermissionsByUser(\Yii::$app->user->findByUsername('admin'))); ?>

<?php //echo 'User id:', \Yii::$app->user->getId(); ?>



<?php //print_r(@$ar['articleCreateNew']); ?>


<?php //print_r(\Yii::$app->authManager->getAssignments(\Yii::$app->user->getId())); ?>

<?php //var_dump(\Yii::$app->user->can('articleCreateNew', [], false)); ?>
<?php //var_dump(\Yii::$app->user->can('articleCreateNew')); ?>

</body>
</html>
<?php $this->endPage() ?>
