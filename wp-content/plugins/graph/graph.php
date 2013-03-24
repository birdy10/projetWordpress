<?php
/*
Plugin Name: Graph
Description: Gère le graphe et les votes des techologies du blog
Author: Romain Ardiet & Franck Gorin
Version: 1.0
*/
include_once('class/Data.class.php');
include_once('class/Highcharts.class.php');
include_once('class/ManageVotes.class.php');

/**
 * Ici gestion du graph
 */

$_oData = new Data();
$_aJson = $_oData->createDataForJson();
$_oData->createFileJson($_aJson);

$_oTest = new Highcharts();



function display_all()
{
    $_oManageVotes = new ManageVotes();
    $_sHTML = $_oManageVotes->createHTMLToVote();
    echo $_sHTML;
}
//echo $_sGraph;

add_shortcode( 'list', 'display_all' );