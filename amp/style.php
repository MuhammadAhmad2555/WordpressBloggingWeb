<?php
/**
 * Style template.
 *
 * @package AMP
 */

/**
 * Context.
 *
 * @var AMP_Post_Template $this
 */

$content_max_width       = absint( $this->get( 'content_max_width' ) );

// Theme Settings.
$text_color       = '#000000';
$muted_text_color = '#000000';
$border_color     = '#ced4da';

$link_color      = get_theme_mod( 'color_primary', '#000000' );
$color_primary   = get_theme_mod( 'color_primary', '#000000' );
$color_footer_bg = get_theme_mod( 'color_footer_bg', '#000000' );
$font_base       = get_theme_mod( 'font_base' );
$font_primary    = get_theme_mod( 'font_primary' );
$font_secondary  = get_theme_mod( 'font_secondary' );
$font_headings   = get_theme_mod( 'font_headings' );

$font_family = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
?>
/* Generic WP styling */
html {
	line-height: 1.15;
}

.alignright {
	float: right;
}

.alignleft {
	float: left;
}

.aligncenter {
	display: block;
	margin-left: auto;
	margin-right: auto;
}

button,
.button,
input[type="button"],
input[type="reset"],
input[type="submit"],
.amp-wp-comments-link a {
	font-family: <?php echo wp_kses( $font_family, 'post' ); ?>;
	font-weight: <?php echo ( isset( $font_primary['font-weight'] ) && $font_primary['font-weight'] ) ? esc_attr( $font_primary['font-weight'] ) : '300'; ?>;
	font-style: <?php echo ( isset( $font_primary['font-style'] ) && $font_primary['font-style'] ) ? esc_attr( $font_primary['font-style'] ) : 'normal'; ?>;
}

label,
figcaption,
blockquote cite,
.wp-caption-text {
	font-family: <?php echo wp_kses( $font_family, 'post' ); ?>;
	font-weight: <?php echo ( isset( $font_secondary['font-weight'] ) && $font_secondary['font-weight'] ) ? esc_attr( $font_secondary['font-weight'] ) : '300'; ?>;
	font-style: <?php echo ( isset( $font_secondary['font-style'] ) && $font_secondary['font-style'] ) ? esc_attr( $font_secondary['font-style'] ) : 'normal'; ?>;
}

blockquote cite {
	display: block;
	width: 100%;
}

h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
	font-family: <?php echo wp_kses( $font_family, 'post' ); ?>;
	font-weight: <?php echo ( isset( $font_headings['font-weight'] ) && $font_headings['font-weight'] ) ? esc_attr( $font_headings['font-weight'] ) : '600'; ?>;
	font-style: <?php echo ( isset( $font_headings['font-style'] ) && $font_headings['font-style'] ) ? esc_attr( $font_headings['font-style'] ) : 'normal'; ?>;
	line-height: 1.15;
}

h1, .h1 {
	font-size: 2.5rem;
}

h2, .h2 {
	font-size: 2rem;
}

h3, .h3 {
	font-size: 1.75rem;
}

h4, .h4 {
	font-size: 1.5rem;
}

h5, .h5 {
	font-size: 1.25rem;
}

h6, .h6 {
	font-size: 1rem;
}

.amp-wp-article-content {
	counter-reset: h2;
}

.amp-wp-article-content h2 {
	counter-reset: h3;
}

.amp-wp-article-content h3 {
	counter-reset: h4;
}

.amp-wp-article-content h4 {
	counter-reset: h5;
}

.amp-wp-article-content h5 {
	counter-reset: h6;
}

.amp-wp-enforced-sizes {
	/** Our sizes fallback is 100vw, and we have a padding on the container; the max-width here prevents the element from overflowing. **/
	max-width: 100%;
	margin: 0 auto;
}

.amp-wp-unknown-size img {
	/** Worst case scenario when we can't figure out dimensions for an image. **/
	/** Force the image into a box of fixed dimensions and use object-fit to scale. **/
	object-fit: contain;
}

/* Template Styles */

.amp-wp-content,
.amp-wp-title-bar div {
	<?php if ( $content_max_width > 0 ) : ?>
	margin: 0 auto;
	max-width: <?php echo esc_html( sprintf( '%dpx', $content_max_width ) ); ?>;
	<?php endif; ?>
}


body {
	color: <?php echo esc_html( sanitize_hex_color( $text_color ) ); ?>;
	font-family: <?php echo wp_kses( $font_family, 'post' ); ?>;
	font-weight: <?php echo ( isset( $font_base['font-weight'] ) && $font_base['font-weight'] ) ? esc_attr( $font_base['font-weight'] ) : '300'; ?>;
	font-style: <?php echo ( isset( $font_base['font-style'] ) && $font_base['font-style'] ) ? esc_attr( $font_base['font-style'] ) : 'normal'; ?>;
	line-height: 1.75em;
}

