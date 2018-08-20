<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.03.16
 * Time: 15:47
 * @var $this \yii\web\View
 * @var $model \common\models\User
 * @var $photo \common\models\Image
 */
$this->title = 'Изменение профиля';
echo '<div class="header">'.$this->title.'</div>';
echo $this->render('_form', ['model' => $model, 'photo' => $photo]);