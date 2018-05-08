<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

use nterms\pagesize\PageSize;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-8">
                <h2>Articles</h2>

                <div class="pull-right">

                    <?php Pjax::begin([
                            'id' => 'articles-per-page-cursor', 
                            'formSelector' => '#articles-per-page select',
                            'timeout' => \Yii::$app->params['pjax.timeout.default']
                        ]) ?>
                        <?= Html::beginForm(['site/index'], 'get', ['data-pjax' => 0, 'id' => 'articles-per-page']); ?>
                        <?php echo Html::label(\Yii::t('app', 'Articles on page')) ?>
                        <?= Html::dropDownList('per-page', 
                            \Yii::$app->getRequest()->getQueryParam('per-page') != NULL ? 
                            \Yii::$app->getRequest()->getQueryParam('per-page') : 
                                \Yii::$app->params['pagination.perpage.begin'], 
                                \Yii::$app->params['pagination.perpage.default'],
                                [
                                    'class' => 'form-control',
                                    'style' => 'display: inline-block; width: 5em'
                                ])
                        ?>
                        <?= Html::submitButton('Ok', ['class' => 'btn btn-sx btn-primary']) ?>
                        <?= Html::endForm() ?>
                    <?php Pjax::end(); ?>

                    
                </div>

                <?php $pjax_wgt = Pjax::begin([ 
                    'id' => 'articles-list',
                    'enablePushState' => true,
                    'enableReplaceState' => false,
                    'timeout' => \Yii::$app->params['pjax.timeout.default']
                ]); ?>

                <?php 
                echo ListView::widget([ 
                        'dataProvider' => $dataProvider,
                        'itemView'     => function ($model, $key, $index, $widget) {
                            return $this->renderAjax('partial/_article', [
                                'dataProvider' => $widget->dataProvider,
                                'model' => $model
                            ]);
                        },
                        'options' => [ 'data-pjax' => true ],
                        'layout' => '
                            <div>
                                {items}
                                <div class="clr"></div>
                            </div>
                            {pager}
                        ',
                        'pager' => [
                            'linkOptions'=>[
                                'data-pjax' => 1,
                                'data-container-id' => "#{$pjax_wgt->getId()}"
                            ],
                            'prevPageLabel' => '<',
                            'nextPageLabel' => '>',
                            'firstPageLabel' => '<<',
                            'lastPageLabel' => '>>',
                            'maxButtonCount' => 5
                        ],
                    ]);
                ?>
                <?php Pjax::end(); ?>
            </div>
            <div class="col-lg-4">
                <h2>Congratulations!</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
