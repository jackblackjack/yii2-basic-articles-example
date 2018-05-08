<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h3><?php echo Html::encode($model->title) ?></h3>
    <?php echo HtmlPurifier::process($model->preview_data) ?>
    <p>
        <?php echo Html::a('Detail view &raquo;', 
                    Url::toRoute([ 'article/view', 'id' => $model->id ]), 
                    [
                        'class' => 'btn btn-default', 
                        'data-pjax' => 0 
                    ]) 
        ?>
    </p>
</div>
                    