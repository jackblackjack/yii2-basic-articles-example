<?php
 
use yii\helpers\Html;
 
$homeLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
 
<div class="sign-up-congratulations">
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>Follow the link below to enter:</p>
    <p><?= Html::a(Html::encode($homeLink), $homeLink) ?></p>
</div>