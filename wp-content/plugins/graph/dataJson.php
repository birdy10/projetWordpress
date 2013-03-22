<?php
/**
 * Created by the fat IDE JetBrains PhpStorm.
 * User: Franck GORIN
 * Date: 21/03/13
 * Time: 15:46
 */

// Set the JSON header
header("Content-type: text/json");

include ("class/Data.class.php");

$_oData = new Data();
$_oAllPosts = $_oData->getAllPosts();

$_aJson;
foreach($_oAllPosts as $_aPost)
{
    $_iVote = $_oData->getVotesByPostId($_aPost->ID);

    if(isset($_iVote)) {
        $_iVote = $_iVote;
    } else {
        $_iVote = 0;
    }
    // Create a PHP array and echo it as JSON
    $_aJson['titles'][] = $_aPost->post_title;
    $_aJson['votes'][] = (int)$_iVote;
}

echo json_encode($_aJson);

?>