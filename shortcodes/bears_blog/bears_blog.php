<?php

/* shortcode */
vc_map(
	array(
		"name" => __( "Bears Blog", TBBS_NAME ),
	    "base" => "bears_blog",
	    "class" => "vc-bears-blog",
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

class WPBakeryShortCode_bears_blog extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$atts = shortcode_atts( array(
				'element_id'	=> '',
				'source'		=> '',
				'template'		=> '',
				'class' 		=> '',
			    ), $atts);

		/**
		 * wp_query
		 */
		list( $args, $wp_query ) = vc_build_loop_query( $atts['source'] );
        $paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	    if( $paged > 1 ){
	    	$args['paged'] = $paged;
	    	$wp_query = new WP_Query( $args );
	    }
	    $atts['posts'] = $wp_query;

		return tbbs_LoadTemplate( basename( __FILE__, '.php' ), $atts, $content );
	}
}