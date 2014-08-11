$(document).ready(function () {

    (function ($) {
        var options;
        $.fn.updatePagination = function (params) {
            options = $.extend({}, options, params);
            var type = options.type;
            var id = options.id;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/ajax/updatePagination',
                data: {
                    activePage: id,
                    type: type
                },
                success: function (response) {
                    $("#" + type + "Pagination").html(response.html);
                    window.history.replaceState("", "", "/admin/" + type + "/page/" + id);
                }
            });
            return this;
        };
    })(jQuery);

    (function ($) {
        var options;
        $.fn.updateTable = function (params) {
            options = $.extend({}, options, params);
            var table = options.table;
            var id = options.id;
            var url = "/ajax/load" + table;
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: url,
                data: {activePage: id},
                beforeSend: function () {
                    $('.dark').fadeIn(100);
                },
                success: function (response) {
                    setTimeout(function () {
                        console.log(response);
                        $('#' + table).html(response.html);
                        $('.dark').fadeOut(100);
                    }, 100);
                }
            });
            return this;
        };
    })(jQuery);

    $('.selectpicker#regions').change(function () {
        var value = $(this).val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/ajax/updateCities',
            data: {id: value},

            success: function (response) {
                console.log(response);
                $('#cities').html(response.html);
                $('.selectpicker#cities').selectpicker("refresh");
            }
        });
    }).change();



    $('#citiesPagination').on('click', '.page', function () {
        var id = $(this).data('page');
        if (!$(this).parent().hasClass('active')) {
            $(this).updatePagination({id: id, type: 'cities'}).updateTable({table: 'cities', id: id});
        }
        return false;
    });

    $('#regionsPagination').on('click', '.page', function () {
        var id = $(this).data('page');
        if (!$(this).parent().hasClass('active')) {
            $(this).updatePagination({id: id, type: 'regions'}).updateTable({table: 'regions', id: id});
        }
        return false;
    });
});