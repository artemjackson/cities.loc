$(document).ready(function () {
    $('#map_canvas').gmap().bind('init', function (ev, map) {
        $(this).gmap({'zoom':10});
    });
});