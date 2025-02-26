<?php
/**
 * The Affair functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package The Affair
 */

if ( ! function_exists( 'csco_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function csco_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on The Affair, use a find and replace
		 * to change 'the-affair' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'the-affair', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Register custom thumbnail sizes.
		add_image_size( 'cs-small', 80, 80, true );
		add_image_size( 'cs-intermediate', 155, 120, true );
		add_image_size( 'cs-thumbnail-uncropped', 480, 0, false );
		add_image_size( 'cs-thumbnail-landscape', 640, 420, true );
		add_image_size( 'cs-thumbnail-portrait', 320, 420, true );
		add_image_size( 'cs-thumbnail-square', 480, 480, true );
		add_image_size( 'cs-medium-uncropped', 640, 0, false );
		add_image_size( 'cs-medium-landscape', 880, 580, true );
		add_image_size( 'cs-medium-portrait', 440, 580, true );
		add_image_size( 'cs-medium-square', 660, 660, true );
		add_image_size( 'cs-large-uncropped', 960, 0, false );
		add_image_size( 'cs-large-landscape', 1280, 840, true );
		add_image_size( 'cs-large-portrait', 640, 840, true );
		add_image_size( 'cs-large-square', 960, 960, true );
		add_image_size( 'cs-extra-large', 1920, 0, false );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'the-affair' ),
			'mobile'  => esc_html__( 'Mobile', 'the-affair' ),
			'footer'  => esc_html__( 'Footer', 'the-affair' ),
		) );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		// Supported Formats.
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

		// Supported Powerkit Formats UI.
		add_theme_support( 'powerkit-post-format-ui' );

		/*
		 * Switch default core markup for search form, comment form, comments, etc.
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Restoring the classic Widgets Editor.
		remove_theme_support( 'widgets-block-editor' );
	}
}
add_action( 'after_setup_theme', 'csco_setup' );



function my_custom_editor_styles() {
    add_theme_support( 'editor-styles' ); // Ensure editor styles are enabled
    add_editor_style( '\editor-style.css' ); // Load a custom stylesheet
}
add_action( 'after_setup_theme', 'my_custom_editor_styles' );





/**
 * Theme Settings.
 */
require get_template_directory() . '/inc/classes/class-csco-theme-settings.php';

/**
 * Promo Banner.
 */
require get_template_directory() . '/inc/classes/promo-banner/class-promo-banner.php';

/**
 * Assets.
 */
require get_template_directory() . '/inc/assets.php';

/**
 * Widgets Init.
 */
require get_template_directory() . '/inc/widgets-init.php';

/**
 * Main Query.
 */
require get_template_directory() . '/inc/main-query.php';

/**
 *
 * Template Functions.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Filters.
 */
require get_template_directory() . '/inc/filters.php';

/**
 * Gutenberg.
 */
require get_template_directory() . '/inc/gutenberg.php';

/**
 * Woocommerce.
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Customizer Functions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Actions.
 */
require get_template_directory() . '/inc/actions.php';

/**
 * Partials.
 */
require get_template_directory() . '/inc/partials.php';

/**
 * Meta Boxes.
 */
require get_template_directory() . '/inc/metabox.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom post meta function.
 */
require get_template_directory() . '/inc/post-meta.php';

/**
 * Mega menu.
 */
require get_template_directory() . '/inc/mega-menu.php';

/**
 * Load More.
 */
require get_template_directory() . '/inc/load-more.php';

/**
 * Load Nextpost.
 */
require get_template_directory() . '/inc/load-nextpost.php';

/**
 * Custom Content.
 */
require get_template_directory() . '/inc/custom-content.php';

/**
 * Powerkit fuctions.
 */
require get_template_directory() . '/inc/powerkit.php';

/**
 * Plugins.
 */
require get_template_directory() . '/inc/plugins.php';

/**
 * Deprecated.
 */
require get_template_directory() . '/inc/deprecated.php';

/**
 * One Click Demo Import.
 */
require get_template_directory() . '/inc/demo-import/ocdi-filters.php';

/**
 * Customizer demos.
 */
require get_template_directory() . '/inc/demo-import/customizer-demos.php';

/**
 * Theme demos.
 */
require get_template_directory() . '/inc/demo-import/theme-demos.php';
