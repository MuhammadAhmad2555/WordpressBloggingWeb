<?php
/**
 * Miscellaneous Settings
 *
 * @package The Affair
 */

CSCO_Kirki::add_section(
	'miscellaneous', array(
		'title'    => esc_html__( 'Miscellaneous Settings', 'the-affair' ),
		'priority' => 60,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'checkbox',
		'settings' => 'display_published_date',
		'label'    => esc_html__( 'Display published date instead of modified date', 'the-affair' ),
		'section'  => 'miscellaneous',
		'default'  => true,
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'text',
		'settings' => 'search_placeholder',
		'label'    => esc_html__( 'Search Form Placeholder', 'the-affair' ),
		'section'  => 'miscellaneous',
		'default'  => esc_html__( 'Search The Affair', 'the-affair' ),
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'text',
		'settings' => 'label_readmore',
		'label'    => esc_html__( '"View Post" Button Label', 'the-affair' ),
		'section'  => 'miscellaneous',
		'default'  => esc_html__( 'View Post', 'the-affair' ),
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'radio',
		'settings' => 'classic_gallery_alignment',
		'label'    => esc_html__( 'Alignment of Galleries in Classic Block', 'the-affair' ),
		'section'  => 'miscellaneous',
		'default'  => 'default',
		'priority' => 10,
		'choices'  => array(
			'default' => esc_html__( 'Default', 'the-affair' ),
			'wide'    => esc_html__( 'Wide', 'the-affair' ),
			'large'   => esc_html__( 'Large', 'the-affair' ),
		),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'checkbox',
		'settings' => 'sticky_sidebar',
		'label'    => esc_html__( 'Sticky Sidebar', 'the-affair' ),
		'section'  => 'miscellaneous',
		'default'  => true,
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'            => 'radio',
		'settings'        => 'sticky_sidebar_method',
		'label'           => esc_html__( 'Sticky Method', 'the-affair' ),
		'section'         => 'miscellaneous',
		'default'         => 'stick-to-bottom',
		'priority'        => 10,
		'choices'         => array(
			'stick-to-top'    => esc_html__( 'Sidebar top edge', 'the-affair' ),
			'stick-to-bottom' => esc_html__( 'Sidebar bottom edge', 'the-affair' ),
			'stick-last'      => esc_html__( 'Last widget top edge', 'the-affair' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'sticky_sidebar',
				'operator' => '==',
				'value'    => true,
			),
		),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'checkbox',
		'settings' => 'effects_parallax',
		'label'    => esc_html__( 'Enable Parallax', 'the-affair' ),
		'section'  => 'miscellaneous',
		'default'  => true,
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'        => 'radio',
		'settings'    => 'webfonts_load_method',
		'label'       => esc_html__( 'Webfonts Load Method', 'the-affair' ),
		'description' => esc_html__( 'Please', 'the-affair' ) . ' <a href="' . add_query_arg( array( 'action' => 'kirki-reset-cache' ), get_site_url() ) . '" target="_blank">' . esc_html__( 'reset font cache', 'overflow' ) . '</a> ' . esc_html__( 'after saving.', 'overflow' ),
		'section'     => 'miscellaneous',
		'default'     => 'async',
		'priority'    => 10,
		'choices'     => array(
			'async' => esc_html__( 'Asynchronous', 'the-affair' ),
			'link'  => esc_html__( 'Render-Blocking', 'the-affair' ),
		),
	)
);
