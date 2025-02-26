<?php
/**
 * Adding Custom Meta Boxes.
 *
 * @package The Affair
 */

/**
 * Check display metabox layout options
 */
function csco_mb_display_layout_options() {
	// Check Coming Soon Page.
	if ( csco_powerkit_module_enabled( 'coming_soon' ) && powerkit_coming_soon_status() ) {

		$page_id = get_option( 'powerkit_coming_soon_page' );

		if ( (int) get_the_ID() === (int) $page_id ) {
			return;
		}
	}

	return true;
}

/**
 * ==================================
 * Layout Options
 * ==================================
 */

/**
 * Add new meta box
 */
function csco_mb_layout_options() {
	if ( ! csco_mb_display_layout_options() ) {
		return;
	}

	$function = sprintf( 'add_meta_%s', 'box' );

	$function( 'csco_mb_layout_options', esc_html__( 'Layout Options', 'the-affair' ), 'csco_mb_layout_options_callback', array( 'post', 'page', 'product' ), 'side' );
}
add_action( sprintf( 'add_meta_%s', 'boxes' ), 'csco_mb_layout_options' );

/**
 * Callback meta box
 *
 * @param object $post The post object.
 */
function csco_mb_layout_options_callback( $post ) {

	wp_nonce_field( 'layout_options', 'csco_mb_layout_options' );

	$sidebar       = get_post_meta( $post->ID, 'csco_singular_sidebar', true );
	$layout        = get_post_meta( $post->ID, 'csco_singular_layout', true );
	$cover_bg      = get_post_meta( $post->ID, 'csco_post_cover_bg', true );
	$load_nextpost = get_post_meta( $post->ID, 'csco_post_load_nextpost', true );

	// Set Default.
	$sidebar       = $sidebar ? $sidebar : 'default';
	$layout        = $layout ? $layout : 'default';
	$cover_bg      = $cover_bg ? $cover_bg : 'default';
	$load_nextpost = $load_nextpost ? $load_nextpost : 'default';
	?>
		<h4><?php esc_html_e( 'Page Layout', 'the-affair' ); ?></h4>
		<select name="csco_singular_layout" id="csco_singular_layout" class="regular-text">
			<option value="default" <?php selected( 'default', $layout ); ?>> <?php esc_html_e( 'Default', 'the-affair' ); ?></option>
			<option value="fullwidth" <?php selected( 'fullwidth', $layout ); ?>> <?php esc_html_e( 'Fullwidth', 'the-affair' ); ?></option>
			<option value="boxed" <?php selected( 'boxed', $layout ); ?>> <?php esc_html_e( 'Boxed', 'the-affair' ); ?></option>
		</select>

		<h4><?php esc_html_e( 'Sidebar', 'the-affair' ); ?></h4>
		<select name="csco_singular_sidebar" id="csco_singular_sidebar" class="regular-text">
			<option value="default" <?php selected( 'default', $sidebar ); ?>> <?php esc_html_e( 'Default', 'the-affair' ); ?></option>
			<option value="right" <?php selected( 'right', $sidebar ); ?>> <?php esc_html_e( 'Right Sidebar', 'the-affair' ); ?></option>
			<option value="left" <?php selected( 'left', $sidebar ); ?>> <?php esc_html_e( 'Left Sidebar', 'the-affair' ); ?></option>
			<option value="disabled" <?php selected( 'disabled', $sidebar ); ?>> <?php esc_html_e( 'No Sidebar', 'the-affair' ); ?></option>
		</select>

		<?php if ( 'post' === get_post_type( $post->ID ) ) : ?>
			<h4><?php esc_html_e( 'Auto Load Next Post', 'the-affair' ); ?></h4>
			<select name="csco_post_load_nextpost" id="csco_post_load_nextpost" class="regular-text">
				<option value="default" <?php selected( 'default', $load_nextpost ); ?>> <?php esc_html_e( 'Default', 'the-affair' ); ?></option>
				<option value="enabled" <?php selected( 'enabled', $load_nextpost ); ?>> <?php esc_html_e( 'Enabled', 'the-affair' ); ?></option>
				<option value="disabled" <?php selected( 'disabled', $load_nextpost ); ?>> <?php esc_html_e( 'Disabled', 'the-affair' ); ?></option>
			</select>

			<h4><label for="csco_post_cover_bg"><?php esc_html_e( 'Cover Background', 'the-affair' ); ?></label></h4>
			<select name="csco_post_cover_bg" id="csco_post_cover_bg" class="regular-text">
				<option value="default" <?php selected( 'default', $cover_bg ); ?>><?php esc_html_e( 'Default', 'the-affair' ); ?></option>
				<option value="brand" <?php selected( 'brand', $cover_bg ); ?>><?php esc_html_e( 'Brand', 'the-affair' ); ?></option>
				<option value="primary" <?php selected( 'primary', $cover_bg ); ?>><?php esc_html_e( 'Primary', 'the-affair' ); ?></option>
				<option value="secondary" <?php selected( 'secondary', $cover_bg ); ?>><?php esc_html_e( 'Secondary', 'the-affair' ); ?></option>
			</select>
		<?php endif; ?>
	<?php
}

