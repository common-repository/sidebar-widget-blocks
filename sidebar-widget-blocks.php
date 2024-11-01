<?php
/**
 * Plugin Name: Sidebar Widget Blocks
 * Plugin URI:  https://presscargo.io/plugins/sidebar-widget-blocks
 * Description: Creates a widget for displaying Gutenberg blocks in your sidebars
 * Version:     1.0.0
 * Author:      Press Cargo
 * Author URI:  https://presscargo.io
 * License: GPLv2 or later
 * Text Domain: sidebar-widget-blocks
 *
 * @package   SidebarWidgetBlocks
 * @version   1.0.0
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The plugin class.
 *
 * @since  1.0.0
 * @access public
 */
class SidebarWidgetBlocks {

	/**
	 * Minimum required PHP version.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	private $php_version = '5.6.0';

	/**
	 * Plugin directory path.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $dir = '';

	/**
	 * Plugin directory URI.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $uri = '';

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup();
			$instance->includes();
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up globals.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup() {

		// Main plugin directory path and URI.
		$this->dir = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->uri = trailingslashit( plugin_dir_url(  __FILE__ ) );
	}

	/**
	 * Loads files needed by the plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function includes() {

		// Check if we meet the minimum PHP version.
		if ( version_compare( PHP_VERSION, $this->php_version, '<' ) ) {

			// Add admin notice.
			add_action( 'admin_notices', array( $this, 'php_admin_notice' ) );

			// Bail.
			return;
		}

		require_once( $this->dir . 'inc/functions-cpt.php' );
		require_once( $this->dir . 'inc/functions-widgets.php' );
	}

	/**
	 * Sets up main plugin actions and filters.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {
		// Register activation hook.
		register_activation_hook( __FILE__, array( $this, 'activation' ) );

		// Register deactivation hook
		register_activation_hook( __FILE__, array( $this, 'deactivation' ) );
	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function activation() {

		// Check PHP version requirements.
		if ( version_compare( PHP_VERSION, $this->php_version, '<' ) ) {

			// Make sure the plugin is deactivated.
			deactivate_plugins( plugin_basename( __FILE__ ) );

			// Add an error message and die.
			wp_die( $this->get_min_php_message() );
		}
		
	}

	/**
	 * Method that runs only when the plugin is deactivated.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function deactivation() {

	}

	/**
	 * Returns a message noting the minimum version of PHP required.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function get_min_php_message() {

		return sprintf(
			__( 'Sidebar Widget Blocks requires PHP version %1$s. You are running version %2$s. Please upgrade and try again.', 'sidebar-widget-blocks' ),
			$this->php_version,
			PHP_VERSION
		);
	}

	/**
	 * Outputs the admin notice that the user needs to upgrade their PHP version. It also
	 * auto-deactivates the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function php_admin_notice() {

		// Output notice.
		printf(
			'<div class="notice notice-error is-dismissible"><p><strong>%s</strong></p></div>',
			esc_html( $this->get_min_php_message() )
		);

		// Make sure the plugin is deactivated.
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}

/**
 * Gets the instance of the `SidebarWidgetBlocks` class.  This function is useful for quickly grabbing data used throughout the plugin.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function sidebar_widget_blocks_plugin() {
	return SidebarWidgetBlocks::get_instance();
}

sidebar_widget_blocks_plugin();
