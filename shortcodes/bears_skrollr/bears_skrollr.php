<?php 
/**
 * tbbs_BearsQrcodejsLib
 */
function tbbs_BearsSkrollrLib( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'skrollr',
		'type' => 'js',
		'handle' => 'skrollr',
		'src' => TBBS_URL . 'shortcodes/bears_skrollr/assets/js/skrollr.js',
		'deps' => array( 'jquery' ),
		'include' => 1,
		) );
		
	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsSkrollrLib' );