<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 18.03.16
 * Time: 22:35
 * @var $model \common\models\Request;
 * @var $id integer
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$form = ActiveForm::begin([
    'action' => Url::to(['event/sendrequest', 'id_event' => $id])
]);
?>
<?=$form->field($model, 'name')?>
<?=$form->field($model, 'age')?>
<?=Html::submitButton('Отправить заявку')?>

<?php ActiveForm::end()?>
