<?php
/**
 * Template part for displaying category trending posts section.
 *
 * @package The Affair
 */

do_action( 'csco_category_trending_before' );

$ids = csco_get_trending_posts_ids();

if ( $ids ) {
	$args = array(
		'ignore_sticky_posts' => true,
		'post__in'            => $ids,
		'posts_per_page'      => count( $ids ),
		'orderby'             => 'post__in',
	);

	$the_query = new WP_Query( $args );
}

// Determines whether there are more posts available in the loop.
if ( $ids && $the_query->have_posts() ) {

	$prev_merge = 1;
	?>

	<section class="section-category-trending">
		<?php do_action( 'csco_category_trending_start' ); ?>

			<div class="cs-category-trending-posts">
				<div class="cs-category-trending-posts-wrap">
					<div class="cs-category-trending-header">
						<h5 class="title-trending"><?php echo esc_html( get_theme_mod( 'category_trending_posts_title', 'Trending Posts' ) ); ?></h5>
					</div>
					<div class="cs-category-trending-container cs-merge-init">
						<div class="cs-merge-carousel" data-columns="2">
							<?php
							while ( $the_query->have_posts() ) :
								$the_query->the_post();

								// Starting orientation.
								$orientation = null;

								// Set last post orientation.
								if ( ( $the_query->current_post + 1 ) === $the_query->post_count && 2 === $prev_merge ) {
									$orientation = 'landscape';
								}

								// Get attachment data.
								$attachment_data = csco_attachment_orientation_data( get_post_thumbnail_id(), false, $orientation );

								$merge = 'portrait' === $attachment_data['orientation'] ? 1 : 2;
								?>
								<div class="owl-slide cs-category-trending-post" data-merge="<?php echo esc_attr( $merge ); ?>">
									<article <?php post_class(); ?>>
										<div class="cs-overlay cs-overlay-ratio cs-bg-dark">
											<div class="cs-overlay-background">
												<?php
													the_post_thumbnail( $attachment_data['size'], array(
														'class' => 'pk-lazyload-disabled',
													) );
												?>
											</div>
											<div class="cs-overlay-content">
												<?php csco_the_post_format_icon(); ?>
												<?php csco_get_post_meta( 'category', false, true, true ); ?>
												<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
												<?php csco_get_post_meta( array( 'shares', 'views', 'author', 'date', 'comments', 'reading_time' ), false, true, true ); ?>
											</div>
											<a href="<?php the_permalink(); ?>" class="cs-overlay-link"></a>
										</div>
									</article>
								</div>
								<?php
								$prev_merge = $merge;
							endwhile;
							?>
						</div>
						<div class="owl-nav"></div>
						<div class="owl-dots"></div>
					</div>
				</div>
			</div>

			<?php wp_reset_postdata(); ?>

		<?php do_action( 'csco_category_trending_end' ); ?>

	</section>

	<?php
}

do_action( 'csco_category_trending_after' );
