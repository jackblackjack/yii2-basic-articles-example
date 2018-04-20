<?php
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/sign-up-activate', 'token' => $user->auth_key]);
?>
 
Hello <?= $user->username ?>,
Follow the link below to activate account:
 
<?= $resetLink ?>