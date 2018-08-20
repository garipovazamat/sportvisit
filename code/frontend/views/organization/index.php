<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.02.16
 * Time: 15:03
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel \frontend\models\SearchOrganization
 */
use yii\grid\GridView;
use yii\grid\DataColumn;
use common\models\Image;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Sports;
use yii\widgets\Pjax;
?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    'options' => ['class' => 'event_form'],
]);?>
<div class="search_block">
    <?=$form->field($searchModel, 'sportId')
        ->dropDownList(Sports::getSportsList(), ['prompt' => 'Все виды'])?>
    <?=Html::submitButton('Найти', ['class' => 'eventmap'])?>
</div>
<?php ActiveForm::end()?>
<div class="org_index">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'filterPosition' => GridView::FILTER_POS_HEADER,
    'summary' => "<div class='summary'>Показанны {begin} - {end} организаций из {totalCount}, страница {page}</div>",
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
                /* @var \common\models\Organization $data */
                $first_image_url = $data->getFirstImageUrl();
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
                return $this->render('_org_element', ['model' => $data]);
            }
        ],
    ],
]);?>
</div>
