<?php
 
use yii\helpers\Html;
 
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/sign-up-activate', 'token' => $user->auth_key]);
?>
 
<div class="sign-up-activate">
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>Follow the link below to activate account:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>