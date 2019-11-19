<?php
/**
 * Layout Name: Default
 * Author: BEARS Theme
 * Author URI: http://themebears.com
 * Param: tbbs_BearsListingPostParams
 */

/* define variable */
$_id 		= sprintf( 'bears-element-%s', $atts['element_id'] );
$_class 	= sprintf( 'bs-listing-post-layout-%s %s', str_replace( '.php', '', $atts['template_params']['template'] ), $atts['class'] );
$loop 		= $atts['posts'];

if( ! function_exists( 'tbbs_ShortcodeListingPostHeader_woocommerce' ) ) :
	function tbbs_ShortcodeListingPostHeader_woocommerce( $atts )
	{
		return "
		<h4 class='header-text'>{$atts['header_text']}</h4>";
	}
endif;

if( ! function_exists( 'tbbs_ShortcodeListingPostLoop_woocommerce' ) ) :
	function tbbs_ShortcodeListingPostLoop_woocommerce( $atts )
	{
		global $product, $post;
		
		/* link */
		$link = get_the_permalink();
        /* title */
        $title = get_the_title();
        /* content */
        $content = wp_trim_words( get_the_content(), (int) $atts['template_params']['word_number'], '...' );
        /* price */
		$price_html = $product->get_price_html();
		/* thumbnail */
		$thumbnail = '';
		if( has_post_thumbnail() ):
            $thumbnail_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
        	$thumbnail = $thumbnail_data[0];
        endif;

		$output = "
		<div class='tb-listing-post-item'>
			<div class='thumb' style='background: url({$thumbnail}) no-repeat center center / cover, #333;'>
			</div>
			<div class='info'>
				<a href='{$link}'><h2 class='title'>{$title}</h2></a>
				<div class='des'>{$content}</div>
				<div class='price'>{$price_html}</div>
			</div>
		</div>";

		return $output;
	}
endif;
?>
<div id="<?php esc_attr_e( $_id ) ?>" class="bs-listing-post <?php esc_attr_e( $_class ); ?>">
	<div class="bs-listing-post-container">
		<?php 
		if( ! empty( $atts['header_text'] ) ) :
			echo call_user_func_array( 'tbbs_ShortcodeListingPostHeader_' . $atts['template_params']['layout'], array( $atts ) );
		endif;

		while( $loop->have_posts() ) : 
			$loop->the_post();
			echo call_user_func_array( 'tbbs_ShortcodeListingPostLoop_' . $atts['template_params']['layout'], array( $atts ) );
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</div>