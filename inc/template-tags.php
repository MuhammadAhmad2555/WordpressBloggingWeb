<?php
/**
 * Template Tags
 *
 * Functions that are called directly from template parts or within actions.
 *
 * @package The Affair
 */

if ( ! function_exists( 'csco_page_pagination' ) ) {
	/**
	 * Post Pagination
	 */
	function csco_page_pagination() {
		if ( ! is_singular() ) {
			return;
		}

		do_action( 'csco_pagination_before' );

		wp_link_pages(
			array(
				'before'           => '<div class="navigation pagination"><div class="nav-links">',
				'after'            => '</div></div>',
				'link_before'      => '<span class="page-number">',
				'link_after'       => '</span>',
				'next_or_number'   => 'next_and_number',
				'separator'        => ' ',
				'nextpagelink'     => esc_html__( 'Next page', 'the-affair' ),
				'previouspagelink' => esc_html__( 'Previous page', 'the-affair' ),
			)
		);

		do_action( 'csco_pagination_after' );
	}
}

if ( ! function_exists( 'csco_the_post_format_icon' ) ) {
	/**
	 * Post Format Icon
	 *
	 * @param string $content After content.
	 */
	function csco_the_post_format_icon( $content = '' ) {
		$post_format = get_post_format();

		if ( 'gallery' === $post_format ) {
			$attachments = get_post_meta( get_the_ID(), 'powerkit_post_format_gallery', true );

			$content = $attachments ? sprintf( '<span>%s</span>', count( $attachments ) ) : '';
		}

		if ( $post_format ) {
		?>
		<span class="post-format-icon">
			<a class="cs-format-<?php echo esc_attr( $post_format ); ?>" href="<?php the_permalink(); ?>">
				<?php echo wp_kses( $content, 'post' ); ?>
			</a>
		</span>
		<?php
		}
	}
}

if ( ! function_exists( 'csco_post_tags' ) ) {
	/**
	 * Post Tags
	 */
	function csco_post_tags() {
		if ( ! is_single() ) {
			return;
		}

		if ( false === get_theme_mod( 'post_tags', true ) ) {
			return;
		}

		the_tags( '<section class="post-tags"><ul><li>', '</li><li>', '</li></ul></section>' );
	}
}

if ( ! function_exists( 'csco_archive_post_description' ) ) {
	/**
	 * Post Description in Archive Pages
	 */
	function csco_archive_post_description() {
		$description = get_the_archive_description();
		if ( $description ) {
			?>
			<div class="archive-description">
				<?php echo do_shortcode( $description ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'csco_archive_post_count' ) ) {
	/**
	 * Post Count in Archive Pages
	 */
	function csco_archive_post_count() {
		global $wp_query;
		$found_posts = $wp_query->found_posts;
		?>
		<div class="archive-count">
			<?php
			/* translators: 1: Singular, 2: Plural. */
			echo esc_html( apply_filters( 'csco_article_full_count', sprintf( _n( '%s post', '%s posts', $found_posts, 'the-affair' ), $found_posts ), $found_posts ) );
			?>
		</div>
	<?php
	}
}

if ( ! function_exists( 'csco_post_author' ) ) {
	/**
	 * Post Author Details
	 *
	 * @param int $id Author ID.
	 */
	function csco_post_author( $id = null ) {
		if ( ! $id ) {
			$id = get_the_author_meta( 'ID' );
		}

		$tag = apply_filters( 'csco_section_title_tag', 'h5' );
		?>
		<div class="author-wrap">
			<div class="author">
				<div class="author-avatar">
					<a href="<?php echo esc_url( get_author_posts_url( $id ) ); ?>" rel="author">
						<?php echo get_avatar( $id, '120' ); ?>
					</a>
				</div>
				<div class="author-data">
					<<?php echo esc_html( $tag ); ?> class="title-author">
						<span class="fn">
							<a href="<?php echo esc_url( get_author_posts_url( $id ) ); ?>" rel="author">
								<?php the_author_meta( 'display_name', $id ); ?>
							</a>
						</span>
					</<?php echo esc_html( $tag ); ?>>
					<?php
					if ( csco_powerkit_module_enabled( 'social_links' ) ) {
						powerkit_author_social_links( $id );
					}
					?>
				</div>
				<div class="author-description">
					<p class="note"><?php the_author_meta( 'description', $id ); ?></p>
				</div>
			</div>
		</div>
	<?php
	}
}

if ( ! function_exists( 'csco_wrap_entry_content' ) ) {
	/**
	 * Wrap .entry-content content in div with a class.
	 *
	 * Used for floated share buttons on single posts.
	 */
	function csco_wrap_entry_content() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		if ( ! csco_has_post_meta( 'author' ) && ! csco_has_post_meta( 'category' )
			&& ! ( csco_powerkit_module_enabled( 'share_buttons' ) && powerkit_share_buttons_exists( 'post_sidebar' ) ) ) {
			return;
		}

		if ( 'csco_post_content_before' === current_filter() ) {
			?>
			<div class="entry-container">
				<div class="entry-sidebar-wrap">
					<div class="entry-sidebar">
						<div class="entry-sidebar-inner">
							<?php do_action( 'csco_post_sidebar_start' ); ?>

							<?php if ( csco_powerkit_module_enabled( 'share_buttons' ) && powerkit_share_buttons_exists( 'post_sidebar' ) ) : ?>
								<section class="post-share-buttons">
									<?php powerkit_share_buttons_location( 'post_sidebar' ); ?>
								</section>
							<?php endif; ?>

							<?php do_action( 'csco_post_sidebar_end' ); ?>
						</div>
					</div>
				</div>
			<?php
		} else {
			?>
			</div>
			<?php
		}
	}
}
