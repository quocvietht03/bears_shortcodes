<?php 
/**
 * Layout Name: Icon
 * Author: BEARS Theme
 * Author URI: http://themebears.com
 * Param: tbbs_BearsBlockIconParams
 */

/* define variable */
$_id 		= sprintf( 'bears-element-%s', $atts['element_id'] );
$_class 	= sprintf( 'bs-block-layout-%s %s', str_replace( '.php', '', $atts['template_params']['template'] ), $atts['class'] );
$_color_arr = array(
	'black' => array( 'color1' => '#555', 'color2' => '#333', 'color3' => '#999', 'color4' => 'rgba(0,0,0,.1)' ), 
	'white' => array( 'color1' => '#FFF', 'color2' => '#FFF', 'color3' => '#FFF', 'color4' => 'rgba(255,255,255,.1)' ), 
	'red' => array( 'color1' => 'red', 'color2' => 'red', 'color3' => 'red', 'color4' => 'rgba(0,0,0,.1)' ) );
$_type_color = $_color_arr[$atts['template_params']['color_style']];

/**
 * tbbs_BearsBlockIconLayoutBlock
 *
 */
if( ! function_exists( 'tbbs_BearsBlockIconLayoutBlock' ) ) :
	function tbbs_BearsBlockIconLayoutBlock( $data ) 
	{
		extract( $data );
		$output = "
		<div class='bs-block-container tbbs-text-{$atts['template_params']['align']}'
		style='background: {$type_color['color4']}'>
		
			<div class='bs-block-icon' 
			style='color: {$type_color['color1']}'>
				<span><i class='{$atts['template_params']['icon_font_class']}'></i></span>
			</div>
			
			<h2 class='title'
			style='color: {$type_color['color2']}'>
				{$atts['template_params']['title']}
			</h2>
			
			<p class='sub-title'
			style='color: {$type_color['color3']}'>
				{$atts['template_params']['sub_title']}
			</p>
			
		</div>";
		
		return $output;
	}
endif;

/**
 * tbbs_BearsBlockIconLayoutInline
 *
 */
if( ! function_exists( 'tbbs_BearsBlockIconLayoutInline' ) ) :
	function tbbs_BearsBlockIconLayoutInline( $data ) 
	{
		extract( $data );
		$output = "
		<div class='bs-block-container tbbs-text-{$atts['template_params']['align']} tbbs-no-padding'>
			
			<div class='bs-block-icon-inline' 
			style='color: {$type_color['color1']}'>
				<span><i class='{$atts['template_params']['icon_font_class']}'></i>
			</div>
			
			<div class='bs-block-text'>
				<h2 class='title-inline'
				style='color: {$type_color['color2']}'>
					{$atts['template_params']['title']}
				</h2>
				<p class='sub-title-inline'
				style='color: {$type_color['color3']}'>
					{$atts['template_params']['sub_title']}
				</p>
			</div>
			
		</div>";
		
		return $output;
	}
endif;
?>
<div id="<?php esc_attr_e( $_id ) ?>" class="bs-block <?php esc_attr_e( $_class ); ?>">
	<?php
	$data = array( 'atts' => $atts, 'type_color' => $_type_color );
	
	switch( $atts['template_params']['layout'] ) {
		case 'block': _e( tbbs_BearsBlockIconLayoutBlock( $data ) ); break;
		case 'inline': _e( tbbs_BearsBlockIconLayoutInline( $data ) ); break;
	}
	?>
</div>