<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h3><?= Html::encode($model->title) ?></h3>
    <?= HtmlPurifier::process($model->preview_data) ?>

    <?php if (! \Yii::$app->user->isGuest): ?>
    <?php echo Html::a('aaa') ?>
    <?php endif ?>
</div>