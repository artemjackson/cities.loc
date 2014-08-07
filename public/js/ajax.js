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

    $('#citiesPagination').on('click', '.page', function () {
        var id = $(this).data('page');
        if (!$(this).parent().hasClass('active')) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/updatePagination',
                data: {
                    activePage: id,
                    type: 'cities'
                },
                success: function (response) {
                    $('#citiesPagination').html(response.html);
                    window.history.replaceState("", "", "/admin/cities/page/" + id);
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/loadCities',
                data: {activePage: id},
                beforeSend: function () {
                    $('.dark').fadeIn(100);
                },
                success: function (response) {
                    setTimeout(function () {
                        console.log(response);
                        $('#cities').html(response.html);
                        $('.dark').fadeOut(100);
                    }, 100);
                }

            });
        }
        return false;
    });

    $('#regionsPagination').on('click', '.page', function () {
        var id = $(this).data('page');
        if (!$(this).parent().hasClass('active')) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/updatePagination',
                data: {
                    activePage: id,
                    type: 'regions'
                },
                success: function (response) {
                    $('#regionsPagination').html(response.html);
                    window.history.replaceState("", "", "/admin/regions/page/" + id);
                }
            });
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/loadRegions',
                data: {activePage: id},
                beforeSend: function () {
                    $('.dark').fadeIn(100);
                },
                success: function (response) {
                    setTimeout(function () {
                        console.log(response);
                        $('#regions').html(response.html);
                        $('.dark').fadeOut(100);
                    }, 100);
                }
            });
        }
        return false;
    });

    //$('.page').click();
});