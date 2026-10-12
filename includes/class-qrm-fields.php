<?php
/** Resource metadata fields. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Adds and saves resource button metadata and display order. */
class QRM_Fields {
	/** Attach hooks. */
	public static function init() {
		add_action( 'add_meta_boxes_qodeax_resource', array( __CLASS__, 'add_meta_box' ) );
		add_action( 'save_post_qodeax_resource', array( __CLASS__, 'save_meta' ) );
		add_filter( 'manage_qodeax_resource_posts_columns', array( __CLASS__, 'columns' ) );
		add_action( 'manage_qodeax_resource_posts_custom_column', array( __CLASS__, 'column_content' ), 10, 2 );
	}

	/** Add the metadata editor. */
	public static function add_meta_box() {
		add_meta_box(
			'qrm_resource_details',
			__( 'Resource Buttons and Display Order', 'qodeax-resources-manager' ),
			array( __CLASS__, 'render_meta_box' ),
			'qodeax_resource',
			'normal',
			'default'
		);
	}

	/** Render fields. */
	public static function render_meta_box( $post ) {
		wp_nonce_field( 'qrm_save_resource', 'qrm_resource_nonce' );
		$fields = array(
			'button_1_text' => __( 'Button 1 Text', 'qodeax-resources-manager' ),
			'button_1_url'  => __( 'Button 1 URL', 'qodeax-resources-manager' ),
			'button_2_text' => __( 'Button 2 Text', 'qodeax-resources-manager' ),
			'button_2_url'  => __( 'Button 2 URL', 'qodeax-resources-manager' ),
		);
		foreach ( $fields as $key => $label ) {
			$value = get_post_meta( $post->ID, '_qrm_' . $key, true );
			$type  = false !== strpos( $key, '_url' ) ? 'url' : 'text';
			printf(
				'<p><label for="qrm_%1$s"><strong>%2$s</strong></label><br><input class="widefat" type="%3$s" id="qrm_%1$s" name="qrm_%1$s" value="%4$s"%5$s></p>',
				esc_attr( $key ),
				esc_html( $label ),
				esc_attr( $type ),
				esc_attr( $value ),
				'url' === $type ? ' maxlength="2048"' : ' maxlength="120"'
			);
		}
		$order = get_post_meta( $post->ID, '_qrm_display_order', true );
		printf(
			'<p><label for="qrm_display_order"><strong>%1$s</strong></label><br><input type="number" min="0" step="1" id="qrm_display_order" name="qrm_display_order" value="%2$s"></p>',
			esc_html__( 'Display Order', 'qodeax-resources-manager' ),
			esc_attr( '' === $order ? '0' : $order )
		);
		echo '<p>' . esc_html__( 'The description is entered in the main editor. Lower display order values appear first.', 'qodeax-resources-manager' ) . '</p>';
	}

	/** Save submitted metadata after checking authorization and nonce. */
	public static function save_meta( $post_id ) {
		if ( ! isset( $_POST['qrm_resource_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qrm_resource_nonce'] ) ), 'qrm_save_resource' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( array( 'button_1_text', 'button_2_text' ) as $key ) {
			$name  = 'qrm_' . $key;
			$value = isset( $_POST[ $name ] ) ? sanitize_text_field( wp_unslash( $_POST[ $name ] ) ) : '';
			if ( '' !== $value ) {
				update_post_meta( $post_id, '_qrm_' . $key, $value );
			} else {
				delete_post_meta( $post_id, '_qrm_' . $key );
			}
		}
		foreach ( array( 'button_1_url', 'button_2_url' ) as $key ) {
			$name  = 'qrm_' . $key;
			$value = isset( $_POST[ $name ] ) ? esc_url_raw( wp_unslash( $_POST[ $name ] ) ) : '';
			if ( '' !== $value ) {
				update_post_meta( $post_id, '_qrm_' . $key, $value );
			} else {
				delete_post_meta( $post_id, '_qrm_' . $key );
			}
		}
		$order = isset( $_POST['qrm_display_order'] ) ? absint( wp_unslash( $_POST['qrm_display_order'] ) ) : 0;
		update_post_meta( $post_id, '_qrm_display_order', $order );
	}

	/** Add an order column to the resource list. */
	public static function columns( $columns ) {
		$columns['qrm_order'] = __( 'Display Order', 'qodeax-resources-manager' );
		return $columns;
	}

	/** Render the order column. */
	public static function column_content( $column, $post_id ) {
		if ( 'qrm_order' === $column ) {
			echo esc_html( (string) get_post_meta( $post_id, '_qrm_display_order', true ) );
		}
	}
}
