<?php
/**
 * Assets
 *
 * All enqueues of scripts and styles.
 *
 * @package The Affair
 */

if ( ! function_exists( 'csco_content_width' ) ) {
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function csco_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'csco_content_width', 680 );
	}
}
add_action( 'after_setup_theme', 'csco_content_width', 0 );

if ( ! function_exists( 'csco_editor_style' ) ) {
	/**
	 * Add callback for custom editor stylesheets.
	 */
	function csco_editor_style() {
		// Add support for editor styles.
		add_theme_support( 'editor-styles' );
	}
}
add_action( 'current_screen', 'csco_editor_style' );

if ( ! function_exists( 'csco_enqueue_block_editor_assets' ) ) {
	/**
	 * Enqueue block editor specific scripts.
	 */
	function csco_enqueue_block_editor_assets() {

		if ( ! ( is_admin() && ! is_customize_preview() ) ) {
			return;
		}

		$version = csco_get_theme_data( 'Version' );

		// Register theme styles.
		wp_register_style( 'csco-editor', get_template_directory_uri() . '/css/editor-style.css', false, $version );

		// Add RTL support.
		wp_style_add_data( 'csco-editor', 'rtl', 'replace' );

		// Enqueue theme styles.
		wp_enqueue_style( 'csco-editor' );
	}
	add_action( 'enqueue_block_assets', 'csco_enqueue_block_editor_assets' );
}

if ( ! function_exists( 'csco_enqueue_scripts' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function csco_enqueue_scripts() {

		$version = csco_get_theme_data( 'Version' );

		// Register vendor scripts.
		wp_register_script( 'colcade', get_template_directory_uri() . '/js/colcade.js', array( 'jquery' ), '0.2.0', true );
		wp_register_script( 'object-fit-images', get_template_directory_uri() . '/js/ofi.min.js', array(), '3.2.3', true );
		wp_register_script( 'owl', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
		wp_register_script( 'vide', get_template_directory_uri() . '/js/jquery.vide.min.js', array( 'jquery' ), '0.5.1', true );
		wp_register_script( 'jarallax', get_template_directory_uri() . '/js/jarallax.min.js', array( 'jquery' ), '1.10.3', true );
		wp_register_script( 'jarallax-video', get_template_directory_uri() . '/js/jarallax-video.min.js', array( 'jquery' ), '1.0.1', true );

		// Register theme scripts.
		wp_register_script( 'csco-scripts', get_template_directory_uri() . '/js/scripts.js', array(
			'jquery',
			'imagesloaded',
			'owl',
			'colcade',
			'object-fit-images',
			'vide',
			'jarallax',
			'jarallax-video',
		), $version, true );

		// Enqueue theme scripts.
		wp_enqueue_script( 'csco-scripts' );

		// Enqueue comment reply script.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Register theme styles.
		wp_register_style( 'csco-styles', csco_style( get_template_directory_uri() . '/style.css' ), array(), $version );

		// Enqueue theme styles.
		wp_enqueue_style( 'csco-styles' );

		// Add RTL support.
		wp_style_add_data( 'csco-styles', 'rtl', 'replace' );

		// Dequeue Contact Form 7 styles.
		wp_dequeue_style( 'contact-form-7' );
	}
}
add_action( 'wp_enqueue_scripts', 'csco_enqueue_scripts' );
