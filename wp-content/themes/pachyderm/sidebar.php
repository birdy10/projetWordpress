<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Pachyderm
 * @since Pachyderm 1.0
 */
?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php do_action( 'before_sidebar' ); ?>
			<?php if ( ! dynamic_sidebar( __( 'Primary Sidebar' , 'pachyderm' ) ) ) : ?>
			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
