<?php
vc_map(
	array(
		"name" => __( "Bears Block", TBBS_NAME ),
	    "base" => "bears_block",
	    "class" => "vc-bears-block",
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
	            'shortcode' => 'bears_block',
	            'group' => __( 'Template', TBBS_NAME ),
	        	),
	    	)
		)
	);

class WPBakeryShortCode_bears_block extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$atts = shortcode_atts( array(
				'element_id'	=> '',
				'template'		=> '',
				'class' 		=> '',
			    ), $atts);
		
		return tbbs_LoadTemplate( 'bears_block', $atts, $content );
	}
}

/**
 * tbbs_BearsCarouselOwlCarouselLib
 * register lib owlcarousel JS
 */
function tbbs_BearsBlockIconLib( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'font-icon',
		'type' => 'css',
		'handle' => 'font-awesome',
		'src' => TBBS_URL . 'shortcodes/bears_block/assets/css/font-awesome.min.css',
		'ver' => '4.5.0',
		'include' => 1,
		) );

	array_push( $scripts, array(
		'group' => 'font-icon',
		'type' => 'css',
		'handle' => 'ionicons',
		'src' => TBBS_URL . 'shortcodes/bears_block/assets/css/ionicons.min.css',
		'ver' => '2.0.1',
		'include' => 1,
		) );

	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsBlockIconLib' );

/**
 * tbbs_BearsCarouselParams
 *
 */
function tbbs_BearsBlockDefaultParams()
{
	return array(
		array(
			'name' => 'title',
			'title' => __( 'Title', TBBS_NAME ),
			'type' => 'text',
			'value' => '',
			),
		array(
			'name' => 'content',
			'title' => __( 'Content', TBBS_NAME ),
			'type' => 'textarea',
			'value' => '',
			),
		array(
			'name' => 'link',
			'title' => __( 'Link', TBBS_NAME ),
			'type' => 'link',
			'value' => array( 'text' => '', 'url' => '' ),
			),
		array(
			'name' => 'background_image',
			'title' => __( 'Background Image', TBBS_NAME ),
			'type' => 'media',
			'value' => '',
			),
		array(
			'name' => 'height',
			'title' => __( 'Height', TBBS_NAME ),
			'type' => 'text',
			'value' => '240px',
			'description' => '<i>Set height for block(default: 240px)</i>'
			),
		);
}

/**
 * tbbs_BearsBlockIconParams
 * 
 */
function tbbs_BearsBlockIconParams()
{
 	return array(
 		array(
 			'name' => 'mess1',
 			'type' => 'message',
 			'text' => '<i>Note: Use one in 2 icon type is font or image(prioritize: Icon Font)</i>',
 			),
		array(
			'name' => 'icon_font_class',
			'title' => __( 'Icon Font Class', TBBS_NAME ),
			'type' => 'text',
			'value' => '',
			'description' => 'Lib FontIcon: <a href="https://fortawesome.github.io/Font-Awesome/" target="_blank">Font-Awesome</a>, <a href="http://ionicons.com/" target="_blank">ionicons</a>, ...',
			),
		// array(
		// 	'name' => 'icon_image',
		// 	'title' => __( 'Icon Image', TBLG_NAME ),
		// 	'type' => 'media',
		// 	'data' => 'url',
		// 	'value' => '',
		// 	),
		array(
			'name' => 'title',
			'title' => __( 'Title', TBBS_NAME ),
			'type' => 'text',
			'value' => '',
			),
		array(
			'name' => 'sub_title',
			'title' => __( 'Sub Title', TBBS_NAME ),
			'type' => 'textarea',
			'value' => '',
			),
		array(
			'name' => 'align',
			'title' => __( 'Align', TBBS_NAME ),
			'type' => 'select',
			'value' => 'center',
			'options' => array(
				array(
					'value' => 'center',
					'text'	=> 'Center',
					),
				array(
					'value' => 'left',
					'text'	=> 'Left',
					),
				array(
					'value' => 'right',
					'text'	=> 'Right',
					),
				)
			),
		array(
			'name' => 'color_style',
			'title' => __( 'Color Style', TBBS_NAME ),
			'type' => 'select',
			'value' => 'while',
			'options' => array(
				array(
					'value' => 'black',
					'text' => 'Black',
					),
				array(
					'value' => 'white',
					'text' => 'White',
					),
				array(
					'value' => 'red',
					'text' => 'Red',
					)
				)
			),
		array(
			'name' => 'layout',
			'title' => __( 'Layout', TBBS_NAME ),
			'type' => 'select',
			'value' => 'block',
			'options' => array(
				array(
					'value' => 'block',
					'text' => 'Block',
					),
				array(
					'value' => 'inline',
					'text' => 'Inline',
					),
				)
			)
		);
}