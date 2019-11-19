<?php
/**
 * bears_favorite_func
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_woofavorite_func' ) ) :
	function bears_woofavorite_func( $atts, $content ){
		$atts = array_merge( array(
			'title' => __( 'My wishlist', TBBS_NAME ),
			'layout' => 'default', /* woocommerce */
			'class' => '',
			), $atts );

		extract( $atts );

		ob_start();
		require __DIR__ . '/layout.php';
		return ob_get_clean();
	}
endif;
add_shortcode( 'bears_woofavorite', 'bears_woofavorite_func' );

/**
 * bears_woofavorite_icon_func
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_woofavorite_icon_func' ) ) :
	function bears_woofavorite_icon_func( $atts, $content ){
		$atts = array_merge( array(
			'pid' => 0,
			'class' => '',
			), $atts );

		extract( $atts );

		$output = "<a href='#' class='bs-woofavorite-handle {$class}' title='add favorite' data-pid='{$pid}'><i class='ion-ios-heart-outline'></i></a>";
		return $output;
	}
endif;
add_shortcode( 'bears_woofavorite_icon', 'bears_woofavorite_icon_func' );

/**
 * tbbs_woofavorite_items
 *
 */
if( ! function_exists( 'tbbs_woofavorite_items' ) ) :
	function tbbs_woofavorite_items()
	{
		extract( $_POST );
		$result = array( 'count' => 0, 'html' => '' );
		
		if( isset( $favorited ) && count( $favorited ) > 0 ) :
			$result['count'] = count( $favorited );

			foreach( $favorited as $pid ) : 
				/* set $product */
				$product = get_product( $pid );
				if( empty( $product ) ) continue;

				/* link */
				$link = get_permalink( $pid );
		        /* title */
		        $title = get_the_title( $pid );
		        /* content */
		        $content = wp_trim_words( get_post_field( 'post_content', $pid ), 8, '...' );
		        /* price */
				$price_html = $product->get_price_html();
				/* thumbnail */
				$thumbnail = '';
				if( get_post_thumbnail_id( $pid ) ):
		            $thumbnail_data = wp_get_attachment_image_src( get_post_thumbnail_id( $pid ), 'large' );
		        	$thumbnail = $thumbnail_data[0];
		        endif;
		        /* add to cart btn */
		        $add_to_cart_html = sprintf( '
					<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s icon-add-to-cart ajax_add_to_cart product_type_%s" title="%s">
						<i class="icon icon-ecommerce-bag-plus"></i>
					</a>', 
					esc_url( $product->add_to_cart_url() ),
					esc_attr( $product->id ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					( $product->is_purchasable() && $product->is_in_stock() ) ? 'add_to_cart_button' : '',
					esc_attr( $product->product_type ),
					esc_attr( 'add to cart', TBBS_NAME ) );

				$item_Html = "
				<div class='item' data-pid='{$pid}'>
					<div class='bs-favorite-item'>
						<div class='thumb' style='background: url({$thumbnail}) no-repeat center center / cover, #fafafa'></div>
						<div class='info'>
							<a href='{$link}'><h2 class='title'>{$title}</h2></a>
							<div class='price'>{$price_html}</div>
							<div class='handle'>
								{$add_to_cart_html}
							</div>
						</div>
					</div>
				</div>";

				$result['html'] .= $item_Html;
			endforeach;
		endif;

		/* apply_filters name : tbbs_bears_woofavorite_layout_items */
		$result['html'] = apply_filters( 'tbbs_' . basename( __FILE__, '.php' . '_layout_items' ), $result['html'], $_POST );
		echo json_encode( $result );
		exit();
	}
endif;
add_action( 'wp_ajax_tbbs_woofavorite_items', 'tbbs_woofavorite_items' );
add_action( 'wp_ajax_nopriv_tbbs_woofavorite_items', 'tbbs_woofavorite_items' );
