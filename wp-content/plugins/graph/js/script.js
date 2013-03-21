/**
 * Request data from the server, add it to the graph and set a timeout to request again
 */
function requestData()
{
    $.ajax({
        url: '../datajson.php',
        success: function(point) {
            var series = chart.series[1],
                shift = series.data.length > 20; // shift if the series is longer than 20
            // add the point
            chart.series[1].addPoint(point, true, shift);
        },
        cache: false
    });
}

/**
 * Au chargement de la page, affiche le graph
 */
$(window).load(function() {
    chart = new Highcharts.Chart({
        chart: {
            renderTo: 'container',
            type: 'bar',
            events: {
                load: requestData
            }
        },
        title: {
            text: 'Live votes data'
        },
        xAxis: {
            categories: ['Africa', 'America', 'Asia', 'Europe', 'Oceania'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Votes',
            }
        },
        series: [{
            name: 'Data',
            data: []
        }]
    });
});