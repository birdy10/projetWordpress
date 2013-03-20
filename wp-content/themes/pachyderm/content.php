<?php
/**
 * @package Pachyderm
 * @since Pachyderm 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="post-format-indicator">
			<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'pachyderm' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</div>
		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( '0', 'pachyderm' ), __( '1', 'pachyderm' ), __( '%', 'pachyderm' ) ); ?></span>
		<?php endif; ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'pachyderm' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php pachyderm_posted_on(); ?><?php edit_post_link( __( 'Edit', 'pachyderm' ) , ' | ', ''); ?>

		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php if ( get_post_format() || is_single() || 'page' == get_post_type() ) : ?>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'pachyderm' ) ); ?>
		<?php else : ?>
			<?php if ( is_home() && '' !== get_the_post_thumbnail() ) : ?>
				<?php the_post_thumbnail(); ?>
			<?php endif; ?>
			<?php the_excerpt(); ?>
		<?php endif; ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'next_or_number' => 'number', 'link_before' => '<span class="active-link">', 'link_after' => '</span>', ) ); ?>
	</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() && is_single() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( ' ' );
				if ( $categories_list && pachyderm_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php echo $categories_list; ?>
			</span>
			<?php endif; // End if categories ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '' );
				if ( $tags_list ) :
			?>
			<span class="tag-links">
				<?php echo $tags_list; ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->