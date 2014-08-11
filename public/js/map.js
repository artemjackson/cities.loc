$(document).ready(function () {

        $('#map_canvas').gmap().bind('init', function (ev, map) {
            $('#map_canvas').gmap('addMarker', {'position': '53.07, 25.59', 'bounds': true}).click(function () {
                $('#map_canvas').gmap('openInfoWindow', {'content': 'Hello World!'}, this);
            });
        });
    }
);