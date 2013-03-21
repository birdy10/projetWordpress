<?php
/**
 * Pachyderm functions and definitions
 *
 * @package Pachyderm
 * @since Pachyderm 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Pachyderm 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 560; /* pixels */

if ( ! function_exists( 'pachyderm_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Pachyderm 1.0
 */
function pachyderm_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );

	/* Jetpack Infinite Scroll */
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'content',
		'footer'     => 'page',
		'footer_widgets' => 'infinite_scroll_has_footer_widgets',
	) );

	function infinite_scroll_has_footer_widgets() {
		if ( jetpack_is_mobile( '', true ) && is_active_sidebar( 'primary-sidebar' ) )
			return true;

		return false;
	}

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Pachyderm, use a find and replace
	 * to change 'pachyderm' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'pachyderm', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'headermenu' => __( 'Header Menu', 'pachyderm' ),
	) );

	/**
	 * Add support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'audio', 'video', 'status', 'quote', 'link', 'chat' ) );

	/**
	* Add support for editor style
	*/
	add_editor_style();

	/**
	* Add support for post thumbs
	*/
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true );

	/**
	 * Setup the WordPress core custom background feature.
	 *
	 * Use add_theme_support to register support for WordPress 3.4+
	 * as well as provide backward compatibility for previous versions.
	 * Use feature detection of wp_get_theme() which was introduced
	 * in WordPress 3.4.
	 *
	 * Hooks into the after_setup_theme action.
	 *
	 * @since Pachyderm 1.0
	 */

	$args = array(
		'default-color' => 'fef8cd',
		'default-image' => get_template_directory_uri() . '/img/background.png',
	);

	$args = apply_filters( 'pachyderm_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}

}
endif; // pachyderm_setup
add_action( 'after_setup_theme', 'pachyderm_setup' );

/* Filter to add author credit to Infinite Scroll footer */
function pachyderm_footer_credits( $credit ) {
	$credit = sprintf( __( '%3$s | Theme: %1$s by %2$s.', 'pachyderm' ), 'Pachyderm', '<a href="http://carolinemoore.net/" rel="designer">Caroline Moore</a>', '<a href="http://wordpress.org/" title="' . esc_attr( __( 'A Semantic Personal Publishing Platform', 'pachyderm' ) ) . '" rel="generator">Proudly powered by WordPress</a>' );
	return $credit;
}
add_filter( 'infinite_scroll_credit', 'pachyderm_footer_credits' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Pachyderm 1.0
 */
function pachyderm_widgets_init() {

	register_sidebar( array(
		'id' => 'primary-sidebar',
		'name' => __( 'Primary Sidebar' , 'pachyderm' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>'
		)
	);

}
add_action( 'widgets_init', 'pachyderm_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function pachyderm_scripts() {

	global $post;

	wp_enqueue_style( 'googlefonts', 'http://fonts.googleapis.com/css?family=Berkshire+Swash|Poiret+One|Gudea:400,400italic,700' );

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

}
add_action( 'wp_enqueue_scripts', 'pachyderm_scripts' );

/**
* Change excerpt [...] to something else
**/

function pachyderm_new_excerpt_more( $more ) {
    global $post;
	return '...<br /><a class="more-link" href="'. get_permalink( $post->ID ) . __( '">Continue reading &raquo;</a>', 'grisaille' );
}
add_filter( 'excerpt_more', 'pachyderm_new_excerpt_more' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );







/**
 * CUSTOM FIELDS 'VOTES' POUR LES ARTICLES
 * 0 par défaut lorsqu'un article est ajouté (puisqu'il n'a pas encore recu de votes)
 **/
add_action('publish_post', 'add_custom_field_votes');
function add_custom_field_votes($post_ID)
{
    global $wpdb;
    if(!wp_is_post_revision($post_ID))
    {
        add_post_meta($post_ID, 'votes', '0', true);
    }
}