<?php
/**
 * Typography
 *
 * @package The Affair
 */

CSCO_Kirki::add_panel(
	'typography', array(
		'title'    => esc_html__( 'Typography', 'the-affair' ),
		'priority' => 30,
	)
);

CSCO_Kirki::add_section(
	'typography_general', array(
		'title'    => esc_html__( 'General', 'the-affair' ),
		'panel'    => 'typography',
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'typography',
		'settings' => 'font_base',
		'label'    => esc_html__( 'Base Font', 'the-affair' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'Karla',
			'variant'        => 'regular',
			'subsets'        => array( 'latin' ),
			'font-size'      => '1rem',
			'letter-spacing' => '0',
		),
		'choices'  => apply_filters( 'powerkit_fonts_choices', array(
			'variant' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
		) ),
		'priority' => 10,
		'output'   => apply_filters( 'csco_font_base', array(
			array(
				'element' => 'body',
			),
		) ),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'        => 'typography',
		'settings'    => 'font_primary',
		'label'       => esc_html__( 'Primary Font', 'the-affair' ),
		'description' => esc_html__( 'Used for buttons and other elements.', 'the-affair' ),
		'section'     => 'typography_general',
		'default'     => array(
			'font-family'    => 'Montserrat',
			'variant'        => '400',
			'subsets'        => array( 'latin' ),
			'font-size'      => '0.6875rem',
			'letter-spacing' => '0.125em',
			'text-transform' => 'uppercase',
		),
		'choices'     => apply_filters( 'powerkit_fonts_choices', array() ),
		'priority'    => 10,
		'output'      => apply_filters( 'csco_font_primary', array(
			array(
				'element' => '.cs-font-primary, button, .button, input[type="button"], input[type="reset"], input[type="submit"], .no-comments, .entry-more, .siblingcategories .cs-nav-link, .tagcloud a, .pk-nav-item, .pk-card-header a, .pk-twitter-actions ul li, .navigation.pagination .nav-links > span, .navigation.pagination .nav-links > a, .pk-font-primary',
			),
		) ),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'        => 'typography',
		'settings'    => 'font_secondary',
		'label'       => esc_html__( 'Secondary Font', 'the-affair' ),
		'description' => esc_html__( 'Used for post meta, image captions and other secondary elements.', 'the-affair' ),
		'section'     => 'typography_general',
		'default'     => array(
			'font-family'    => 'Karla',
			'subsets'        => array( 'latin' ),
			'variant'        => '400',
			'font-size'      => '0.625rem',
			'letter-spacing' => '0.125em',
			'text-transform' => 'uppercase',
		),
		'choices'     => apply_filters( 'powerkit_fonts_choices', array() ),
		'priority'    => 10,
		'output'      => apply_filters( 'csco_font_secondary', array(
			array(
				'element' => 'label, .post-tags a, .cs-font-secondary, .post-meta, .archive-count, .page-subtitle, .site-description, figcaption, .wp-block-image figcaption, .wp-block-audio figcaption, .wp-block-embed figcaption, .wp-block-pullquote cite, .wp-block-pullquote footer, .wp-block-pullquote .wp-block-pullquote__citation, .wp-block-quote cite, .post-format-icon, .comment-metadata, .says, .logged-in-as, .must-log-in, .wp-caption-text, blockquote cite, div[class*="meta-"], span[class*="meta-"], small, .cs-breadcrumbs, .pk-social-links-count, .pk-share-buttons-count, .pk-social-links-label, .pk-twitter-time, .pk-font-secondary, .pk-pin-it',
			),
		) ),
	)
);


CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'typography',
		'settings' => 'font_post_content',
		'label'    => esc_html__( 'Post Content', 'the-affair' ),
		'section'  => 'typography_general',
		'default'  => array(
			'font-family'    => 'inherit',
			'variant'        => 'inherit',
			'subsets'        => array( 'latin' ),
			'font-size'      => 'inherit',
			'letter-spacing' => 'inherit',
		),
		'choices'  => apply_filters( 'powerkit_fonts_choices', array(
			'variant' => array(
				'regular',
				'italic',
				'700',
				'700italic',
			),
		) ),
		'priority' => 10,
		'output'   => apply_filters( 'csco_font_post_content', array(
			array(
				'element' => '.entry-content',
			),
		) ),
	)
);

