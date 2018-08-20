<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.02.16
 * Time: 19:59
 * @var $this \yii\web\View
 * @var $model \common\models\Organization
 */
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\SearchEvent;
use yii\widgets\Pjax;

$this->registerCssFile('/social-likes/social-likes_flat.css');
$this->registerJsFile('/social-likes/social-likes.min.js', ['depends' => [yii\web\JqueryAsset::className()]]);

$this->title = $model->name;
?>
    <div class="org_view">
        <div class="header"><h2><?= Html::encode($this->title) ?></h2></div>
        <?php if ($model->isOwner()) { ?>
            <div class="org_owner_block">
                <a href="<?= Url::to(['organization/update', 'id' => $model->id]) ?>">
                    <span class="glyphicon glyphicon-edit"></span> Изменить
                </a>
                <a href="<?= Url::to(['event/create', 'id_org' => $model->id]) ?>">
                    <span class="glyphicon glyphicon-plus-sign"></span> Создать мероприятие
                </a>
                <a href="<?= Url::to(['event/create', 'isSection' => 1, 'id_org' => $model->id]) ?>">
                    <span class="glyphicon glyphicon-plus-sign"></span> Создать секцию
                </a>
            </div>
        <?php } ?>
        <?php if (!empty($model->phone)) { ?>
            <div class="org_phone">
                <span class="glyphicon glyphicon-earphone"></span> <?= $model->phone ?>
            </div>
            <?php
        }
        if (!empty($model->id_city)) { ?>
            <div class="org_phone">
                Город: <?= $model->city->name ?>
            </div>
        <?php }
        if (!empty($model->address)) { ?>
            <div class="org_phone">
                <span class="glyphicon glyphicon-home"></span> <?= $model->address ?>
            </div>
        <?php } ?>
        <div class="org_phone">
            <span class="glyphicon glyphicon-user"></span> Владелец страницы:
            <?= Html::a($model->user->getAllname(), $model->user->getUrlProfile()) ?>
        </div>
        <div class="org_desc">
            <?= $model->descript ?>
        </div>

        <?php if (!empty($model->coordinates)) { ?>
            <div class="org_phone">
                Место на карте:
            </div>
            <div id="map" style="height: 70vh;"></div>
        <?php } ?>

        <div class="social_block">
            <div class="soc_title">Поделитесь в социальных сетях:</div>
            <div class="social-likes">
                <div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div>
                <div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div>
                <div class="mailru" title="Поделиться ссылкой в Моём мире">Мой мир</div>
                <div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div>
                <div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div>
                <div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div>
            </div>
        </div>

        <?php
        $searchEvent = new SearchEvent();
        $searchEvent->id_org = $model->id;
        $dataProvider = $searchEvent->search();
        $dataProvider->pagination->setPageSize(5);
        if ($dataProvider->count > 0) {
        ?>
        <div class="org_event_head">Мероприятия этой организации</div>
        <div class="org_event">
            <?php
                Pjax::begin();
                echo $this->render('_event_list', [
                    'searchModel' => $searchEvent,
                    'dataProvider' => $dataProvider
                ]);
                Pjax::end();
            ?>
        </div>
        <?php }
        $searchSection = new SearchEvent();
        $searchSection->id_org = $model->id;
        $dataProvider = $searchSection->search(null, true, true);
        $dataProvider->pagination->setPageSize(5);
        if ($dataProvider->count > 0) {
        ?>
        <div class="org_event_head">Секции этой организации</div>
        <div class="org_event">
            <?php
                Pjax::begin();
                echo $this->render('_event_list', [
                    'searchModel' => $searchSection,
                    'dataProvider' => $dataProvider
                ]);
                Pjax::end();
            ?>
        </div>
        <?php } ?>
    </div>

<?php
if (!empty($model->coordinates))
    echo $this->render('/layouts/mapscript', ['coords' => $model->coordinates]);
?>