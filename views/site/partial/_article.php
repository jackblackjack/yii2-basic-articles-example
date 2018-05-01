<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h3><?= Html::encode($model->title) ?></h3>
    <?= HtmlPurifier::process($model->preview_data) ?>

    <?php if (! \Yii::$app->user->isGuest): ?>
    <p><?php echo Html::a('Полный текст &raquo;', Url::toRoute([ 'article/view', 'id' => $model->id ]), ['class' => 'btn btn-default']) ?></p>
    <?php endif ?>
</div>
                    