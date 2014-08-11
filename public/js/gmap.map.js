$(document).ready(function () {
    $('.selectpicker#regions').on('change',function () {
        var value = $(this).val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/ajax/updateCities',
            data: {id: value},

            success: function (response) {
                console.log(response);
                $('#cities').html(response.html);
                $('.selectpicker#cities').selectpicker("refresh").change();
                $('.selectpicker#cities option').each(function () {
                    var lat = $(this).data('lat');
                    var lng = $(this).data('lng');
                    $('#map_canvas').gmap('addMarker', {'position': lat + ',' + lng, 'bounds': false});
                });
            }
        });

        $('#map_canvas').gmap('clear', 'markers');
    }).change();

    $('.selectpicker#cities').on('change', function () {
        var selected = $(this).find(":selected");

        var latLng = new google.maps.LatLng(selected.data('lat'), selected.data('lng'));
        $('#map_canvas').gmap('option', 'center', latLng);
        $('#map_canvas').gmap('option', 'zoom', 10);
        $('#map_canvas').gmap('addMarker', {position: latLng, bounds: false});
    });
});