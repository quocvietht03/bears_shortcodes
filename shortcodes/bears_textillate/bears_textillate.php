<?php

/* shortcode */
vc_map(
	array(
		"name" => __( "Bears Textillate", TBBS_NAME ),
	    "base" => "bears_textillate",
	    "class" => "vc-bears-textillate",
	    "category" => __("Bears", TBBS_NAME),
	    "params" => array(
	    	array(
				'type' => 'el_id',
				'param_name' => 'element_id',
				'settings' => array(
					'auto_generate' => true,
				),
				'heading' => __( 'Element ID', TBBS_NAME ),
				'description' => __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', TBBS_NAME ),
				'group' => __( 'Source Settings', TBBS_NAME ),
				),
	    	array(
				'type' => 'font_container',
				'param_name' => 'font_container',
				'value'=>'',
				'settings' => array(
					'fields' => array(
						// 'tag' => 'h2',
						'text_align',
						'font_size',
						'line_height',
						'color',
						'tag_description' => __('Select element tag.', TBBS_NAME ),
						'text_align_description' => __('Select text alignment.', TBBS_NAME ),
						'font_size_description' => __('Enter font size.', TBBS_NAME ),
						'line_height_description' => __('Enter line height.', TBBS_NAME ),
						'color_description' => __('Select color for your element.', TBBS_NAME ),
						),
					),
				'group' => __( 'Source Settings', TBBS_NAME ),
				),
	    	array(
	    		'type' => 'checkbox',
	    		'heading' => __( 'Use Google Fonts',TBBS_NAME ),
	    		'param_name' => 'use_google_fonts',
	    		'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Source Settings', TBBS_NAME )
	    		),
	    	array(
				'type' => 'google_fonts',
				'param_name' => 'google_fonts',
				'value' => '',// Not recommended, this will override 'settings'. Example:
				'font_family:'.rawurlencode('Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic').'|font_style:'.rawurlencode('900
				bold italic:900:italic'),
				'settings' => array(
					'fields'=>array(
						'font_family' => 'Abril Fatface:regular',//
						'Exo:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic',
						'font_style' => '400 regular:400:normal',
						'font_family_description' => __('Select font family.', TBBS_NAME ),
						'font_style_description' => __('Select font styling.', TBBS_NAME )
						)
					),
				'description' => __( 'Description for this group', TBBS_NAME ), // Description for field group
				'group' => __( 'Source Settings', TBBS_NAME ),
				'dependency' => array( 'element' => 'use_google_fonts', 'value' => 'true' ),
				),

	    	/* Textillate */
	    	array(
	            'type' => 'dropdown',
	            'heading' => __( 'In Animation (effect)',TBBS_NAME ),
	            'param_name' => 'in_animate_effect',
	            'value' => array('flash' => 'flash', 'bounce' => 'bounce', 'shake' => 'shake', 'tada' => 'tada', 'swing' => 'swing', 'wobble' => 'wobble', 'pulse' => 'pulse', 'flip' => 'flip', 'flipInX' => 'flipInX', 'flipOutX' => 'flipOutX', 'flipInY' => 'flipInY', 'flipOutY' => 'flipOutY', 'fadeIn' => 'fadeIn', 'fadeInUp' => 'fadeInUp', 'fadeInDown' => 'fadeInDown', 'fadeInLeft' => 'fadeInLeft', 'fadeInRight' => 'fadeInRight', 'fadeInUpBig' => 'fadeInUpBig', 'fadeInDownBig' => 'fadeInDownBig', 'fadeInLeftBig' => 'fadeInLeftBig', 'fadeInRightBig' => 'fadeInRightBig', 'fadeOut' => 'fadeOut', 'fadeOutUp' => 'fadeOutUp', 'fadeOutDown' => 'fadeOutDown', 'fadeOutLeft' => 'fadeOutLeft', 'fadeOutRight' => 'fadeOutRight', 'fadeOutUpBig' => 'fadeOutUpBig', 'fadeOutDownBig' => 'fadeOutDownBig', 'fadeOutLeftBig' => 'fadeOutLeftBig', 'fadeOutRightBig' => 'fadeOutRightBig', 'bounceIn' => 'bounceIn', 'bounceInDown' => 'bounceInDown', 'bounceInUp' => 'bounceInUp', 'bounceInLeft' => 'bounceInLeft', 'bounceInRight' => 'bounceInRight', 'bounceOut' => 'bounceOut', 'bounceOutDown' => 'bounceOutDown', 'bounceOutUp' => 'bounceOutUp', 'bounceOutLeft' => 'bounceOutLeft', 'bounceOutRight' => 'bounceOutRight', 'rotateIn' => 'rotateIn', 'rotateInDownLeft' => 'rotateInDownLeft', 'rotateInDownRight' => 'rotateInDownRight', 'rotateInUpLeft' => 'rotateInUpLeft', 'rotateInUpRight' => 'rotateInUpRight', 'rotateOut' => 'rotateOut', 'rotateOutDownLeft' => 'rotateOutDownLeft', 'rotateOutDownRight' => 'rotateOutDownRight', 'rotateOutUpLeft' => 'rotateOutUpLeft', 'rotateOutUpRight' => 'rotateOutUpRight', 'hinge' => 'hinge', 'rollIn' => 'rollIn', 'rollOut' => 'rollOut'),
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	            ),
	    	array(
	            'type' => 'dropdown',
	            'heading' => __( 'In Animation (type)',TBBS_NAME ),
	            'param_name' => 'in_animate_type',
	            'value' => array( 'sequence' => '', 'reverse' => 'reverse', 'sync' => 'sync', 'shuffle' => 'shuffle' ),
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	            ),
	    	array(
	            'type' => 'dropdown',
	            'heading' => __( 'Out Animation (effect)',TBBS_NAME ),
	            'param_name' => 'out_animate_effect',
	            'value' => array('flash' => 'flash', 'bounce' => 'bounce', 'shake' => 'shake', 'tada' => 'tada', 'swing' => 'swing', 'wobble' => 'wobble', 'pulse' => 'pulse', 'flip' => 'flip', 'flipInX' => 'flipInX', 'flipOutX' => 'flipOutX', 'flipInY' => 'flipInY', 'flipOutY' => 'flipOutY', 'fadeIn' => 'fadeIn', 'fadeInUp' => 'fadeInUp', 'fadeInDown' => 'fadeInDown', 'fadeInLeft' => 'fadeInLeft', 'fadeInRight' => 'fadeInRight', 'fadeInUpBig' => 'fadeInUpBig', 'fadeInDownBig' => 'fadeInDownBig', 'fadeInLeftBig' => 'fadeInLeftBig', 'fadeInRightBig' => 'fadeInRightBig', 'fadeOut' => 'fadeOut', 'fadeOutUp' => 'fadeOutUp', 'fadeOutDown' => 'fadeOutDown', 'fadeOutLeft' => 'fadeOutLeft', 'fadeOutRight' => 'fadeOutRight', 'fadeOutUpBig' => 'fadeOutUpBig', 'fadeOutDownBig' => 'fadeOutDownBig', 'fadeOutLeftBig' => 'fadeOutLeftBig', 'fadeOutRightBig' => 'fadeOutRightBig', 'bounceIn' => 'bounceIn', 'bounceInDown' => 'bounceInDown', 'bounceInUp' => 'bounceInUp', 'bounceInLeft' => 'bounceInLeft', 'bounceInRight' => 'bounceInRight', 'bounceOut' => 'bounceOut', 'bounceOutDown' => 'bounceOutDown', 'bounceOutUp' => 'bounceOutUp', 'bounceOutLeft' => 'bounceOutLeft', 'bounceOutRight' => 'bounceOutRight', 'rotateIn' => 'rotateIn', 'rotateInDownLeft' => 'rotateInDownLeft', 'rotateInDownRight' => 'rotateInDownRight', 'rotateInUpLeft' => 'rotateInUpLeft', 'rotateInUpRight' => 'rotateInUpRight', 'rotateOut' => 'rotateOut', 'rotateOutDownLeft' => 'rotateOutDownLeft', 'rotateOutDownRight' => 'rotateOutDownRight', 'rotateOutUpLeft' => 'rotateOutUpLeft', 'rotateOutUpRight' => 'rotateOutUpRight', 'hinge' => 'hinge', 'rollIn' => 'rollIn', 'rollOut' => 'rollOut'),
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	            ),
	    	array(
	            'type' => 'dropdown',
	            'heading' => __( 'Out Animation (type)',TBBS_NAME ),
	            'param_name' => 'out_animate_type',
	            'value' => array( 'sequence' => '', 'reverse' => 'reverse', 'sync' => 'sync', 'shuffle' => 'shuffle' ),
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	            ),
	    	array(
	            'type' => 'textfield',
	            'heading' => __( 'initialDelay',TBBS_NAME ),
	            'param_name' => 'initial_delay',
	            'value' => 0,
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	        	),
	    	array(
	            'type' => 'dropdown',
	            'heading' => __( 'autoStart',TBBS_NAME ),
	            'param_name' => 'auto_start',
	            'value' => array( 'True' => 1, 'False' => 0 ),
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	            ),
	    	array(
	            'type' => 'dropdown',
	            'heading' => __( 'loop',TBBS_NAME ),
	            'param_name' => 'loop',
	            'value' => array( 'True' => 1, 'False' => 0 ),
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	            ),
	    	array(
	            'type' => 'dropdown',
	            'heading' => __( 'type',TBBS_NAME ),
	            'param_name' => 'type',
	            'value' => array( 'char' => 'char', 'word' => 'word' ),
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Textillate Settings', TBBS_NAME )
	            ),
            /* Textillate */

	    	array(
	            'type' => 'textfield',
	            'heading' => __( 'Extra Class',TBBS_NAME ),
	            'param_name' => 'class',
	            'value' => '',
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Template', TBBS_NAME )
	        	),
			array(
	            'type' => 'btbs_supper_template',
	            'heading' => __( 'Template', TBBS_NAME ),
	            'param_name' => 'template',
	            'shortcode' => basename( __FILE__, '.php' ),
	            'group' => __( 'Template', TBBS_NAME ),
	        	),

			array(
	            'type' => 'css_editor',
	            'heading' => __( 'Css', TBBS_NAME ),
	            'param_name' => 'css',
	            'group' => __( 'Design options', TBBS_NAME ),
	        	),
	    	),
		)
	);

