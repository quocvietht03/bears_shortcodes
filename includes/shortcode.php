<?php 
/**
 * VC Custom Type
 */
require TBBS_INCLUDES . 'vc-custom-types/tbbs_supper_templates.php';

/**
 * tbbs_LoadShortcode
 * Scan on folder ../shortcodes
 */
function tbbs_LoadShortcode()
{
	$shortcode_dir = TBBS_SHORTCODES;
	$shortcodes = tbbs_FileScanDirectory( $shortcode_dir );
	
	if( count( $shortcodes ) <= 0 ) return;

	foreach( $shortcodes as $shortcode ) :
		$dir = TBBS_SHORTCODES . $shortcode . '/' . $shortcode . '.php';
		if( file_exists( $dir ) ) require_once $dir;
	endforeach;
}
tbbs_LoadShortcode();