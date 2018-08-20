<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.02.16
 * Time: 20:40
 * @var $model \common\models\Event
 */
use yii\helpers\Url;

?>
<div class="even_list_name">
    <?=$model->news->name ?>
</div>
<div class="event_desc">
    <?=$model->news->getShortText(300)?>
    <a href="<?=Url::to(['event/view', 'id' => $model->id])?>"> Подробнее</a>
</div>
<div class="event_date">
    <?=$model->getStartDate() . ' - ' . $model->getEndDate()?>
</div>