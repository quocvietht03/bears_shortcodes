<?php
/**
 * bears_single_product_slider_func
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_single_product_slider_func' ) ) :
	function bears_single_product_slider_func( $atts, $content ){
		$atts = array_merge( array(
			'id' => '',
			'class' => '',
			), $atts );

		extract( $atts );

		global $product;
		$attachment_ids = $product->get_gallery_attachment_ids();

		/* thumbnail */
		$thumbnail = array();
		if( has_post_thumbnail() ):
            $thumbnail_data = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'full' );
        	array_push( $thumbnail , $thumbnail_data[0] );
        endif;

        if( count( $attachment_ids ) > 0 ) : 
        	foreach( $attachment_ids as $attachment_id ) :
        		$image_data = wp_get_attachment_image_src( $attachment_id, 'full' );
        		array_push( $thumbnail , $image_data[0] );
        	endforeach;
        endif;
        
        $_content = '';
        if( count( $thumbnail ) > 0 ) :
        	foreach( $thumbnail as $k => $src ) :
        		$current = ( $k == 0 ) ? 'current' : '';

        		$_content .= "
        		<div class='item {$current}'>
					<img src='{$src}' alt=''>
        		</div>";
        	endforeach;
        endif;

        $slick_opts_for = json_encode( array(
        	'slidesToShow' 		=> 1,
			'slidesToScroll' 	=> 1,
			'arrows' 			=> false,
			'fade' 				=> true,
			'asNavFor' 			=> '.woo-slider-nav' ) );

        $slick_opts_nav = json_encode( array(
        	'slidesToShow' 		=> 3,
			'slidesToScroll' 	=> 1,
			'asNavFor' 			=> '.woo-slider-for',
			'dots' 				=> false,
			'centerMode' 		=> true,
			'focusOnSelect' 	=> true,
			'prevArrow'			=> '<button type="button" class="woo-slick-prev"><i class="ion-ios-arrow-thin-left"></i></button>',
			'nextArrow'			=> '<button type="button" class="woo-slick-next"><i class="ion-ios-arrow-thin-right"></i></button>', ) );
        
        $wooSliderNavHtml = ( count( $thumbnail ) > 1 ) ? "<div class='woo-slider-nav' data-slick-carousel='{$slick_opts_nav}' >{$_content}</div>" : '';

		return "
		<div class='bs_signle_product_slider_slick'>
			<div class='woo-slider-for' data-slick-carousel='{$slick_opts_for}' >{$_content}</div>
			{$wooSliderNavHtml}
		</div>";
	}
endif;
add_shortcode( 'bears_single_product_slider', 'bears_single_product_slider_func' );

/**
 * tbbs_BearsDocScript
 */
function tbbs_BearsSingleProductSliderLib( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'slick',
		'type' => 'css',
		'handle' => 'slick',
		'src' => TBBS_URL . 'shortcodes/bears_single_product_slider/assets/css/slick.css',
		'include' => 1,
		) );

	array_push( $scripts, array(
		'group' => 'slick',
		'type' => 'js',
		'handle' => 'slick',
		'src' => TBBS_URL . 'shortcodes/bears_single_product_slider/assets/js/slick.min.js',
		'include' => 1,
		'deps' => array( 'jquery', 'jquery-ui-core' ),
		) );
		
	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsSingleProductSliderLib' );

