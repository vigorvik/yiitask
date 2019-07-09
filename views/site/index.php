<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use yii\widgets\LinkPager;

$this->title = 'Регистрация';
?>
<div class="site-index">

    <div class="body-content">
    
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'surname')->label('Фамилия') ?>
    
    <?= $form->field($model, 'name')->label('Имя') ?>

    <?= $form->field($model, 'email')->label('E-mail') ?>
    
    <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
    
    <?= $form->field($model, 'confirmation')->passwordInput()->label('Подтверждение пароля') ?>
       
    <div class="form-group">
        <?= Html::submitButton('Зарегистрировать', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

    </div>
</div>
