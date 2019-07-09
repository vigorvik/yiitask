<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-profile">

    <div class="body-content">
	
<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'surname')->label('Ваша фамилия')->textInput() ?>

    <?= $form->field($model, 'name')->label('Ваше имя') ?>

    <?= $form->field($model, 'email')->label('Ваш Email')->textInput(['readonly' => true,]);?>
    
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['name' => 'submitBtn', 'value' => 'save', 'class' => 'btn btn-primary']) ?>
    </div>
	
<?php
Modal::begin([
    'toggleButton' => ['label' => 'Удалить профиль', 'class' => 'btn btn-primary'],
 ]);
?>
	<p>Вы действительно хотите удалить профиль?</p>
	<div>
        <?= Html::Button('Отмена', ['data-dismiss' => 'modal', 'area-hidden' => 'true', 'class' => 'btn btn-primary']) ?>
        <?= Html::submitButton('Удалить профиль', ['name' => 'submitBtn', 'value' => 'delete', 'class' => 'btn btn-primary']) ?>
    </div>

<?php Modal::end(); ?>

<?php ActiveForm::end(); ?>

    </div>
</div>

