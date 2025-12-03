<?php
/**
 * Plugin Name: Simple Social Icons
 * Plugin URI: https://wordpress.org/plugins/simple-social-icons/
 * Description: A simple CSS and SVG driven social icons widget. Also extends WordPress core Social Icons block with additional icon variations (WordPress 6.9+).
 * Author: OsomPress
 * Author URI: https://www.osompress.com/
 * Version: 4.0.0
 * Requires at least: 4.0
 * Requires PHP: 7.4
 * Text Domain: simple-social-icons
 * Domain Path: /languages
 *
 * License: GNU General Public License v2.0 (or later)
 * License URI: https://www.opensource.org/licenses/gpl-license.php
 *
 * @package simple-social-icons
 */

add_action( 'plugins_loaded', 'simple_social_icons_load_textdomain' );
/**
 * Load textdomain
 */
function simple_social_icons_load_textdomain() {
	load_plugin_textdomain( 'simple-social-icons', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

/**
 * The Simple Social Icons widget.
 */
class Simple_Social_Icons_Widget extends WP_Widget {

	/**
	 * Plugin version for enqueued static resources.
	 *
	 * @var string
	 */
	protected $version = '4.0.0';

	/**
	 * Default widget values.
	 *
	 * @var array
	 */
	protected $defaults;

	/**
	 * Default widget values.
	 *
	 * @var array
	 */
	protected $sizes;

	/**
	 * Default widget profile values.
	 *
	 * @var array
	 */
	protected $profiles;

	/**
	 * Array of widget instance IDs. Used to generate CSS.
	 *
	 * @var array
	 */
	protected $active_instances;

	/**
	 * Controls custom css output.
	 *
	 * @var bool
	 */
	protected $disable_css_output;

	/**
	 * Constructor method.
	 *
	 * Set some global values and create widget.
	 */
	public function __construct() {

		/**
		 * Filter for default widget option values.
		 *
		 * @since 1.0.6
		 *
		 * @param array $defaults Default widget options.
		 */
		$this->defaults = apply_filters(
			'simple_social_default_styles',
			array(
				'title'                  => '',
				'new_window'             => 0,
				'size'                   => 36,
				'border_radius'          => 3,
				'border_width'           => 0,
				'border_color'           => '#ffffff',
				'border_color_hover'     => '#ffffff',
				'icon_color'             => '#ffffff',
				'icon_color_hover'       => '#ffffff',
				'background_color'       => '#999999',
				'background_color_hover' => '#666666',
				'alignment'              => 'alignleft',
				'amazon'                 => '',
				'behance'                => '',
				'bloglovin'              => '',
				'bluesky'              => '',
				'diaspora'              => '',
				'dribbble'               => '',
				'email'                  => '',
				'etsy'                  => '',
				'facebook'               => '',
				'flickr'                 => '',
				'github'                 => '',
				'goodreads'              => '',
				'instagram'              => '',
				'linkedin'               => '',
				'mastodon'               => '',
				'medium'                 => '',
				'meetup'                 => '',
				'periscope'              => '',
				'phone'                  => '',
				'pinterest'              => '',
				'reddit'                 => '',
				'rss'                    => '',
				'snapchat'               => '',
				'substack'               => '',
				'telegram'               => '',
				'threads'                => '',
				'tiktok'                 => '',
				'tripadvisor'            => '',
				'tumblr'                 => '',
				'twitter'             	 => '',
				'vimeo'                  => '',
				'whatsapp'               => '',
				'xing'                   => '',
				'youtube'                => '',
			)
		);

		/**
		 * Filter for social profile choices.
		 *
		 * @since 1.0.6
		 *
		 * @param array $profiles Social icons to include in widget options.
		 */
		$this->profiles = apply_filters(
			'simple_social_default_profiles',
			array(
				'amazon'      => array(
					'label'   => __( 'Amazon URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'amazon', __( 'Amazon', 'simple-social-icons' ) ),
				),
				'behance'     => array(
					'label'   => __( 'Behance URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'behance', __( 'Behance', 'simple-social-icons' ) ),
				),
				'bloglovin'   => array(
					'label'   => __( 'Bloglovin URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'bloglovin', __( 'Bloglovin', 'simple-social-icons' ) ),
				),
				'bluesky'   => array(
					'label'   => __( 'Bluesky URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'bluesky', __( 'Bluesky', 'simple-social-icons' ) ),
				),
				'diaspora'    => array(
					'label'   => __( 'Diaspora URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'diaspora', __( 'Diaspora', 'simple-social-icons' ) ),
				),
				'dribbble'    => array(
					'label'   => __( 'Dribbble URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'dribbble', __( 'Dribbble', 'simple-social-icons' ) ),
				),
				'email'       => array(
					'label'   => __( 'Email URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'email', __( 'Email', 'simple-social-icons' ) ),
				),
				'etsy'       => array(
					'label'   => __( 'Etsy URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'etsy', __( 'Etsy', 'simple-social-icons' ) ),
				),
				'facebook'    => array(
					'label'   => __( 'Facebook URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'facebook', __( 'Facebook', 'simple-social-icons' ) ),
				),
				'flickr'      => array(
					'label'   => __( 'Flickr URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'flickr', __( 'Flickr', 'simple-social-icons' ) ),
				),
				'github'      => array(
					'label'   => __( 'GitHub URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'github', __( 'GitHub', 'simple-social-icons' ) ),
				),
				'goodreads'   => array(
					'label'   => __( 'Goodreads URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'goodreads', __( 'Goodreads', 'simple-social-icons' ) ),
				),
				'instagram'   => array(
					'label'   => __( 'Instagram URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'instagram', __( 'Instagram', 'simple-social-icons' ) ),
				),
				'linkedin'    => array(
					'label'   => __( 'Linkedin URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'linkedin', __( 'LinkedIn', 'simple-social-icons' ) ),
				),
				'mastodon'    => array(
					'label'   => __( 'Mastodon URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'mastodon', __( 'Mastodon', 'simple-social-icons' ) ),
				),
				'medium'      => array(
					'label'   => __( 'Medium URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'medium', __( 'Medium', 'simple-social-icons' ) ),
				),
				'meetup'      => array(
					'label'   => __( 'Meetup URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'meetup', __( 'Meetup', 'simple-social-icons' ) ),
				),
				'periscope'   => array(
					'label'   => __( 'Periscope URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'periscope', __( 'Periscope', 'simple-social-icons' ) ),
				),
				'phone'       => array(
					'label'   => __( 'Phone URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'phone', __( 'Phone', 'simple-social-icons' ) ),
				),
				'pinterest'   => array(
					'label'   => __( 'Pinterest URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'pinterest', __( 'Pinterest', 'simple-social-icons' ) ),
				),
				'reddit'      => array(
					'label'   => __( 'Reddit URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'reddit', __( 'Reddit', 'simple-social-icons' ) ),
				),
				'rss'         => array(
					'label'   => __( 'RSS URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'rss', __( 'RSS', 'simple-social-icons' ) ),
				),
				'snapchat'    => array(
					'label'   => __( 'Snapchat URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'snapchat', __( 'Snapchat', 'simple-social-icons' ) ),
				),
				'substack'       => array(
					'label'   => __( 'Substack URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'substack', __( 'Substack', 'simple-social-icons' ) ),
				),
				'telegram'       => array(
					'label'   => __( 'Telegram URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'telegram', __( 'Telegram', 'simple-social-icons' ) ),
				),
				'threads'    => array(
					'label'   => __( 'Threads URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'threads', __( 'Threads', 'simple-social-icons' ) ),
				),
				'tiktok'      => array(
					'label'   => __( 'TikTok URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'tiktok', __( 'TikTok', 'simple-social-icons' ) ),
				),
				'tripadvisor' => array(
					'label'   => __( 'Tripadvisor URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'tripadvisor', __( 'Tripadvisor', 'simple-social-icons' ) ),
				),
				'tumblr'      => array(
					'label'   => __( 'Tumblr URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'tumblr', __( 'Tumblr', 'simple-social-icons' ) ),
				),
				'twitter'     => array(
					'label'   => __( 'X URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'twitter', __( 'Twitter', 'simple-social-icons' ) ),
				),
				'vimeo'       => array(
					'label'   => __( 'Vimeo URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'vimeo', __( 'Vimeo', 'simple-social-icons' ) ),
				),
				'whatsapp'    => array(
					'label'   => __( 'WhatsApp URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'whatsapp', __( 'WhatsApp', 'simple-social-icons' ) ),
				),
				'xing'        => array(
					'label'   => __( 'Xing URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'xing', __( 'xing', 'simple-social-icons' ) ),
				),
				'youtube'     => array(
					'label'   => __( 'YouTube URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'youtube', __( 'YouTube', 'simple-social-icons' ) ),
				),
			)
		);

		/**
		 * Filter to disable output of custom CSS.
		 *
		 * Setting this to true in your child theme will:
		 *  - Stop output of inline custom icon CSS.
		 *  - Stop styling options showing in Simple Social Icons widget settings.
		 *
		 * The intent if enabling is that your theme will provide CSS for all
		 * widget areas, instead of allowing people to set their own icon
		 * styles. You should consider mentioning in theme documentation that
		 * Simple Social Icons widget settings will not display styling
		 * options, as your theme styles icons instead.
		 *
		 * @since 3.0.0
		 *
		 * @param bool $disable_css_output True if custom CSS should be disabled.
		 */
		$this->disable_css_output = apply_filters( 'simple_social_disable_custom_css', false );

		$widget_ops = array(
			'classname'   => 'simple-social-icons',
			'description' => __( 'Displays select social icons.', 'simple-social-icons' ),
		);

		$control_ops = array(
			'id_base' => 'simple-social-icons',
		);

		$this->active_instances = array();

		parent::__construct( 'simple-social-icons', __( 'Simple Social Icons', 'simple-social-icons' ), $widget_ops, $control_ops );

		/** Enqueue scripts and styles */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );

		/** Load CSS in <head> */
		add_action( 'wp_footer', array( $this, 'css' ) );

		/** Load color picker */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_color_picker' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );

	}

	/**
	 * Color Picker.
	 *
	 * Enqueue the color picker script.
	 *
	 * @param string $hook The current admin page.
	 */
	public function load_color_picker( $hook ) {
		if ( 'widgets.php' !== $hook ) {
			return;
		}
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'underscore' );
	}

	/**
	 * Print scripts.
	 *
	 * Reference https://core.trac.wordpress.org/attachment/ticket/25809/color-picker-widget.php
	 */
	public function print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.ssiw-color-picker' ).wpColorPicker( {
						change: function ( event ) {
							var $picker = $( this );
							_.throttle(setTimeout(function () {
								$picker.trigger( 'change' );
							}, 5), 250);
						},
						width: 235,
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.ssiw-color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}

	/**
	 * Widget Form.
	 *
	 * Outputs the widget form that allows users to control the output of the widget.
	 *
	 * @param array $instance The widget settings.
	 */
	public function form( $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'simple-social-icons' ); ?></label> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

		<p><label><input id="<?php echo esc_attr( $this->get_field_id( 'new_window' ) ); ?>" type="checkbox" name="<?php echo esc_attr( $this->get_field_name( 'new_window' ) ); ?>" value="1" <?php checked( 1, $instance['new_window'] ); ?>/> <?php esc_html_e( 'Open links in new window?', 'simple-social-icons' ); ?></label></p>

		<?php if ( ! $this->disable_css_output ) { ?>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>"><?php esc_html_e( 'Icon Size', 'simple-social-icons' ); ?>:</label> <input id="<?php echo esc_attr( $this->get_field_id( 'size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'size' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['size'] ); ?>" size="3" />px</p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'border_radius' ) ); ?>"><?php esc_html_e( 'Icon Border Radius:', 'simple-social-icons' ); ?></label> <input id="<?php echo esc_attr( $this->get_field_id( 'border_radius' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border_radius' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['border_radius'] ); ?>" size="3" />px</p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'border_width' ) ); ?>"><?php esc_html_e( 'Border Width:', 'simple-social-icons' ); ?></label> <input id="<?php echo esc_attr( $this->get_field_id( 'border_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border_width' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['border_width'] ); ?>" size="3" />px</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>"><?php esc_html_e( 'Alignment', 'simple-social-icons' ); ?>:</label>
				<select id="<?php echo esc_attr( $this->get_field_id( 'alignment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'alignment' ) ); ?>">
					<option value="alignleft" <?php selected( 'alignright', $instance['alignment'] ); ?>><?php esc_html_e( 'Align Left', 'simple-social-icons' ); ?></option>
					<option value="aligncenter" <?php selected( 'aligncenter', $instance['alignment'] ); ?>><?php esc_html_e( 'Align Center', 'simple-social-icons' ); ?></option>
					<option value="alignright" <?php selected( 'alignright', $instance['alignment'] ); ?>><?php esc_html_e( 'Align Right', 'simple-social-icons' ); ?></option>
				</select>
			</p>

			<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>"><?php esc_html_e( 'Icon Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo esc_attr( $this->get_field_id( 'icon_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_color' ) ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['icon_color'] ); ?>" value="<?php echo esc_attr( $instance['icon_color'] ); ?>" size="6" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'background_color_hover' ) ); ?>"><?php esc_html_e( 'Icon Hover Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo esc_attr( $this->get_field_id( 'icon_color_hover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon_color_hover' ) ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['icon_color_hover'] ); ?>" value="<?php echo esc_attr( $instance['icon_color_hover'] ); ?>" size="6" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>"><?php esc_html_e( 'Background Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['background_color'] ); ?>" value="<?php echo esc_attr( $instance['background_color'] ); ?>" size="6" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'background_color_hover' ) ); ?>"><?php esc_html_e( 'Background Hover Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo esc_attr( $this->get_field_id( 'background_color_hover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color_hover' ) ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['background_color_hover'] ); ?>" value="<?php echo esc_attr( $instance['background_color_hover'] ); ?>" size="6" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'border_color' ) ); ?>"><?php esc_html_e( 'Border Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo esc_attr( $this->get_field_id( 'border_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border_color' ) ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['border_color'] ); ?>" value="<?php echo esc_attr( $instance['border_color'] ); ?>" size="6" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'border_color_hover' ) ); ?>"><?php esc_html_e( 'Border Hover Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo esc_attr( $this->get_field_id( 'border_color_hover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'border_color_hover' ) ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['border_color_hover'] ); ?>" value="<?php echo esc_attr( $instance['border_color_hover'] ); ?>" size="6" /></p>

			<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />
		<?php } ?>

		<?php
		foreach ( (array) $this->profiles as $profile => $data ) {

			printf( '<p><label for="%s">%s:</label></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
			printf( '<p><input type="text" id="%s" name="%s" value="%s" class="widefat" />', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_attr( $instance[ $profile ] ) );
			printf( '</p>' );

		}

	}

	/**
	 * Form validation and sanitization.
	 *
	 * Runs when you save the widget form. Allows you to validate or sanitize widget options before they are saved.
	 *
	 * @param array $newinstance The new settings.
	 * @param array $oldinstance The old settings.
	 * @return array The settings to save.
	 */
	public function update( $newinstance, $oldinstance ) {

		// Fields that can be transparent if their values are unset.
		$can_be_transparent = array(
			'background_color',
			'background_color_hover',
			'border_color',
			'border_color_hover',
		);

		foreach ( $newinstance as $key => $value ) {

			/** Border radius and Icon size must not be empty, must be a digit */
			if ( ( 'border_radius' === $key || 'size' === $key ) && ( '' === $value || ! ctype_digit( $value ) ) ) {
				$newinstance[ $key ] = 0;
			}

			if ( ( 'border_width' === $key || 'size' === $key ) && ( '' === $value || ! ctype_digit( $value ) ) ) {
				$newinstance[ $key ] = 0;
			} elseif ( in_array( $key, $can_be_transparent, true ) && '' === trim( $value ) ) {
				// Accept empty colors for permitted keys.
				$newinstance[ $key ] = '';
			} elseif ( strpos( $key, '_color' ) && 0 === preg_match( '/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/', $value ) ) {
				// Validate hex code colors.
				$newinstance[ $key ] = $oldinstance[ $key ];
			} elseif ( array_key_exists( $key, (array) $this->profiles ) && ! is_email( $value ) && ! 'phone' === $key ) {
				// Sanitize Profile URIs.
				$newinstance[ $key ] = esc_url( $newinstance[ $key ] );
			}
		}

		return $newinstance;

	}

	/**
	 * Widget Output.
	 *
	 * Outputs the actual widget on the front-end based on the widget options the user selected.
	 *
	 * @param array $args The display args.
	 * @param array $instance The instance settings.
	 */
	public function widget( $args, $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $args['before_widget']; // phpcs:ignore

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title']; // phpcs:ignore
		}

			$output = '';

			$profiles = (array) $this->profiles;

		foreach ( $profiles as $profile => $data ) {

			if ( empty( $instance[ $profile ] ) ) {
				continue;
			}

			$new_window = $instance['new_window'] ? 'target="_blank" rel="noopener noreferrer"' : '';

			if ( is_email( $instance[ $profile ] ) || false !== strpos( $instance[ $profile ], 'mailto:' ) ) {
				$new_window = '';
			}

			if ( is_email( $instance[ $profile ] ) ) {
				$output .= sprintf( $data['pattern'], 'mailto:' . esc_attr( antispambot( $instance[ $profile ] ) ), $new_window );
			} elseif ( 'phone' === $profile ) {
				$output .= sprintf( $data['pattern'], 'tel:' . esc_attr( antispambot( $instance[ $profile ] ) ), $new_window );
			} else {
				$output .= sprintf( $data['pattern'], esc_url( $instance[ $profile ] ), $new_window );
			}
		}

		if ( $output ) {
			$output = str_replace( '{WIDGET_INSTANCE_ID}', $this->number, $output );
			printf( '<ul class="%s">%s</ul>', esc_attr( $instance['alignment'] ), $output ); // phpcs:ignore
		}

		echo $args['after_widget']; // phpcs:ignore

		$this->active_instances[] = $this->number;

	}

	/**
	 * Enqueues the CSS.
	 */
	public function enqueue_css() {

		/**
		 * Filter the plugin stylesheet location.
		 *
		 * @since 2.0.0
		 *
		 * @param string $cssfile The full path to the stylesheet.
		 */
		$cssfile = apply_filters( 'simple_social_default_stylesheet', plugin_dir_url( __FILE__ ) . 'css/style.css' );

		wp_enqueue_style( 'simple-social-icons-font', esc_url( $cssfile ), array(), $this->version, 'all' );
	}

	/**
	 * Custom CSS.
	 *
	 * Outputs custom CSS to control the look of the icons.
	 */
	public function css() {

		/** Pull widget settings, merge with defaults */
		$all_instances = $this->get_settings();

		$css = '';

		foreach ( $this->active_instances as $instance_id ) {
			// Skip if info for this instance does not exist - this should never happen.
			if ( ! isset( $all_instances[ $instance_id ] ) || $this->disable_css_output ) {
				continue;
			}

			$instance = wp_parse_args( $all_instances[ $instance_id ], $this->defaults );

			$font_size    = round( (int) $instance['size'] / 2 );
			$icon_padding = round( (int) $font_size / 2 );

			// Treat empty background and border colors as transparent.
			$instance['background_color']       = $instance['background_color'] ?: 'transparent';
			$instance['border_color']           = $instance['border_color'] ?: 'transparent';
			$instance['background_color_hover'] = $instance['background_color_hover'] ?: 'transparent';
			$instance['border_color_hover']     = $instance['border_color_hover'] ?: 'transparent';

			/** The CSS to output */
			$css .= '
			#simple-social-icons-' . $instance_id . ' ul li a,
			#simple-social-icons-' . $instance_id . ' ul li a:hover,
			#simple-social-icons-' . $instance_id . ' ul li a:focus {
				background-color: ' . $instance['background_color'] . ' !important;
				border-radius: ' . $instance['border_radius'] . 'px;
				color: ' . $instance['icon_color'] . ' !important;
				border: ' . $instance['border_width'] . 'px ' . $instance['border_color'] . ' solid !important;
				font-size: ' . $font_size . 'px;
				padding: ' . $icon_padding . 'px;
			}

			#simple-social-icons-' . $instance_id . ' ul li a:hover,
			#simple-social-icons-' . $instance_id . ' ul li a:focus {
				background-color: ' . $instance['background_color_hover'] . ' !important;
				border-color: ' . $instance['border_color_hover'] . ' !important;
				color: ' . $instance['icon_color_hover'] . ' !important;
			}

			#simple-social-icons-' . $instance_id . ' ul li a:focus {
				outline: 1px dotted ' . $instance['background_color_hover'] . ' !important;
			}';

		}

		// Minify a bit.
		$css = str_replace( "\t", '', $css );
		$css = str_replace( array( "\n", "\r" ), ' ', $css );

		echo '<style type="text/css" media="screen">' . wp_strip_all_tags( $css ) . '</style>'; // phpcs:ignore

	}

	/**
	 * Construct the markup for each icon
	 *
	 * @param string $icon The lowercase icon name for use in tag attributes.
	 * @param string $label The plain text icon label.
	 *
	 * @return string The full markup for the given icon.
	 */
	public function get_icon_markup( $icon, $label ) {
		$markup  = '<li class="ssi-' . esc_attr( $icon ) . '"><a href="%s" %s>';
		$markup .= '<svg role="img" class="social-' . esc_attr( $icon ) . '" aria-labelledby="social-' . esc_attr( $icon ) . '-{WIDGET_INSTANCE_ID}">';
		$markup .= '<title id="social-' . esc_attr( $icon ) . '-{WIDGET_INSTANCE_ID}">' . esc_html( $label ) . '</title>';
		$markup .= '<use xlink:href="' . esc_attr( plugin_dir_url( __FILE__ ) . 'symbol-defs.svg#social-' . $icon ) . '"></use>';
		$markup .= '</svg></a></li>';

		/**
		 * Filter the icon markup HTML.
		 *
		 * @since 3.0.0
		 *
		 * @param string $markup The full HTML markup for a single icon.
		 * @param string $icon The lowercase icon name used in tag attributes.
		 * @param string $label The plain text icon label.
		 */
		return apply_filters( 'simple_social_icon_html', $markup, $icon, $label );
	}

	/**
	 * Remove option when uninstalling the plugin.
	 *
	 * @since 2.1.0
	 */
	public static function plugin_uninstall() {
		delete_option( 'widget_simple-social-icons' );
	}


}

register_uninstall_hook( __FILE__, array( 'Simple_Social_Icons_Widget', 'plugin_uninstall' ) );
add_action( 'widgets_init', 'ssiw_load_widget' );
/**
 * Widget Registration.
 *
 * Register Simple Social Icons widget.
 */
function ssiw_load_widget() {

	register_widget( 'Simple_Social_Icons_Widget' );

}

/**
 * Check if WordPress version supports block variations for social-link.
 * Block variations for social-link are available in WordPress 6.9+.
 *
 * @return bool True if WordPress 6.9+ is installed.
 */
function simple_social_icons_supports_block_variations() {
	global $wp_version;
	return version_compare( $wp_version, '6.9', '>=' );
}

/**
 * Enqueue block editor assets for block variations.
 * Only loads on WordPress 6.9+ where block variations are supported.
 */
add_action( 'enqueue_block_editor_assets', 'simple_social_icons_editor_assets' );
function simple_social_icons_editor_assets() {
	// Only load block variations on WordPress 6.9+
	if ( ! simple_social_icons_supports_block_variations() ) {
		return;
	}

	$dir = untrailingslashit( plugin_dir_path( __FILE__ ) );
	$url = untrailingslashit( plugin_dir_url( __FILE__ ) );

	if ( file_exists( "{$dir}/build/index.asset.php" ) ) {
		$asset = include "{$dir}/build/index.asset.php";

		wp_enqueue_script(
			'simple-social-icons-block-variations',
			"{$url}/build/index.js",
			$asset['dependencies'],
			$asset['version'],
			true
		);
	}
}

/**
 * Enqueue block assets (CSS) for front-end and editor.
 * Only loads on WordPress 6.9+ where block variations are supported.
 */
add_action( 'init', 'simple_social_icons_enqueue_block_assets' );
function simple_social_icons_enqueue_block_assets() {
	// Only load block assets on WordPress 6.9+
	if ( ! simple_social_icons_supports_block_variations() ) {
		return;
	}

	$dir = untrailingslashit( plugin_dir_path( __FILE__ ) );
	$url = untrailingslashit( plugin_dir_url( __FILE__ ) );

	if ( file_exists( "{$dir}/build/index.asset.php" ) ) {
		$asset = include "{$dir}/build/index.asset.php";

		wp_enqueue_block_style(
			'core/social-links',
			array(
				'handle' => 'simple-social-icons-block-styles',
				'src'    => "{$url}/build/style-index.css",
				'path'   => "{$dir}/build/style-index.css",
				'ver'    => $asset['version'],
			)
		);
	}
}

/**
 * Register custom social link services for front-end rendering.
 * This ensures icons display correctly on the front-end.
 * Only registers on WordPress 6.9+ where block variations are supported.
 */
add_filter( 'block_core_social_link_get_services', 'simple_social_icons_register_services' );
function simple_social_icons_register_services( $services_data ) {
	// Only register services on WordPress 6.9+
	if ( ! simple_social_icons_supports_block_variations() ) {
		return $services_data;
	}
	$custom_services = array(
		'diaspora'    => array(
			'name' => _x( 'Diaspora', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M15.257 21.928l-2.33-3.255c-.622-.87-1.128-1.549-1.155-1.55-.027 0-1.007 1.317-2.317 3.115-1.248 1.713-2.28 3.115-2.292 3.115-.035 0-4.5-3.145-4.51-3.178-.006-.016 1.003-1.497 2.242-3.292 1.239-1.794 2.252-3.29 2.252-3.325 0-.056-.401-.197-3.55-1.247a1604.93 1604.93 0 0 1-3.593-1.2c-.033-.013.153-.635.79-2.648.46-1.446.845-2.642.857-2.656.013-.015 1.71.528 3.772 1.207 2.062.678 3.766 1.233 3.787 1.233.021 0 .045-.032.053-.07.008-.039.026-1.794.04-3.902.013-2.107.036-3.848.05-3.87.02-.03.599-.038 2.725-.038 1.485 0 2.716.01 2.735.023.023.016.064 1.175.132 3.776.112 4.273.115 4.33.183 4.33.026 0 1.66-.547 3.631-1.216 1.97-.668 3.593-1.204 3.605-1.191.04.045 1.656 5.307 1.636 5.327-.011.01-1.656.574-3.655 1.252-2.75.932-3.638 1.244-3.645 1.284-.006.029.94 1.442 2.143 3.202 1.184 1.733 2.148 3.164 2.143 3.18-.012.036-4.442 3.299-4.48 3.299-.015 0-.577-.767-1.249-1.705z"/></svg>',
		),
		'bloglovin'   => array(
			'name' => _x( 'Bloglovin', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M16 28c-.27 0-.5-.093-.688-.282l-9.75-9.407c-.104-.083-.248-.217-.43-.406s-.47-.53-.868-1.023-.75-1-1.063-1.522-.59-1.152-.835-1.89S2 12.01 2 11.312c0-2.29.66-4.084 1.983-5.375S7.135 4 9.467 4c.646 0 1.305.112 1.977.336s1.296.527 1.875.907 1.074.737 1.492 1.07c.416.334.813.688 1.188 1.063.375-.375.77-.73 1.188-1.063s.914-.69 1.493-1.07 1.205-.682 1.876-.907S21.886 4 22.533 4c2.334 0 4.16.646 5.484 1.938S30 9.022 30 11.313c0 2.302-1.192 4.646-3.578 7.032l-9.734 9.375c-.188.188-.416.28-.688.28z"/></svg>',
		),
		'phone'       => array(
			'name' => _x( 'Phone', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M28.571 22.143q0 .482-.179 1.259t-.375 1.223q-.375.893-2.179 1.893-1.679.911-3.321.911-.482 0-.938-.063t-1.027-.223-.848-.259-.991-.366-.875-.321q-1.75-.625-3.125-1.482-2.286-1.411-4.723-3.848t-3.848-4.723q-.857-1.375-1.482-3.125-.054-.161-.321-.875t-.366-.991-.259-.848-.223-1.027-.063-.938q0-1.643.911-3.321 1-1.804 1.893-2.179.446-.196 1.223-.375t1.259-.179q.25 0 .375.054.321.107.946 1.357.196.339.536.964t.625 1.134.554.955q.054.071.313.446t.384.634.125.509q0 .357-.509.893t-1.107.982-1.107.946-.509.821q0 .161.089.402t.152.366.25.429.205.339q1.357 2.446 3.107 4.196t4.196 3.107q.036.018.339.205t.429.25.366.152.402.089q.321 0 .821-.509t.946-1.107.982-1.107.893-.509q.25 0 .509.125t.634.384.446.313q.446.268.955.554t1.134.625.964.536q1.25.625 1.357.946.054.125.054.375z"/></svg>',
		),
		'substack'    => array(
			'name' => _x( 'Substack', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.539 8.242H1.46V5.406h21.08v2.836zM1.46 10.812V24L12 18.11L22.54 24V10.812H1.46zM22.54 0H1.46v2.836h21.08V0z"/></svg>',
		),
		'tripadvisor' => array(
			'name' => _x( 'Tripadvisor', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M 32 9.613281 L 27.472656 9.613281 C 24.335938 7.480469 20.5 6.398438 16 6.398438 C 11.5 6.398438 7.660156 7.480469 4.527344 9.613281 L 0 9.613281 C 0.683594 10.285156 1.324219 11.757812 1.589844 12.878906 C 0.5625 14.242188 0.00390625 15.90625 0 17.613281 C 0 22.023438 3.589844 25.613281 8 25.613281 C 10.039062 25.609375 12 24.820312 13.476562 23.414062 L 16 27.199219 L 18.523438 23.414062 C 20 24.824219 21.960938 25.613281 24 25.617188 C 28.410156 25.617188 32 22.027344 32 17.617188 C 32 15.835938 31.398438 14.207031 30.410156 12.878906 C 30.675781 11.761719 31.316406 10.289062 32 9.617188 Z M 8 23.054688 C 5 23.054688 2.558594 20.613281 2.558594 17.613281 C 2.558594 14.613281 5 12.175781 8 12.175781 C 11 12.175781 13.441406 14.613281 13.441406 17.613281 C 13.441406 20.613281 11 23.054688 8 23.054688 Z M 16 17.613281 C 15.996094 13.808594 13.3125 10.535156 9.585938 9.773438 C 11.511719 9.125 13.648438 8.800781 16 8.800781 C 18.351562 8.800781 20.488281 9.125 22.414062 9.777344 C 18.6875 10.535156 16.007812 13.808594 16 17.613281 Z M 24 23.054688 C 21 23.054688 18.558594 20.613281 18.558594 17.613281 C 18.558594 14.613281 21 12.175781 24 12.175781 C 27 12.175781 29.441406 14.613281 29.441406 17.613281 C 29.441406 20.613281 27 23.054688 24 23.054688 Z M 8 14.175781 C 6.105469 14.175781 4.558594 15.71875 4.558594 17.617188 C 4.558594 19.511719 6.105469 21.054688 8 21.054688 C 9.894531 21.054688 11.441406 19.511719 11.441406 17.617188 C 11.441406 15.71875 9.894531 14.175781 8 14.175781 Z M 8 18.640625 C 7.425781 18.640625 6.960938 18.175781 6.960938 17.601562 C 6.960938 17.027344 7.425781 16.5625 8 16.5625 C 8.574219 16.5625 9.039062 17.027344 9.039062 17.601562 C 9.039062 18.175781 8.574219 18.640625 8 18.640625 Z M 24 14.175781 C 22.105469 14.175781 20.558594 15.71875 20.558594 17.617188 C 20.558594 19.511719 22.105469 21.054688 24 21.054688 C 25.894531 21.054688 27.441406 19.511719 27.441406 17.617188 C 27.441406 15.71875 25.894531 14.175781 24 14.175781 Z M 24 18.640625 C 23.425781 18.640625 22.960938 18.175781 22.960938 17.601562 C 22.960938 17.027344 23.425781 16.5625 24 16.5625 C 24.574219 16.5625 25.039062 17.027344 25.039062 17.601562 C 25.039062 18.175781 24.574219 18.640625 24 18.640625 Z"/></svg>',
		),
		'xing'        => array(
			'name' => _x( 'Xing', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M14.15 11.654c-.118.213-1.636 2.907-4.554 8.08-.32.543-.704.814-1.152.814H4.208c-.248 0-.432-.1-.55-.302-.118-.2-.118-.413 0-.637l4.484-7.938c.012 0 .012-.005 0-.018L5.29 6.708c-.141-.259-.148-.479-.018-.655.107-.177.295-.266.568-.266h4.236c.471 0 .863.266 1.17.798l2.904 5.068zM28.434.277c.13.189.13.407 0 .655l-9.357 16.552v.018L25.031 28.4c.13.236.136.455.018.655-.118.177-.307.266-.568.266h-4.236c-.496 0-.886-.266-1.17-.798L13.07 17.502c.213-.379 3.35-5.943 9.411-16.693.295-.532.673-.798 1.134-.798h4.271c.259 0 .441.089.548.266z"/></svg>',
		),
		'imdb'        => array(
			'name' => _x( 'IMDB', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M4.7954 8.2603v7.3636H2.8899V8.2603h1.9055zm6.5367 0v7.3636H9.6707v-4.9704l-.6711 4.9704H7.813l-.6986-4.8618-.0066 4.8618h-1.668V8.2603h2.468c.0748.4476.1492.9694.2307 1.5734l.2712 1.8713.4407-3.4447h2.4817zm2.9772 1.3289c.0742.0404.122.108.1417.2034.0279.0953.0345.3118.0345.6442v2.8548c0 .4881-.0345.7867-.0955.8954-.0609.1152-.2304.1695-.5018.1695V9.5211c.204 0 .3457.0205.4211.0681zm-.0211 6.0347c.4543 0 .8006-.0265 1.0245-.0742.2304-.0477.4204-.1357.5694-.2648.1556-.1218.2642-.298.3251-.5219.0611-.2238.1021-.6648.1021-1.3224v-2.5832c0-.6986-.0271-1.1668-.0742-1.4039-.041-.237-.1431-.4543-.3126-.6437-.1695-.1973-.4198-.3324-.7456-.421-.3191-.0808-.8542-.1285-1.7694-.1285h-1.4244v7.3636h2.3051zm5.14-1.7827c0 .3523-.0199.5762-.0544.6708-.033.0947-.1894.1424-.3046.1424-.1086 0-.19-.0477-.2238-.1351-.041-.0887-.0609-.2986-.0609-.6238v-1.9469c0-.3324.0199-.5423.0543-.6237.0338-.0808.1086-.122.2171-.122.1153 0 .2709.0412.3114.1425.041.0947.0609.2986.0609.6032v1.8926zm-2.4747-5.5809v7.3636h1.7157l.1152-.4675c.1556.1894.3251.3324.5152.4271.1828.0881.4608.1357.678.1357.3047 0 .5629-.0748.7802-.237.2165-.1562.3589-.3462.4198-.5628.0543-.2173.0887-.543.0887-.9841v-2.0675c0-.4409-.0139-.7324-.0344-.8681-.0199-.1357-.0742-.2781-.1695-.4204-.1021-.1425-.2437-.251-.4272-.3325-.1834-.0742-.3999-.1152-.6576-.1152-.2172 0-.4952.0477-.6846.1285-.1835.0887-.353.2238-.5086.4007V8.2603h-1.8309z"/></svg>',
		),
		'kofi'        => array(
			'name' => _x( 'Ko-fi', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M11.351 2.715c-2.7 0-4.986.025-6.83.26C2.078 3.285 0 5.154 0 8.61c0 3.506.182 6.13 1.585 8.493 1.584 2.701 4.233 4.182 7.662 4.182h.83c4.209 0 6.494-2.234 7.637-4a9.5 9.5 0 0 0 1.091-2.338C21.792 14.688 24 12.22 24 9.208v-.415c0-3.247-2.13-5.507-5.792-5.87-1.558-.156-2.65-.208-6.857-.208m0 1.947c4.208 0 5.09.052 6.571.182 2.624.311 4.13 1.584 4.13 4v.39c0 2.156-1.792 3.844-3.87 3.844h-.935l-.156.649c-.208 1.013-.597 1.818-1.039 2.546-.909 1.428-2.545 3.064-5.922 3.064h-.805c-2.571 0-4.831-.883-6.078-3.195-1.09-2-1.298-4.155-1.298-7.506 0-2.181.857-3.402 3.012-3.714 1.533-.233 3.559-.26 6.39-.26m6.547 2.287c-.416 0-.65.234-.65.546v2.935c0 .311.234.545.65.545 1.324 0 2.051-.754 2.051-2s-.727-2.026-2.052-2.026m-10.39.182c-1.818 0-3.013 1.48-3.013 3.142 0 1.533.858 2.857 1.949 3.897.727.701 1.87 1.429 2.649 1.896a1.47 1.47 0 0 0 1.507 0c.78-.467 1.922-1.195 2.649-1.896 1.091-1.04 1.949-2.364 1.949-3.897 0-1.662-1.195-3.142-3.013-3.142-.78 0-1.506.234-2.091.623-.585.39-1.039.935-1.313 1.584-.274.65-.39 1.351-.39 2.091 0 .78.116 1.48.39 2.13.274.65.728 1.195 1.313 1.584.585.39 1.311.623 2.091.623.78 0 1.506-.234 2.091-.623.585-.39 1.039-.935 1.313-1.584.274-.65.39-1.351.39-2.13 0-.74-.116-1.441-.39-2.091-.274-.65-.728-1.195-1.313-1.584-.585-.39-1.311-.623-2.091-.623z"/></svg>',
		),
		'letterboxd'  => array(
			'name' => _x( 'Letterboxd', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M8.224 14.352a4.447 4.447 0 0 1-3.775 2.092C1.992 16.444 0 14.454 0 12s1.992-4.444 4.45-4.444c1.592 0 2.988.836 3.774 2.092-.427.682-.673 1.488-.673 2.352s.246 1.67.673 2.352zM15.101 12c0-.864.247-1.67.674-2.352-.786-1.256-2.183-2.092-3.775-2.092s-2.989.836-3.775 2.092c.427.682.674 1.488.674 2.352s-.247 1.67-.674 2.352c.786 1.256 2.183 2.092 3.775 2.092s2.989-.836 3.775-2.092A4.42 4.42 0 0 1 15.1 12zm4.45-4.444a4.447 4.447 0 0 0-3.775 2.092c.427.682.673 1.488.673 2.352s-.246 1.67-.673 2.352a4.447 4.447 0 0 0 3.775 2.092C22.008 16.444 24 14.454 24 12s-1.992-4.444-4.45-4.444z"/></svg>',
		),
		'signal'      => array(
			'name' => _x( 'Signal', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 0q-.934 0-1.83.139l.17 1.111a11 11 0 0 1 3.32 0l.172-1.111A12 12 0 0 0 12 0M9.152.34A12 12 0 0 0 5.77 1.742l.584.961a10.8 10.8 0 0 1 3.066-1.27zm5.696 0-.268 1.094a10.8 10.8 0 0 1 3.066 1.27l.584-.962A12 12 0 0 0 14.848.34M12 2.25a9.75 9.75 0 0 0-8.539 14.459c.074.134.1.292.064.441l-1.013 4.338 4.338-1.013a.62.62 0 0 1 .441.064A9.7 9.7 0 0 0 12 21.75c5.385 0 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25m-7.092.068a12 12 0 0 0-2.59 2.59l.909.664a11 11 0 0 1 2.345-2.345zm14.184 0-.664.909a11 11 0 0 1 2.345 2.345l.909-.664a12 12 0 0 0-2.59-2.59M1.742 5.77A12 12 0 0 0 .34 9.152l1.094.268a10.8 10.8 0 0 1 1.269-3.066zm20.516 0-.961.584a10.8 10.8 0 0 1 1.27 3.066l1.093-.268a12 12 0 0 0-1.402-3.383M.138 10.168A12 12 0 0 0 0 12q0 .934.139 1.83l1.111-.17A11 11 0 0 1 1.125 12q0-.848.125-1.66zm23.723.002-1.111.17q.125.812.125 1.66c0 .848-.042 1.12-.125 1.66l1.111.172a12.1 12.1 0 0 0 0-3.662M1.434 14.58l-1.094.268a12 12 0 0 0 .96 2.591l-.265 1.14 1.096.255.36-1.539-.188-.365a10.8 10.8 0 0 1-.87-2.35m21.133 0a10.8 10.8 0 0 1-1.27 3.067l.962.584a12 12 0 0 0 1.402-3.383zm-1.793 3.848a11 11 0 0 1-2.345 2.345l.664.909a12 12 0 0 0 2.59-2.59zm-19.959 1.1L.357 21.48a1.8 1.8 0 0 0 2.162 2.161l1.954-.455-.256-1.095-1.953.455a.675.675 0 0 1-.81-.81l.454-1.954zm16.832 1.769a10.8 10.8 0 0 1-3.066 1.27l.268 1.093a12 12 0 0 0 3.382-1.402zm-10.94.213-1.54.36.256 1.095 1.139-.266c.814.415 1.683.74 2.591.961l.268-1.094a10.8 10.8 0 0 1-2.35-.869zm3.634 1.24-.172 1.111a12.1 12.1 0 0 0 3.662 0l-.17-1.111q-.812.125-1.66.125a11 11 0 0 1-1.66-.125"/></svg>',
		),
		'youtube-music' => array(
			'name' => _x( 'YouTube Music', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 0C5.376 0 0 5.376 0 12s5.376 12 12 12 12-5.376 12-12S18.624 0 12 0zm0 19.104c-3.924 0-7.104-3.18-7.104-7.104S8.076 4.896 12 4.896s7.104 3.18 7.104 7.104-3.18 7.104-7.104 7.104zm0-13.332c-3.432 0-6.228 2.796-6.228 6.228S8.568 18.228 12 18.228s6.228-2.796 6.228-6.228S15.432 5.772 12 5.772zM9.684 15.54V8.46L15.816 12l-6.132 3.54z"/></svg>',
		),
		'pixelfed'    => array(
			'name' => _x( 'Pixelfed', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 24C5.3726 24 0 18.6274 0 12S5.3726 0 12 0s12 5.3726 12 12-5.3726 12-12 12m-.9526-9.3802h2.2014c2.0738 0 3.7549-1.6366 3.7549-3.6554S15.3226 7.309 13.2488 7.309h-3.1772c-1.1964 0-2.1663.9442-2.1663 2.1089v8.208z"/></svg>',
		),
		'matrix'       => array(
			'name' => _x( 'Matrix', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M.632.55v22.9H2.28V24H0V0h2.28v.55zm7.043 7.26v1.157h.033c.309-.443.683-.784 1.117-1.024.433-.245.936-.365 1.5-.365.54 0 1.033.107 1.481.314.448.208.785.582 1.02 1.108.254-.374.6-.706 1.034-.992.434-.287.95-.43 1.546-.43.453 0 .872.056 1.26.167.388.11.716.286.993.53.276.245.489.559.646.951.152.392.23.863.23 1.417v5.728h-2.349V11.52c0-.286-.01-.559-.032-.812a1.755 1.755 0 0 0-.18-.66 1.106 1.106 0 0 0-.438-.448c-.194-.11-.457-.166-.785-.166-.332 0-.6.064-.803.189a1.38 1.38 0 0 0-.48.499 1.946 1.946 0 0 0-.231.696 5.56 5.56 0 0 0-.06.785v4.768h-2.35v-4.8c0-.254-.004-.503-.018-.752a2.074 2.074 0 0 0-.143-.688 1.052 1.052 0 0 0-.415-.503c-.194-.125-.476-.19-.854-.19-.111 0-.259.024-.439.074-.18.051-.36.143-.53.282-.171.138-.319.337-.439.595-.12.259-.18.6-.18 1.02v4.966H5.46V7.81zm15.693 15.64V.55H21.72V0H24v24h-2.28v-.55z"/></svg>',
		),
		'protonmail'  => array(
			'name' => _x( 'ProtonMail', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="m15.24 8.998 3.656-3.073v15.81H2.482C1.11 21.735 0 20.609 0 19.223V6.944l7.58 6.38a2.186 2.186 0 0 0 2.871-.042l4.792-4.284h-.003zm-5.456 3.538 1.809-1.616a2.438 2.438 0 0 1-1.178-.533L.905 2.395A.552.552 0 0 0 0 2.826v2.811l8.226 6.923a1.186 1.186 0 0 0 1.558-.024zM23.871 2.463a.551.551 0 0 0-.776-.068l-3.199 2.688v16.653h1.623c1.371 0 2.481-1.127 2.481-2.513V2.824a.551.551 0 0 0-.129-.36z"/></svg>',
		),
		'paypal'      => array(
			'name' => _x( 'PayPal', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M15.607 4.653H8.941L6.645 19.251H1.82L4.862 0h7.995c3.754 0 6.375 2.294 6.473 5.513-.648-.478-2.105-.86-3.722-.86m6.57 5.546c0 3.41-3.01 6.853-6.958 6.853h-2.493L11.595 24H6.74l1.845-11.538h3.592c4.208 0 7.346-3.634 7.153-6.949a5.24 5.24 0 0 1 2.848 4.686M9.653 5.546h6.408c.907 0 1.942.222 2.363.541-.195 2.741-2.655 5.483-6.441 5.483H8.714Z"/></svg>',
		),
		'antennapod'  => array(
			'name' => _x( 'AntennaPod', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 7.188 10.98l3.339-9.459a2.118 2.118 0 1 1 2.946 0l3.339 9.46A12 12 0 0 0 24 12 12 12 0 0 0 12 0m0 2.824a9.177 9.177 0 0 1 4.969 16.892l-.486-1.376a7.765 7.765 0 1 0-8.967 0l-.485 1.376A9.177 9.177 0 0 1 12 2.824m0 3.529a5.647 5.647 0 0 1 3.739 9.879l-.521-1.478a4.235 4.235 0 1 0-6.436 0l-.522 1.478A5.647 5.647 0 0 1 12 6.353m0 8.298-1.618 4.584a7.4 7.4 0 0 0 3.236 0zm-2.21 6.258-.937 2.656A12 12 0 0 0 12 24a12 12 0 0 0 3.146-.435l-.937-2.656a9.2 9.2 0 0 1-2.209.267 9.2 9.2 0 0 1-2.21-.267"/></svg>',
		),
		'caldotcom'   => array(
			'name' => _x( 'Cal.com', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M2.408 14.488C1.035 14.488 0 13.4 0 12.058c0-1.346.982-2.443 2.408-2.443.758 0 1.282.233 1.691.765l-.66.55a1.343 1.343 0 0 0-1.03-.442c-.93 0-1.44.711-1.44 1.57 0 .86.559 1.557 1.44 1.557.413 0 .765-.147 1.043-.443l.651.573c-.391.51-.929.743-1.695.743zM6.948 10.913h.89v3.49h-.89v-.51c-.185.362-.493.604-1.083.604-.943 0-1.695-.82-1.695-1.826 0-1.007.752-1.825 1.695-1.825.585 0 .898.241 1.083.604zm.026 1.758c0-.546-.374-.998-.964-.998-.568 0-.938.457-.938.998 0 .528.37.998.938.998.586 0 .964-.456.964-.998zM8.467 9.503h.89v4.895h-.89zM9.752 13.937a.53.53 0 0 1 .542-.528c.313 0 .533.242.533.528a.527.527 0 0 1-.533.537.534.534 0 0 1-.542-.537zM14.23 13.839c-.33.403-.832.658-1.426.658a1.806 1.806 0 0 1-1.84-1.826c0-1.007.778-1.825 1.84-1.825.572 0 1.07.241 1.4.622l-.687.577c-.172-.215-.396-.376-.713-.376-.568 0-.938.456-.938.998 0 .541.37.997.938.997.343 0 .58-.179.757-.42zM14.305 12.671c0-1.007.78-1.825 1.84-1.825 1.061 0 1.84.818 1.84 1.825 0 1.007-.779 1.826-1.84 1.826-1.06-.005-1.84-.82-1.84-1.826zm2.778 0c0-.546-.37-.998-.938-.998-.568-.004-.937.452-.937.998 0 .542.37.998.937.998.568 0 .938-.456.938-.998zM24 12.269v2.13h-.89v-1.911c0-.604-.281-.864-.704-.864-.396 0-.678.197-.678.864v1.91h-.89v-1.91c0-.604-.285-.864-.704-.864-.396 0-.744.197-.744.864v1.91h-.89v-3.49h.89v.484c.185-.376.52-.564 1.035-.564.489 0 .898.241 1.123.649.224-.417.554-.65 1.153-.65.731.005 1.299.56 1.299 1.442z"/></svg>',
		),
		'fedora'      => array(
			'name' => _x( 'Fedora', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12.001 0C5.376 0 .008 5.369.004 11.992H.002v9.287h.002A2.726 2.726 0 0 0 2.73 24h9.275c6.626-.004 11.993-5.372 11.993-11.997C23.998 5.375 18.628 0 12 0zm2.431 4.94c2.015 0 3.917 1.543 3.917 3.671 0 .197.001.395-.03.619a1.002 1.002 0 0 1-1.137.893 1.002 1.002 0 0 1-.842-1.175 2.61 2.61 0 0 0 .013-.337c0-1.207-.987-1.672-1.92-1.672-.934 0-1.775.784-1.777 1.672.016 1.027 0 2.046 0 3.07l1.732-.012c1.352-.028 1.368 2.009.016 1.998l-1.748.013c-.004.826.006.677.002 1.093 0 0 .015 1.01-.016 1.776-.209 2.25-2.124 4.046-4.424 4.046-2.438 0-4.448-1.993-4.448-4.437.073-2.515 2.078-4.492 4.603-4.469l1.409-.01v1.996l-1.409.013h-.007c-1.388.04-2.577.984-2.6 2.47a2.438 2.438 0 0 0 2.452 2.439c1.356 0 2.441-.987 2.441-2.437l-.001-7.557c0-.14.005-.252.02-.407.23-1.848 1.883-3.256 3.754-3.256z"/></svg>',
		),
		'googlephotos' => array(
			'name' => _x( 'Google Photos', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12.678 16.672c0 2.175.002 4.565-.001 6.494-.001.576-.244.814-.817.833-7.045.078-8.927-7.871-4.468-11.334-1.95.016-4.019.007-5.986.007-1.351 0-1.414-.01-1.405-1.351.258-6.583 7.946-8.275 11.323-3.936L11.308.928c-.001-.695.212-.906.906-.925 6.409-.187 9.16 7.308 4.426 11.326l6.131.002c1.097 0 1.241.105 1.228 1.217-.223 6.723-7.802 8.376-11.321 4.124zm.002-15.284l-.003 9.972c6.56-.465 6.598-9.532.003-9.972zm-1.36 21.224l-.001-9.97c-6.927.598-6.29 9.726.002 9.97zM1.4 11.315l9.95.008c-.527-6.829-9.762-6.367-9.95-.008zm11.238 1.365c.682 6.875 9.67 6.284 9.977.01z"/></svg>',
		),
		'googlescholar' => array(
			'name' => _x( 'Google Scholar', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M5.242 13.769L0 9.5 12 0l12 9.5-5.242 4.269C17.548 11.249 14.978 9.5 12 9.5c-2.977 0-5.548 1.748-6.758 4.269zM12 10a7 7 0 1 0 0 14 7 7 0 0 0 0-14z"/></svg>',
		),
		'mendeley'    => array(
			'name' => _x( 'Mendeley', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12.0037 9.1684h.019a2.355 2.355 0 011.5038 4.1655 1.8076 1.8076 0 01-.8561.452 2.348 2.348 0 01-.6487.0923h-.019c-.2246 0-.4421-.033-.6487-.0922a1.8126 1.8126 0 01-.8561-.4521 2.346 2.346 0 01-.8511-1.8106 2.358 2.358 0 012.3569-2.355m-9.9731 9.474c1.2652.1583 2.388-.762 2.5073-2.0573a2.4442 2.4442 0 00-.2136-1.236c-1.7724-3.8889 6.9726-3.978 5.4949-.3078l-.01.016c-.6988 1.1178-.3198 2.5695.841 3.2402.4272.2486.9003.3508 1.3625.3308.4622.02.9354-.0822 1.3624-.3308 1.161-.6717 1.54-2.1224.8412-3.2402l-.01-.016c-1.4778-3.6703 7.2682-3.581 5.4938.3077a2.4462 2.4462 0 00-.2126 1.2361c.1203 1.2953 1.2422 2.2156 2.5083 2.0572a2.345 2.345 0 001.4246-.7368s.5885-.4883.5795-1.7334c-.008-1.0156-.5795-1.578-.5795-1.578a2.2116 2.2116 0 00-1.8145-.6456c-1.6231-.036-1.8637-1.3073-1.4056-3.7033.1685-.4251.2416-.8802.2266-1.3354a3.4166 3.4166 0 00-2.1304-3.2953c-.039-.017-.0782-.03-.1183-.0461a1.5138 1.5138 0 00-.1343-.0461 3.4156 3.4156 0 00-4.004 1.4526c-.8171.8973-1.187 1.4417-2.0272 1.4417-.799 0-1.211-.5444-2.0271-1.4417a3.4126 3.4126 0 00-4.1374-1.4075c-.0401.016-.0792.029-.1193.0461a3.4156 3.4156 0 00-2.1294 3.2953c-.016.4552.0582.9103.2256 1.3354.4581 2.397.2175 3.6672-1.4045 3.7033-.795-.0852-1.3885.2426-1.988.8431-.6016.5995-.5514 2.2056 0 2.9063.4.5103.9423.8632 1.598.9454"/></svg>',
		),
		'notion'      => array(
			'name' => _x( 'Notion', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M4.459 4.208c.746.606 1.026.56 2.428.466l13.215-.793c.28 0 .047-.28-.046-.326L17.86 1.968c-.42-.326-.981-.7-2.055-.607L3.01 2.295c-.466.046-.56.28-.374.466zm.793 3.08v13.904c0 .747.373 1.027 1.214.98l14.523-.84c.841-.046.935-.56.935-1.167V6.354c0-.606-.233-.933-.748-.887l-15.177.887c-.56.047-.747.327-.747.933zm14.337.745c.093.42 0 .84-.42.888l-.7.14v10.264c-.608.327-1.168.514-1.635.514-.748 0-.935-.234-1.495-.933l-4.577-7.186v6.952L12.21 19s0 .84-1.168.84l-3.222.186c-.093-.186 0-.653.327-.746l.84-.233V9.854L7.822 9.76c-.094-.42.14-1.026.793-1.073l3.456-.233 4.764 7.279v-6.44l-1.215-.139c-.093-.514.28-.887.747-.933zM1.936 1.035l13.31-.98c1.634-.14 2.055-.047 3.082.7l4.249 2.986c.7.513.934.653.934 1.213v16.378c0 1.026-.373 1.634-1.68 1.726l-15.458.934c-.98.047-1.448-.093-1.962-.747l-3.129-4.06c-.56-.747-.793-1.306-.793-1.96V2.667c0-.839.374-1.54 1.447-1.632z"/></svg>',
		),
		'overcast'    => array(
			'name' => _x( 'Overcast', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12 24C5.389 24.018.017 18.671 0 12.061V12C0 5.35 5.351 0 12 0s12 5.35 12 12c0 6.649-5.351 12-12 12zm0-4.751l.9-.899-.9-3.45-.9 3.45.9.899zm-1.15-.05L10.4 20.9l1.05-1.052-.6-.649zm2.3 0l-.6.601 1.05 1.051-.45-1.652zm.85 3.102L12 20.3l-2 2.001c.65.1 1.3.199 2 .199s1.35-.05 2-.199zM12 1.5C6.201 1.5 1.5 6.201 1.5 12c-.008 4.468 2.825 8.446 7.051 9.899l2.25-8.35c-.511-.372-.809-.968-.801-1.6 0-1.101.9-2.001 2-2.001s2 .9 2 2.001c0 .649-.301 1.2-.801 1.6l2.25 8.35c4.227-1.453 7.06-5.432 7.051-9.899 0-5.799-4.701-10.5-10.5-10.5zm6.85 15.7c-.255.319-.714.385-1.049.15-.313-.207-.4-.628-.194-.941.014-.021.028-.04.044-.06 0 0 1.35-1.799 1.35-4.35s-1.35-4.35-1.35-4.35c-.239-.289-.198-.719.091-.957.02-.016.039-.031.06-.044.335-.235.794-.169 1.049.15.1.101 1.65 2.15 1.65 5.2S18.949 17.1 18.85 17.2zm-3.651-1.95c-.3-.3-.249-.85.051-1.15 0 0 .75-.799.75-2.1s-.75-2.051-.75-2.1c-.3-.301-.3-.801-.051-1.15.232-.303.666-.357.969-.125.029.022.056.047.082.074C16.301 8.75 17.5 10 17.5 12s-1.199 3.25-1.25 3.301c-.301.299-.75.25-1.051-.051zm-6.398 0c-.301.301-.75.35-1.051.051C7.699 15.199 6.5 14 6.5 12s1.199-3.199 1.25-3.301c.301-.299.801-.299 1.051.051.3.3.249.85-.051 1.15 0 .049-.75.799-.75 2.1s.75 2.1.75 2.1c.3.3.351.799.051 1.15zm-2.602 2.101c-.335.234-.794.169-1.05-.15C5.051 17.1 3.5 15.05 3.5 12s1.551-5.1 1.649-5.2c.256-.319.715-.386 1.05-.15.313.206.4.628.194.941-.013.02-.028.04-.043.059C6.35 7.65 5 9.449 5 12s1.35 4.35 1.35 4.35c.25.3.15.75-.151 1.001z"/></svg>',
		),
		'pexels'      => array(
			'name' => _x( 'Pexels', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M1.5 0A1.5 1.5 0 000 1.5v21A1.5 1.5 0 001.5 24h21a1.5 1.5 0 001.5-1.5v-21A1.5 1.5 0 0022.5 0h-21zm6.75 6.75h5.2715a3.843 3.843 0 01.627 7.6348V17.25H8.25V6.75zm1.5 1.5v7.5h2.8984v-2.8145h.873a2.343 2.343 0 100-4.6855H9.75Z"/></svg>',
		),
		'pocketcasts' => array(
			'name' => _x( 'Pocket Casts', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M12,0C5.372,0,0,5.372,0,12c0,6.628,5.372,12,12,12c6.628,0,12-5.372,12-12 C24,5.372,18.628,0,12,0z M15.564,12c0-1.968-1.596-3.564-3.564-3.564c-1.968,0-3.564,1.595-3.564,3.564 c0,1.968,1.595,3.564,3.564,3.564V17.6c-3.093,0-5.6-2.507-5.6-5.6c0-3.093,2.507-5.6,5.6-5.6c3.093,0,5.6,2.507,5.6,5.6H15.564z M19,12c0-3.866-3.134-7-7-7c-3.866,0-7,3.134-7,7c0,3.866,3.134,7,7,7v2.333c-5.155,0-9.333-4.179-9.333-9.333 c0-5.155,4.179-9.333,9.333-9.333c5.155,0,9.333,4.179,9.333,9.333H19z"/></svg>',
		),
		'strava'      => array(
			'name' => _x( 'Strava', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M15.387 17.944l-2.089-4.116h-3.065L15.387 24l5.15-10.172h-3.066m-7.008-5.599l2.836 5.598h4.172L10.463 0l-7 13.828h4.169"/></svg>',
		),
		'wechat'      => array(
			'name' => _x( 'WeChat', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M8.691 2.188C3.891 2.188 0 5.476 0 9.53c0 2.212 1.17 4.203 3.002 5.55a.59.59 0 0 1 .213.665l-.39 1.48c-.019.07-.048.141-.048.213 0 .163.13.295.29.295a.326.326 0 0 0 .167-.054l1.903-1.114a.864.864 0 0 1 .717-.098 10.16 10.16 0 0 0 2.837.403c.276 0 .543-.027.811-.05-.857-2.578.157-4.972 1.932-6.446 1.703-1.415 3.882-1.98 5.853-1.838-.576-3.583-4.196-6.348-8.596-6.348zM5.785 5.991c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 0 1-1.162 1.178A1.17 1.17 0 0 1 4.623 7.17c0-.651.52-1.18 1.162-1.18zm5.813 0c.642 0 1.162.529 1.162 1.18a1.17 1.17 0 0 1-1.162 1.178 1.17 1.17 0 0 1-1.162-1.178c0-.651.52-1.18 1.162-1.18zm5.34 2.867c-1.797-.052-3.746.512-5.28 1.786-1.72 1.428-2.687 3.72-1.78 6.22.942 2.453 3.666 4.229 6.884 4.229.826 0 1.622-.12 2.361-.336a.722.722 0 0 1 .598.082l1.584.926a.272.272 0 0 0 .14.047c.134 0 .24-.111.24-.247 0-.06-.023-.12-.038-.177l-.327-1.233a.582.582 0 0 1-.023-.156.49.49 0 0 1 .201-.398C23.024 18.48 24 16.82 24 14.98c0-3.21-2.931-5.837-6.656-6.088V8.89c-.135-.01-.27-.027-.407-.03zm-2.53 3.274c.535 0 .969.44.969.982a.976.976 0 0 1-.969.983.976.976 0 0 1-.969-.983c0-.542.434-.982.97-.982zm4.844 0c.535 0 .969.44.969.982a.976.976 0 0 1-.969.983.976.976 0 0 1-.969-.983c0-.542.434-.982.969-.982z"/></svg>',
		),
		'zulip'       => array(
			'name' => _x( 'Zulip', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M22.767 3.589c0 1.209-.543 2.283-1.37 2.934l-8.034 7.174c-.149.128-.343-.078-.235-.25l2.946-5.9c.083-.165-.024-.368-.194-.368H4.452c-1.77 0-3.219-1.615-3.219-3.59C1.233 1.616 2.682 0 4.452 0h15.096c1.77-.001 3.219 1.614 3.219 3.589zM4.452 24h15.096c1.77 0 3.219-1.616 3.219-3.59 0-1.974-1.449-3.59-3.219-3.59H8.12c-.17 0-.277-.202-.194-.367l2.946-5.9c.108-.172-.086-.378-.235-.25l-8.033 7.173c-.828.65-1.37 1.725-1.37 2.934 0 1.974 1.448 3.59 3.218 3.59z"/></svg>',
		),
		'podcastaddict' => array(
			'name' => _x( 'Podcast Addict', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M5.36.037C2.41.037 0 2.447 0 5.397v13.207c0 2.95 2.41 5.36 5.36 5.36h13.28c2.945 0 5.36-2.41 5.36-5.36V5.396c0-2.95-2.415-5.36-5.36-5.36zm6.585 4.285a7.72 7.72 0 017.717 7.544l.005 7.896h-3.39v-1.326a7.68 7.68 0 01-4.327 1.326 7.777 7.777 0 01-2.384-.378v-4.63a3.647 3.647 0 002.416.91 3.666 3.666 0 003.599-2.97h-1.284a2.416 2.416 0 01-4.73-.66v-.031c0-1.095.728-2.023 1.728-2.316V8.403a3.67 3.67 0 00-2.975 3.6v6.852a7.72 7.72 0 013.625-14.533zm.031 1.87V7.43h.006a4.575 4.575 0 014.573 4.574v.01h1.237v-.01a5.81 5.81 0 00-5.81-5.81zm0 2.149v1.246h.006a2.413 2.413 0 012.415 2.416v.01h1.247v-.01a3.662 3.662 0 00-3.662-3.662zm0 2.252c-.78 0-1.409.629-1.409 1.41 0 .78.629 1.409 1.41 1.409.78 0 1.409-.629 1.409-1.41 0-.78-.629-1.409-1.41-1.409z"/></svg>',
		),
		'applepodcasts' => array(
			'name' => _x( 'Apple Podcasts', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M5.34 0A5.328 5.328 0 000 5.34v13.32A5.328 5.328 0 005.34 24h13.32A5.328 5.328 0 0024 18.66V5.34A5.328 5.328 0 0018.66 0zm6.525 2.568c2.336 0 4.448.902 6.056 2.587 1.224 1.272 1.912 2.619 2.264 4.392.12.59.12 2.2.007 2.864a8.506 8.506 0 01-3.24 5.296c-.608.46-2.096 1.261-2.336 1.261-.088 0-.096-.091-.056-.46.072-.592.144-.715.48-.856.536-.224 1.448-.874 2.008-1.435a7.644 7.644 0 002.008-3.536c.208-.824.184-2.656-.048-3.504-.728-2.696-2.928-4.792-5.624-5.352-.784-.16-2.208-.16-3 0-2.728.56-4.984 2.76-5.672 5.528-.184.752-.184 2.584 0 3.336.456 1.832 1.64 3.512 3.192 4.512.304.2.672.408.824.472.336.144.408.264.472.856.04.36.03.464-.056.464-.056 0-.464-.176-.896-.384l-.04-.03c-2.472-1.216-4.056-3.274-4.632-6.012-.144-.706-.168-2.392-.03-3.04.36-1.74 1.048-3.1 2.192-4.304 1.648-1.737 3.768-2.656 6.128-2.656zm.134 2.81c.409.004.803.04 1.106.106 2.784.62 4.76 3.408 4.376 6.174-.152 1.114-.536 2.03-1.216 2.88-.336.43-1.152 1.15-1.296 1.15-.023 0-.048-.272-.048-.603v-.605l.416-.496c1.568-1.878 1.456-4.502-.256-6.224-.664-.67-1.432-1.064-2.424-1.246-.64-.118-.776-.118-1.448-.008-1.02.167-1.81.562-2.512 1.256-1.72 1.704-1.832 4.342-.264 6.222l.413.496v.608c0 .336-.027.608-.06.608-.03 0-.264-.16-.512-.36l-.034-.011c-.832-.664-1.568-1.842-1.872-2.997-.184-.698-.184-2.024.008-2.72.504-1.878 1.888-3.335 3.808-4.019.41-.145 1.133-.22 1.814-.211zm-.13 2.99c.31 0 .62.06.844.178.488.253.888.745 1.04 1.259.464 1.578-1.208 2.96-2.72 2.254h-.015c-.712-.331-1.096-.956-1.104-1.77 0-.733.408-1.371 1.112-1.745.224-.117.534-.176.844-.176zm-.011 4.728c.988-.004 1.706.349 1.97.97.198.464.124 1.932-.218 4.302-.232 1.656-.36 2.074-.68 2.356-.44.39-1.064.498-1.656.288h-.003c-.716-.257-.87-.605-1.164-2.644-.341-2.37-.416-3.838-.218-4.302.262-.616.974-.966 1.97-.97z"/></svg>',
		),
		'ivoox'       => array(
			'name' => _x( 'iVoox', 'social link block variation name', 'simple-social-icons' ),
			'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><g transform="translate(0, 24) scale(0.005797, -0.005797)"><path d="M693 4130 c-314 -47 -557 -257 -664 -575 l-24 -70 -3 -1380 c-2 -1228 -1 -1389 13 -1459 64 -317 314 -567 631 -631 70 -14 231 -15 1454 -13 1548 3 1410 -4 1585 82 214 106 365 291 427 526 l23 85 0 1370 c0 1546 5 1439 -79 1612 -104 213 -293 370 -525 436 l-76 22 -1355 1 c-745 1 -1378 -2 -1407 -6z m1517 -430 c65 -18 144 -73 177 -123 43 -64 56 -117 51 -198 -6 -75 -43 -154 -91 -195 -80 -67 -201 -101 -325 -90 -202 18 -325 136 -325 311 0 198 161 324 398 310 44 -2 96 -9 115 -15z m-836 -622 c2 -13 9 -57 15 -98 34 -225 209 -409 447 -470 162 -42 366 -36 515 15 219 74 360 242 398 474 l16 101 378 0 377 0 0 -23 c0 -50 -22 -197 -41 -272 -75 -295 -306 -568 -614 -723 -91 -45 -222 -93 -307 -112 -32 -7 -58 -16 -58 -20 0 -4 26 -13 58 -20 219 -48 452 -173 614 -328 207 -198 316 -429 343 -724 l7 -78 -380 0 -380 0 -7 66 c-38 355 -329 573 -735 550 -205 -11 -355 -70 -471 -186 -93 -92 -169 -257 -169 -366 0 -68 27 -64 -388 -64 l-375 0 6 93 c18 264 148 536 345 718 82 76 235 178 335 224 90 40 242 92 297 101 51 8 51 20 0 28 -60 9 -216 64 -307 107 -190 91 -384 252 -486 406 -106 159 -172 350 -184 531 l-6 92 376 0 377 0 4 -22z"/></g></svg>',
		),
	);

	return array_merge( $services_data, $custom_services );
}
