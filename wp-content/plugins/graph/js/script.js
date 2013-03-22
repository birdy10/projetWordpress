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
        navigation: {
            buttonOptions: {
                enabled: false
            }
        },
        xAxis: {
            categories: [],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            type: 'int',
            title: {
                text: 'Nombre de votes',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        series: [{
            showInLegend: false,
            name: 'votes reçus',
            data: [],
            color: '#7c5a50'
        }],
        credits: {
            enabled: false
        }
    };

    // Fonction ajax pour récuperer les données des posts
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