$(document).ready(function() {
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });

    $.getJSON("API/yiban/getAuthState.php", function(data) {
        if(data.result != 0) {
            location.href='http://f.yiban.cn/iapp86859'
        }
    });
});