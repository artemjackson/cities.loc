$(document).ready(function () {
    $('#citiesPagination').on('click', '.page', function () {
        //TODO var $this = $(this);
        var page = $(this).data('page');
        if (!$(this).parent().hasClass('active')) {
            $(this).updatePagination({page: page, type: 'cities'}).updateTable({table: 'cities', page: page});
        }
        return false;
    });

    $('#regionsPagination').on('click', '.page', function () {
        //TODO var $this = $(this);
        var page = $(this).data('page');
        if (!$(this).parent().hasClass('active')) {
            $(this).updatePagination({page: page, type: 'regions'}).updateTable({table: 'regions', page: page});
        }
        return false;
    });

    $('#cities').on('click', '#up',function () {
        var page = $('#citiesPagination .active a').data('page');
        var column = $(this).parent().data('type');

        $(this).updateTable({table: 'cities', column: column, page: page, order: 'ASC'});
        return false;

    }).on('click', '#down', function () {
        var page = $('#citiesPagination .active a').data('page');
        var column = $(this).parent().data('type');

        $(this).updateTable({table: 'cities', column: column, page: page, order: 'DESC'});
        return false;
    }).on('click','a', function(){
       $('.sort a').css('color','#cccccc;');
        $(this).css('color', '#31b0d5')
    });

    $('#searchButton').on('click', function () {
        var value = $('#srch-term').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/ajax/findAnyMatches/',
            data: {needle: value},
            beforeSend: function () {
                $('.dark').fadeIn(100);
            },
            success: function (response) {
                setTimeout(function () {
                    console.log(response);
                    $('#citiesTable').empty().html(response.html);
                    $('.dark').fadeOut(100);
                }, 100);
                $('#citiesPagination').css('display','none');
                $('.sort').css('display','none');

            }
        });
    });

});

(function ($) {
    var options;
    $.fn.updatePagination = function (params) {
        options = $.extend({}, options, params);
        var type = options.type;
        var page = options.page;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/ajax/updatePagination', //TODO it must be set from options
            data: {
                activePage: page,
                type: type
            },
            success: function (response) {
                $("#" + type + "Pagination").html(response.html);
                window.history.replaceState("", "", "/admin/" + type + "/page/" + page); //TODO it must be set from options
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
        var page = options.page;
        var column = options.column ? options.column : 'city_name';
        var order = options.order ? options.order : 'ASC';

        var url = "/ajax/load" + table; //TODO it must be set from options

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: url,
            data: {activePage: page, column: column, order: order},
            beforeSend: function () {
                $('.dark').fadeIn(100);
            },
            success: function (response) {
                setTimeout(function () {
                    console.log(response);
                    $('#' + table + 'Table').empty().html(response.html);
                    $('.dark').fadeOut(100);
                }, 100);
            }
        });
        return this;
    };
})(jQuery);