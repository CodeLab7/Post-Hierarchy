<?php

class Posthierarchy_CustomPost extends Posthierarchy_Abstruct {

	private $taxonomy;
	private $post_type;
	private $new_post_type;

	public function create_cate( $name, $post_type = false ) {
		$this->taxonomy[] = [
			'name'      => $name,
			'slug'      => sanitize_title( $name ),
			'post_type' => ( $post_type ) ? $post_type : $this->post_type,
			'config'    => [ 'hierarchical' => true ]
		];
	}

	public function create_tag( $name, $post_type = false ) {
		$this->taxonomy[] = [
			'name'      => $name,
			'slug'      => sanitize_title( $name ),
			'post_type' => ( $post_type ) ? $post_type : $this->post_type,
			'config'    => [ 'hierarchical' => false ]
		];
	}

	public function create_custom_post( $name, $config = [] ) {
		$this->new_post_type[] = [
			'name'   => $name,
			'slug'   => sanitize_title( $name ),
			'config' => $config
		];
		$this->post_type = sanitize_title( $name );
	}

	public function create_custom_page( $name ) {
		$this->new_post_type[] = [
			'name'   => $name,
			'slug'   => sanitize_title( $name ),
			'config' => [
				'capability_type' => 'page',
				'hierarchical'    => true,
				array( 'page-attributes' )
			]
		];

		$this->post_type = sanitize_title( $name );
	}

	public function set_post_type( $post_type ) {
		$this->post_type = $post_type;
	}

	public function register() {
		foreach ( $this->taxonomy as $taxonomy ) {
			$this->_register_taxonomy( $taxonomy['name'], $taxonomy['slug'], $taxonomy['post_type'], $taxonomy['config'] );
		}

		foreach ( $this->new_post_type as $post_type ) {
			$this->_register_post_type( $post_type['name'], $post_type['slug'], $post_type['config'] );
		}

	}

	private function _register_taxonomy( $name, $slug, $post_type, $config ) {
		$labels = array(
			'name'                       => $name,
			'singular_name'              => $name,
			'menu_name'                  => $name,
			'all_items'                  => 'All ' . $name,
			'parent_item'                => 'Parent ' . $name,
			'parent_item_colon'          => 'Parent ' . $name . ':',
			'new_item_name'              => 'New ' . $name,
			'add_new_item'               => 'Add New ' . $name,
			'edit_item'                  => 'Edit ' . $name,
			'update_item'                => 'Update ' . $name,
			'view_item'                  => 'View ' . $name,
			'separate_items_with_commas' => 'Separate ' . $name . ' with commas',
			'add_or_remove_items'        => 'Add or remove ' . $name,
			'choose_from_most_used'      => 'Choose from the most used',
			'popular_items'              => 'Popular ' . $name,
			'search_items'               => 'Search ' . $name,
			'not_found'                  => 'Not Found',
			'no_terms'                   => 'No ' . $name,
			'items_list'                 => 'Items list',
			'items_list_navigation'      => 'Items list navigation',
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => true,
		);
		register_taxonomy( $slug, $post_type, array_replace( $args, $config ) );
	}

	/**
	 * Todo:Register Post type
	 */
	private function _register_post_type( $name, $slug, $config ) {

		$labels = array(
			'name'                  => $name,
			'singular_name'         => $name,
			'menu_name'             => $name,
			'name_admin_bar'        => $name,
			'archives'              => $name . ' Archives',
			'attributes'            => $name . ' Attributes',
			'parent_item_colon'     => 'Parent Item:',
			'all_items'             => 'All ' . $name,
			'add_new_item'          => 'Add New ' . $name,
			'add_new'               => 'Add New',
			'new_item'              => 'New ' . $name,
			'edit_item'             => 'Edit ' . $name,
			'update_item'           => 'Update ' . $name,
			'view_item'             => 'View ' . $name,
			'view_items'            => 'View Items',
			'search_items'          => 'Search ' . $name,
			'not_found'             => 'Not found',
			'not_found_in_trash'    => 'Not found in Trash',
			'featured_image'        => 'Featured Image',
			'set_featured_image'    => 'Set featured image',
			'remove_featured_image' => 'Remove featured image',
			'use_featured_image'    => 'Use as featured image',
			'insert_into_item'      => 'Insert in ' . $name,
			'uploaded_to_this_item' => 'Uploaded to this ' . $name,
			'items_list'            => $name . ' list',
			'items_list_navigation' => $name . ' list navigation',
			'filter_items_list'     => 'Filter items list',
		);
		$args   = array(
			'label'               => $name,
			'description'         => 'Special Posts for ' . $name,
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'post-formats' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( $slug, array_replace( $args, $config ) );
	}

}