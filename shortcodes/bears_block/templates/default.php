<?php 
/**
 * Layout Name: Default
 * Author: BEARS Theme
 * Author URI: http://themebears.com
 * Param: tbbs_BearsBlockDefaultParams
 */

/* define variable */
$_id 		= sprintf( 'bears-element-%s', $atts['element_id'] );
$_class 	= sprintf( 'bs-block-layout-%s %s', str_replace( '.php', '', $atts['template_params']['template'] ), $atts['class'] );

?>
<div id="<?php esc_attr_e( $_id ) ?>" class="bs-block <?php esc_attr_e( $_class ); ?>">
	<div class="bs-block-container" 
		style="<?php esc_attr_e( "height: {$atts['template_params']['height']};" ); ?>">
		
		<!-- div background -->
		<div class="bs-block-background" 
		style="<?php esc_attr_e( "background: url({$atts['template_params']['background_image']}) no-repeat center center / cover, #555;" ); ?>">
			
		</div>
		
		<!-- div info -->
		<div class="bs-block-info">
			<h2 class="title"><?php _e( $atts['template_params']['title'] ) ?></h2>
			<p class="content"><?php _e( $atts['template_params']['content'] ) ?></p>
			<a href="<?php _e( $atts['template_params']['link']['url'] ) ?>" class="link"><?php _e( $atts['template_params']['link']['text'] ) ?></a>
		</div>
	
	</div>
</div>