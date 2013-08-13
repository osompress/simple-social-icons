<?php
/*
Plugin Name: Simple Social Icons
Plugin URI: http://www.studiopress.com/plugins/simple-social-icons
Description: A simple, CSS and sprite driven social icons widget.
Author: Nathan Rice
Author URI: http://www.nathanrice.net/

Version: 0.9.4

License: GNU General Public License v2.0 (or later)
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

class Simple_Social_Icons_Widget extends WP_Widget {

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
	 * Default widget values.
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
		$this->defaults = array(
			'title'					 => '',
			'new_window'			 => 0,
			'size'					 => 32,
			'border_radius'			 => 3,
			'background_color'		 => '#999999',
			'background_color_hover' => '#666666',
			'alignment'				 => 'alignleft',
			'dribbble'				 => '',
			'email'				 => '',
			'facebook'				 => '',
			'gplus'					 => '',
			'linkedin'				 => '',
			'pinterest'				 => '',
			'rss'					 => '',
			'stumbleupon'				 => '',
			'twitter'				 => '',
			'youtube'				 => '',
		);

		/**
		 * Icon sizes.
		 */
		$this->sizes = array( '24', '32', '48' );

		/**
		 * Social profile choices.
		 */
		$this->profiles = array(
			'dribbble' => array(
				'label'	  => __( 'Dribbble URI', 'ssiw' ),
				'pattern' => '<li class="social-dribbble"><a href="%s" %s>Dribbble</a></li>',
				'background_positions' => array(
					'24' => '0 0',
					'32' => '0 0',
					'48' => '0 0',
				)
			),
			'email' => array(
				'label'	  => __( 'Email URI', 'ssiw' ),
				'pattern' => '<li class="social-email"><a href="%s" %s>Email</a></li>',
				'background_positions' => array(
					'24' => '-24px 0',
					'32' => '-32px 0',
					'48' => '-48px 0',
				)
			),
			'facebook' => array(
				'label'	  => __( 'Facebook URI', 'ssiw' ),
				'pattern' => '<li class="social-facebook"><a href="%s" %s>Facebook</a></li>',
				'background_positions' => array(
					'24' => '-48px 0',
					'32' => '-64px 0',
					'48' => '-96px 0',
				)
			),
			'gplus' => array(
				'label'	  => __( 'Google+ URI', 'ssiw' ),
				'pattern' => '<li class="social-gplus"><a href="%s" %s>Google+</a></li>',
				'background_positions' => array(
					'24' => '-72px 0',
					'32' => '-96px 0',
					'48' => '-144px 0',
				)
			),
			'linkedin' => array(
				'label'	  => __( 'Linkedin URI', 'ssiw' ),
				'pattern' => '<li class="social-linkedin"><a href="%s" %s>Linkedin</a></li>',
				'background_positions' => array(
					'24' => '-96px 0',
					'32' => '-128px 0',
					'48' => '-192px 0',
				)
			),
			'pinterest' => array(
				'label'	  => __( 'Pinterest URI', 'ssiw' ),
				'pattern' => '<li class="social-pinterest"><a href="%s" %s>Pinterest</a></li>',
				'background_positions' => array(
					'24' => '-120px 0',
					'32' => '-160px 0',
					'48' => '-240px 0',
				)
			),
			'rss' => array(
				'label'	  => __( 'RSS URI', 'ssiw' ),
				'pattern' => '<li class="social-rss"><a href="%s" %s>RSS</a></li>',
				'background_positions' => array(
					'24' => '-144px 0',
					'32' => '-192px 0',
					'48' => '-288px 0',
				)
			),
			'stumbleupon' => array(
				'label'	  => __( 'StumbleUpon URI', 'ssiw' ),
				'pattern' => '<li class="social-stumbleupon"><a href="%s" %s>StumbleUpon</a></li>',
				'background_positions' => array(
					'24' => '-168px 0',
					'32' => '-224px 0',
					'48' => '-336px 0',
				)
			),
			'twitter' => array(
				'label'	  => __( 'Twitter URI', 'ssiw' ),
				'pattern' => '<li class="social-twitter"><a href="%s" %s>Twitter</a></li>',
				'background_positions' => array(
					'24' => '-192px 0',
					'32' => '-256px 0',
					'48' => '-384px 0',
				)
			),
			'youtube' => array(
				'label'	  => __( 'YouTube URI', 'ssiw' ),
				'pattern' => '<li class="social-youtube"><a href="%s" %s>YouTube</a></li>',
				'background_positions' => array(
					'24' => '-216px 0',
					'32' => '-288px 0',
					'48' => '-432px 0',
				)
			),
		);

		$widget_ops = array(
			'classname'	  => 'simple-social-icons',
			'description' => __( 'Displays select social icons.', 'ssiw' ),
		);

		$control_ops = array(
			'id_base' => 'simple-social-icons',
			#'width'   => 505,
			#'height'  => 350,
		);

		$this->WP_Widget( 'simple-social-icons', __( 'Simple Social Icons', 'ssiw' ), $widget_ops, $control_ops );

		/** Load CSS in <head> */
		add_action( 'wp_head', array( $this, 'css' ) );

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

		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

		<p><label><input id="<?php echo $this->get_field_id( 'new_window' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'new_window' ); ?>" value="1" <?php checked( 1, $instance['new_window'] ); ?>/> <?php esc_html_e( 'Open links in new window?', 'ssiw' ); ?></label></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Icon Size', 'ssiw' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'size' ); ?>" name="<?php echo $this->get_field_name( 'size' ); ?>">
				<?php
				foreach ( (array) $this->sizes as $size ) {
					printf( '<option value="%d" %s>%dpx</option>', (int) $size, selected( $size, $instance['size'], 0 ), (int) $size );
				}
				?>
			</select>
		</p>

		<p><label for="<?php echo $this->get_field_id( 'border_radius' ); ?>"><?php _e( 'Icon Border Radius:', 'ssiw' ); ?></label> <input id="<?php echo $this->get_field_id( 'border_radius' ); ?>" name="<?php echo $this->get_field_name( 'border_radius' ); ?>" type="text" value="<?php echo esc_attr( $instance['border_radius'] ); ?>" size="3" />px</p>

		<p><label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Icon Color:', 'ssiw' ); ?></label> <input id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo esc_attr( $instance['background_color'] ); ?>" size="8" /></p>

		<p><label for="<?php echo $this->get_field_id( 'background_color_hover' ); ?>"><?php _e( 'Hover Color:', 'ssiw' ); ?></label> <input id="<?php echo $this->get_field_id( 'background_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'background_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $instance['background_color_hover'] ); ?>" size="8" /></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'alignment' ); ?>"><?php _e( 'Alignment', 'ssiw' ); ?>:</label>
			<select id="<?php echo $this->get_field_id( 'alignment' ); ?>" name="<?php echo $this->get_field_name( 'alignment' ); ?>">
				<option value="alignleft" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Left', 'ssiw' ); ?></option>
				<option value="alignright" <?php selected( 'alignright', $instance['alignment'] ) ?>><?php _e( 'Align Right', 'ssiw' ); ?></option>
			</select>
		</p>

		<hr style="background: #ccc; border: 0; height: 1px; margin: 20px 0;" />

		<?php
		foreach ( (array) $this->profiles as $profile => $data ) {

			printf( '<p><label for="%s">%s:</label>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $data['label'] ) );
			printf( '<input type="text" id="%s" class="widefat" name="%s" value="%s" /></p>', esc_attr( $this->get_field_id( $profile ) ), esc_attr( $this->get_field_name( $profile ) ), esc_url( $instance[$profile] ) );

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

			/** Border radius must not be empty, must be a digit */
			if ( 'border_radius' == $key && ( '' == $value || ! ctype_digit( $value ) ) ) {
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

			foreach ( (array) $this->profiles as $profile => $data ) {
				if ( ! empty( $instance[$profile] ) )
					$output .= sprintf( $data['pattern'], esc_url( $instance[$profile] ), $new_window );
			}

			if ( $output )
				printf( '<ul class="%s">%s</ul>', $instance['alignment'], $output );

		echo $after_widget;

	}

	/**
	 * Custom CSS.
	 *
	 * Outputs custom CSS to control the look of the icons.
	 */
	function css() {

		/** Pull widget settings, merge with defaults */
		$all_instances = $this->get_settings();
		$instance = wp_parse_args( $all_instances[$this->number], $this->defaults );

		/** The image locations */
		$imgs = array(
			'24' => plugin_dir_url( __FILE__ ) . 'images/sprite_24x24.png',
			'32' => plugin_dir_url( __FILE__ ) . 'images/sprite_32x32.png',
			'48' => plugin_dir_url( __FILE__ ) . 'images/sprite_48x48.png'
		);

		/** The CSS to output */
		$css = '.simple-social-icons {
			overflow: hidden;
		}
		.simple-social-icons .alignleft, .simple-social-icons .alignright {
			margin: 0; padding: 0;
		}
		.simple-social-icons ul li {
			background: none !important;
			border: none !important;
			float: left;
			list-style-type: none !important;
			margin: 0 5px 10px !important;
			padding: 0 !important;
		}
		.simple-social-icons ul li a,
		.simple-social-icons ul li a:hover {
			background: ' . $instance['background_color'] . ' url(' . $imgs[$instance['size']] . ') no-repeat;
			-moz-border-radius: ' . $instance['border_radius'] . 'px
			-webkit-border-radius: ' . $instance['border_radius'] . 'px;
			border-radius: ' . $instance['border_radius'] . 'px;
			display: block;
			height: ' . $instance['size'] . 'px;
			overflow: hidden;
			text-indent: -999px;
			width: ' . $instance['size'] . 'px;
		}

		.simple-social-icons ul li a:hover {
			background-color: ' . $instance['background_color_hover'] . ';
		}';

		/** Individual Profile button styles */
		foreach ( (array) $this->profiles as $profile => $data ) {

			if ( ! $instance[$profile] )
				continue;

			$css .= '.simple-social-icons ul li.social-' . $profile . ' a,
			.simple-social-icons ul li.social-' . $profile . ' a:hover {
				background-position: ' . $data['background_positions'][$instance['size']] . ';
			}';

		}

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