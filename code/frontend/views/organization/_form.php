<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.02.16
 * Time: 11:49
 * @var $model \common\models\Organization
 * @var $this \yii\web\View
 * @var $sport \common\models\OrgSport
 */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use vova07\imperavi\Widget;
use yii\helpers\Url;
use kolyunya\yii2\widgets\MapInputWidget;
use common\models\Sports;
use yii\widgets\MaskedInput;
use common\models\City;
?>

<div class="org_create">
    <?php $form = ActiveForm::begin(); ?>
    <div class="little_fields">
        <?=$form->field($model, 'name') ?>
        <?=$form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '+7(999) 999 9999'
        ])?>
        <?=$form->field($model, 'email') ?>
        <?=$form->field($model, 'id_city')
            ->dropDownList(City::getCityList(), [
                'prompt' => 'Выберите город, в котором расположена организация'
            ])?>
        <?=$form->field($model, 'address')?>
        <?=$form->field($sport, 'id_sport')
            ->dropDownList(Sports::getSportsList(), [
            'prompt' => 'Выберите вид спорта'
        ])?>
        <?=$form->field($model, 'url_address') ?>
    </div>
    <?=$form->field($model, 'descript')->widget(Widget::className(), [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'imageUpload' => Url::to(['/event/image-upload']),
            'plugins' => [
                'clips',
                'fullscreen',
            ]
        ]
    ])?>
    <?= $form->field($model, 'coordinates')->widget(MapInputWidget::className(), [
        'key' => 'AIzaSyBsS9NHmGrE7xBQVCUveDBpihrHen3YWpw',
        'latitude' => 60,
        'longitude' => 60,
        'zoom' => 3,
        //'width' => '700px',
        'height' => '80vh',
        'mapType' => 'roadmap',
        'animateMarker' => true,
        'alignMapCenter' => false,
        'pattern' => '%longitude%,%latitude%'
    ]) ?>

    <?=Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => 'btn btn-primary'])?>

    <?php ActiveForm::end(); ?>
</div>
