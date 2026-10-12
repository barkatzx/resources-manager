<?php
/** Frontend shortcode rendering. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Renders the resources grid. */
class QRM_Shortcode {
	/** Attach shortcode hook. */
	public static function init() {
		add_shortcode( 'qodeax_resources', array( __CLASS__, 'render' ) );
	}

	/** Render published resources. */
	public static function render( $attributes ) {
		$attributes = shortcode_atts( array( 'limit' => '0' ), $attributes, 'qodeax_resources' );
		$limit      = ctype_digit( (string) $attributes['limit'] ) ? (int) $attributes['limit'] : 0;
		$args       = array(
			'post_type'              => 'qodeax_resource',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit > 0 ? min( $limit, 1000 ) : -1,
			'orderby'                => array( 'meta_value_num' => 'ASC', 'date' => 'ASC', 'title' => 'ASC' ),
			'meta_key'               => '_qrm_display_order',
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => false,
		);
		if ( function_exists( 'pll_current_language' ) ) {
			$language = pll_current_language( 'slug' );
			if ( is_string( $language ) && '' !== $language ) {
				$args['lang'] = $language;
			}
		}
		$query = new WP_Query( $args );
		if ( ! $query->have_posts() ) {
			return '';
		}
		wp_enqueue_style( 'qrm-frontend', QRM_PLUGIN_URL . 'assets/css/frontend.css', array(), QRM_VERSION );
		$output     = '<div class="qrm-resources">';
		while ( $query->have_posts() ) {
			$query->the_post();
			$post_id = get_the_ID();
			$title   = get_the_title( $post_id );
			$content = get_post_field( 'post_content', $post_id );
			$output .= '<article class="qrm-card">';
			$output .= '<h2 class="qrm-card__title">' . esc_html( $title ) . '</h2>';
			if ( '' !== trim( $content ) ) {
				$output .= '<div class="qrm-card__description">' . wp_kses_post( apply_filters( 'the_content', $content ) ) . '</div>';
			}
			$buttons = '';
			foreach ( array( 1, 2 ) as $number ) {
				$text = get_post_meta( $post_id, '_qrm_button_' . $number . '_text', true );
				$url  = get_post_meta( $post_id, '_qrm_button_' . $number . '_url', true );
				$url  = esc_url( $url );
				if ( '' !== $text && '' !== $url ) {
					$button_class = 'qrm-button qrm-button--' . $number;
					$icon         = 2 === $number ? '<svg class="qrm-button__icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M21.9 4.2 18.6 20c-.2 1.1-.9 1.4-1.8.9l-5-3.7-2.4 2.3c-.3.3-.5.5-1 .5l.4-5.1 9.3-8.4c.4-.4-.1-.6-.6-.2L6 13.5 1.1 12c-1.1-.3-1.1-1 .2-1.5L20.4 3c.9-.3 1.7.2 1.5 1.2Z"/></svg>' : '';
					$buttons     .= '<a class="' . esc_attr( $button_class ) . '" href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $icon . '<span>' . esc_html( $text ) . '</span></a>';
				}
			}
			if ( '' !== $buttons ) {
				$output .= '<div class="qrm-card__buttons">' . $buttons . '</div>';
			}
			$output .= '</article>';
		}
		wp_reset_postdata();
		$output .= '</div>';
		return $output;
	}
}