class WPBakeryShortCode_bears_textillate extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$atts = shortcode_atts( array(
				'element_id'			=> '',
				'font_container'		=> '',
				'use_google_fonts' 		=> '',
				'google_fonts'			=> '',
				'in_animate_effect' 	=> 'flash',
				'in_animate_type' 		=> '',
				'out_animate_effect' 	=> 'flash',
				'out_animate_type'	 	=> '',
				'initial_delay'			=> 0,
				'auto_start'			=> 1,
				'loop'					=> 1,
				'type'					=> 'char',
				'template'				=> '',
				'class' 				=> '',
				'css' 					=> '',
			    ), $atts);

		extract( $atts );

		$font_container_obj = new Vc_Font_Container();
		$google_fonts_obj = new Vc_Google_Fonts();
		$font_container_field_settings = array();
		$google_fonts_field_settings = array();
		$font_container_data = $font_container_obj->_vc_font_container_parse_attributes( $font_container_field_settings, $font_container );
		$google_fonts_data = strlen( $google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings, $google_fonts ) : '';
		
		$atts['font_container_data'] = $font_container_data;
		$atts['google_fonts_data'] = $google_fonts_data;
		$atts['style'] = $this->getStyles( '', '', $google_fonts_data, $font_container_data, $atts );
		$atts['class'] .= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		
		/* get subsets */
		$settings = get_option( 'wpb_js_google_fonts_subsets' );
		if ( is_array( $settings ) && ! empty( $settings ) ) $subsets = '&subset=' . implode( ',', $settings );
		else $subsets = '';	

		/* inc google-font */
		if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data['values']['font_family'] ) )
			wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );

		return tbbs_LoadTemplate( basename( __FILE__, '.php' ), $atts, $content );
	}

	/**
	 * Parses google_fonts_data and font_container_data to get needed css styles to markup
	 *
	 * @param $el_class
	 * @param $css
	 * @param $google_fonts_data
	 * @param $font_container_data
	 * @param $atts
	 *
	 * @since 4.3
	 * @return array
	 */
	public function getStyles( $el_class, $css, $google_fonts_data, $font_container_data, $atts ) {
		$styles = array();
		if ( ! empty( $font_container_data ) && isset( $font_container_data['values'] ) ) {
			foreach ( $font_container_data['values'] as $key => $value ) {
				if ( 'tag' !== $key && strlen( $value ) ) {
					if ( preg_match( '/description/', $key ) ) {
						continue;
					}
					if ( 'font_size' === $key || 'line_height' === $key ) {
						$value = preg_replace( '/\s+/', '', $value );
					}
					if ( 'font_size' === $key ) {
						$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
						// allowed metrics: http://www.w3schools.com/cssref/css_units.asp
						$regexr = preg_match( $pattern, $value, $matches );
						$value = isset( $matches[1] ) ? (float) $matches[1] : (float) $value;
						$unit = isset( $matches[2] ) ? $matches[2] : 'px';
						$value = $value . $unit;
					}
					if ( strlen( $value ) > 0 ) {
						$styles[] = str_replace( '_', '-', $key ) . ': ' . $value;
					}
				}
			}
		}
		if ( ( ! isset( $atts['use_theme_fonts'] ) || 'yes' !== $atts['use_theme_fonts'] ) && ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
			$google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
			$styles[] = 'font-family:' . $google_fonts_family[0];
			$google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
			$styles[] = 'font-weight:' . $google_fonts_styles[1];
			$styles[] = 'font-style:' . $google_fonts_styles[2];
		}

		/**
		 * Filter 'VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG' to change vc_custom_heading class
		 *
		 * @param string - filter_name
		 * @param string - element_class
		 * @param string - shortcode_name
		 * @param array - shortcode_attributes
		 *
		 * @since 4.3
		 */
		$css_class = ''; // apply_filters( 'bt_custom_heading', 'bt_custom_heading ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

		return array(
			'css_class' => trim( preg_replace( '/\s+/', ' ', $css_class ) ),
			'styles' => $styles,
		);
	}
}

