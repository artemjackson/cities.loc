$(document).ready(function () {
    $('#regions').change(function () {
        var value = $(this).val();
        console.log(value);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'application/controllers/ajax.php',
            data: {id: value},
            success: function (response) {
                console.log(response);
                $('#cities').html(response.html);
            }
        });
    }).change();
});