<?php
/*
Plugin Name: Simple Social Icons
Plugin URI: http://wordpress.org/plugins/simple-social-icons/
Description: A simple CSS and SVG driven social icons widget.
Author: Nathan Rice
Author URI: http://www.nathanrice.net/

Version: 2.0.1

Text Domain: simple-social-icons
Domain Path: /languages

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

add_action( 'plugins_loaded', 'simple_social_icons_load_textdomain' );
/**
 * Load textdomain
 */
function simple_social_icons_load_textdomain() {
	load_plugin_textdomain( 'simple-social-icons', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

class Simple_Social_Icons_Widget extends WP_Widget {

	/**
	 * Plugin version for enqueued static resources.
	 *
	 * @var string
	 */
	protected $version = '2.0.1';

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
	 * Constructor method.
	 *
	 * Set some global values and create widget.
	 */
	function __construct() {

		/**
		 * Default widget option values.
		 */
		$this->defaults = apply_filters( 'simple_social_default_styles', array(
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
			'behance'                => '',
			'bloglovin'              => '',
			'dribbble'               => '',
			'email'                  => '',
			'facebook'               => '',
			'flickr'                 => '',
			'github'                 => '',
			'gplus'                  => '',
			'instagram'              => '',
			'linkedin'               => '',
			'medium'                 => '',
			'periscope'              => '',
			'phone'                  => '',
			'pinterest'              => '',
			'rss'                    => '',
			'snapchat'               => '',
			'stumbleupon'            => '',
			'tumblr'                 => '',
			'twitter'                => '',
			'vimeo'                  => '',
			'xing'                   => '',
			'youtube'                => '',
		) );

		/**
		 * Social profile choices.
		 */
		$this->profiles = apply_filters( 'simple_social_default_profiles', array(
			'behance' => array(
				'label'   => __( 'Behance URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-behance"><a href="%s" %s><svg role="img" class="social-behance" aria-labelledby="social-behance"><title id="social-behance">' . __( 'Behance', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-behance' ) . '"></use></svg></a></li>',
			),
			'bloglovin' => array(
				'label'   => __( 'Bloglovin URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-bloglovin"><a href="%s" %s><svg role="img" class="social-bloglovin" aria-labelledby="social-bloglovin"><title id="social-bloglovin">' . __( 'Bloglovin', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-bloglovin' ) . '"></use></svg></a></li>',
			),
			'dribbble' => array(
				'label'   => __( 'Dribbble URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-dribbble"><a href="%s" %s><svg role="img" class="social-dribbble" aria-labelledby="social-dribbble"><title id="social-dribbble">' . __( 'Dribbble', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-dribbble' ) . '"></use></svg></a></li>',
			),
			'email' => array(
				'label'   => __( 'Email URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-email"><a href="%s" %s><svg role="img" class="social-email" aria-labelledby="social-email"><title id="social-email">' . __( 'Email', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-email' ) . '"></use></svg></a></li>',
			),
			'facebook' => array(
				'label'   => __( 'Facebook URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-facebook"><a href="%s" %s><svg role="img" class="social-facebook" aria-labelledby="social-facebook"><title id="social-facebook">' . __( 'Facebook', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-facebook' ) . '"></use></svg></a></li>',
			),
			'flickr' => array(
				'label'   => __( 'Flickr URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-flickr"><a href="%s" %s><svg role="img" class="social-flickr" aria-labelledby="social-flickr"><title id="social-flickr">' . __( 'Flickr', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-flickr' ) . '"></use></svg></a></li>',
			),
			'github' => array(
				'label'   => __( 'GitHub URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-github"><a href="%s" %s><svg role="img" class="social-github" aria-labelledby="social-github"><title id="social-github">' . __( 'Github', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-github' ) . '"></use></svg></a></li>',
			),
			'gplus' => array(
				'label'   => __( 'Google+ URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-gplus"><a href="%s" %s><svg role="img" class="social-gplus" aria-labelledby="social-gplus"><title id="social-gplus">' . __( 'Google+', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-gplus' ) . '"></use></svg></a></li>',
			),
			'instagram' => array(
				'label'   => __( 'Instagram URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-instagram"><a href="%s" %s><svg role="img" class="social-instagram" aria-labelledby="social-instagram"><title id="social-instagram">' . __( 'Instagram', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-instagram' ) . '"></use></svg></a></li>',
			),
			'linkedin' => array(
				'label'   => __( 'Linkedin URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-linkedin"><a href="%s" %s><svg role="img" class="social-linkedin" aria-labelledby="social-linkedin"><title id="social-linkedin">' . __( 'Linkedin', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-linkedin' ) . '"></use></svg></a></li>',
			),
			'medium' => array(
				'label'   => __( 'Medium URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-medium"><a href="%s" %s><svg role="img" class="social-medium" aria-labelledby="social-medium"><title id="social-medium">' . __( 'Medium', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-medium' ) . '"></use></svg></a></li>',
			),
			'periscope' => array(
				'label'   => __( 'Periscope URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-periscope"><a href="%s" %s><svg role="img" class="social-periscope" aria-labelledby="social-periscope"><title id="social-periscope">' . __( 'Periscope', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-periscope' ) . '"></use></svg></a></li>',
			),
			'phone' => array(
				'label'   => __( 'Phone URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-phone"><a href="%s" %s><svg role="img" class="social-phone" aria-labelledby="social-phone"><title id="social-phone">' . __( 'Phone', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-phone' ) . '"></use></svg></a></li>',
			),
			'pinterest' => array(
				'label'   => __( 'Pinterest URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-pinterest"><a href="%s" %s><svg role="img" class="social-pinterest" aria-labelledby="social-pinterest"><title id="social-pinterest">' . __( 'Pinterest', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-pinterest' ) . '"></use></svg></a></li>',
			),
			'rss' => array(
				'label'   => __( 'RSS URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-rss"><a href="%s" %s><svg role="img" class="social-rss" aria-labelledby="social-rss"><title id="social-rss">' . __( 'RSS', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-rss' ) . '"></use></svg></a></li>',
			),
			'snapchat' => array(
				'label'   => __( 'Snapchat URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-snapchat"><a href="%s" %s><svg role="img" class="social-snapchat" aria-labelledby="social-snapchat"><title id="social-snapchat">' . __( 'Snapchat', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-snapchat' ) . '"></use></svg></a></li>',
			),
			'stumbleupon' => array(
				'label'   => __( 'StumbleUpon URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-stumbleupon"><a href="%s" %s><svg role="img" class="social-stumbleupon" aria-labelledby="social-stumbleupon"><title id="social-stumbleupon">' . __( 'StumbleUpon', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-stumbleupon' ) . '"></use></svg></a></li>',
			),
			'tumblr' => array(
				'label'   => __( 'Tumblr URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-tumblr"><a href="%s" %s><svg role="img" class="social-tumblr" aria-labelledby="social-tumblr"><title id="social-tumblr">' . __( 'Tumblr', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-tumblr' ) . '"></use></svg></a></li>',
			),
			'twitter' => array(
				'label'   => __( 'Twitter URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-twitter"><a href="%s" %s><svg role="img" class="social-twitter" aria-labelledby="social-twitter"><title id="social-twitter">' . __( 'Twitter', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-twitter' ) . '"></use></svg></a></li>',
			),
			'vimeo' => array(
				'label'   => __( 'Vimeo URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-vimeo"><a href="%s" %s><svg role="img" class="social-vimeo" aria-labelledby="social-vimeo"><title id="social-vimeo">' . __( 'Vimeo', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-vimeo' ) . '"></use></svg></a></li>',
			),
			'xing' => array(
				'label'   => __( 'Xing URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-xing"><a href="%s" %s><svg role="img" class="social-xing" aria-labelledby="social-xing"><title id="social-xing">' . __( 'Xing', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-xing' ) . '"></use></svg></a></li>',
			),
			'youtube' => array(
				'label'   => __( 'YouTube URI', 'simple-social-icons' ),
				'pattern' => '<li class="ssi-youtube"><a href="%s" %s><svg role="img" class="social-youtube" aria-labelledby="social-youtube"><title id="social-youtube">' . __( 'YouTube', 'simple-social-icons' ) . '</title><use xlink:href="' . esc_url( plugin_dir_url(__FILE__) . 'symbol-defs.svg#social-youtube' ) . '"></use></svg></a></li>',
			),
		) );

		$widget_ops = array(
			'classname'   => 'simple-social-icons',
			'description' => __( 'Displays select social icons.', 'simple-social-icons' ),
		);

		$control_ops = array(
			'id_base' => 'simple-social-icons',
		);

		parent::__construct( 'simple-social-icons', __( 'Simple Social Icons', 'simple-social-icons' ), $widget_ops, $control_ops );

		/** Enqueue scripts and styles */
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_css' ) );

		/** Load CSS in <head> */
		add_action( 'wp_head', array( $this, 'css' ) );

		/** Load color picker */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_color_picker' ) );
		add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 );

	}

	/**
	 * Color Picker.
	 *
	 * Enqueue the color picker script.
	 *
	 */
	function load_color_picker( $hook ) {
		if( 'widgets.php' != $hook )
			return;
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'underscore' );
	}

	/**
	 * Print scripts.
	 *
	 * Reference https://core.trac.wordpress.org/attachment/ticket/25809/color-picker-widget.php
	 *
	 */
	function print_scripts() {
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
	 */
	function form( $instance ) {

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		?>

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'simple-social-icons' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

		<p><label><input id="<?php echo $this->get_field_id( 'new_window' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="1" <?php checked( 1, $instance['new_window'] ); ?>/> <?php esc_html_e( 'Open links in new window?', 'simple-social-icons' ); ?></label></p>

		<p><label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Icon Size', 'simple-social-icons' ); ?>:</label> <input id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>" type="text" value="<?php echo esc_attr( $instance['size'] ); ?>" size="3" />px</p>

		<p><label for="<?php echo $this->get_field_id( 'border_radius' ); ?>"><?php _e( 'Icon Border Radius:', 'simple-social-icons' ); ?></label> <input id="<?php echo $this->get_field_id( 'border_radius' ); ?>" name="<?php echo $this->get_field_name( 'border_radius' ); ?>" type="text" value="<?php echo esc_attr( $instance['border_radius'] ); ?>" size="3" />px</p>

		<p><label for="<?php echo $this->get_field_id( 'border_width' ); ?>"><?php _e( 'Border Width:', 'simple-social-icons' ); ?></label> <input id="<?php echo $this->get_field_id( 'border_width' ); ?>" name="<?php echo $this->get_field_name( 'border_width' ); ?>" type="text" value="<?php echo esc_attr( $instance['border_width'] ); ?>" size="3" />px</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'alignment' ); ?>"><?php _e( 'Alignment', 'simple-social-icons' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>">
				<option value="alignleft" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Left', 'simple-social-icons' ); ?></option>
				<option value="aligncenter" <?php selected( 'aligncenter', $instance['alignment'] ) ?>><?php _e( 'Align Center', 'simple-social-icons' ); ?></option>
				<option value="alignright" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Right', 'simple-social-icons' ); ?></option>
			</select>
		</p>

		<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

		<p><label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Icon Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo $this->get_field_id( 'icon_color' ); ?>" name="<?php echo $this->get_field_name( 'icon_color' ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['icon_color'] ); ?>" value="<?php echo esc_attr( $instance['icon_color'] ); ?>" size="6" /></p>

		<p><label for="<?php echo $this->get_field_id( 'background_color_hover' ); ?>"><?php _e( 'Icon Hover Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo $this->get_field_id( 'icon_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'icon_color_hover' ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['icon_color_hover'] ); ?>" value="<?php echo esc_attr( $instance['icon_color_hover'] ); ?>" size="6" /></p>

		<p><label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Background Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['background_color'] ); ?>" value="<?php echo esc_attr( $instance['background_color'] ); ?>" size="6" /></p>

		<p><label for="<?php echo $this->get_field_id( 'background_color_hover' ); ?>"><?php _e( 'Background Hover Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo $this->get_field_id( 'background_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'background_color_hover' ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['background_color_hover'] ); ?>" value="<?php echo esc_attr( $instance['background_color_hover'] ); ?>" size="6" /></p>

		<p><label for="<?php echo $this->get_field_id( 'border_color' ); ?>"><?php _e( 'Border Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo $this->get_field_id( 'border_color' ); ?>" name="<?php echo $this->get_field_name( 'border_color' ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['border_color'] ); ?>" value="<?php echo esc_attr( $instance['border_color'] ); ?>" size="6" /></p>

		<p><label for="<?php echo $this->get_field_id( 'border_color_hover' ); ?>"><?php _e( 'Border Hover Color:', 'simple-social-icons' ); ?></label><br /> <input id="<?php echo $this->get_field_id( 'border_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'border_color_hover' ); ?>" type="text" class="ssiw-color-picker" data-default-color="<?php echo esc_attr( $this->defaults['border_color_hover'] ); ?>" value="<?php echo esc_attr( $instance['border_color_hover'] ); ?>" size="6" /></p>

		<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

		<?php
		foreach ( (array) $this->profiles as $profile => $data ) {

			printf( '<p><label for="%s">%s:</label></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
			printf( '<p><input type="text" id="%s" name="%s" value="%s" class="widefat" />', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );
			printf( '</p>' );

		}

	}

	/**
	 * Form validation and sanitization.
	 *
	 * Runs when you save the widget form. Allows you to validate or sanitize widget options before they are saved.
	 *
	 */
	function update( $newinstance, $oldinstance ) {

		foreach ( $newinstance as $key => $value ) {

			/** Border radius and Icon size must not be empty, must be a digit */
			if ( ( 'border_radius' == $key || 'size' == $key ) && ( '' == $value || ! ctype_digit( $value ) ) ) {
				$newinstance[$key] = 0;
			}

			if ( ( 'border_width' == $key || 'size' == $key ) && ( '' == $value || ! ctype_digit( $value ) ) ) {
				$newinstance[$key] = 0;
			}

			/** Validate hex code colors */
			elseif ( strpos( $key, '_color' ) && 0 == preg_match( '/^#(([a-fA-F0-9]{3}$)|([a-fA-F0-9]{6}$))/', $value ) ) {
				$newinstance[$key] = $oldinstance[$key];
			}

			/** Sanitize Profile URIs */
			elseif ( array_key_exists( $key, (array) $this->profiles ) ) {
				$newinstance[$key] = esc_url( $newinstance[$key] );
			}

		}

		return $newinstance;

	}

	/**
	 * Widget Output.
	 *
	 * Outputs the actual widget on the front-end based on the widget options the user selected.
	 *
	 */
	function widget( $args, $instance ) {

		extract( $args );

		/** Merge with defaults */
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		echo $before_widget;

			if ( ! empty( $instance['title'] ) )
				echo $before_title . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $after_title;

			$output = '';

			$new_window = $instance['new_window'] ? 'target="_blank"' : '';

			$profiles = (array) $this->profiles;

			foreach ( $profiles as $profile => $data ) {

				if ( empty( $instance[ $profile ] ) )
					continue;

				if ( is_email( $instance[ $profile ] ) )
					$output .= sprintf( $data['pattern'], 'mailto:' . esc_attr( $instance[$profile] ), $new_window );
				else
					$output .= sprintf( $data['pattern'], esc_url( $instance[$profile] ), $new_window );

			}

			if ( $output )
				printf( '<ul class="%s">%s</ul>', $instance['alignment'], $output );

		echo $after_widget;

	}

	function enqueue_css() {

		$cssfile = apply_filters( 'simple_social_default_stylesheet', plugin_dir_url( __FILE__ ) . 'css/style.css' );

		wp_enqueue_style( 'simple-social-icons-font', esc_url( $cssfile ), array(), $this->version, 'all' );

		wp_enqueue_script('svg-x-use', plugin_dir_url(__FILE__) . 'svgxuse.js', array(), '1.1.21' );
	}

	/**
	 * Custom CSS.
	 *
	 * Outputs custom CSS to control the look of the icons.
	 */
	function css() {

		/** Pull widget settings, merge with defaults */
		$all_instances = $this->get_settings();
		if ( ! isset( $this->number ) || ! isset( $all_instances[$this->number] ) ) {
			return;
		}

		$instance = wp_parse_args( $all_instances[$this->number], $this->defaults );

		$font_size = round( (int) $instance['size'] / 2 );
		$icon_padding = round ( (int) $font_size / 2 );

		/** The CSS to output */
		$css = '
		.simple-social-icons ul li a,
		.simple-social-icons ul li a:hover,
		.simple-social-icons ul li a:focus {
			background-color: ' . $instance['background_color'] . ' !important;
			border-radius: ' . $instance['border_radius'] . 'px;
			color: ' . $instance['icon_color'] . ' !important;
			border: ' . $instance['border_width'] . 'px ' . $instance['border_color'] . ' solid !important;
			font-size: ' . $font_size . 'px;
			padding: ' . $icon_padding . 'px;
		}

		.simple-social-icons ul li a:hover,
		.simple-social-icons ul li a:focus {
			background-color: ' . $instance['background_color_hover'] . ' !important;
			border-color: ' . $instance['border_color_hover'] . ' !important;
			color: ' . $instance['icon_color_hover'] . ' !important;
		}

		.simple-social-icons ul li a:focus {
			outline: 1px dotted ' . $instance['background_color_hover'] . ' !important;
		}';

		/** Minify a bit */
		$css = str_replace( "\t", '', $css );
		$css = str_replace( array( "\n", "\r" ), ' ', $css );

		/** Echo the CSS */
		echo '<style type="text/css" media="screen">' . $css . '</style>';

	}

}

add_action( 'widgets_init', 'ssiw_load_widget' );
/**
 * Widget Registration.
 *
 * Register Simple Social Icons widget.
 *
 */
function ssiw_load_widget() {

	register_widget( 'Simple_Social_Icons_Widget' );

}
