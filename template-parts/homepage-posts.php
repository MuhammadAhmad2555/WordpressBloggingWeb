<?php
/**
 * Template part for displaying homepage posts section.
 *
 * @package The Affair
 */

do_action( 'csco_homepage_posts_before' );

$ids = csco_get_homepage_posts_ids();

if ( $ids ) {
	$args = array(
		'ignore_sticky_posts' => true,
		'post__in'            => $ids,
		'posts_per_page'      => count( $ids ),
		'post_type'           => array( 'post', 'page' ),
		'orderby'             => 'post__in',
	);

	$the_query = new WP_Query( $args );
}

// Determines whether there are more posts available in the loop.
if ( $ids && $the_query->have_posts() ) {

	// Set columns.
	$posts_columns = get_theme_mod( 'featured_posts_columns', 3 );

	// Set thumb size.
	$thumb_slug = 'cs-thumbnail';

	if ( 'fullwidth' === csco_get_page_layout() ) {
		$thumb_slug = 'cs-large';
	} elseif ( 'disabled' === csco_get_page_sidebar() ) {
		$thumb_slug = 'cs-medium';
	}

	// Set thumb size by orientation.
	$posts_thumb_size = $thumb_slug . '-portrait';

	if ( 1 === (int) $posts_columns ) {
		$posts_thumb_size = $thumb_slug . '-landscape';
	}
	if ( 2 === (int) $posts_columns ) {
		$posts_thumb_size = $thumb_slug . '-square';
	}
	?>

	<div class="section-homepage-posts">

		<?php do_action( 'csco_homepage_posts_start' ); ?>

			<div class="cs-homepage-posts cs-merge-init">
				<div class="cs-merge-carousel" data-columns="<?php echo esc_attr( $posts_columns ); ?>">
					<?php
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						?>
						<div class="owl-slide cs-homepage-post" data-merge="1">
							<article <?php post_class(); ?>>
								<div class="cs-overlay cs-overlay-ratio cs-bg-dark">
									<div class="cs-overlay-background">
										<?php
										the_post_thumbnail( $posts_thumb_size, array(
											'class' => 'pk-lazyload-disabled',
										) );
										?>
									</div>
									<div class="cs-overlay-content">
										<?php csco_the_post_format_icon(); ?>
										<?php
										if ( 'post' === get_post_type() ) {
											csco_get_post_meta( 'category', false, true, true );
										}
										?>
										<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
										<?php
										if ( 'post' === get_post_type() ) {
											csco_get_post_meta( array( 'shares', 'views', 'author', 'date', 'comments', 'reading_time' ), false, true, true );
										}
										?>
									</div>
									<a href="<?php the_permalink(); ?>" class="cs-overlay-link"></a>
								</div>
							</article>
						</div>
						<?php
					endwhile;
					?>
				</div>
				<div class="owl-nav"></div>
				<div class="owl-dots"></div>
			</div>

			<?php wp_reset_postdata(); ?>

		<?php do_action( 'csco_homepage_posts_end' ); ?>

	</div>

	<?php
}

do_action( 'csco_homepage_posts_after' );
