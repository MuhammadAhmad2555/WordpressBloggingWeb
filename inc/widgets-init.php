<?php
/**
 * Widgets Init
 *
 * Register sitebar locations for widgets.
 *
 * @package The Affair
 */

if ( ! function_exists( 'csco_widgets_init' ) ) {
	/**
	 * Register widget areas.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	function csco_widgets_init() {

		$tag = apply_filters( 'csco_section_title_tag', 'h5' );

		register_sidebar(
			array(
				'name'          => esc_html__( 'Default Sidebar', 'the-affair' ),
				'id'            => 'sidebar-main',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $tag . ' class="title-block title-widget">',
				'after_title'   => '</' . $tag . '>',
			)
		);

		register_sidebar(
			array(
				'name'          => esc_html__( 'Off-Canvas', 'the-affair' ),
				'id'            => 'sidebar-offcanvas',
				'before_widget' => '<div class="widget %1$s %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $tag . ' class="title-block title-widget">',
				'after_title'   => '</' . $tag . '>',
			)
		);
	}
}
add_action( 'widgets_init', 'csco_widgets_init' );
