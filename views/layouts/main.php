<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\Modal;

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

    if (!\Yii::$app->user->isGuest) {
        $ar_items[] =  [
            'label' => 'Articles', 
            'visible' => \Yii::$app->user->can('editor') || \Yii::$app->user->can('articleManager'), 
            'items' => [
                [
                    'label' => 'Add article (modal)', 
                    'url' => ['/article/create'], 
                    'options' => [ 'data-modal-container-id' => '#template-modal' ]
                ],
                [
                    'label' => 'Articles list', 
                    'url' => ['/article/index'], 
                ],
            ]
        ];
    }
    
    if (!\Yii::$app->user->isGuest) {
        $ar_items[] =  
            [
                'label' => 'Users',
                'visible' => \Yii::$app->user->can('userManager'), 
                'items' => [
                    [
                        'label' => 'Add user (modal)', 
                        'url' => ['/user/create'], 
                        'options' => [ 'data-modal-container-id' => '#template-modal' ]
                    ],
                    [
                        'label' => 'Users list', 
                        'url' => ['/user/index']
                    ],
                ]
            ];
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

<?php 
Modal::begin([
    'headerOptions' => ['id' => 'modalHeader' ],
    'id' => 'template-modal',
    'size' => 'modal-sm',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => true
    ]
]) ?>
<?php Modal::end(); ?>
<?php $this->endBody() ?>

<!--div>
<?php if (! \Yii::$app->user->isGuest): ?>
    <?php //print_r(\Yii::$app->authManager->getPermissionsByUser(\Yii::$app->user->getId())); ?>
    <hr />  
    <?php //var_dump(\Yii::$app->user->can('editor')); ?>
    <?php //var_dump(\Yii::$app->user->can('articleOwnManager')); ?>
    <?php //var_dump(\Yii::$app->user->can('articleManager')); ?>
    <?php //var_dump(\Yii::$app->user->can('userManager')); ?>
<?php endif ?>
</div-->

</body>
</html>
<?php $this->endPage() ?>
