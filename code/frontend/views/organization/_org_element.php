<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.02.16
 * Time: 18:04
 * @var $model \common\models\Organization
 */
use yii\helpers\Html;
?>
<div class="even_list_name">
    <?=Html::a($model->name, ['organization/view', 'id' => $model->url_address]) ?>
</div>
<div class="event_desc">
    <?=$model->getShortText(300) ?> ...
    <?=Html::a('Подробнее', ['organization/view', 'id' => $model->url_address]) ?>
</div>
