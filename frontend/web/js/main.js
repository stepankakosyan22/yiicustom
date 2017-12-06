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

    $(document).delegate(".check_in", "click", function () {
        var d = new Date();
        var hour=d.getHours();
        if (hour<10){
            hour='0'.concat(hour);
        }
        var minute=d.getMinutes();
        if (minute<10){
            minute='0'.concat(minute);
        }
        var check_in= hour + ":" + minute;
        var check_in_data = {check_in: check_in, _csrf: yii.getCsrfToken()};
        myAjax('/checkin/create', check_in_data);
    });
    $(document).delegate(".lunch_check_out", "click", function () {
        var d = new Date();
        var hour=d.getHours();
        if (hour<10){
            hour='0'.concat(hour);
        }
        var minute=d.getMinutes();
        if (minute<10){
            minute='0'.concat(minute);
        }
        var lunch_check_out= hour + ":" + minute;
        var id=$(this).parent('td').parent('tr').attr('data-id');
        var lunch_check_out_data = {lunch_check_out: lunch_check_out, id:id, _csrf: yii.getCsrfToken()};
        myAjax('/checkin/lunchcheckout', lunch_check_out_data);
    });

    $(document).delegate(".lunch_check_in", "click", function () {
        var d = new Date();
        var hour=d.getHours();
        if (hour<10){
            hour='0'.concat(hour);
        }
        var minute=d.getMinutes();
        if (minute<10){
            minute='0'.concat(minute);
        }
        var lunch_check_in= hour + ":" + minute;
        var id=$(this).parent('td').parent('tr').attr('data-id');
        var lunch_check_in_data = {lunch_check_in: lunch_check_in, id:id, _csrf: yii.getCsrfToken()};
        myAjax('/checkin/lunchcheckin', lunch_check_in_data);
    });

    $(document).delegate(".check_out", "click", function () {
        var d = new Date();
        var hour=d.getHours();
        if (hour<10){
            hour='0'.concat(hour);
        }
        var minute=d.getMinutes();
        if (minute<10){
            minute='0'.concat(minute);
        }
        var id=$(this).parent('td').parent('tr').attr('data-id');
        var check_out= hour + ":" + minute;
        var check_out_data = {check_out: check_out, id:id, _csrf: yii.getCsrfToken()};
        myAjax('/checkin/checkout', check_out_data);
    });
    $(document).delegate(".send_comment", "click", function () {
        var id=$(this).parent('div').parent('td').parent('tr').attr('data-id');
        var comment= $('.comment_input'+id).val();
        var comment_data = {comment:comment, id:id, _csrf: yii.getCsrfToken()};
        myAjax('/checkin/comment', comment_data);
    });
    $( function() {
        $( "#dob" ).datepicker({
            changeMonth: true,
            dateFormat: 'yy-mm-dd'
        });
    });
});