<?php

use yii\helpers\{ Html, Url, HtmlPurifier };
use yii\grid\GridView;
use yii\widgets\Pjax;

use nterms\pagesize\PageSize;
use yii\bootstrap\Alert;

use app\assets\backend\ArticleAsset;
ArticleAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php $pjax_wgt = Pjax::begin(); ?> 
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if ($message = Yii::$app->session->getFlash('message')) {
        echo Alert::widget([
            'options' => [
                'class' => 'alert-info',
            ],
            'body' => $message,
        ]);
    }?>

    <?php if (!\Yii::$app->user->isGuest && \Yii::$app->user->can('articleCreateNew')): ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create Article'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif ?>

    <div class="pull-right">
        <?php echo PageSize::widget([
            'label' => 'Items on page',
            'defaultPageSize' => 20,
            'sizes' => [ 10 => 10, 20 => 20, 50 => 50 ],
        ]); ?>
    </div>
    
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'maxButtonCount' => 5,
            'prevPageLabel' => '<',
            'nextPageLabel' => '>',
            'firstPageLabel' => '<<',
            'lastPageLabel' => '>>',
        ],
        'columns' => [
            [ 'class' => 'yii\grid\SerialColumn' ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i:s']
            ],
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
                        'article/status', 
                        'id' => $model->id
                    ]);

                    return Html::a(
                                '<span class="glyphicon ' . $icon_style . '" aria-hidden="true"></span> ', '#', [
                                    'title' => Yii::t('yii', 'Toggle status'),
                                    'aria-label' => Yii::t('yii', 'Toggle status'),
                                    'data-url' => "{$uri}",
                                    'data-model-id' => $model->id,
                                    'data-confirm-text' => Yii::t('yii', 'Are you sure you want to change article status?'),
                                    'data-container-id' => "#{$pjax_wgt->getId()}"
                                ]) . $hint_text;
                },
            ],
            [
                'attribute' => 'title',
                'format' => 'raw',
                'value' => function($model) {
                    return HtmlPurifier::process($model->title);
                }
            ],
            [
                'attribute' => 'preview_data',
                'format' => 'raw',
                'value' => function($model) {
                    return HtmlPurifier::process($model->preview_data);
                }
            ],
            [
                'attribute' => 'full_data',
                'format' => 'raw',
                'value' => function($model) {
                    return HtmlPurifier::process($model->full_data);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'update' => function ($model) {
                        return \Yii::$app->user->can('articleCanEditIfOwner', ['post' => $model]);
                    },
                    'delete' => function ($model) {
                        return \Yii::$app->user->can('articleCanDeleteIfOwner', ['post' => $model]);
                    },
                ],
            ],
        ],
    ]); ?>
    
    <?php Pjax::end(); ?>
</div>
