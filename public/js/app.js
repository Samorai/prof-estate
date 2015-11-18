(function () {
    'use strict';
    window.appName = 'prof-estate';
    $(document).ready(function () {
        $("#form_order").submit(function (event) {
            event.preventDefault();
            $.post('/order', {
                website_name: $("#website_name").val(),
                user_name: $("#user_name").val(),
                contact_info: $("#contact_info").val(),
                _token: $("#_token").val()
            }, function(){alert('Success');});
        });
        var pull = $('#pull'),
            menu = $('nav ul');

        $(pull).on('click', function(e) {
            e.preventDefault();
            menu.slideToggle();
            $(".menu-icons").toggleClass('active', '');
            $(".main").toggleClass('menu-active', '');
        });

        $(window).resize(function(){
            var w = $(window).width();
            if(w > 320 && menu.is(':hidden')) {
                menu.removeAttr('style');
                $(".main").toggleClass('menu-active', '');
            }
        });
    });
})();

function makeGraph() {
    $.getJSON('/result', function (answer) {
        console.log(answer);
        $('#container').highcharts({
            title: {
                text: answer.data.name,
                align: 'left'
            },
            xAxis: {
                tickWidth: 0, gridLineWidth: 1, labels: {align: 'left'},
                categories: answer.data.dates
            },
            yAxis: {title: {text: 'Visits'}, plotLines: [{value: 0, width: 1, color: '#808080'}]},
            legend: {
                align: 'left',
                verticalAlign: 'top',
                y: 10,
                floating: true,
                borderWidth: 0
            },

            tooltip: {
                shared: true,
                crosshairs: true
            },
            series: answer.data.series
        });
    });
}


