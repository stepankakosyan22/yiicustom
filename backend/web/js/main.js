$(function(){
    $('#reportModalButton').click(function () {
        $('#modalProjectUpdate').modal('show')
            .find('#ProjectUpdateModalContent')
            .load($('#ProjectUpdateModalButton').attr('value'));
    });
    var type = jQuery("#user-position").val();
    if (type == 'Worker') {
        $(".company_name").prop("disabled", false).hide();
        $(".full_name").prop("disabled", false).hide();
    } else{
        $(".company_name").prop("disabled", true).hide();
        $(".full_name").prop("disabled", false).hide();
    }
    $('#user-position').on('change', function () {
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

$( function() {
    $( "#end_date" ).datepicker({
        changeMonth: true,
        dateFormat: 'yy-mm-dd'
    });

        $( "#start_date" ).datepicker({
        changeMonth: true,
        dateFormat: 'yy-mm-dd'
    });

});
