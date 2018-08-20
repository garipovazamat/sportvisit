<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.03.16
 * Time: 12:14
 * @var $this \yii\web\View
 * @var $model \common\models\User
 * @var $photo \common\models\Image
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\date\DatePicker;
use common\models\User;
use yii\widgets\MaskedInput;
use common\models\City;
?>

<div class="user_form">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="little_fields">
        <?=$form->field($model, 'name')?>
        <?=$form->field($model, 'sname')?>
        <?=$form->field($photo, 'imageFile')->fileInput()->label('Ваше фото')?>
        <?=$form->field($model, 'sex')->dropDownList([
            User::SEX_MALE => 'Мужской',
            User::SEX_FEMALE => 'Женский',
        ], ['prompt' => 'не выбрано'])?>
        <?=$form->field($model, 'id_city')
            ->dropDownList(City::getCityList(), ['prompt' => 'Выберите город'])?>
        <?=$form->field($model, 'date_born')->widget(DatePicker::className(), [
            'options' => ['placeholder' => 'Введите дату рождения ...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ])?>
        <?=$form->field($model, 'email')?>
        <?=$form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '+7(999) 999 9999'
        ])?>
    </div>
    <?=$form->field($model, 'about_me')->textarea()?>

    <div class="little_fields">
    <?=$form->field($model, 'password')->passwordInput()
        ->label('Введите пароль, если хотите изменить его')?>
    </div>

    <?=Html::submitButton('Изменить', ['class' => 'btn btn-primary'])?>

    <?php
    ActiveForm::end();
    ?>
</div>
