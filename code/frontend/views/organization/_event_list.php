<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.02.16
 * Time: 12:22
 * @var $model \common\models\Organization
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel \frontend\models\SearchEvent
 */
use yii\grid\GridView;
use yii\grid\DataColumn;
use common\models\Image;
use yii\helpers\Html;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'filterPosition' => GridView::FILTER_POS_FOOTER,
    'layout'=>"{items}\n{pager}",
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
                return $this->render('/event/_event_element', ['model' => $data]);
            }
        ],
    ],
]);?>
