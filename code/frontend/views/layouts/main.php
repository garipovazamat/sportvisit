<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use common\models\City;
use common\models\Organization;

if(Yii::$app->session->has(City::SESSION_KEY))
    $city = City::findOne(['id' => City::getSessionCityId()]);
else $city = new City();

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'SportVisit.ru',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        //['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'Поиск секций', 'url' => ['/event/section']],
        ['label' => 'Поиск мероприятий', 'url' => ['/event/index']],
        ['label' => 'Организации', 'url' => ['/organization/index']],
        //['label' => 'Контакты', 'url' => ['/site/contact']],
        ['label' => (!City::hasSessionCity()) ? 'Выбрать город' : 'Город: '.$city->name,
            'url' => ['#'], 'linkOptions' => [
                'data-toggle' => 'modal',
                'data-target' => '#citychoose',
                'id' => 'choose_city_link'
        ]],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {
        $myProfileItem = [
            'label' => 'Мой профиль',
            'items' => [
                ['label' => 'Моя страница', 'url' => ['/user/index'],],
            ],
        ];
        $myOrg = Yii::$app->user->identity->getMyOrg();
        if($myOrg) {
            $myProfileItem['items'][] = [
                'label' => 'Моя организация (' . $myOrg->name . ')',
                'url' => ['/organization/view', 'id' => $myOrg->url_address]
            ];
        } else{
            $myProfileItem['items'][] = [
                'label' => 'Создать организацию',
                'url' => ['/organization/create']
            ];
        }
        $menuItems[] = $myProfileItem;
        $menuItems[] = [
            'label' => 'Выйти (' . Yii::$app->user->identity->name . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    if(Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index'){
        echo $this->render('header');
    } ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            <?=Html::a('Создать организацию', Organization::getCreateUrl())?>
        </p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php
Modal::begin([
    'header' => 'Выбор города',
    'options' => [
    'id' => 'citychoose',
]]);
Url::remember();
$form = ActiveForm::begin([
    'action' => Url::to(['/site/choosecity']),
    'method' => 'post'
]);?>
<div class="sity_choose">
    <?=$form->field($city, 'id')->dropDownList(City::getCityList(), ['prompt' => 'Все города']); ?>
</div>
<!--<div class="attention">
    Внимание: время на сайте будет установлено, согласно часовому поясу города.
</div>!-->
<?=Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end();
Modal::end();
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>