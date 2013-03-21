<?php
/*
Plugin Name: Graph
Description: Gère le graphe et les votes des techologies du blog
Author: Romain Ardiet & Franck Gorin
Version: 1.0
*/

include_once("class/Data.class.php");

/**
 * Ici gestion du graph
 */

$_oData = new Data();
$_oAllPosts = $_oData->getAllPosts();

foreach($_oAllPosts as $_aPost){
    //var_dump($_aPost->ID);
    $_aThisVote = $_oData->getVotesByPostId($_aPost->ID);
    $_aAllVotes[$_aPost->ID] = $_aThisVote;
}






//add_shortcode( 'graphic', 'gett_All' );