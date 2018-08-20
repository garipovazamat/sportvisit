<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.02.16
 * Time: 16:30
 * @var $this \yii\web\View
 * @var $searchModel frontend\models\SearchEvent
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $data \common\models\Event
 */

use yii\grid\GridView;
use yii\grid\DataColumn;
use common\models\Image;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Sports;
use yii\widgets\Pjax;


?>
<?php Pjax::begin();?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    'options' => ['data-pjax' => true, 'class' => 'event_form'],
]);?>
<div class="search_block">
    <?=$form->field($searchModel, 'id_sport')
            ->dropDownList(Sports::getSportsList(), ['prompt' => 'Все виды'])?>
    <?=Html::submitButton('Найти', ['class' => 'eventmap'])?>
    <?=Html::a((!$searchModel->isSection)?'Мероприятия на карте':'Секции на карте',
        ['event/eventsmap', 'isSection' => $searchModel->isSection],
        ['class' => 'form-group eventmap btn btn-primary'])?>
</div>
<?php ActiveForm::end()?>

<div class="events_list">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'filterPosition' => GridView::FILTER_POS_HEADER,
    'summary' => "<div class='summary'>Показанны {begin} - {end} событий из {totalCount}, страница {page}</div>",
    'tableOptions' => ['class' => 'table table-striped table-hover'],
    'columns' => [
        [
            'class' => DataColumn::className(),
            'contentOptions' => ['style' => [
                'min-width' => '100px',
            ]],
            'format' => 'raw',
            'label' => '',
            'value' => function($data) {
                /* @var \common\models\Event $data */
                $first_image_url = $data->news->getFirstImageUrl();
                $thumb_url = Image::getThumbnail($first_image_url);
                return Html::img($thumb_url, ['class' => 'event_thumb']);
            }
        ],
        [
            'class' => DataColumn::className(),
            'contentOptions' => ['width' => '100%', 'align' => 'left'],
            'format' => 'raw',
            'label' => '',
            'value' => function($data) {
                /* @var $this \yii\web\View */
                return $this->render('_event_element', ['model' => $data]);
            }
        ],
    ],
]);?>
<?php Pjax::end();?>
</div>
