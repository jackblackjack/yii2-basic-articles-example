<?php
 
use yii\helpers\Html;
 
$homeLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
 
<div class="sign-up-congratulations">
    <p>Hello <?= Html::encode($user->username) ?>!</p>
    <p>Welcome to site!</p>
</div>