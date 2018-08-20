<?php
/** @var $this yii\web\View
 * @var $model \common\models\User
 */
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

?>
<div class="profile_page">
    <div class="left_block">
        <!--<div class="avatar" style="background-image: url(<?= $model->getAvatarUrl() ?>)">
        </div>!-->
        <img class="avatar" src="<?= $model->getAvatarUrl() ?>" width=250px>
        <?php
        $items = [];
        if(!Yii::$app->user->isGuest) {
            $cUserId = Yii::$app->user->id;
            if($cUserId == $model->id)
                $items[] = ['label' => 'Изменить профиль', 'url' => ['/user/update']];
        }

        if (!$model->isHaveOrg())
            $items[] = ['label' => 'Создать организацию', 'url' => ['/organization/create']];
        echo Nav::widget([
            'items' => $items
            //'options' => ['class' => 'navbar-nav'],
        ]);
        ?>
    </div>
    <div class="right_block">
        <div class="name">
            <h2><?= $model->getAllname() ?></h2>
        </div>
        <?php if ($model->getSex()) { ?>
            <div class="profile_field">
                <b>Пол:</b> <?= $model->getSex() ?>
            </div>
        <?php } ?>
        <?php if ($model->date_born) { ?>
            <div class="profile_field">
                <b>Дата рождения:</b> <?= $model->getBornDate() ?>
            </div>
        <?php } ?>
        <?php if ($model->id_city) { ?>
            <div class="profile_field">
                <b>Город:</b> <?=$model->city->name ?>
            </div>
        <?php } ?>
        <div class="profile_field">
            <b>Электронная почта:</b> <?=$model->email ?>
        </div>
    </div>

</div>
</div>
