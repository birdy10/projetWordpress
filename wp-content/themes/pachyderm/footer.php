<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Pachyderm
 * @since Pachyderm 1.0
 */

?>
	</div><!-- #main -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php pachyderm_content_nav( 'nav-below' ); ?>
		<div class="site-info">
			<a href="<?php echo esc_url( 'http://www.carolinemoore.net' ); ?>" target="_blank" title="<?php _e( 'Going to the Zoo Theme by Caroline Moore' , 'pachyderm' ); ?>"><?php _e( 'Pachyderm by Caroline Moore' , 'pachyderm' ); ?></a>
		</div><!-- .site-info -->
	</footer><!-- .site-footer .site-footer -->
</div><!-- #page .hfeed .site -->
<?php wp_footer(); ?>

</body>
</html>