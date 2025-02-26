<?php
/**
 * Page Settings
 *
 * @package The Affair
 */

CSCO_Kirki::add_section(
	'page_settings', array(
		'title'    => esc_html__( 'Page Settings', 'the-affair' ),
		'priority' => 50,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'radio',
		'settings' => 'page_layout',
		'label'    => esc_html__( 'Default Page Layout', 'the-affair' ),
		'section'  => 'page_settings',
		'default'  => 'fullwidth',
		'priority' => 10,
		'choices'  => array(
			'fullwidth' => esc_html__( 'Fullwidth', 'the-affair' ),
			'boxed'     => esc_html__( 'Boxed', 'the-affair' ),
		),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'radio',
		'settings' => 'page_sidebar',
		'label'    => esc_html__( 'Default Sidebar', 'the-affair' ),
		'section'  => 'page_settings',
		'default'  => 'right',
		'priority' => 10,
		'choices'  => array(
			'right'    => esc_attr__( 'Right Sidebar', 'the-affair' ),
			'left'     => esc_attr__( 'Left Sidebar', 'the-affair' ),
			'disabled' => esc_attr__( 'No Sidebar', 'the-affair' ),
		),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'checkbox',
		'settings' => 'page_comments_simple',
		'label'    => esc_html__( 'Display comments without the View Comments button', 'the-affair' ),
		'section'  => 'page_settings',
		'default'  => false,
		'priority' => 10,
	)
);
