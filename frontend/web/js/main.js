

$(function () {
    function myAjax(url, data) {
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function (res) {
                console.log(res);
            }
        });
    }

    $('#reportModalButton').click(function () {
        $('#modal').modal('show')
            .find('#reportModalContent')
            .load($('#reportModalButton').attr('value'));
    });

    $('#loginModalButton').click(function () {
        $('#login_modal').modal('show')
            .find('#loginModalContent')
            .load($('#loginModalButton').attr('value'));
    });


    var type = jQuery("#signupform-position").val();
    if (type == 'Worker') {
        $(".company_name").prop("disabled", false).hide();
        $(".full_name").prop("disabled", false).hide();
    } else{
        $(".company_name").prop("disabled", true).hide();
        $(".full_name").prop("disabled", false).hide();
    }
    $('#signupform-position').on('change', function () {
        if (this.value=='Worker') {
            $(".company_name").prop("disabled", false).hide();
            $(".full_name").prop("disabled", true).show();
        }
        if(this.value=='Customer') {
            $(".company_name").prop("disabled", true).show();
            $(".full_name").prop("disabled", false).hide();
        }
        if(this.value=='') {
            $(".company_name").prop("disabled", true).hide();
            $(".full_name").prop("disabled", false).hide();
        }
    });
});