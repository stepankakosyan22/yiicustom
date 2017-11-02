// $(document).ready(function () {
//     function myAjax(url, data) {
//         $.ajax({
//             url: url,
//             type: 'post',
//             data: data,
//             success: function (res) {
//                 console.log(res);
//             }
//         });
//     }
// });

$(function(){
    $('#reportModalButton').click(function () {
        $('#modalProjectUpdate').modal('show')
            .find('#ProjectUpdateModalContent')
            .load($('#ProjectUpdateModalButton').attr('value'));
    })



});


