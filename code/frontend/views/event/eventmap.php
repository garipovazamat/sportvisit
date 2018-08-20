<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14.03.16
 * Time: 15:11
 * @var $events \common\models\Event[]
 */
use common\models\Event;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Sports;

$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyBsS9NHmGrE7xBQVCUveDBpihrHen3YWpw&callback=initMap&libraries=places', [
    'position' => \yii\web\View::POS_END,
]);

 $form = ActiveForm::begin([
    'method' => 'get',
    'options' => ['class' => 'event_form'],
]);?>
<div class="search_block">
    <?=$form->field($searchModel, 'id_sport')
        ->dropDownList(Sports::getSportsList(), ['prompt' => 'Все виды'])?>
    <?=Html::submitButton('Найти', ['class' => 'eventmap'])?>
</div>
<?php ActiveForm::end()?>

<div id="map" style="height: 70vh;"></div>

<script>
    navigator.geolocation.getCurrentPosition(function(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: latitude, lng: longitude},
            zoom: 12
        });
        var markerImage = {
            url: '/images/marker.png',
            size: new google.maps.Size(40, 40),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 32)
        };
        var markerI = new google.maps.Marker({
            position: {lat: latitude, lng: longitude},
            map: map,
            icon: markerImage,
            title: 'Я'
        });

        var events = [];
        <?php
        foreach ($events as $one_event) {
        if(!empty($one_event->coords)){
        $coords = $one_event->getCoords();
        ?>
        events.push({
            latitude: <?=$coords[1]?>,
            longitude: <?=$coords[0]?>,
            name: '<?=$one_event->news->name?>',
            text: '<?='<b>' . $one_event->news->name . '</b><br>Дата начала: ' .
                $one_event->getStartDate() . '<br>' .
                Html::a('Страница мероприятия', $one_event->getViewUrl())?>'
        });
        <?php }}?>

        for(var i=0; i<events.length; i++){
            var event = events[i];
            var marker = new google.maps.Marker({
                position: {lat: event.latitude, lng: event.longitude},
                map: map,
                title: event.name
            });
            console.log(event.latitude);
            var infowindow = new google.maps.InfoWindow({
                content: event.text
            });
            marker.addListener('click', (function(infowindow, marker) {
                return function() {
                    infowindow.open(map, marker);
                };
            })(infowindow, marker));
        }

    });
</script>