p,
ol,
ul,
figure {
	margin: 0 0 1em;
	padding: 0;
}

a,
a:visited {
	color: <?php echo esc_html( sanitize_hex_color( $link_color ) ); ?>;
}

a:hover,
a:active,
a:focus {
	color: <?php echo esc_html( sanitize_hex_color( $text_color ) ); ?>;
}

/* Quotes */

blockquote {
	color: <?php echo esc_html( sanitize_hex_color( $text_color ) ); ?>;
	background: rgba(127,127,127,.125);
	border-left: 2px solid <?php echo esc_html( sanitize_hex_color( $link_color ) ); ?>;
	margin: 8px 0 24px 0;
	padding: 16px;
}

blockquote p:last-child {
	margin-bottom: 0;
}

/* Header */
.amp-wp-header {
	-webkit-box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
	box-shadow: 0 0 1rem rgba(0, 0, 0, 0.1);
}

.amp-wp-header .navbar-content {
	margin: 0 auto;
	max-width: calc(840px - 32px);
	position: relative;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	-ms-flex-align: center;
	align-items: center;
	position: relative;
	height: 60px;
}

.amp-wp-header .navbar-brand {
	display: inline-block;
	margin-bottom: 0;
	line-height: inherit;
	white-space: nowrap;
	margin-left: auto;
	margin-right: auto;
}

.amp-wp-header .navbar-brand{
	text-decoration: none;
	transition: 0.2s;
}

@media (min-width: 760px) {
	.amp-wp-header .navbar-brand {
		margin-left: 0;
		margin-right: 1rem;
	}
}

.amp-wp-header .site-title {
	color: black;
	font-size: 1.25rem;
}

.amp-wp-header .site-title:hover {
	color: <?php echo esc_html( $color_primary ); ?>;
}

.amp-wp-header .navbar-text {
	display: inline-block;
	margin-bottom: 0;
}

.amp-wp-header .site-description {
	display: none;
	font-size: 0.875rem;
	padding-left: 1rem;
	border-left: 1px rgba(233, 236, 239, 0.5) solid;
	color: rgba(108, 117, 125, 0.5);
}

@media (min-width: 760px) {
	.amp-wp-header .site-description {
		display: inline-block;
	}
}

/* Article */

.amp-wp-article {
	color: <?php echo esc_html( sanitize_hex_color( $text_color ) ); ?>;
	font-weight: 400;
	margin: 3em auto;
	max-width: 840px;
	list-style: none;
	overflow-wrap: break-word;
	word-wrap: break-word;
}

/* Article Header */

.amp-wp-article-header {
	align-items: center;
	align-content: stretch;
	display: flex;
	flex-wrap: wrap;
	margin: 1.5em 16px;
}

.amp-wp-title {
	color: <?php echo esc_html( sanitize_hex_color( $text_color ) ); ?>;
	display: block;
	flex: 1 0 100%;
	font-weight: 600;
	margin: 0 0 .625em;
	width: 100%;
}

/* Article Meta */

.amp-wp-meta {
	color: <?php echo esc_html( sanitize_hex_color( $muted_text_color ) ); ?>;
	display: inline-block;
	font-size: .875em;
	line-height: 1.5em;
	padding: 0;
}

.amp-wp-article-header .amp-wp-meta:last-of-type {
	margin-left: 16px;
	text-align: right;
}

.amp-wp-article-header .amp-wp-meta:first-of-type {
	text-align: left;
}

.amp-wp-byline amp-img,
.amp-wp-byline .amp-wp-author {
	display: inline-block;
	vertical-align: middle;
}

.amp-wp-byline amp-img {
	border: 1px solid <?php echo esc_html( sanitize_hex_color( $link_color ) ); ?>;
	border-radius: 50%;
	position: relative;
	margin-right: 6px;
}

.amp-wp-posted-on {
	text-align: right;
}

/* Featured image */

.amp-wp-article-featured-image {
	margin: 0 16px 1em;
}
.amp-wp-article-featured-image amp-img {
	margin: 0 auto;
}
.amp-wp-article-featured-image.wp-caption .wp-caption-text {
	margin: 0 18px;
}

/* Article Content */

.amp-wp-article-content {
	margin: 0 16px;
}

.amp-wp-article-content figure {
	max-width: 100%;
}

.amp-wp-article-content ul,
.amp-wp-article-content ol {
	margin-left: 1em;
}

.amp-wp-article-content amp-img {
	margin: 0 auto;
}

.amp-wp-article-content amp-img.alignright {
	margin: 0 0 1em 16px;
}

