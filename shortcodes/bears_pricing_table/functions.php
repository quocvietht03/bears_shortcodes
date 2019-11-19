<?php
/**
 * tbbs_BearsPricingTableParams
 *
 */
function tbbs_BearsPricingTableParams()
{
	return array(
		array(
			'name' => 'name',
			'title' => __( 'Name', TBBS_NAME ),
			'type' => 'text',
			'value' => '',
			),
		array(
			'name' => 'description',
			'title' => __( 'Description', TBBS_NAME ),
			'type' => 'textarea',
			'value' => '',
			),
		array(
			'name' => 'price',
			'title' => __( 'Price', TBBS_NAME ),
			'type' => 'price',
			'value' => array( 'symbols' => '$', 'price' => 10.99, 'position_symbols' => 'left' ),
			),
		array(
			'name' => 'content',
			'title' => __( 'Content', TBBS_NAME ),
			'type' => 'textarea',
			'rows' => 5,
			'value' => '<ul>&#10;<li>Line 1</li>&#10;<li>Line 2</li>&#10;<li>Line 3</li>&#10;</ul>',
			),
		array(
			'name' => 'button',
			'title' => __( 'Button', TBBS_NAME ),
			'type' => 'link',
			'value' => array( 'text' => __( 'PURCHASE' ), 'url' => '#' ),
			),
		array(
			'name' => 'status',
			'title' => __( 'Status', TBBS_NAME ),
			'type' => 'select',
			'value' => 'normal',
			'options' => array(
				array(
					'value' => 'normal',
					'text'	=> __( 'Normal', TBBS_NAME ),
					),
				array(
					'value' => 'active',
					'text'	=> __( 'Active', TBBS_NAME ),
					),
				)
			),
		array(
			'name' => 'layout',
			'title' => __( 'Layout', TBBS_NAME ),
			'type' => 'select',
			'value' => 'default',
			'options' => apply_filters( 'tbbs_ShortcodePricingTableLayout', array(
					array(
						'value' => 'default',
						'text'	=> __( 'Default', TBBS_NAME ),
						),
					) 
				)
			),
		array(
			'name' => 'min_height',
			'title' => __( 'Min Height', TBBS_NAME ),
			'type' => 'text',
			'value' => '',
			'description' => __( 'ex: 500px', TBBS_NAME ),
			),
		);
}

/**
 * tbbs_PricingTableLayout_default
 * 
 * @param [html] $output
 * @param [array] $atts
 */
if( ! function_exists( 'tbbs_PricingTableLayout_default' ) ) :
	function tbbs_PricingTableLayout_default( $output, $atts )
	{
		$_lparam = $atts['template_params'];
		$_min_height = ! empty( $_lparam['min_height'] ) ? "min-height: {$_lparam['min_height']}" : '';
		$output = "
		<div class='bs-pricing-item layout-{$_lparam['layout']} __{$_lparam['status']}'>
			<div class='bs-pricing-inner' style='{$_min_height}'>
				<h4 class='title'>{$_lparam['name']}</h4>
				<div class='price-ui'>
					<div class='currency position-{$_lparam['price']['position_symbols']}'>{$_lparam['price']['symbols']}</div>
					<div class='price-num'>{$_lparam['price']['price']}</div>
				</div>
				<div class='des'>{$_lparam['description']}</div>
				<div class='wrap-field'>{$_lparam['content']}</div>
				<div class='btn-wrap'>
					<a href='{$_lparam['button']['url']}' class='button'>{$_lparam['button']['text']}</a>
				</div>
			</div>
		</div>";

		return $output;
	}
endif;
add_filter( 'tbbs_PricingTableLayout_default', 'tbbs_PricingTableLayout_default', 10, 2 );
