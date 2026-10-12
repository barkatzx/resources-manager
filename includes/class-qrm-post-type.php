<?php
/** Resource post type registration. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Registers the resource post type. */
class QRM_Post_Type {
	/** Attach hooks. */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_filter( 'pll_get_post_types', array( __CLASS__, 'enable_polylang_support' ), 10, 2 );
	}

	/** Make resources translatable when Polylang is active. */
	public static function enable_polylang_support( $post_types, $is_settings ) {
		$post_types['qodeax_resource'] = 'qodeax_resource';
		return $post_types;
	}

	/** Register the resource post type. */
	public static function register_post_type() {
		$labels = array(
			'name'                  => __( 'Resources', 'qodeax-resources-manager' ),
			'singular_name'         => __( 'Resource', 'qodeax-resources-manager' ),
			'menu_name'             => __( 'Resources', 'qodeax-resources-manager' ),
			'add_new'               => __( 'Add New', 'qodeax-resources-manager' ),
			'add_new_item'          => __( 'Add New Resource', 'qodeax-resources-manager' ),
			'edit_item'             => __( 'Edit Resource', 'qodeax-resources-manager' ),
			'new_item'              => __( 'New Resource', 'qodeax-resources-manager' ),
			'view_item'             => __( 'View Resource', 'qodeax-resources-manager' ),
			'search_items'          => __( 'Search Resources', 'qodeax-resources-manager' ),
			'not_found'             => __( 'No resources found.', 'qodeax-resources-manager' ),
			'not_found_in_trash'    => __( 'No resources found in Trash.', 'qodeax-resources-manager' ),
			'all_items'             => __( 'All Resources', 'qodeax-resources-manager' ),
			'featured_image'        => __( 'Resource Image', 'qodeax-resources-manager' ),
			'set_featured_image'    => __( 'Set resource image', 'qodeax-resources-manager' ),
			'remove_featured_image' => __( 'Remove resource image', 'qodeax-resources-manager' ),
		);

		register_post_type(
			'qodeax_resource',
			array(
				'labels'              => $labels,
				'public'              => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'rewrite'             => false,
				'menu_icon'           => 'dashicons-portfolio',
				'supports'            => array( 'title', 'editor', 'page-attributes' ),
				'map_meta_cap'        => true,
				'capability_type'      => 'post',
				'menu_position'       => 21,
				'show_in_nav_menus'   => false,
				'delete_with_user'    => false,
				'taxonomies'          => array(),
				'can_export'          => true,
				'query_var'           => false,
				'with_front'          => false,
				'description'          => __( 'Manage resources displayed by the resources shortcode.', 'qodeax-resources-manager' ),
			)
		);
	}
}
