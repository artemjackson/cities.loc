$(document).ready(function () {

    $('#cities').on('click', '.cityDeletion',function () {
        var value = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/ajax/cityDelete',
            data: {city: value}
        });
        $('.modal').modal('hide');
        location.reload();
    });

    $('#regions').on('click', '.regionDeletion', function () {
        var value = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/ajax/regionDelete',
            data: {city: value}
        });
        $('.modal').modal('hide');
        location.reload();
    });
});