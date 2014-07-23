$(document).ready(function () {
    $('#regions').change(function () {
        var value = $(this).val();
        console.log(value);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '/ajax/cities',
            data: {id: value},
            success: function (response) {
                console.log(response);
                $('#cities').html(response.html);
            }
        });
    }).change();

    $('#wowButon').click(function () {
        alert("Воу-воу, полегче!");
    });

});