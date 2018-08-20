<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.02.16
 * Time: 11:48
 * @var $this \yii\web\View
 * @var $model \common\models\Organization
 * @var $sport \common\models\Sports
 */
use yii\helpers\Html;

$this->title = 'Создание организации';
?>
    <div class="header">
        <?=Html::encode($this->title) ?>
    </div>

<?php
echo $this->render('_form', ['model' => $model, 'sport' => $sport]);
?>