.amp-wp-article-content amp-img.alignleft {
	margin: 0 16px 1em 0;
}

/* Captions */

.wp-caption {
	padding: 0;
}

.wp-caption.alignleft {
	margin-right: 16px;
}

.wp-caption.alignright {
	margin-left: 16px;
}

.wp-caption .wp-caption-text {
	border-bottom: 1px solid <?php echo esc_html( sanitize_hex_color( $border_color ) ); ?>;
	color: <?php echo esc_html( sanitize_hex_color( $muted_text_color ) ); ?>;
	font-size: .875em;
	line-height: 1.5em;
	margin: 0;
	padding: .66em 10px .75em;
}

/* AMP Media */

amp-carousel {
	background: <?php echo esc_html( sanitize_hex_color( $border_color ) ); ?>;
	margin: 0 0 1.5em;
}
amp-iframe,
amp-youtube,
amp-instagram,
amp-vine {
	background: <?php echo esc_html( sanitize_hex_color( $border_color ) ); ?>;
	margin: 0 0 1.5em;
}

.amp-wp-article-content amp-carousel amp-img {
	border: none;
}

amp-carousel > amp-img > img {
	object-fit: contain;
}

.amp-wp-iframe-placeholder {
	background: <?php echo esc_html( sanitize_hex_color( $border_color ) ); ?> url( <?php echo esc_url( $this->get( 'placeholder_image_url' ) ); ?> ) no-repeat center 40%;
	background-size: 48px 48px;
	min-height: 48px;
}

/* Article Footer Meta */

.amp-wp-article-footer .amp-wp-meta {
	display: block;
}

.amp-wp-tax-category,
.amp-wp-tax-tag {
	color: <?php echo esc_html( sanitize_hex_color( $muted_text_color ) ); ?>;
	font-size: .875em;
	line-height: 1.5em;
	margin: 1.5em 16px;
}

.amp-wp-comments-link {
	text-align: center;
	margin: 3em 0;
}

.amp-wp-comments-link a {
	display: inline-block;
	border: none;
	font-weight: 700;
	text-align: center;
	white-space: nowrap;
	vertical-align: middle;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	cursor: pointer;
	border: 1px solid transparent;
	padding: 0.85rem 1.5rem;
	line-height: 1.5;
	background-color: #000000;
	text-decoration: none;
	color: #fff;
	font-size: 10px;
	letter-spacing: 2px;
	text-transform: uppercase;
	transition: 0.2s;
}

.amp-wp-comments-link a:hover {
	background-color: black;
}

.pk-share-buttons-wrap .pk-share-buttons-link {
	border-radius: 4px;
}

/* AMP Footer */

.amp-wp-footer {
	border-top: 1px solid <?php echo esc_html( csco_light_or_dark( $color_footer_bg, '#e9ecef', 'transparent' ) ); ?>;
	margin-top: 3rem;
	padding: 3rem 0;
}

.amp-wp-footer .site-info {
	position: relative;
	padding-right: 20px;
	padding-left: 20px;
	margin-right: auto;
	margin-left: auto;
	max-width: calc(840px - 32px);
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	flex-direction: column;
	text-align: center;
	-webkit-box-pack: justify;
	-ms-flex-pack: justify;
	justify-content: space-between;
}

@media (min-width: 760px) {
	.amp-wp-footer .site-info {
		flex-direction: row;
		text-align: initial;
	}
}

.amp-wp-footer .footer-title {
	margin: 0;
}

.amp-wp-footer p {
	font-size: .8em;
	margin: 0;
}

.amp-wp-footer a {
	color: <?php echo esc_html( csco_light_or_dark( $color_footer_bg, $muted_text_color ) ); ?>;
}

.amp-wp-footer a:hover {
	text-decoration: none;
}

.back-to-top {
	bottom: 1.275em;
	font-size: .8em;
	font-weight: 600;
	line-height: 2em;
	position: absolute;
	right: 16px;
}


/* Background Dark */
.cs-bg-dark {
	color: rgba(255, 255, 255, 0.75);
}

.cs-bg-dark a {
	color: rgba(255, 255, 255);
}

.cs-bg-dark .site-title {
	color: #fff;
}

.cs-bg-dark.amp-wp-header {
	color: rgba(255, 255, 255, 0.75);
	-webkit-box-shadow: none;
	box-shadow: none;
}

.cs-bg-dark.amp-wp-header .site-title:hover,
.cs-bg-dark.amp-wp-header .site-title:focus {
	color: rgba(255, 255, 255, 0.75);
}

.cs-bg-dark.amp-wp-header .site-description {
	border-left-color: rgba(255, 255, 255, 0.05);
	color: rgba(255, 255, 255, 0.75);
}