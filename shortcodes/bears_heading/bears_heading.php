<?php
vc_map(
	array(
		"name" => __( "Bears Heading", TBBS_NAME ),
	    "base" => "bears_heading",
	    "class" => "vc-bears-heading",
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
	            'type' => 'textarea',
	            'heading' => __( 'Text',TBBS_NAME ),
	            'param_name' => 'text',
	            'value' => '',
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Source Settings', TBBS_NAME )
	            ),
	    	array(
				'type' => 'font_container',
				'param_name' => 'font_container',
				'value'=>'',
				'settings' => array(
					'fields' => array(
						'tag' => 'h2',
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
	    	)
		)
	);

class WPBakeryShortCode_bears_heading extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$atts = shortcode_atts( array(
				'element_id'	=> '',
				'text'			=> '',
				'font_container'	=> '',
				'use_google_fonts' 	=> '',
				'google_fonts'	=> '',
				'template'		=> '',
				'class' 		=> '',
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
 * tbbs_BearsHeadingDefaultParams
 *
 */
if( ! function_exists( 'tbbs_BearsHeadingDefaultParams' ) ) :
	function tbbs_BearsHeadingDefaultParams()
	{
		return array(
			array(
				'name' => 'background_image',
				'title' => __( 'Background Image', TBLG_NAME ),
				'type' => 'media',
				'value' => '',
				),
			array(
				'name' => 'background_style',
				'title' => __( 'Background Style', TBBS_NAME ),
				'type' => 'select',
				'value' => 'default',
				'options' => apply_filters( 'tbbs_ShortcodeHeadingLayoutItem', array(
					array(
						'value' => 'default',
						'text' => __( 'Default', TBBS_NAME ),
						),
					array(
						'value' => 'fixed',
						'text' => __( 'Fixed', TBBS_NAME ),
						),
					) )
				),
			array(
				'name' => 'padding',
				'title' => __( 'Padding', TBLG_NAME ),
				'type' => 'text',
				'value' => '20px 0',
				),
			array(
				'name' => 'layout',
				'title' => __( 'Layout', TBBS_NAME ),
				'type' => 'select',
				'value' => 'default',
				'options' => apply_filters( 'tbbs_ShortcodeHeadingLayoutItem', array(
					array(
						'value' => 'default',
						'text' => __( 'Default', TBBS_NAME ),
						),
					) )
				)
			);
	}
endif;

/**
 * tbbs_headingLayoutCustom_default
 *
 * @param string $output
 * @param array $atts
 * @return Html
 */
if( ! function_exists( 'tbbs_headingLayout_default' ) ) :
	function tbbs_headingLayoutCustom_default( $output, $atts ) 
	{	
		/* check background image */
		if( ! empty( $atts['template_params']['background_image'] ) )
			array_push( $atts['style']['styles'] , "background: url({$atts['template_params']['background_image']}) no-repeat center center / cover" );

		/* check background style */
		if( ! empty( $atts['template_params']['background_style'] ) && $atts['template_params']['background_style'] == 'fixed' ) 
			array_push( $atts['style']['styles'] , "background-attachment: fixed" );

		/* check has padding */
		if( ! empty( $atts['template_params']['padding'] ) )
			array_push( $atts['style']['styles'] , "padding: {$atts['template_params']['padding']}" );

		/* build style */
		$style = implode( ';', $atts['style']['styles'] );

		/* content */
		$content = do_shortcode( $atts['text'] );

		/* build output */
		$output = "
		<{$atts['font_container_data']['values']['tag']} class='tbbs-heading-style' style='{$style}'>
			<div class='tbbs-heading-text'>{$content}</div>
		</{$atts['font_container_data']['values']['tag']}>";
		return $output;
	}
endif;
add_filter( 'tbbs_headingLayout_default', 'tbbs_headingLayoutCustom_default', 10, 2 );