/**
 * Save meta box
 *
 * @param int $post_id The post id.
 */
function csco_mb_layout_options_save( $post_id ) {

	// Bail if we're doing an auto save.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// if our nonce isn't there, or we can't verify it, bail.
	if ( ! isset( $_POST['csco_mb_layout_options'] ) || ! wp_verify_nonce( $_POST['csco_mb_layout_options'], 'layout_options' ) ) { // Input var ok; sanitization ok.
		return;
	}

	if ( isset( $_POST['csco_singular_layout'] ) ) { // Input var ok; sanitization ok.
		$layout = sanitize_text_field( $_POST['csco_singular_layout'] ); // Input var ok; sanitization ok.

		update_post_meta( $post_id, 'csco_singular_layout', $layout );
	}

	if ( isset( $_POST['csco_singular_sidebar'] ) ) { // Input var ok; sanitization ok.
		$sidebar = sanitize_text_field( $_POST['csco_singular_sidebar'] ); // Input var ok; sanitization ok.

		update_post_meta( $post_id, 'csco_singular_sidebar', $sidebar );
	}

	if ( isset( $_POST['csco_post_cover_bg'] ) ) { // Input var ok; sanitization ok.
		$sidebar = sanitize_text_field( $_POST['csco_post_cover_bg'] ); // Input var ok; sanitization ok.

		update_post_meta( $post_id, 'csco_post_cover_bg', $sidebar );
	}

	if ( isset( $_POST['csco_post_load_nextpost'] ) ) { // Input var ok; sanitization ok.
		$load_nextpost = sanitize_text_field( $_POST['csco_post_load_nextpost'] ); // Input var ok; sanitization ok.

		update_post_meta( $post_id, 'csco_post_load_nextpost', $load_nextpost );
	}
}
add_action( 'save_post', 'csco_mb_layout_options_save' );


/**
 * ==================================
 * Category Options
 * ==================================
 */

/**
 * Add fields to Category
 *
 * @param string $taxonomy The taxonomy slug.
 */
function csco_mb_category_options_add( $taxonomy ) {
	wp_nonce_field( 'category_options', 'csco_mb_category_options' );
	?>
		<h2><?php esc_html_e( 'Category Options', 'the-affair' ); ?></h2>
		<div class="form-field">
			<div class="category-upload-image upload-img-container" data-frame-title="<?php esc_html_e( 'Select or upload image', 'the-affair' ); ?>" data-frame-btn-text="<?php esc_html_e( 'Set image', 'the-affair' ); ?>">
				<p class="uploaded-img-box">
					<span class="uploaded-image"></span>
					<input id="csco_header_image" class="uploaded-img-id" name="csco_header_image" type="hidden"/>
				</p>
				<p class="hide-if-no-js">
					<a class="upload-img-link button button-primary" href="#"><?php esc_html_e( 'Upload image', 'the-affair' ); ?></a>
					<a class="delete-img-link button button-secondary hidden" href="#"><?php esc_html_e( 'Remove image', 'the-affair' ); ?></a>
				</p>
			</div>
			<br><hr><br>
		</div>
	<?php
}
add_action( 'category_add_form_fields', 'csco_mb_category_options_add', 10 );

/**
 * Edit fields from Category
 *
 * @param object $tag      Current taxonomy term object.
 * @param string $taxonomy Current taxonomy slug.
 */
function csco_mb_category_options_edit( $tag, $taxonomy ) {
	wp_nonce_field( 'category_options', 'csco_mb_category_options' );

	$csco_header_image = get_term_meta( $tag->term_id, 'csco_header_image', true );

	$csco_header_image_url = wp_get_attachment_image_url( $csco_header_image, 'large' );
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="csco_header_image"><?php esc_html_e( 'Header Image', 'the-affair' ); ?></label></th>
		<td>
			<div class="category-upload-image upload-img-container" data-frame-title="<?php esc_html_e( 'Select or upload image', 'the-affair' ); ?>" data-frame-btn-text="<?php esc_html_e( 'Set image', 'the-affair' ); ?>">
				<p class="uploaded-img-box">
					<span class="uploaded-image">
						<?php if ( $csco_header_image_url ) : ?>
							<img src="<?php echo esc_url( $csco_header_image_url ); ?>" style="max-width:100%;" />
						<?php endif; ?>
					</span>

					<input id="csco_header_image" class="uploaded-img-id" name="csco_header_image" type="hidden" value="<?php echo esc_attr( $csco_header_image ); ?>" />
				</p>
				<p class="hide-if-no-js">
					<a class="upload-img-link button button-primary <?php echo esc_attr( $csco_header_image_url ? 'hidden' : '' ); ?>" href="#"><?php esc_html_e( 'Upload image', 'the-affair' ); ?></a>
					<a class="delete-img-link button button-secondary <?php echo esc_attr( ! $csco_header_image_url ? 'hidden' : '' ); ?>" href="#"><?php esc_html_e( 'Remove image', 'the-affair' ); ?></a>
				</p>
			</div>
		</td>
	</tr>
	<?php
}
add_action( 'category_edit_form_fields', 'csco_mb_category_options_edit', 10, 2 );

