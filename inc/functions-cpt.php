<?php
/**
 * Registers the custom post types
 *
 * @package    SidebarWidgetBlocks
 * @subpackage Includes
 * @author     Press Cargo
 * @copyright  Copyright (c) 2018, Press Cargo
 * @link       https://presscargo.io/plugins/sidebar-widget-blocks
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

add_action( 'init', 'sidebar_widget_blocks_custom_post_type' );

/**
 * Register Post Types.
 *
 * @since  1.0.0
 * @access public
 */
function sidebar_widget_blocks_custom_post_type() {
	/*
	 * Register Sidebars
	 */
	$labels = array(
		'name'                  => _x( 'Sidebars', 'Post Type General Name', 'sidebar-widget-blocks' ),
		'singular_name'         => _x( 'Sidebar', 'Post Type Singular Name', 'sidebar-widget-blocks' ),
		'menu_name'             => __( 'Sidebars', 'sidebar-widget-blocks' ),
		'name_admin_bar'        => __( 'Sidebars', 'sidebar-widget-blocks' ),
		'archives'              => __( 'Sidebar Archives', 'sidebar-widget-blocks' ),
		'attributes'            => __( 'Sidebar Attributes', 'sidebar-widget-blocks' ),
		'parent_item_colon'     => __( 'Parent Sidebar:', 'sidebar-widget-blocks' ),
		'all_items'             => __( 'All Sidebars', 'sidebar-widget-blocks' ),
		'add_new_item'          => __( 'Add New Sidebar', 'sidebar-widget-blocks' ),
		'add_new'               => __( 'Add New', 'sidebar-widget-blocks' ),
		'new_item'              => __( 'New Sidebar', 'sidebar-widget-blocks' ),
		'edit_item'             => __( 'Edit Sidebar', 'sidebar-widget-blocks' ),
		'update_item'           => __( 'Update Sidebar', 'sidebar-widget-blocks' ),
		'view_item'             => __( 'View Sidebar', 'sidebar-widget-blocks' ),
		'view_items'            => __( 'View Sidebars', 'sidebar-widget-blocks' ),
		'search_items'          => __( 'Search Sidebar', 'sidebar-widget-blocks' ),
		'not_found'             => __( 'Not found', 'sidebar-widget-blocks' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'sidebar-widget-blocks' ),
		'featured_image'        => __( 'Featured Image', 'sidebar-widget-blocks' ),
		'set_featured_image'    => __( 'Set featured image', 'sidebar-widget-blocks' ),
		'remove_featured_image' => __( 'Remove featured image', 'sidebar-widget-blocks' ),
		'use_featured_image'    => __( 'Use as featured image', 'sidebar-widget-blocks' ),
		'insert_into_item'      => __( 'Insert into item', 'sidebar-widget-blocks' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sidebar-widget-blocks' ),
		'items_list'            => __( 'Items list', 'sidebar-widget-blocks' ),
		'items_list_navigation' => __( 'Items list navigation', 'sidebar-widget-blocks' ),
		'filter_items_list'     => __( 'Filter items list', 'sidebar-widget-blocks' ),
	);

	$args = array(
		'label'                 => __( 'Sidebar', 'sidebar-widget-blocks' ),
		'description'           => __( 'Post Type Description', 'sidebar-widget-blocks' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'page-attributes' ),
		'taxonomies'            => array( '' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_in_rest'          => true,
		'menu_position'         => 30,
		'menu_icon'             => 'dashicons-layout',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);

	register_post_type( 'gs_sidebar', $args );
}