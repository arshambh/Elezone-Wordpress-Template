<?php
/**
 * Meta box for per-page hero banner background image.
 *
 * @package Elezone
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register page banner meta box.
 */
function elezone_add_page_banner_meta_box() {
	add_meta_box(
		'elezone_page_banner_image',
		__( 'Banner Image', 'elezone' ),
		'elezone_render_page_banner_meta_box',
		'page',
		'side',
		'default'
	);
}
add_action( 'add_meta_boxes', 'elezone_add_page_banner_meta_box' );

/**
 * Enqueue media uploader on page edit screen.
 *
 * @param string $hook Current admin page hook.
 */
function elezone_enqueue_page_banner_media( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'elezone_enqueue_page_banner_media' );

/**
 * Render page banner image meta box.
 *
 * @param WP_Post $post Current post.
 */
function elezone_render_page_banner_meta_box( $post ) {
	wp_nonce_field( 'elezone_page_banner_meta', 'elezone_page_banner_meta_nonce' );

	$image_id  = (int) get_post_meta( $post->ID, 'elezone_banner_image_id', true );
	$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'medium' ) : '';
	?>
	<div id="elezone-banner-image-box">
		<input type="hidden" id="elezone_banner_image_id" name="elezone_banner_image_id" value="<?php echo esc_attr( $image_id ); ?>">
		<div id="elezone-banner-image-preview" style="margin-bottom:10px;">
			<?php if ( $image_url ) : ?>
				<img src="<?php echo esc_url( $image_url ); ?>" alt="" style="max-width:100%;height:auto;border-radius:6px;display:block;">
			<?php endif; ?>
		</div>
		<button type="button" class="button button-secondary" id="elezone-select-banner-image"><?php esc_html_e( 'Select Banner Image', 'elezone' ); ?></button>
		<button type="button" class="button-link-delete" id="elezone-remove-banner-image" style="margin-right:8px;<?php echo $image_id ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'elezone' ); ?></button>
	</div>
	<script>
	(function($){
		var frame;
		$('#elezone-select-banner-image').on('click', function(e){
			e.preventDefault();
			if (frame) { frame.open(); return; }
			frame = wp.media({
				title: '<?php echo esc_js( __( 'Select Banner Image', 'elezone' ) ); ?>',
				button: { text: '<?php echo esc_js( __( 'Use Image', 'elezone' ) ); ?>' },
				library: { type: 'image' },
				multiple: false
			});
			frame.on('select', function(){
				var attachment = frame.state().get('selection').first().toJSON();
				$('#elezone_banner_image_id').val(attachment.id);
				var previewUrl = (attachment.sizes && attachment.sizes.medium) ? attachment.sizes.medium.url : attachment.url;
				$('#elezone-banner-image-preview').html('<img src="' + previewUrl + '" style="max-width:100%;height:auto;border-radius:6px;display:block;">');
				$('#elezone-remove-banner-image').show();
			});
			frame.open();
		});
		$('#elezone-remove-banner-image').on('click', function(e){
			e.preventDefault();
			$('#elezone_banner_image_id').val('');
			$('#elezone-banner-image-preview').empty();
			$(this).hide();
		});
	})(jQuery);
	</script>
	<?php
}

/**
 * Save page banner image meta.
 *
 * @param int $post_id Current post ID.
 */
function elezone_save_page_banner_meta( $post_id ) {
	if ( ! isset( $_POST['elezone_page_banner_meta_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['elezone_page_banner_meta_nonce'] ) ), 'elezone_page_banner_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( isset( $_POST['elezone_banner_image_id'] ) ) {
		$image_id = absint( wp_unslash( $_POST['elezone_banner_image_id'] ) );
		if ( $image_id > 0 ) {
			update_post_meta( $post_id, 'elezone_banner_image_id', $image_id );
		} else {
			delete_post_meta( $post_id, 'elezone_banner_image_id' );
		}
	}
}
add_action( 'save_post_page', 'elezone_save_page_banner_meta' );

/**
 * Resolve banner background image URL for the current view.
 *
 * @return string
 */
function elezone_get_banner_image_url() {
	$target_id = 0;

	if ( is_singular( 'page' ) ) {
		$target_id = (int) get_queried_object_id();
	} elseif ( function_exists( 'is_cart' ) && is_cart() && function_exists( 'wc_get_page_id' ) ) {
		$target_id = (int) wc_get_page_id( 'cart' );
	} elseif ( function_exists( 'is_checkout' ) && is_checkout() && function_exists( 'wc_get_page_id' ) ) {
		$target_id = (int) wc_get_page_id( 'checkout' );
	} elseif ( function_exists( 'is_shop' ) && is_shop() && function_exists( 'wc_get_page_id' ) ) {
		$target_id = (int) wc_get_page_id( 'shop' );
	}

	if ( $target_id > 0 ) {
		$image_id = (int) get_post_meta( $target_id, 'elezone_banner_image_id', true );
		if ( $image_id > 0 ) {
			$url = wp_get_attachment_image_url( $image_id, 'full' );
			if ( $url ) {
				return $url;
			}
		}
	}

	return '';
}