/**
 * Save meta box
 *
 * @param int    $term_id  ID of the term about to be edited.
 * @param string $taxonomy Taxonomy slug of the related term.
 */
function csco_mb_category_options_save( $term_id, $taxonomy ) {

	// Bail if we're doing an auto save.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// if our nonce isn't there, or we can't verify it, bail.
	if ( ! isset( $_POST['csco_mb_category_options'] ) || ! wp_verify_nonce( $_POST['csco_mb_category_options'], 'category_options' ) ) { // Input var ok; sanitization ok.
		return;
	}

	if ( isset( $_POST['csco_header_image'] ) ) { // Input var ok; sanitization ok.
		$csco_header_image = sanitize_text_field( $_POST['csco_header_image'] ); // Input var ok; sanitization ok.

		update_term_meta( $term_id, 'csco_header_image', $csco_header_image );
	}
}
add_action( 'created_category', 'csco_mb_category_options_save', 10, 2 );
add_action( 'edited_category', 'csco_mb_category_options_save', 10, 2 );

/**
 * Meta box Enqunue Scripts
 *
 * @param string $page Current page.
 */
function csco_mb_category_enqueue_scripts( $page ) {

	if ( 'edit-tags.php' === $page || 'term.php' === $page ) {
		wp_enqueue_script( 'jquery' );

		wp_enqueue_media();

		ob_start();
		?>
		<script>
		jQuery( document ).ready(function( $ ) {

			var powerkitMediaFrame;
			/* Set all variables to be used in scope */
			var metaBox = '.category-upload-image';

			/* Add Image Link */
			$( metaBox ).find( '.upload-img-link' ).on( 'click', function( event ){
				event.preventDefault();

				var parentContainer = $( this ).parents( metaBox );

				// Options.
				var options = {
					title: parentContainer.data( 'frame-title' ) ? parentContainer.data( 'frame-title' ) : 'Select or Upload Media',
					button: {
						text: parentContainer.data( 'frame-btn-text' ) ? parentContainer.data( 'frame-btn-text' ) : 'Use this media',
					},
					library : { type : 'image' },
					multiple: false // Set to true to allow multiple files to be selected.
				};

				// Create a new media frame
				powerkitMediaFrame = wp.media( options );

				// When an image is selected in the media frame...
				powerkitMediaFrame.on( 'select', function() {

					// Get media attachment details from the frame state.
					var attachment = powerkitMediaFrame.state().get('selection').first().toJSON();

					// Send the attachment URL to our custom image input field.
					parentContainer.find( '.uploaded-image' ).html( '<img src="' + attachment.url + '" style="max-width:100%;"/>' );
					parentContainer.find( '.uploaded-img-id' ).val( attachment.id ).change();
					parentContainer.find( '.upload-img-link' ).addClass( 'hidden' );
					parentContainer.find( '.delete-img-link' ).removeClass( 'hidden' );

					powerkitMediaFrame.close();
				});

				// Finally, open the modal on click.
				powerkitMediaFrame.open();
			});


			/* Delete Image Link */
			$( metaBox ).find( '.delete-img-link' ).on( 'click', function( event ){
				event.preventDefault();

				$( this ).parents( metaBox ).find( '.uploaded-image' ).html( '' );
				$( this ).parents( metaBox ).find( '.upload-img-link' ).removeClass( 'hidden' );
				$( this ).parents( metaBox ).find( '.delete-img-link' ).addClass( 'hidden' );
				$( this ).parents( metaBox ).find( '.uploaded-img-id' ).val( '' ).change();
			});
		});

		jQuery( document ).ajaxSuccess(function(e, request, settings){
			let action   = settings.data.indexOf( 'action=add-tag' );
			let screen   = settings.data.indexOf( 'screen=edit-category' );
			let taxonomy = settings.data.indexOf( 'taxonomy=category' );

			if( action > -1 && screen > -1 && taxonomy > -1 ){
				$( '.delete-img-link' ).click();
			}
		});
		</script>
		<?php
		wp_add_inline_script( 'jquery', str_replace( array( '<script>', '</script>' ), '', ob_get_clean() ) );
	}
}
add_action( 'admin_enqueue_scripts', 'csco_mb_category_enqueue_scripts' );
