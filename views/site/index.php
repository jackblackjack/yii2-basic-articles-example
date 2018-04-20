<?php
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">

        <div class="row">
            <div class="col-lg-8">
                <h2>Articles</h2>
                <?php 
                Pjax::begin(); //['timeout'=>700] ['enablePushState'=>false] 

                echo ListView::widget([ 
                        'id' => 'sdfsd',
                        'dataProvider' => $dataProvider,
                        'itemView' => 'partial/_article',
                        'layout' => '
                            <div class="cat_title_block">{pager}</div>
                            <div>
                                {items}
                                <div class="clr"></div>
                            </div>
                        ',
                        'pager' => [
                            'prevPageLabel' => '<',
                            'nextPageLabel' => '>',
                            'firstPageLabel' => '<<',
                            'lastPageLabel' => '>>'
                        ],
                    ]);
                Pjax::end(); ?>
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
