<?php
/**
 * Customizer Functions
 *
 * @package The Affair
 */

/**
 * Kirki Init.
 */
require get_template_directory() . '/inc/classes/class-csco-kirki.php';

/**
 * Kirki Installer.
 */
require get_template_directory() . '/inc/classes/class-csco-kirki-installer.php';

/**
 * Telemetry implementation for Kirki
 */
function csco_kirki_telemetry() {
	return false;
}
add_filter( 'kirki_telemetry', 'csco_kirki_telemetry' );

/**
 * Kirki Config
 *
 * @param array $config is an array of Kirki configuration parameters.
 */
function csco_kirki_config( $config ) {

	if ( isset( $config['compiler'] ) ) {
		unset( $config['compiler'] );
	}

	return $config;
}
add_filter( 'kirki/config', 'csco_kirki_config', 999 );

/**
 * Changes the font-loading method.
 *
 * @param string $method The font-loading method (async|link).
 */
function csco_change_fonts_load_method( $method ) {
	// Check for a theme-mod.
	// We don't want to force the use of the link method for googlefonts loading
	// since the async method is better in general.
	if ( 'link' === get_theme_mod( 'webfonts_load_method', 'async' ) ) {
		$method = 'auto';
	}
	return $method;
}
add_filter( 'kirki_googlefonts_font_display', 'csco_change_fonts_load_method' );
add_filter( 'powerkit_webfonts_load_method', 'csco_change_fonts_load_method' );

/**
 * Remove AMP link.
 */
function csco_admin_remove_amp_link() {
	remove_action( 'admin_menu', 'amp_add_customizer_link' );
}
add_action( 'after_setup_theme', 'csco_admin_remove_amp_link', 20 );

/**
 * Remove AMP panel.
 *
 * @param object $wp_customize Instance of the WP_Customize_Manager class.
 */
function csco_customizer_remove_amp_panel( $wp_customize ) {
	$wp_customize->remove_panel( 'amp_panel' );
}
add_action( 'customize_register', 'csco_customizer_remove_amp_panel', 1000 );


/**
 * Fix spacing in dynamic CSS for editor styles wrapper.
 *
 * Removes unnecessary spaces between `.editor-styles-wrapper` and `[data-*]` attributes
 * to ensure proper CSS rendering in both editor and front-end.
 *
 * @param string $styles The dynamic CSS styles.
 * @return string Processed CSS styles without extra spaces.
 */
function csco_fix_editor_wrapper_spacing( $styles ) {
	if ( ! is_string( $styles ) || empty( $styles ) ) {
		return $styles;
	}

	// Remove extra spaces between `.editor-styles-wrapper` and `[data-*]` attributes.
	$styles = preg_replace_callback(
		'/\.editor-styles-wrapper\s+(\[data-[^\]]+\])/',
		function ( $matches ) {
			return '.editor-styles-wrapper' . $matches[1];
		},
		$styles
	);

	// Remove extra spaces between consecutive `.editor-styles-wrapper`.
	$styles = preg_replace_callback(
		'/\.editor-styles-wrapper\s+\.editor-styles-wrapper/',
		function () {
			return '.editor-styles-wrapper';
		},
		$styles
	);

	return $styles;
}
add_filter( 'csco_kirki_dynamic_css', 'csco_fix_editor_wrapper_spacing' );
add_filter( 'kirki_global_dynamic_css', 'csco_fix_editor_wrapper_spacing' );
add_filter( 'kirki_csco_theme_mod_dynamic_css', 'csco_fix_editor_wrapper_spacing' );

/**
 * Register Theme Mods
 */
function csco_register_theme_mods() {
	/**
	 * Register Theme Mods
	 */
	CSCO_Kirki::add_config(
		'csco_theme_mod', array(
			'capability'  => 'edit_theme_options',
			'option_type' => 'theme_mod',
		)
	);

	/**
	 * Site Identity.
	 */
	require get_template_directory() . '/inc/theme-mods/site-identity.php';

	/**
	 * Colors.
	 */
	require get_template_directory() . '/inc/theme-mods/colors.php';

	/**
	 * Typography.
	 */
	require get_template_directory() . '/inc/theme-mods/typography.php';

	/**
	 * Header Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/header-settings.php';

	/**
	 * Footer Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/footer-settings.php';

	/**
	 * Homepage Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/homepage-settings.php';

	/**
	 * Archive Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/archive-settings.php';

	/**
	 * Category Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/category-settings.php';

	/**
	 * Posts Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/post-settings.php';

	/**
	 * Pages Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/page-settings.php';

	/**
	 * Miscellaneous Settings.
	 */
	require get_template_directory() . '/inc/theme-mods/miscellaneous-settings.php';
}
add_action( 'after_setup_theme', 'csco_register_theme_mods', 20 );
