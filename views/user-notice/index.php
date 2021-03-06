<?php
use yii\helpers\{ Html, HtmlPurifier, Url };
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

use app\assets\backend\UserNoticeAsset;
UserNoticeAsset::register($this);
?>
<?php

?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-8">
                <h2>Choosing the types of notifications you receive</h2>

                <?php $pjax_wgt = Pjax::begin([ 'timeout' => \Yii::$app->params['pjax.timeout.default'] ]); ?>                
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pager' => [
                        'maxButtonCount' => 5,
                        'prevPageLabel' => '<',
                        'nextPageLabel' => '>',
                        'firstPageLabel' => '<<',
                        'lastPageLabel' => '>>',
                    ],
                    'columns' => [
                        [
                            'attribute' => 'Notification type',
                            'format' => 'raw',
                            'value' => function($model) {
                                return HtmlPurifier::process($model['title']);
                            }
                        ],
                        [
                            'class'=>'yii\grid\DataColumn',
                            'attribute' => 'Selected types',
                            'format' => 'raw',
                            'value' => function($model) use ($pjax_wgt) {

                                // Define icon style.
                                $icon_style = $model['is_selected'] ? 'glyphicon-ok-circle' : 'glyphicon-ban-circle';

                                // Define hint text.
                                $hint_text = $model['is_selected'] ? Yii::t('yii', 'Selected') : Yii::t('yii', 'Not selected');

                                // Build a uri.
                                $uri = Url::toRoute([ 
                                    'user-notice/status', 
                                    'id' => $model['id']
                                ]);

                                return Html::a(
                                            '<span class="glyphicon ' . $icon_style . '" aria-hidden="true"></span> ', '#', [
                                                'title' => Yii::t('yii', 'Toggle status'),
                                                'aria-label' => Yii::t('yii', 'Toggle status'),
                                                'data-url' => "{$uri}",
                                                'data-model-id' => $model['id'],
                                                'data-container-id' => "#{$pjax_wgt->getId()}"
                                            ]) . $hint_text;
                            },
                        ]
                    ],
                ]);
                
                Pjax::end();
                ?>
            </div>
        </div>
    </div>
</div>
