<?php
/**
 * bears_iconfont_func
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_iconfont_func' ) ) :
	function bears_iconfont_func( $atts, $content ){
		$atts = array_merge( array(
			'class' => '',
			'fontsize' => '',
			'color' => '',
			'extra_class' => '',
			), $atts );

		extract( $atts );

		/* build style */
		$style = array();

		if( ! empty( $fontsize ) ) array_push( $style, "font-size: {$fontsize}" );
		if( ! empty( $color ) ) array_push( $style, "color: {$color}" );


		$content = do_shortcode( $content );
		return "<i class='bears-iconfont {$class} {$extra_class}' style='". implode( ';', $style ) ."'></i>";
	}
endif;
add_shortcode( 'bears_iconfont', 'bears_iconfont_func' );


/**
 * tbbs_BearsDocScript
 */
function tbbs_BearsIconfontLib( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'font-icon',
		'type' => 'css',
		'handle' => 'linea-ecommerce',
		'src' => TBBS_URL . 'shortcodes/bears_iconfont/assets/fonts/linea_ecommerce/font.css',
		'include' => 1,
		) );

	array_push( $scripts, array(
		'group' => 'font-icon',
		'type' => 'css',
		'handle' => 'linea-basic',
		'src' => TBBS_URL . 'shortcodes/bears_iconfont/assets/fonts/linea_basic/font.css',
		'include' => 0,
		) );

	array_push( $scripts, array(
		'group' => 'font-icon',
		'type' => 'css',
		'handle' => 'pe-icon-7-stroke',
		'src' => TBBS_URL . 'shortcodes/bears_iconfont/assets/fonts/pe-icon-7-stroke/font.css',
		'include' => 1,
		) );
		
	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsIconfontLib' );