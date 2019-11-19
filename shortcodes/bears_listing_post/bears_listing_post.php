<?php
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
    	array(
    		'type' => 'textfield',
            'heading' => __( 'Header Text',TBBS_NAME ),
            'param_name' => 'header_text',
            'value' => '',
            'description' => __( '',TBBS_NAME ),
            'group' => __( 'Heading', TBBS_NAME )
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
            'shortcode' => 'bears_listing_post',
            'group' => __( 'Template', TBBS_NAME ),
        	),
    	) );

vc_map( array(
	"name" => __( "Bears Listing Post", TBBS_NAME ),
    "base" => "bears_listing_post",
    "class" => "vc-bears-listting-post",
    "category" => __("Bears", TBBS_NAME),
    "params" => $params ) );

class WPBakeryShortCode_bears_listing_post extends WPBakeryShortCode
{
	protected function content( $atts, $content = null )
	{
		$_atts = shortcode_atts( array(
				'element_id'	=> '',
				'source'		=> '',
				'header_text'	=> '',
				'template'		=> '',
				'class' 		=> '',
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

		return tbbs_LoadTemplate( basename( __FILE__, '.php' ), $atts, $content );
	}
}

/**
 * tbbs_BearsListingPostParams
 *
 */
if( ! function_exists( 'tbbs_BearsListingPostParams' ) ) :
	function tbbs_BearsListingPostParams()
	{
		return array(
			array(
				'name' => 'word_number',
				'title' => __( 'Word Number', TBBS_NAME ),
				'type' => 'text',
				'value' => 8,
				),
			array(
				'name' => 'layout',
				'title' => __( 'Layout', TBBS_NAME ),
				'type' => 'select',
				'value' => 'default',
				'options' => apply_filters( 'tbbs_ShortcodeListingPostLayout', array(
					array(
						'value' => 'default',
						'text' => __( 'Default', TBBS_NAME ),
						),
					array(
						'value' => 'woocommerce',
						'text' => __( 'Woocommerce', TBBS_NAME ),
						)
					) )
				)
			);
	}
endif;