<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h3><?= Html::encode($model->title) ?></h3>
    <?= HtmlPurifier::process($model->preview_data) ?>
    <p><?php echo Html::a('Читать новость &raquo;', Url::toRoute([ 'article/view', 'id' => $model->id ]), ['class' => 'btn btn-default']) ?></p>
</div>
                    