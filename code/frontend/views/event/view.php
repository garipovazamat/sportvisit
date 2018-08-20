<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.03.16
 * Time: 13:12
 * @var $model \common\models\Event
 * @var $this \yii\web\View
 */
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Event;
use yii\bootstrap\Modal;
use common\models\Request;

$this->registerCssFile('/social-likes/social-likes_flat.css');
$this->registerJsFile('/social-likes/social-likes.min.js', ['depends' => [yii\web\JqueryAsset::className()]]);

$this->title = $model->news->name;
?>

    <div class="event_view">
        <div class="header">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <?php if ($model->isAutor()) { ?>
            <div class="org_owner_block">
                <a href="<?= $model->getUpdateUrl() ?>">
                    <span class="glyphicon glyphicon-edit"></span> Изменить
                </a>
                <?php if ($model->isInsideDate() && $model->isSection()) { ?>
                <a href="<?= Url::to(['event/endsection', 'id' => $model->id]) ?>">
                    <span class="glyphicon glyphicon-remove-circle"></span> Завершить набор
                </a>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="org_phone">
            Организация: <?= Html::a($model->org->name, [
                'organization/view', 'id' => $model->org->url_address
            ]) ?>
        </div>
        <div class="org_phone">
            Дата начала
            <?= ($model->type == Event::TYPE_SECTION) ? 'набора в секцию' : '' ?>:
            <?= $model->getStartDate() ?>
        </div>
        <?php if ($model->isInsideDate()) { ?>
        <div class="request">
                <div class="request_btn">
                    <?php
                    if (!$model->isHaveRequest()) {
                        echo Html::a('Оставить заявку',
                            ['event/sendrequest', 'id_event' => $model->id],
                            ['class' => 'btn btn-primary']);
                        echo Html::a('Оставить заявку на запись ребенка',
                            '#child_request',
                            [
                                'class' => 'btn btn-info',
                                'data-toggle' => 'modal'
                            ]);
                    } else echo Html::a('Заявка отправлена', null,
                        ['class' => 'btn btn-danger']);
                    ?>
                </div>
            <?php
            $requestCount = $model->getRequestCount();
            if ($requestCount != 0) {
                ?>
                <div class="request_text">
                    Оставлено заявок: <?= $model->getRequestCount() ?>
                </div>
            <?php } ?>
        </div>
        <? } ?>


        <div class="org_desc">
            <?= $model->news->text ?>
        </div>

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
        <?php if ($model->isHaveCoords()) { ?>
            <div class="org_phone">
                Место проведения:
            </div>
            <div id="map" style="height: 70vh;"></div>
        <?php } ?>
    </div>


    <!-- Скрипт карты с маркером -->
<?php if ($model->isHaveCoords()) {
    echo $this->render('/layouts/mapscript', ['coords' => $model->coords]);
} ?>

<?php
$childForm = new Request();
Modal::begin([
    'header' => 'Заявка на запись ребенка',
    'options' => [
        'id' => 'child_request',
    ]
]);
echo $this->render('child_request_form', ['model' => $childForm, 'id' => $model->id]);
Modal::end();
?>