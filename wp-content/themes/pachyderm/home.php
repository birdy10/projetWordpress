<?php
/**
 * Created by romain ardiet
 * Date: 21/03/13
 * Time: 11:00
 */

get_header();
?>

<h2>Graphique : </h2>
<div id='container' style='min-width: 500px; height: 500px; margin: 0 auto'></div>


<?php // echo do_shortcode("[graphic]"); ?>

<h2>Liste des technologies : </h2>

<?php echo do_shortcode('[list]'); ?>

<?php  get_footer(); ?>