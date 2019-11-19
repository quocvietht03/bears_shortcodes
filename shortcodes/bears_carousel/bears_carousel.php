<?php


/* include functions.php */
require __DIR__ . '/functions.php';

$params = apply_filters( 'bearsthemes_vcmapfilter_' . basename( __FILE__, '.php' ), array(
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
        	
        /* [Start] Owl tab */
        array(
            'type' => 'textfield',
            'heading' => __( 'Items',TBBS_NAME ),
            'param_name' => 'items',
            'value' => 3,
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
    	array(
            'type' => 'textfield',
            'heading' => __( 'Stage Padding',TBBS_NAME ),
            'param_name' => 'stagepadding',
            'value' => 0,
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Loop',TBBS_NAME ),
            'param_name' => 'loop',
            'value' => array( 'True' => 1, 'False' => 0 ),
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Margin',TBBS_NAME ),
            'param_name' => 'margin',
            'value' => 10,
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Nav',TBBS_NAME ),
            'param_name' => 'nav',
            'value' => array( 'False' => 0, 'True' => 1 ),
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Dots',TBBS_NAME ),
            'param_name' => 'dots',
            'value' => array( 'True' => 1, 'False' => 0 ),
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Autoplay',TBBS_NAME ),
            'param_name' => 'autoplay',
            'value' => array( 'True' => 1, 'False' => 0 ),
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Autoplay Timeout',TBBS_NAME ),
            'param_name' => 'autoplaytimeout',
            'value' => 5000,
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'dropdown',
            'heading' => __( 'Autoplay Hover Pause',TBBS_NAME ),
            'param_name' => 'autoplayhoverpause',
            'value' => array( 'False' => 0, 'True' => 1 ),
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Responsive',TBBS_NAME ),
            'param_name' => 'responsive',
            'value' => '',
            'description' => __( 'Ex: 0:1,600:3,1000:5 = {0:{items:1},600:{items:3},1000:{items:5}}', TBBS_NAME ),
            'group' => __( 'OWL Carousel Settings', TBBS_NAME )
            ),
        /* [End] Owl tab */
        
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
            'shortcode' => 'bears_carousel',
            'group' => __( 'Template', TBBS_NAME ),
        	),
    	) );

vc_map( array(
	"name" => __( "Bears Carousel", TBBS_NAME ),
    "base" => "bears_carousel",
    "class" => "vc-bears-cacousel",
    "category" => __("Bears", TBBS_NAME),
    "params" => $params ) );

class WPBakeryShortCode_bears_carousel extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$_atts = shortcode_atts( array(
				'element_id'	=> '',
				'source'		=> '',
				'items'			=> 3,
				'stagepadding'	=> 0,
				'loop'			=> 1,
				'margin'		=> 10,
				'nav'			=> 0,
				'dots'			=> 1,
				'autoplay'		=> 1,
				'autoplaytimeout'	=> 5000,
				'autoplayhoverpause'	=> 0,
				'responsive'	=> '',
				'template'		=> '',
				'class' 		=> '',
                'content_inner' => '',
			    ), $atts);
        
		$atts = array_merge( $_atts, $atts );

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

		return tbbs_LoadTemplate( 'bears_carousel', $atts, $content );
	}
}