<?php
/**
 * functions.php
 * Author: Bearsthemes
 * Author URI: http://bearsthemes.com
 * Email: bearsthemes@gmail.com
 */

/**
 * tbbs_BearsCarouselOwlCarouselLib
 * register lib owlcarousel JS
 */
function tbbs_BearsCarouselOwlCarouselLib( $scripts )
{	
	array_push( $scripts, array(
		'group' => 'owlcarousel',
		'type' => 'js',
		'handle' => 'owlcarousel',
		'src' => TBBS_URL . 'shortcodes/bears_carousel/assets/js/owl.carousel.js',
		'deps' => array( 'jquery' ),
		'include' => 1,
		) );

	array_push( $scripts, array(
		'group' => 'owlcarousel',
		'type' => 'css',
		'handle' => 'owlcarousel',
		'src' => TBBS_URL . 'shortcodes/bears_carousel/assets/css/owl.carousel.css',
		'include' => 1,
		) );

	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsCarouselOwlCarouselLib' );

/**
 * tbbs_BearsCarouselParams
 *
 */
function tbbs_BearsCarouselParams()
{
	return array(
		array(
			'name' => 'height_thumbnail',
			'title' => 	__( 'Height Thumbnail', TBBS_NAME ),
			'type' => 'text',
			'value' => '240px',
			),
		array(
			'name' => 'display_filter',
			'title' => 	__( 'Display Filter', TBBS_NAME ),
			'type' => 'select',
			'value' => 'hide',
			'options' => array(
				array(
					'value' => 'show',
					'text' => __( 'Show', TBBS_NAME ),
					),
				array(
					'value' => 'hide',
					'text' => __( 'Hide', TBBS_NAME ),
					),
				)
			),
		array(
			'name' => 'align_text',
			'title' => 	__( 'Align Text', TBBS_NAME ),
			'type' => 'select',
			'value' => 'left',
			'options' => array(
				array(
					'value' => 'left',
					'text' => __( 'Left', TBBS_NAME ),
					),
				array(
					'value' => 'center',
					'text' => __( 'Center', TBBS_NAME ),
					),
				array(
					'value' => 'right',
					'text' => __( 'Right', TBBS_NAME ),
					),
				),
			'description' => __( 'Align text (default: align center)', TBBS_NAME )
			),
		array(
			'name' => 'layout_item',
			'title' => __( 'Layout Item', TBBS_NAME ),
			'type' => 'select',
			'value' => 'default',
			'options' => apply_filters( 'tbbs_ShortcodeCarouselLayoutItem', array(
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

/**
 * tbbs_CarouselStyleLayout_default
 *
 * @param string $output
 * @param array $data
 * @param array $atts
 *
 * @return Html
 */
function tbbs_CarouselStyleLayout_default( $output, $atts, $data )
{
	extract( $data );
	$output = "
	<div class='item-thumbnail'
	style='background: url({$thumbnail}) no-repeat center center / cover, #333;height: {$atts['template_params']['height_thumbnail']}'>
		<div class='box-icon'>
			<a href='{$thumbnail}' class='icon-handle' data-imagelightbox-thumbnail><i class='fa fa-expand'></i></a>
		</div>
	</div>
	<div class='item-info tbbs-text-{$atts['template_params']['align_text']}'>
		<a href='{$link}'><h2 class='title'>{$title}</h2></a>
		<p class='content'>{$content}</p>
	</div>";

	return $output;
}
add_filter( 'tbbs_CarouselStyleLayoutItem_default', 'tbbs_CarouselStyleLayout_default', 10, 3 );

/**
 * tbbs_CarouselStyleLayout_woocommerce
 *
 * @param string $output
 * @param array $data
 * @param array $atts
 *
 * @return Html
 */
function tbbs_CarouselStyleLayout_woocommerce( $output, $atts, $data )
{
	extract( $data );
	$output = "
	<div class='item-thumbnail'
	style='background: url({$thumbnail}) no-repeat center center / cover, #333;height: {$atts['template_params']['height_thumbnail']}'>
		<div class='box-icon'>
			<a href='{$thumbnail}' class='icon-handle' data-imagelightbox-thumbnail><i class='fa fa-expand'></i></a>
		</div>
	</div>
	<div class='item-info tbbs-text-{$atts['template_params']['align_text']}'>
		<a href='{$link}'><h2 class='title'>{$title}</h2></a>
		<p class='content'>{$content}</p>
	</div>";

	return $output;
}
add_filter( 'tbbs_CarouselStyleLayoutItem_woocommerce', 'tbbs_CarouselStyleLayout_woocommerce', 10, 3 );