<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.02.16
 * Time: 23:16
 *
 * @var $model common\models\EventForm
 */

use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use dosamigos\datetimepicker\DateTimePicker;
use yii\helpers\Url;
use kolyunya\yii2\widgets\MapInputWidget;
use common\models\Sports;
use common\models\City;
?>

<div class="myforms">
    <?php $form = ActiveForm::begin([
        'id' => 'event_create',
        'options' => ['enctype' => 'multipart/form-data']]);
    ?>
    <div class="event_name_form"><?= $form->field($model, 'name')?></div>
        <?= $form->field($model, 'text')->widget(Widget::className(), [
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
        <div class="date_widget_group">
            <?=$form->field($model, 'id_sport')
                ->dropDownList(Sports::getSportsList(), ['prompt' => 'не выбрано'])?>
            <?=$form->field($model, 'id_city')
                ->dropDownList(City::getCityList())?>
            <?=$form->field($model, 'date_from')->widget(DateTimePicker::className(),[
                'language' => 'ru',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd HH:ii',
                    'todayBtn' => true,
                    'weekStart' => 1,
                    'pickerPosition' => 'bottom-left'
                ]
            ]) ?>
            <?=(!$model->isSection) ?
                $form->field($model, 'date_to')->widget(DateTimePicker::className(),[
                'language' => 'ru',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd HH:ii',
                    'todayBtn' => true,
                    'weekStart' => 1,
                    'pickerPosition' => 'bottom-left'
                ],
            ]) : '' ?>
        </div>
        <?= $form->field($model, 'coords')->widget(MapInputWidget::className(), [
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
    <div class="form-group">
        <?= Html::submitButton(($model->isNew()) ? 'Создать' : 'Изменить', [
            'class' => 'btn btn-primary', 'name' => 'signup-button'
        ]) ?>
    </div>
    <? ActiveForm::end();?>

</div>
