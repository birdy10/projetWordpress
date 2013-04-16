<?php
/**
 * Created by the fat IDE JetBrains PhpStorm.
 * User: Franck GORIN
 * Date: 21/03/13
 * Time: 15:46
 */

include ("class/Data.class.php");

$_iPostID = $_POST['data'];


$_oData = new Data();
$_oData->addVotes($_iPostID);

?>