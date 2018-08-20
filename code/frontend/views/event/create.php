<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.02.16
 * Time: 23:16
 * @var $this yii\web\View
 * @var $model common\models\EventForm
 */
use yii\helpers\Html;

$this->title = (!$model->isSection) ?
    'Создание мероприятия' :
    'Создание набора в секцию';
?>
<div class="header">
    <?=Html::encode($this->title) ?>
</div>

<?php
echo $this->render('_form', ['model' => $model]);
?>