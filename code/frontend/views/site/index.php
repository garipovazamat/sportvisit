<?php

/**
 * @var $this yii\web\View
 * @var $events \common\models\Event[]
 * @var $orgs \common\models\Organization[]
 * @var $sections \common\models\Event[]
 */
use yii\helpers\Html;
use common\models\Image;
use yii\helpers\Url;
use common\models\Event;
use common\models\Organization;


$this->title = 'SportVisit - найди мероприятие или секцию';
?>
<div class="site-index">



    <div class="section_head">
        <a href="<?=Event::getIndexUrl()?>">Ближайшие мероприятия</a>
    </div>
    <div class="section_content">
        <table class="table table-striped table-hover">
            <?php
            foreach ($events as $event) {
                $first_image_url = $event->news->getFirstImageUrl();
                $thumb_url = Image::getThumbnail($first_image_url);
                ?>
                <tr>
                    <td class="thumb_column">
                        <?=Html::img($thumb_url, ['class' => 'event_thumb']);?>
                    </td>
                    <td>
                        <?=$this->render('/event/_event_element', ['model' => $event])?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="section_head">
        <a href="<?=Event::getSectionsUrl()?>">Ближайшие наборы в секцию</a>
    </div>
    <div class="section_content">
        <table class="table table-striped table-hover">
            <?php
            foreach ($sections as $section) {
                $first_image_url = $section->news->getFirstImageUrl();
                $thumb_url = Image::getThumbnail($first_image_url);
                ?>
                <tr>
                    <td class="thumb_column">
                        <?=Html::img($thumb_url, ['class' => 'event_thumb']);?>
                    </td>
                    <td>
                        <?=$this->render('/event/_event_element', ['model' => $section])?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="section_head">
        <a href="<?=Organization::getIndexUrl()?>">Популярные организации:</a>
    </div>
    <div class="section_content">
        <table class="table table-striped table-hover">
            <?php
            foreach ($orgs as $org) {
                $first_image_url = $org->getFirstImageUrl();
                $thumb_url = Image::getThumbnail($first_image_url);
                ?>
                <tr>
                    <td class="thumb_column">
                        <?=Html::img($thumb_url, ['class' => 'event_thumb']);?>
                    </td>
                    <td>
                        <?=$this->render('/organization/_org_element', ['model' => $org])?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</div>
