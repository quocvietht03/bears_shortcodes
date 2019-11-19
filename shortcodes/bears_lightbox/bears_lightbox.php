<?php
/**
 * bears_lightbox_func
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_lightbox_func' ) ) :
	function bears_lightbox_func( $atts, $content ){
		$atts = array_merge( array(
			'href' => '',
			'title' => '',
			'description' => '',
			'width' => 600,
			'height' => 400,
			'titlestyle' => '', /* left, right */
			'group' => '',
			'extra_class' => '',
			), $atts );

		extract( $atts );

		$content = do_shortcode( $content );
		return "<a 
			class='html5lightbox {$extra_class}'
			href='{$href}' 
			title='{$title}' 
			data-description='{$description}' 
			data-width='{$width}' 
			data-height='{$height}' 
			data-titlestyle='{$titlestyle}'>{$content}</a>";
	}
endif;
add_shortcode( 'bears_lightbox', 'bears_lightbox_func' );

/**
 * tbbs_BearsCarouselOwlCarouselLib
 * register lib owlcarousel JS
 */
function tbbs_BearslightboxLib( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'Html5 Lightbox',
		'type' => 'js',
		'handle' => 'html5lightbox',
		'src' => TBBS_URL . 'shortcodes/bears_lightbox/assets/js/html5lightbox.js',
		'ver' => '1.0',
		'include' => 1,
		) );

	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearslightboxLib' );