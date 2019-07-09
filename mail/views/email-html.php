<?php
use yii\helpers\Html;
/** @var $this \yii\web\View */
/** @var $link string */
/** @var $paramExample string */
$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/profile', 'token' => $this->params['authKey']]);
?>

<p>Для завершения регистрации перейдите по следующей ссылке:</p>

<p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>