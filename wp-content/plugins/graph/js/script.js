// Request data from the server, add it to the graph and set a timeout to request again
function requestData()
{
    jQuery.ajax({
        url: 'http://127.0.0.1/projetWordpress/wp-content/plugins/graph/dataJson.php',
        success: function(point) {
            var series = chart.series[0],
                shift = series.data.length; // shift if the series is longer than 20
            // add the point
            console.log(point);
            series.addPoint(point, true, shift);
        },
        error: function(error) {
            console.log(error);
        },
        cache: false
    });
}

/**
 * Au chargement de la page, affiche le graph
 */
jQuery(window).load(function() {

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
            categories: ['Votes'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Votes'
            }
        },
        series: [{
            name: 'Random data',
            data: [50, 100, 58]
        }]
    });
});