<?php
/* include function */
require_once __DIR__ . '/functions.php';

/* shortcode */
vc_map(
	array(
		"name" => __( "Bears Masonry", TBBS_NAME ),
	    "base" => "bears_masonry",
	    "class" => "vc-bears-masonry",
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
	            "type" => "loop",
	            "heading" => __( "Source",TBBS_NAME ),
	            "param_name" => "source",
	            'settings' => array(
	                'size' => array( 'hidden' => false, 'value' => 10 ),
	                'order_by' => array( 'value' => 'date' )
	            	),
	            "group" => __( "Source Settings", TBBS_NAME ),
	        	),

	    	/* masonry */
	    	array(
	            'type' => 'textfield',
	            'heading' => __( 'Cell Height',TBBS_NAME ),
	            'param_name' => 'cell_height',
	            'value' => 180,
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Masonry Settings', TBBS_NAME )
	        ),
	        array(
	            'type' => 'textfield',
	            'heading' => __( 'Padding',TBBS_NAME ),
	            'param_name' => 'padding',
	            'value' => 0,
	            'description' => __( '',TBBS_NAME ),
	            'group' => __( 'Masonry Settings', TBBS_NAME )
	        ),
	    	/* masonry */

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
	            'shortcode' => 'bears_masonry',
	            'group' => __( 'Template', TBBS_NAME ),
	        	),
	    	)
		)
	);

class WPBakeryShortCode_bears_masonry extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$atts = shortcode_atts( array(
				'element_id'	=> '',
				'source'		=> '',
				'columns'		=> '',
				'cell_height' 	=> 180,
				'padding'		=> 0,
				'template'		=> '',
				'class' 		=> '',
			    ), $atts);

		return tbbs_LoadTemplate( 'bears_masonry', $atts, $content );
	}
}