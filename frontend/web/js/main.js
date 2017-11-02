// $(document).ready(function () {
//     alert('allll');
//     // function myAjax(url, data) {
//     //     $.ajax({
//     //         url: url,
//     //         type: 'post',
//     //         data: data,
//     //         success: function (res) {
//     //             console.log(res);
//     //         }
//     //     });
//     // }
//     // $(document).delegate(".adding_new_project", "click", function () {
//     //  alert('heeeeeeeeeeeeeeyyyyyyyy');
//     // });
//
// });

$(function () {
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
        $(".customer_inputs").prop("disabled", false).hide();
        $(".worker_inputs").prop("disabled", false).show();
    } else {
        $(".customer_inputs").prop("disabled", true).show();
        $(".worker_inputs").prop("disabled", false).hide();
    }
    $('#signupform-position').on('change', function () {
        if (this.value=='Worker') {
            $(".customer_inputs").prop("disabled", false).hide();
            $(".worker_inputs").prop("disabled", true).show();
        } else {
            $(".customer_inputs").prop("disabled", true).show();
            $(".worker_inputs").prop("disabled", false).hide();
        }
    });
});