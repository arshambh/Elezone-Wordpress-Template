<?php
/**
 * Meta box for project details (duration, city, area, stone).
 *
 * @package ArshamDecor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the project details meta box.
 */
function arsham_add_project_meta_box() {
	add_meta_box(
		'arsham_project_details',
		__( 'Project Details', 'arshamdecor' ),
		'arsham_render_project_meta_box',
		'project',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'arsham_add_project_meta_box' );

/**
 * Render the meta box fields.
 *
 * @param WP_Post $post Current post.
 */
function arsham_render_project_meta_box( $post ) {
	wp_nonce_field( 'arsham_project_meta', 'arsham_project_meta_nonce' );

	$duration = get_post_meta( $post->ID, 'project_duration', true );
	$city     = get_post_meta( $post->ID, 'project_city', true );
	$area     = get_post_meta( $post->ID, 'project_area', true );
	$stone    = get_post_meta( $post->ID, 'project_stone', true );
	?>
	<p>
		<label for="project_duration"><strong><?php esc_html_e( 'Duration (days)', 'arshamdecor' ); ?></strong></label><br>
		<input type="text" id="project_duration" name="project_duration" value="<?php echo esc_attr( $duration ); ?>" class="widefat">
	</p>
	<p>
		<label for="project_city"><strong><?php esc_html_e( 'City (interior projects only)', 'arshamdecor' ); ?></strong></label><br>
		<input type="text" id="project_city" name="project_city" value="<?php echo esc_attr( $city ); ?>" class="widefat">
	</p>
	<p>
		<label for="project_area"><strong><?php esc_html_e( 'Area (m², interior projects only)', 'arshamdecor' ); ?></strong></label><br>
		<input type="text" id="project_area" name="project_area" value="<?php echo esc_attr( $area ); ?>" class="widefat">
	</p>
	<p>
		<label for="project_stone"><strong><?php esc_html_e( 'Stone type (facade projects only)', 'arshamdecor' ); ?></strong></label><br>
		<input type="text" id="project_stone" name="project_stone" value="<?php echo esc_attr( $stone ); ?>" class="widefat">
	</p>
	<?php
}

/**
 * Save meta box values.
 *
 * @param int $post_id Current post ID.
 */
function arsham_save_project_meta( $post_id ) {
	if ( ! isset( $_POST['arsham_project_meta_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['arsham_project_meta_nonce'] ) ), 'arsham_project_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array( 'project_duration', 'project_city', 'project_area', 'project_stone' );
	foreach ( $fields as $field ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
}
add_action( 'save_post_project', 'arsham_save_project_meta' );
