<?php
/**
 * Pachyderm Theme Options
 *
 * @package Going to the Zoo
 */

/**
 * Register the form setting for our pachyderm_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, pachyderm_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *

 */
function pachyderm_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === pachyderm_get_theme_options() )
		add_option( 'pachyderm_theme_options', pachyderm_get_default_theme_options() );

	register_setting(
		'pachyderm_options',       // Options group, see settings_fields() call in pachyderm_theme_options_render_page()
		'pachyderm_theme_options', // Database option, see pachyderm_get_theme_options()
		'pachyderm_theme_options_validate' // The sanitization callback, see pachyderm_theme_options_validate()
	);

	// Register our settings field group
	add_settings_section( 'general', '', '__return_false', 'theme_options' );

	/* Register our individual settings fields */

	add_settings_field( 'pachyderm_custom_css', __( 'Custom CSS', 'pachyderm' ), 'pachyderm_settings_field_custom_css', 'theme_options', 'general' );

	add_settings_field(
		'pachyderm_support', // Unique identifier for the field for this section
		__( 'Support Caroline Themes', 'pachyderm' ), // Setting field label
		'pachyderm_settings_field_support', // Function that renders the settings field
		'theme_options', // Menu slug, used to uniquely identify the page; see _s_theme_options_add_page()
		'general' // Settings section. Same as the first argument in the add_settings_section() above
	);

}
add_action( 'admin_init', 'pachyderm_theme_options_init' );

/**
 * Change the capability required to save the 'pachyderm_options' options group.
 *
 * @see pachyderm_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see pachyderm_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function pachyderm_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_pachyderm_options', 'pachyderm_option_page_capability' );

/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *

 */
function pachyderm_theme_options_add_page() {
	global $pachyderm_options_hook;
	$pachyderm_options_hook = add_theme_page(
		__( 'Theme Options', 'pachyderm' ),   // Name of page
		__( 'Theme Options', 'pachyderm' ),   // Label in menu
		'edit_theme_options',                    // Capability required
		'theme_options',                         // Menu slug, used to uniquely identify the page
		'pachyderm_theme_options_render_page' // Function that renders the options page
	);

	if ( ! $pachyderm_options_hook )
		return;

	add_action('load-'.$pachyderm_options_hook, 'pachyderm_contextual_help', 10, 3);
}
add_action( 'admin_menu', 'pachyderm_theme_options_add_page' );


/**
 * Returns the default options for Pachyderm.
 *

 */
function pachyderm_get_default_theme_options() {
	$default_theme_options = array(
		'custom_css' => '',
		'support' => 0
	);

	return apply_filters( 'pachyderm_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Pachyderm.
 *

 */
function pachyderm_get_theme_options() {
	return get_option( 'pachyderm_theme_options', pachyderm_get_default_theme_options() );
}


/**
 * Renders the Custom CSS setting field.
 *

 */
function pachyderm_settings_field_custom_css() {
	$options = pachyderm_get_theme_options();
	?>
	<textarea class="large-text" type="text" name="pachyderm_theme_options[custom_css]" id="custom_css" cols="50" rows="10" /><?php echo esc_textarea( $options['custom_css'] ); ?></textarea>
	<label class="description" for="custom_css"><?php _e( 'Add any custom CSS rules here so they will persist through theme updates.', 'pachyderm' ); ?></label>
	<?php
}

/**
 * Renders the Support setting field.
 */
function pachyderm_settings_field_support() {
	$options = pachyderm_get_theme_options();

	if ( $options['support'] !== 'on' || !isset( $options['support'] ) ) {

	?>
	<label for"Pachyderm-support">
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6G3NYZ5EN28EY" target="_blank"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" alt="PayPal - The safer, easier way to pay online!" class="alignright"></a>
		<?php _e( 'If you enjoy my themes, please consider making a secure donation using the PayPal button to your right. Anything is appreciated!', 'pachyderm' ); ?>

		<br /><input type="checkbox" name="pachyderm_theme_options[support]" id="support" <?php checked( 'on', $options['support'] ); ?> />
		<label class="description" for="support">
			<?php _e( 'No, thank you! Dismiss this message.', 'pachyderm' ); ?>
		</label>
	</label>
	<?php
	}
	else { ?>
		<label class="description" for="support">
			<?php _e( 'Hide Donate Button', 'pachyderm' ); ?>
		</label>
		<input type="checkbox" name="pachyderm_theme_options[support]" id="support" <?php checked( 'on', $options['support'] ); ?> />

	</td>

	<?php
	}

}

/**
 * Returns the options array for Pachyderm.
 *

 */
function pachyderm_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'pachyderm' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'pachyderm_options' );
				do_settings_sections( 'theme_options' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see pachyderm_theme_options_init()
 * @todo set up Reset Options action
 *

 */
function pachyderm_theme_options_validate( $input ) {
	$output = $defaults = pachyderm_get_default_theme_options();

	// The Support field should either be on or off
	if ( ! isset( $input['support'] ) )
		$input['support'] = 'off';
	$output['support'] = ( $input['support'] == 'on' ? 'on' : 'off' );

	// The Custom CSS must be safe text with the allowed tags for CSS
	if ( isset( $input['custom_css'] ) )
		$output['custom_css'] = wp_filter_nohtml_kses($input['custom_css'] );

	return apply_filters( 'pachyderm_theme_options_validate', $output, $input, $defaults );
}

/**
 * Theme Options Admin Styles
*/

function pachyderm_theme_options_admin_styles() {
	echo "<style type='text/css'>";
	echo ".layout .description { width: 300px; float: left; text-align: center; margin-bottom: 10px; padding: 10px; }";
	echo "</style>";
}

add_action( 'admin_enqueue_scripts', 'pachyderm_theme_options_admin_styles' );

/**
 * Add a contextual help menu to the Theme Options panel
 */
function pachyderm_contextual_help() {

	global $pachyderm_options_hook;

	$screen = get_current_screen();

	if ( $screen->id == $pachyderm_options_hook ) {

		//Store Theme Options tab in variable
		$theme_options_content = '<p><a href="http://wordpress.org/tags/pachyderm?forum_id=5" target="_blank">' . __( 'For basic support, please post in the WordPress forums.', 'pachyderm' ) . '</a></p>';
		$theme_options_content .= '<p><strong>' . __( 'Custom CSS', 'pachyderm' ) . '</strong> - ' . __( 'You can override the theme\'s default CSS by putting your own code here.  It should be in the format:', 'pachyderm' ) . '</p>';
		$theme_options_content .= '<blockquote><pre>.some-class { width: 100px; }</pre>';
		$theme_options_content .= '<pre>#some-id { background-color: #fff; }</pre></blockquote>';
		$theme_options_content .= '<p>' . __( 'Replacing any classes, ID\'s, etc. with the ones you want to override, and within them the attributes you want to change.', 'pachyderm' ) . '</p>';
		$theme_options_content .= '<p><strong>' . __( 'Support Caroline Themes/Hide Donate Button', 'pachyderm' ) . '</strong> - ' . __( 'If you like my themes and find them useful, please donate!  Checking the box will hide this information.', 'pachyderm' ) . '</p>';
		$theme_options_content .= '<p><a href="http://www.carolinethemes.com" target="_blank">' . __( 'Visit Caroline Themes for more free WordPress themes!', 'pachyderm' ) . '</a></p>';

		$screen->add_help_tab( array (
				'id' => 'Pachyderm-theme-options',
				'title' => __( 'Theme Options', 'pachyderm' ),
				'content' => $theme_options_content
				)
		);

	}
}

?>