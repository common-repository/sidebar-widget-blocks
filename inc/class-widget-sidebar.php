<?php
/**
 * The sidebar widget.
 *
 * @package    SidebarWidgetBlocks
 * @subpackage Includes
 * @author     Press Cargo
 * @copyright  Copyright (c) 2018, Press Cargo
 * @link       https://presscargo.io/plugins/sidebar-widget-blocks
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Class for the Sidebar Blocks widget.
 *
 * @since 1.0.0
 * @access public
 */
class Widget_Sidebar_Widget_Blocks extends WP_Widget {

	/**
	 * Sets up a new widget instance.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$widget_ops = array(
			'description' => __( 'Add Gutenberg blocks to your sidebar.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'sidebar_widget_blocks', __( 'Sidebar Widget Blocks' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Sidebar Blocks widget instance.
	 */
	public function widget( $args, $instance ) {
		// Get sidebar CPT ID
		$sidebar = ! empty( $instance['gs_sidebar'] ) ? $instance['gs_sidebar'] : false;

		if ( ! $sidebar ) return;

		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$sidebar_args = array(
			'post_type' => 'gs_sidebar',
			'p' => $instance['gs_sidebar']
		);

		$the_query = new WP_Query( $sidebar_args );

		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				the_content();
			}

			wp_reset_postdata();
		}

		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Sidebar Blocks widget instance.
	 *
	 * @since 1.0.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['gs_sidebar'] ) ) {
			$instance['gs_sidebar'] = (int) $new_instance['gs_sidebar'];
		}
		return $instance;
	}

	/**
	 * Outputs the settings form for the Sidebar Blocks widget.
	 *
	 * @since 1.0.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$gs_sidebar = isset( $instance['gs_sidebar'] ) ? $instance['gs_sidebar'] : '';

		// Get sidebars
		$sidebars = array();

		$args = array(
			'post_type' => 'gs_sidebar',
		);

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) {

			while ( $the_query->have_posts() ) {

				$the_query->the_post();

				$sidebars[] = array(
					'title' => get_the_title(),
					'id' => get_the_ID()
				);

			}

			wp_reset_postdata();
		}

		// If no sidebars exists, direct the user to go and create some.
		?>
		<p class="sidebar-widget-blocks-widget-no-menus-message" <?php if ( ! empty( $sidebars ) ) { echo ' style="display:none" '; } ?>>
			<?php echo sprintf( __( 'No sidebars have been created yet. <a href="%s">Create some</a>.' ), esc_attr( admin_url( 'edit.php?post_type=gs_sidebar' ) ) ); ?>
		</p>
		<div class="sidebar-widget-blocks-widget-widget-form-controls" <?php if ( empty( $sidebars ) ) { echo ' style="display:none" '; } ?>>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'gs_sidebar' ); ?>"><?php _e( 'Select Menu:' ); ?></label>
				<select id="<?php echo $this->get_field_id( 'gs_sidebar' ); ?>" name="<?php echo $this->get_field_name( 'gs_sidebar' ); ?>">
					<option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
					<?php foreach ( $sidebars as $sidebar ) : ?>
						<option value="<?php echo $sidebar['id']; ?>" <?php selected( $gs_sidebar, $sidebar['id'] ); ?>>
							<?php echo esc_html( $sidebar['title'] ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
		</div>
		<?php
	}
}
