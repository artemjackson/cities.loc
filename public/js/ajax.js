$(document).ready(function () {
    $('#regions').change(function () {
        var value = $(this).val();
        console.log(value); //TODO delete console log
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/ajax/updateCities',
            data: {id: value},
            success: function (response) {
                console.log(response);
                $('#cities').html(response.html);
            }
        });
    }).change();
});