CSCO_Kirki::add_section(
	'typography_headings', array(
		'title'    => esc_html__( 'Headings', 'the-affair' ),
		'panel'    => 'typography',
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'     => 'typography',
		'settings' => 'font_headings',
		'label'    => esc_html__( 'Headings', 'the-affair' ),
		'section'  => 'typography_headings',
		'default'  => array(
			'font-family'    => 'Montserrat',
			'line-height'    => 1,
			'variant'        => '700',
			'subsets'        => array( 'latin' ),
			'letter-spacing' => '-0.05em',
			'text-transform' => 'none',
		),
		'choices'  => apply_filters( 'powerkit_fonts_choices', array() ),
		'priority' => 10,
		'output'   => apply_filters( 'csco_font_headings', array(
			array(
				'element' => 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .site-title, .comment-author .fn, blockquote, .wp-block-quote, .wp-block-cover .wp-block-cover-image-text, .wp-block-cover .wp-block-cover-text, .wp-block-cover h2, .wp-block-cover-image .wp-block-cover-image-text, .wp-block-cover-image .wp-block-cover-text, .wp-block-cover-image h2, .wp-block-pullquote p, p.has-drop-cap:not(:focus):first-letter, .pk-twitter-username, .pk-font-heading',
			),
		) ),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'        => 'typography',
		'settings'    => 'font_title_block',
		'label'       => esc_html__( 'Section Titles', 'the-affair' ),
		'description' => esc_html__( 'Used for widget, related posts and other sections\' titles.', 'the-affair' ),
		'section'     => 'typography_headings',
		'default'     => array(
			'font-family'    => 'Montserrat',
			'variant'        => '700',
			'subsets'        => array( 'latin' ),
			'font-size'      => '.6875rem',
			'letter-spacing' => '0.25em',
			'text-transform' => 'uppercase',
			'color'          => '#000000',
		),
		'choices'     => apply_filters( 'powerkit_fonts_choices', array() ),
		'priority'    => 10,
		'output'      => apply_filters( 'csco_font_title_block', array(
			array(
				'element' => '.title-block, .cs-read-next',
			),
		) ),
	)
);

CSCO_Kirki::add_section(
	'typography_navigation', array(
		'title'    => esc_html__( 'Navigation', 'the-affair' ),
		'panel'    => 'typography',
		'priority' => 10,
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'        => 'typography',
		'settings'    => 'font_menu',
		'label'       => esc_html__( 'Menu Font', 'the-affair' ),
		'description' => esc_html__( 'Used for main top level menu elements.', 'the-affair' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Karla',
			'variant'        => '400',
			'subsets'        => array( 'latin' ),
			'font-size'      => '.6875rem',
			'letter-spacing' => '0.125em',
			'text-transform' => 'uppercase',
		),
		'choices'     => apply_filters( 'powerkit_fonts_choices', array() ),
		'priority'    => 10,
		'output'      => apply_filters( 'csco_font_menu', array(
			array(
				'element' => '.navbar-nav > li > a, .cs-mega-menu-child > a, .widget_archive li, .widget_categories li, .widget_meta li a, .widget_nav_menu .menu > li > a, .widget_pages .page_item a',
			),
		) ),
	)
);

CSCO_Kirki::add_field(
	'csco_theme_mod', array(
		'type'        => 'typography',
		'settings'    => 'font_submenu',
		'label'       => esc_html__( 'Submenu Font', 'the-affair' ),
		'description' => esc_html__( 'Used for submenu elements.', 'the-affair' ),
		'section'     => 'typography_navigation',
		'default'     => array(
			'font-family'    => 'Karla',
			'subsets'        => array( 'latin' ),
			'variant'        => '400',
			'font-size'      => '.875rem',
			'letter-spacing' => '0',
			'text-transform' => 'uppercase',
		),
		'choices'     => apply_filters( 'powerkit_fonts_choices', array() ),
		'priority'    => 10,
		'output'      => apply_filters( 'csco_font_submenu', array(
			array(
				'element' => '.navbar-nav .sub-menu > li > a, .widget_categories .children li a, .widget_nav_menu .sub-menu > li > a',
			),
		) ),
	)
);
