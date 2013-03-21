<?php
/*
Plugin Name: Graph
Description: Gère le graphe et les votes des techologies du blog
Author: Romain Ardiet & Franck Gorin
Version: 1.0
*/
include_once('class/Highcharts.class.php');
/**
 * Ici gestion du graph
 */


$_oTest = new Highcharts();

$_sGraph = $_oTest->buildChartHtml();
echo $_sGraph;

//add_shortcode( 'graphic', 'gett_All' );