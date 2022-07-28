<?php
/**
 * Plugin Name: Simple Social Icons
 * Plugin URI: https://wordpress.org/plugins/simple-social-icons/
 * Description: A simple CSS and SVG driven social icons widget.
 * Author: StudioPress
 * Author URI: https://www.studiopress.com/
 * Version: 3.1.1
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
	protected $version = '3.0.2';

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
				'dribbble'               => '',
				'email'                  => '',
				'facebook'               => '',
				'flickr'                 => '',
				'github'                 => '',
				'goodreads'              => '',
				'instagram'              => '',
				'linkedin'               => '',
				'medium'                 => '',
				'meetup'                 => '',
				'periscope'              => '',
				'phone'                  => '',
				'pinterest'              => '',
				'reddit'                 => '',
				'rss'                    => '',
				'snapchat'               => '',
				'tiktok'                 => '',
				'tripadvisor'            => '',
				'tumblr'                 => '',
				'twitter'                => '',
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
				'dribbble'    => array(
					'label'   => __( 'Dribbble URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'dribbble', __( 'Dribbble', 'simple-social-icons' ) ),
				),
				'email'       => array(
					'label'   => __( 'Email URI', 'simple-social-icons' ),
					'pattern' => $this->get_icon_markup( 'email', __( 'Email', 'simple-social-icons' ) ),
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
					'label'   => __( 'Twitter URI', 'simple-social-icons' ),
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
