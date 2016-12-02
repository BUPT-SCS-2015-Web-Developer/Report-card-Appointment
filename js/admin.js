$(document).ready(function() {
    $('#login').click(function() {
        $.post('API/checkAdmin.php', {
                "ID": $('#ID').val(),
                "pwd": $('#pwd').val()
            }, function(data) {
                if(data.result == "Succeeded") {
                    showData();
                } else {
                    Materialize.toast('失败请重试', 4000);
                }
            }, "json");
    });
});

function showData() {
    $('#login-card').hide();
    $('#data-field').show();
    $('ul.tabs').tabs();
    $.getJSON('API/list.php', function(data) {
        if(data.result == "Succeeded") {
            $('#today p span').text(data.todayTotal);
            $('#future p span').text(data.futureTotal);
            $('#history p span').text(data.historyTotal);
            for(index in data.todayData) {
                $('#today table tbody').append('<tr>'
                    + '<td>' + data.todayData[index].name + '</td>'
                    + '<td>' + data.todayData[index].ID + '</td>'
                    + '<td>' + data.todayData[index].class + '</td>'
                    + '<td>' + data.todayData[index].field + '</td>'
                    + '<td>' + data.todayData[index].grade + '</td>'
                    + '<td>' + data.todayData[index].time + '</td>'
                    + '</tr>'
                );
            }
            for(index in data.futureData) {
                $('#future table tbody').append('<tr>'
                    + '<td>' + data.futureData[index].name + '</td>'
                    + '<td>' + data.futureData[index].ID + '</td>'
                    + '<td>' + data.futureData[index].class + '</td>'
                    + '<td>' + data.futureData[index].field + '</td>'
                    + '<td>' + data.futureData[index].grade + '</td>'
                    + '<td>' + data.futureData[index].time + '</td>'
                    + '</tr>'
                );
            }
            for(index in data.historyData) {
                $('#history table tbody').append('<tr>'
                    + '<td>' + data.historyData[index].name + '</td>'
                    + '<td>' + data.historyData[index].ID + '</td>'
                    + '<td>' + data.historyData[index].class + '</td>'
                    + '<td>' + data.historyData[index].field + '</td>'
                    + '<td>' + data.historyData[index].grade + '</td>'
                    + '<td>' + data.historyData[index].time + '</td>'
                    + '</tr>'
                );
            }
        }
    })
}