/**
 * tbbs_BearsTextillateLib
 */
if( ! function_exists( 'tbbs_BearsTextillateLib' ) ) :
	function tbbs_BearsTextillateLib( $scripts )
	{	
		
		array_push( $scripts, array(
			'group' => 'textillate',
			'type' => 'js',
			'handle' => 'lettering',
			'src' => TBBS_URL . 'shortcodes/bears_textillate/assets/js/jquery.lettering.js',
			'deps' => array( 'jquery' ),
			'include' => 1,
			) );

		array_push( $scripts, array(
			'group' => 'textillate',
			'type' => 'js',
			'handle' => 'textillate',
			'src' => TBBS_URL . 'shortcodes/bears_textillate/assets/js/jquery.textillate.js',
			'deps' => array( 'jquery', 'lettering' ),
			'include' => 1,
			) );

		array_push( $scripts, array(
			'group' => 'textillate',
			'type' => 'css',
			'handle' => 'textillate',
			'src' => TBBS_URL . 'shortcodes/bears_textillate/assets/css/animate.css',
			'include' => 1,
			) );

		return $scripts;
	}
endif;
add_filter( 'tbbs_register_scripts', 'tbbs_BearsTextillateLib' );

if( ! function_exists( 'bearsthemes_BearsTextillateParams' ) ) :
	function bearsthemes_BearsTextillateParams()
	{
		return array(
			array(
				'name' => 'text_template',
				'title' => __( 'Text Template', TBBS_NAME ),
				'type' => 'textarea',
				'value' => '{content}',
				'description' => 'Use: ...{content}...',
				),
			array(
				'name' => 'content',
				'title' => __( 'Content', TBBS_NAME ),
				'type' => 'group',
				'addmore' => true,
				'columns' => 1,
				'fields' => array(
					array( 'type' => 'text', 'name' => 'text', 'title' => __( 'Text', TBBS_NAME ), 'value' => '' )
					) 
				),
			array(
				'name' => 'layout',
				'title' => __( 'Layout', TBBS_NAME ),
				'type' => 'select',
				'value' => 'default',
				'options' => apply_filters( 'tbbs_ShortcodeTextillateLayoutItem', array(
					array(
						'value' => 'default',
						'text' => __( 'Default', TBBS_NAME ),
						),
					) )
				),
			);
	}
endif;

