<?php

use yii\helpers\{ Html, Url, HtmlPurifier };
use yii\grid\GridView;
use yii\widgets\Pjax;

use nterms\pagesize\PageSize;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'email:email',
            'username',
            [
                'attribute' => 'is_active',
                'format' => 'raw',
                'value' => function($model) {
                    $icon_style = $model->is_active ? 'glyphicon-ok-circle' : 'glyphicon-ban-circle';
                    $uri = Url::toRoute(['article/status', 'id' => $model->id]);
                    
                    return Html::a('<span class="glyphicon ' . $icon_style . '" aria-hidden="true"></span>', '#', [
                        'title' => Yii::t('yii', 'Toggle status'),
                        'aria-label' => Yii::t('yii', 'Toggle status'),
                        'onclick' => "
                            if (confirm('Are you sure you want to change status?')) {
                                $.ajax('$uri', {
                                    type: 'POST'
                                }).done(function(data) {
                                    $.pjax.reload({container: '#article-view'});
                                });
                            }
                            return false;
                        ",
                    ]);
                },
            ],
            'auth_key',
            'password_reset_token',
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i:s']
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d/m/Y H:i:s']
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
