<?php
/**
 * bears_quickview_func
 *
 * @param array $atts
 * @param string $content
 */
if( ! function_exists( 'bears_quickview_func' ) ) :
	function bears_quickview_func( $atts, $content ){
		$atts = array_merge( array(
			'title'			=> __( 'Quick View', TBBS_NAME ),
			'layout' 		=> '',
			'pid' 			=> 0,
			'icon' 			=> 'fa fa-search',
			'extra_class' 	=> '',
			), $atts );

		extract( $atts );
		
		return "
		<a class='tbbs-quickview-handle {$extra_class}' title='{$title}' href='#' data-layout='{$layout}' data-pid='{$pid}'>
			<i class='{$icon}'></i>
		</a>";
	}
endif;
add_shortcode( 'bears_quickview', 'bears_quickview_func' );

if( ! function_exists( 'tbbs_quickviewAjaxHandle' ) ) :
	function tbbs_quickviewAjaxHandle() {
		extract( $_POST );
		$content = call_user_func_array( "tbbs_quickviewLayout_{$layout}", array( $pid ) );
		echo "{$content}";
		exit();
	}
endif;
add_action( 'wp_ajax_tbbs_quickviewAjaxHandle', 'tbbs_quickviewAjaxHandle' );
add_action( 'wp_ajax_nopriv_tbbs_quickviewAjaxHandle', 'tbbs_quickviewAjaxHandle' );

if( ! function_exists( 'tbbs_quickview_action_template' ) ) :
function tbbs_quickview_action_template() {

	// Image
	add_action( 'tbbs_qv_product_image_sale', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'tbbs_qv_product_image', 'woocommerce_show_product_images', 20 );

	// Summary
	add_action( 'tbbs_qv_product_summary_title', 'woocommerce_template_single_title', 5 );
	add_action( 'tbbs_qv_product_summary_rating', 'woocommerce_template_single_rating', 10 );
	add_action( 'tbbs_qv_product_summary_price', 'woocommerce_template_single_price', 15 );
	add_action( 'tbbs_qv_product_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'tbbs_qv_product_summary_add_to_cart', 'woocommerce_template_single_add_to_cart', 25 );
	add_action( 'tbbs_qv_product_summary_single_meta', 'woocommerce_template_single_meta', 30 );
}
endif;
tbbs_quickview_action_template();

if( ! function_exists( 'tbbs_quickviewLayout_woocommerce' ) ) :
	function tbbs_quickviewLayout_woocommerce( $pid = 0 )
	{
		$product_id = intval( $pid );

		// set the main wp query for the product
		wp( 'p=' . $product_id . '&post_type=product' );

		ob_start();
		while ( have_posts() ) : the_post(); 
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
	        
	        $_gallery = '';
	        if( count( $thumbnail ) > 0 ) :
	        	foreach( $thumbnail as $k => $src ) :
	        		$_gallery .= "<div class='item' style='background: url($src) no-repeat center center / cover;'></div>";
	        	endforeach;
	        endif;

	        /* add to cart btn */
	        $add_to_cart_html = sprintf( '
				<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="%s icon-add-to-cart ajax_add_to_cart product_type_%s" title="%s">
					ADD TO CART
				</a>', 
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->id ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				( $product->is_purchasable() && $product->is_in_stock() ) ? 'add_to_cart_button' : '',
				esc_attr( $product->product_type ),
				esc_attr( 'add to cart', TBBS_NAME ) );

	        /* social */
			$extra_data = json_encode( array(
				'title' => get_the_title(),
				'description' => wp_trim_words( get_the_content(), 15, '...' ),
				'thumbnail' => $thumbnail[0],
				) );
			
	        /* carousel setting */
	        $slick_opts = json_encode( array(
	        	'slidesToShow' => 1,
	        	'slidesToScroll' => 1,
	        	'arrows' => false,
	        	'dots' => true,
	        	'autoplay' => true,
	        	) );
		?>
			<div class="product woocommerce">
				<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
					<?php do_action( 'tbbs_qv_product_image_sale' ); ?>
					<div class="container-gallery" data-slick-carousel='<?php echo esc_attr( $slick_opts ); ?>'>
						<?php echo "{$_gallery}"; ?>
					</div><div class="container-info">
						<div class="info-inner">
							<?php 
								do_action( 'tbbs_qv_product_summary_title' ); 
								do_action( 'woocommerce_template_single_rating' ); 
								do_action( 'woocommerce_template_single_price' ); 
								echo '<div class="short-decs">' . wp_trim_words( get_the_content(), 20, '...' ) . '</div>';
								echo "{$add_to_cart_html}";
								echo do_shortcode( "[bears_social social='twitter,google,facebook,pinterest' url='". get_permalink() ."' extra_data='{$extra_data}']" );
								// do_action( 'woocommerce_template_single_meta' ); 
							?>
						</div>
					</div>
				</div>

			</div>
		<?php endwhile;
		$output = ob_get_clean();

		return $output;
	}	
endif;
