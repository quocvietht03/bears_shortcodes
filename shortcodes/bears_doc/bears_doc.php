<?php

/* shortcode */
vc_map(
	array(
		"name" => __( "Bears Document", TBBS_NAME ),
	    "base" => "bears_doc",
	    "class" => "vc-bears-doc",
	    "category" => __("Bears", TBBS_NAME),
	    "params" => array(

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
	            'shortcode' => 'bears_doc',
	            'group' => __( 'Template', TBBS_NAME ),
	        	),
	    	)
		)
	);

class WPBakeryShortCode_bears_doc extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$atts = shortcode_atts( array(
				'template'		=> '',
				'class' 		=> '',
			    ), $atts);

		return tbbs_LoadTemplate( 'bears_doc', $atts, $content );
	}
}

/**
 * tbbs_BearsDocScript
 */
function tbbs_BearsDocScript( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'bears document',
		'type' => 'js',
		'handle' => 'shortcode-bears-doc',
		'src' => TBBS_URL . 'shortcodes/bears_doc/assets/js/jquery.bears-doc.js',
		'deps' => array( 'jquery' ),
		'include' => 1,
		) );

	array_push( $scripts, array(
		'group' => 'bears document',
		'type' => 'css',
		'handle' => 'shortcode-bears-doc',
		'src' => TBBS_URL . 'shortcodes/bears_doc/assets/css/bears-doc.css',
		'include' => 1,
		) );
		
	array_push( $scripts, array(
		'group' => 'rainbow master',
		'type' => 'js',
		'handle' => 'rainbow-master',
		'src' => TBBS_URL . 'shortcodes/bears_doc/assets/rainbow-master/js/rainbow.min.js',
		'include' => 1,
		) );
	
	array_push( $scripts, array(
		'group' => 'rainbow master',
		'type' => 'js',
		'handle' => 'language-generic',
		'src' => TBBS_URL . 'shortcodes/bears_doc/assets/rainbow-master/js/language/generic.js',
		'include' => 1,
		) );
	
	array_push( $scripts, array(
		'group' => 'rainbow master',
		'type' => 'js',
		'handle' => 'language-php',
		'src' => TBBS_URL . 'shortcodes/bears_doc/assets/rainbow-master/js/language/php.js',
		'include' => 1,
		) );
	
	array_push( $scripts, array(
		'group' => 'rainbow master',
		'type' => 'css',
		'handle' => 'rainbow-theme-monokai',
		'src' => TBBS_URL . 'shortcodes/bears_doc/assets/rainbow-master/themes/monokai.css',
		'include' => 1,
		) );
		
	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsDocScript' );