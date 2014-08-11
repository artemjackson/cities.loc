$(document).ready(function () {
    $("#geocomplete").geocomplete({
        map: "#map_canvas",
        markerOptions: {
            draggable: true
        },
        details: 'form',
        detailsAttribute: 'data-geo'
    }).bind("geocode:dragged",function (event, latLng) {
        $("input[data-geo=lat]").val(latLng.lat());
        $("input[data-geo=lng]").val(latLng.lng());
    }).geocomplete('find', $("input[data-geo=lat]").val() + "," + $("input[data-geo=lng]").val());
});