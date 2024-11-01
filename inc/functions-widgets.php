<?php
/**
 * Loads and enables the widgets for the plugin.
 *
 * @package    SidebarWidgetBlocks
 * @subpackage Includes
 * @author     Press Cargo
 * @copyright  Copyright (c) 2018, Press Cargo
 * @link       https://presscargo.io/plugins/sidebar-widget-blocks
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// Add registeration to the widgets_init hook
add_action( 'widgets_init', 'sidebar_widget_blocks_register_widgets' );

/**
 * Registers widgets for the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function sidebar_widget_blocks_register_widgets() {
	require_once( sidebar_widget_blocks_plugin()->dir . 'inc/class-widget-sidebar.php' );
	register_widget( 'Widget_Sidebar_Widget_Blocks' );
}
