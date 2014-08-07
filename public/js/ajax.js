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
                $('#cities.selectpicker').selectpicker("refresh");
            }
        });
    }).change();

    $('.page').click(function () {
        var id = $(this).attr('id');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/ajax/loadCities',
            data: {page: id},
            beforeSend:function(){
                $('.dark').fadeIn(100);
            },
            success: function (response) {
                setTimeout(function () {
                    console.log(response);
                    $('#cities').html(response.html);
                    $('.dark').fadeOut(100);
                }, 200);
            }
        });
        $('.active').removeClass('active');
        $('.page#' + id).parent().addClass('active');
    });

    $('.page#1').click();

    $('.cityDeletion').click(function () {
        alert("clicked!");
        var value = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/ajax/cityDelete',
            data: {city: value}
        });
        $(this).dialog('close');
        location.reload();
    });
});