<?php
/**
 * Layout Name: Header Image Background
 * Author: BEARS Theme
 * Author URI: http://themebears.com
 * Param: tbbs_BearsHeadingDefaultParams
 */

/* define variable */
$_id 		= sprintf( 'bears-element-%s', $atts['element_id'] );
$_class 	= sprintf( 'bs-heading-layout-%s %s', str_replace( '.php', '', $atts['template_params']['template'] ), $atts['class'] );
?>
<div id="<?php echo esc_attr( $_id ) ?>" class="bs-heading <?php echo esc_attr( $_class ); ?>">
	<?php echo apply_filters( 'tbbs_headingLayout_' . $atts['template_params']['layout'], '', $atts ); ?>
</div>