<?php 
/*
 * Layout Name: Default
 * Author: Bearsthemes
 * Author URI: http://themebears.com
 * Param: bearsthemes_BearsTextillateParams
 */

/* define variable */
$_id 		= sprintf( 'bears-element-%s', $atts['element_id'] );
$_class 	= sprintf( 'layout-%s %s', str_replace( '.php', '', $atts['template_params']['template'] ), $atts['class'] );
$_style = implode( ';', $atts['style']['styles'] );
$_template = explode( '{content}', $atts['template_params']['text_template'] );
$_tlt_settings = json_encode( array(
		'selector' => '.texts',
		'loop' => (int) $atts['loop'],
		// 'minDisplayTime' => 2000,
		'initialDelay' => (int) $atts['initial_delay'],
		'autoStart' => (int) $atts['auto_start'],
		// 'inEffects' => array(),
		// 'outEffects' => array( 'hinge' ),
		'in' => array( 
			'effect' => $atts['in_animate_effect'],
			'delayScale' => 1.5,
			'delay' => 50,
			"{$atts['in_animate_type']}" => true 
			),
		'out' => array(
			'effect' => $atts['out_animate_effect'],
			'delayScale' => 1.5,
			'delay' => 50,
			"{$atts['out_animate_type']}" => true 
			),
		'type' => $atts['type'], // set the type of token to animate (available types: 'char' and 'word')
		) );
// echo '<pre>'; print_r( $_tlt_settings ); echo '</pre>';
/**
 * tbbs_ShortcodeTextillateLayout_default
 *
 * @param [array] $atts
 * @return [html] $output
 */
if( ! function_exists( 'tbbs_ShortcodeTextillateLayout_default' ) ) :
	function tbbs_ShortcodeTextillateLayout_default( $atts )
	{
		$output = '';
		$itemHtml = '';
		$template_params = $atts['template_params'];
		$texts = $template_params['content']['text'];
		
		if( count( $texts ) > 0 ) :
			for( $i = 0; $i <= ( count( $texts ) - 1 ); $i++ ) :
				$itemHtml .= "<li>{$template_params['content']['text'][$i]}</li>";
			endfor;
		endif;

		$output .= "<ul class='texts layout-{$template_params['layout']}'>{$itemHtml}</ul>";

		return $output;
	}
endif;
?>
<div id="<?php echo esc_attr( $_id ) ?>" class="bs-textillate <?php echo esc_attr( $_class ); ?>">
	<div class="bs-container" style='<?php echo esc_attr( $_style ); ?>'>
	<?php echo do_shortcode( trim( $_template[0] ) ); ?>
	<span class="bs-textillate-selector tlt" data-textillate-handle='<?php echo esc_attr( $_tlt_settings ); ?>'>
		<?php echo call_user_func_array( 'tbbs_ShortcodeTextillateLayout_' . $atts['template_params']['layout'], array( $atts ) ); ?>
	</span>
	<?php echo do_shortcode( trim( $_template[1] ) ); ?>
	</div>
</div>