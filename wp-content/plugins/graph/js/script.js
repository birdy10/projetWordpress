/**
 * Au chargement de la page, affiche le graph
 */
jQuery(window).load(function() {

    var options = {
        chart: {
            renderTo: 'container',
            type: 'bar',
            backgroundColor: 'transparent'
        },
        title: {
            text: 'Technologies émergentes'
        },
        xAxis: {
            categories: [],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,

            title: {
                text: 'Nombre de votes',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        series: [{
            name: 'votes',
            data: []
        }]
    };
    //console.log(options.series);
    jQuery.ajax({
        url: 'http://127.0.0.1/projetWordpress/wp-content/plugins/graph/dataJson.php',
        success: function(data) {
            data = JSON.parse(data);
            options.xAxis.categories = data.titles;
            options.series[0].data = data.votes;
            var chart = new Highcharts.Chart(options);
        },
        error: function(error) {
            console.log(error);
        },
        cache: false
    });
});