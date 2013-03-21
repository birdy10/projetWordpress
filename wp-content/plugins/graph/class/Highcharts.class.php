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
        add_action( 'wp_print_scripts', 'loadJS' );
    }

    /**
     * Fonction qui load les librairies javascript jquery et raphael
    */
    public function loadJS()
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'highlight', plugins_url( '/js/highlight.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'export', plugins_url( '/js/exporting.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'script', plugins_url( '/js/script.js', __FILE__ ), array( 'jquery' ) );
    }


    /**
     * Fonction qui construit le html de la page
     */
    public function buildChartHtml()
    {
        $_sHtml = "<div id='container' style='min-width: 400px; height: 400px; margin: 0 auto'></div>";
        return $_sHtml;
    }

    /**
     * Fonction qui donne les données pour le js (name du post et nombre de ses votes)
     */
    public function renderDataForJS()
    {

    }


}

