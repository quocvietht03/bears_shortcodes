<?php
/**
 * bears_qrcodejs_func
 * [bears_qrcodejs url=""]
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_qrcodejs_func' ) ) :
	function bears_qrcodejs_func( $atts, $content ){
		$atts = array_merge( array(
			'render'		=> 'image',
			'text' 			=> '',
			'ecLevel' 		=> 'H', // error correction level: 'L', 'M', 'Q' or 'H'
			'size' 			=> 150,
			'fill' 			=> '#000',
			'background' 	=> null,
			'radius'		=> 0.5,
		    'quiet'			=> 3,
		    'mode'			=> 0,
			'extra_class' 	=> '',
			), $atts );

		$qrcode_opts = json_encode( $atts );

		return 
		"<div class='bs-qrcodejs-wrap {$atts['extra_class']}'>
			<div class='bs-qrcodejs-selector' data-qrcodejs='{$qrcode_opts}''></div>
		</div>";
	}
endif;
add_shortcode( 'bears_qrcodejs', 'bears_qrcodejs_func' );

/**
 * tbbs_BearsQrcodejsLib
 */
function tbbs_BearsQrcodejsLib( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'qrcode',
		'type' => 'js',
		'handle' => 'qrcode',
		'src' => TBBS_URL . 'shortcodes/bears_qrcodejs/assets/js/jquery.qrcode-0.12.0.min.js',
		'deps' => array( 'jquery' ),
		'include' => 1,
		) );
		
	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsQrcodejsLib' );