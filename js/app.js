$(document).ready(function() {
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });

    //check authencation
    $.getJSON("API/yiban/getAuthState.php", function(data) {
        if(data.result != 0) {
            location.href='http://f.yiban.cn/iapp86859'
        }
    });

    $('#make-appointment').click(function() {
        if(checkValidation() == 0) {
            $.post('API/post.php', {
                "name": $('#name').val(),
                "ID": $('#ID').val(),
                "class": $('#class').val(),
                "field": $('#field').val(),
                "grade": $('#grade').val(),
                "time": $('#time').val()
            }, function(data) {
                switch(data.result) {
                    case "Succeeded":
                        Materialize.toast('预约成功', 4000);
                        break;
                    case "Forbidden":
                        Materialize.toast('请从易班打开连接并授权', 4000);
                        break;
                    case "Appointed":
                        Materialize.toast('您已预约该时间段', 4000);
                        break;
                    case "Failed":
                        Materialize.toast('失败请重试', 4000);
                        break;
                    default:
                        Materialize.toast('请联系管理员', 4000);
                        break;
                }
            }, "json");
        }
    });
});

function checkValidation() {
    if($('#name').val() == '') {
        Materialize.toast('请填写姓名！', 4000);
        return -1;
    }
    if($('#ID').val() == '') {
        Materialize.toast('请填写学号！', 4000);
        return -1;
    }
    if($('#ID').hasClass('invalid')) {
        Materialize.toast('学号不正确！', 4000);
        return -1;
    }
    if($('#class').val() == '') {
        Materialize.toast('请填写班级！', 4000);
        return -1;
    }
    if($('#class').hasClass('invalid')) {
        Materialize.toast('班级不正确！', 4000);
        return -1;
    }
    if($('#grade').val() == '') {
        Materialize.toast('请填写年级！', 4000);
        return -1;
    }
    if($('#grade').hasClass('invalid')) {
        Materialize.toast('年级不正确！', 4000);
        return -1;
    }
    if($('#field').val() == '') {
        Materialize.toast('请填写专业！', 4000);
        return -1;
    }
    if($('#time').val() == '') {
        Materialize.toast('请填写预约日期！', 4000);
        return -1;
    }   
    return 0; 
}