<?php

use yii\helpers\{ Html, Url, HtmlPurifier };
use yii\grid\GridView;
use yii\widgets\Pjax;

use nterms\pagesize\PageSize;
use yii\bootstrap\Alert;

use app\assets\backend\UserAsset;
UserAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if ($message = Yii::$app->session->getFlash('message')) {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $message,
        ]);
    }?>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php $pjax_wgt = Pjax::begin(); ?>
    
    <div class="pull-right">
        <?php echo PageSize::widget([
            'label' => 'Items on page',
            'defaultPageSize' => current(array_keys(\Yii::$app->params['pagination.perpage.begin'])),
            'sizes' => \Yii::$app->params['pagination.perpage.default'],
        ]); ?>
    </div>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'email:email',
            'username',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function($model) use ($pjax_wgt) {
                    
                    // Define icon style.
                    $icon_style = $model->is_active ? 'glyphicon-ok-circle' : 'glyphicon-ban-circle';

                    // Define hint text.
                    $hint_text = $model->is_active ? Yii::t('yii', 'Active') : Yii::t('yii', 'Not active');

                    // Build a uri.
                    $uri = Url::toRoute([ 
                        'user/status', 
                        'id' => $model->id
                    ]);

                    return Html::a(
                                '<span class="glyphicon ' . $icon_style . '" aria-hidden="true"></span> ', '#', [
                                    'title' => Yii::t('yii', 'Toggle status'),
                                    'aria-label' => Yii::t('yii', 'Toggle status'),
                                    'data-url' => "{$uri}",
                                    'data-model-id' => $model->id,
                                    'data-confirm-text' => Yii::t('yii', 'Change user status?'),
                                    'data-container-id' => "#{$pjax_wgt->getId()}"
                                ]) . $hint_text;
                },
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i:s']
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['date', 'php:d/m/Y H:i:s']
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
