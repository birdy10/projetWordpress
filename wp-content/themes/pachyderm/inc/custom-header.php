<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package Pachyderm
 * @since Pachyderm 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses pachyderm_header_style()
 * @uses pachyderm_admin_header_style()
 * @uses pachyderm_admin_header_image()
 *
 * @package Going to the Zoo
 */
function pachyderm_custom_header_setup() {
	$args = array(
		'default-image'          => get_template_directory_uri() . '/img/zoo.png',
		'default-text-color'     => '49352f',
		'width'                  => 790,
		'height'                 => 200,
		'flex-height'            => true,
		'flex-width'			 => true,
		'wp-head-callback'       => 'pachyderm_header_style',
		'admin-head-callback'    => 'pachyderm_admin_header_style',
		'admin-preview-callback' => 'pachyderm_admin_header_image',
	);

	$args = apply_filters( 'pachyderm_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'pachyderm_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Going to the Zoo
 * @since Going to the Zoo 1.1
 */

if ( ! function_exists( 'get_custom_header' ) ) {
	function get_custom_header() {
		return (object) array(
			'url'           => get_header_image(),
			'thumbnail_url' => get_header_image(),
			'width'         => HEADER_IMAGE_WIDTH,
			'height'        => HEADER_IMAGE_HEIGHT,
		);
	}
}

if ( ! function_exists( 'pachyderm_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see pachyderm_custom_header_setup().
 *
 * @since Pachyderm 1.0
 */
function pachyderm_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // pachyderm_header_style

if ( ! function_exists( 'pachyderm_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see pachyderm_custom_header_setup().
 *
 * @since Pachyderm 1.0
 */
function pachyderm_admin_header_style() {

	wp_enqueue_style( 'googlefonts', 'http://fonts.googleapis.com/css?family=Berkshire+Swash|Gudea:400' );
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
	}
	#headimg h1 {
		clear: both;
		color: #49352f;
		font-family: "Berkshire Swash", sans-serif;
		font-size: 48px;
		font-weight: normal;
		line-height: normal;
		margin: 0;
	}
	#headimg h1 a {
		color: #49352f;
		text-decoration: none;
	}
	#desc {
		clear: both;
		color: #f15d5d;
		font-family: Gudea, Helvetica, Arial, sans-serif;
		font-size: 18px;
		line-height: 45px;
		margin: -10px 0 20px 5px;
	}
	#headimg img {
	}
	</style>
<?php
}
endif; // pachyderm_admin_header_style

if ( ! function_exists( 'pachyderm_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see pachyderm_custom_header_setup().
 *
 * @since Pachyderm 1.0
 */
function pachyderm_admin_header_image() { ?>
	<div id="headimg">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif;

		if ( 'blank' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) || '' == get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_theme_mod( 'header_textcolor', HEADER_TEXTCOLOR ) . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
	</div>
<?php }
endif; // pachyderm_admin_header_image