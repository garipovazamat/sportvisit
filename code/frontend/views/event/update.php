<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.02.16
 * Time: 12:08
 * @var $this yii\web\View
 * @var $model common\models\EventForm
 */
use yii\helpers\Html;

$this->title = (!$model->isSection) ?
    'Изменение мероприятия "' . $model->name . '"' :
    'Изменение секции "' . $model->name . '"';
?>
    <div class="header">
        <?=Html::encode($this->title) ?>
    </div>

<?php
echo $this->render('_form', ['model' => $model]);
?>