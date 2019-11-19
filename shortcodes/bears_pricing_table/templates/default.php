<?php 
/**
 * Layout Name: Default
 * Author: Bearsthemes
 * Author URI: http://themebears.com
 * Param: tbbs_BearsPricingTableParams
 */

/* define variable */
$_id 		= sprintf( 'bears-element-%s', $atts['element_id'] );
$_class 	= sprintf( 'bs-template-%s %s', basename( __FILE__, '.php' ), $atts['class'] );
?>
<div id="<?php echo esc_attr( $_id ) ?>" class="bs-pricing-table <?php echo esc_attr( $_class ); ?>">
	<div class="bs-element-container">
		<?php echo apply_filters( 'tbbs_PricingTableLayout_' . $atts['template_params']['layout'], '', $atts ); ?>
	</div>
</div>