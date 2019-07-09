<?php

/** @var $this \yii\web\View */
/** @var $link string */
/** @var $paramExample string */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/profile', 'token' => $this->params['authKey']]);
?>
Для завершения регистрации перейдите по следующей ссылке:

<?= $confirmLink ?>