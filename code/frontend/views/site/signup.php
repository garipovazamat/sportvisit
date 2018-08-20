<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\User;
use yii\widgets\MaskedInput;
use common\models\City;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'sname') ?>
                <div class="little_fields">
                    <?=$form->field($model, 'id_city')
                        ->dropDownList(City::getCityList())?>
                    <?= $form->field($model, 'sex')->dropDownList([
                        User::SEX_MALE => 'Мужской',
                        User::SEX_FEMALE => 'Женский',
                    ], ['prompt' => 'не выбрано'])?>
                    <?=$form->field($model, 'phone')->widget(MaskedInput::className(), [
                        'mask' => '+7(999) 999 9999'
                    ])?>
                </div>
                <?= $form->field($model, 'is_organizator')->checkbox() ?>
                <?=$form->field($model, 'date_born')->hiddenInput()->label(false)?>

                <div class="form-group">
                    <?= Html::submitButton('Регистрация', [
                        'class' => 'btn btn-primary',
                        'name' => 'signup-button'
                    ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
