<?php
$homeLink = Yii::$app->urlManager->createAbsoluteUrl(['site/index']);
?>
 
Hello <?= $user->username ?>,
Follow the link below to enter:
 
<?= $homeLink ?>