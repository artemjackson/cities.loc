$(document).ready(function () {
    $('.regionDelete').click(function () {
        var val = $(this).val();
        $('.deleteDialog').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                "Yes": function () {
                    var value = val;
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/regionDelete',
                        data: {region: value}
                    });
                    $(this).dialog('close');
                    location.reload();
                },
                "No": function () {
                    $(this).dialog("close");
                }
            }
        }).dialog('open');
    });

    $('.cityDelete').click(function () {
        var val = $(this).val();
        $('.deleteDialog').dialog({
            autoOpen: false,
            modal: true,
            buttons: {
                "Yes": function () {
                    var value = val;
                    $.ajax({
                        type: 'POST',
                        url: '/ajax/cityDelete',
                        data: {city: value}
                    });
                    $(this).dialog('close');
                    location.reload();
                },
                "No": function () {
                    $(this).dialog("close");
                }
            }
        }).dialog('open');
    });
});