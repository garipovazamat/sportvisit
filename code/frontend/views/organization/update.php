<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29.02.16
 * Time: 15:32
 * @var $this \yii\web\View
 * @var $model \common\models\Organization
 */
use yii\helpers\Html;

$this->title = 'Редактирование организации "' . $model->name . '"';
?>
    <div class="header">
        <?=Html::encode($this->title) ?>
    </div>

<?php
echo $this->render('_form', ['model' => $model, 'sport' => $sport]);