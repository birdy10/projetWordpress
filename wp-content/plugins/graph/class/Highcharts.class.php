<?php
/**
 * Created by romain ardiet
 * Date: 21/03/13
 * Time: 14:09
 */

// Gestion du plugin js highcharts ici
class Highcharts
{
    /**
     * constructeur
    */
    public function __construct()
    {
        // fonction de load js
        add_action( 'wp_print_scripts', array( $this, 'loadJS' ) );
    }

    /**
     * Fonction qui load les librairies javascript jquery et raphael
    */
    public function loadJS()
    {
        wp_enqueue_script( 'highlight', 'http://code.highcharts.com/highcharts.js', array() );
        wp_enqueue_script( 'export', 'http://code.highcharts.com/modules/exporting.js', array() );
        echo "<script type='text/javascript' src='http://127.0.0.1/projetWordpress/wp-includes/js/jquery/jquery.js?ver=1.8.3'></script>";
        echo "<script type='text/javascript' src='http://127.0.0.1/projetWordpress/wp-content/plugins/graph/js/script.js'></script>";
    }

}

