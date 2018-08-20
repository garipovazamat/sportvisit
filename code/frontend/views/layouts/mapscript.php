<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.03.16
 * Time: 14:54
 * @var $coords string
 * @var $this \yii\web\View
 */
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyBsS9NHmGrE7xBQVCUveDBpihrHen3YWpw&callback=initMap&libraries=places', [
    'position' => \yii\web\View::POS_END,
]);
?>
<script>

    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            <?php $coords = explode(',', $coords);?>
            center: {lat: <?=$coords[1]?>, lng: <?=$coords[0]?>},
            zoom: 12
        });
        var marker = new google.maps.Marker({
            position: {lat: <?=$coords[1]?>, lng: <?=$coords[0]?>},
            map: map
        });
        marker.setMap(map);
    }
</script>