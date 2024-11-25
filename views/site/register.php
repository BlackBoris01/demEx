<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-register">
<h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
    'id' => 'signup-form',
    'enableAjaxValidation' => true,
]); ?>


        <?= $form->field($model, 'name') ?>
        <?= $form->field($model, 'surname') ?>
        <?= $form->field($model, 'patronymic') ?>
        <?= $form->field($model, 'login') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password') ->passwordInput()?>
        <?= $form->field($model, 'passwordRep') ->passwordInput()?>
        <?= $form->field($model, 'phone') ?>
        <?= $form->field($model, 'profilePhoto')->fileInput() ?>
        <?= $form->field($model, 'rules') ->checkbox() ?>

      
    
        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-register -->
