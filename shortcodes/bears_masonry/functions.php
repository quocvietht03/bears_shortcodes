<?php
/**
 * tbbs_BearsCarouselOwlCarouselLib
 * register lib owlcarousel JS
 */
function tbbs_BearsMasonryIsotopeLib( $scripts )
{	
	wp_enqueue_script( 'jquery-ui-resizable' );
	
	array_push( $scripts, array(
		'group' => 'isotope',
		'type' => 'js',
		'handle' => 'isotope',
		'src' => TBBS_URL . 'shortcodes/bears_masonry/assets/js/isotope.pkgd.min.js',
		'deps' => array( 'jquery' ),
		'include' => 1,
		) );

	array_push( $scripts, array(
		'group' => 'image lightbox',
		'type' => 'js',
		'handle' => 'imagelightbox',
		'src' => TBBS_URL . 'shortcodes/bears_masonry/assets/js/imagelightbox.min.js',
		'deps' => array( 'jquery' ),
		'include' => 1,
		) );

	array_push( $scripts, array(
		'group' => 'shortcode masonry scripts',
		'type' => 'js',
		'handle' => 'tbbs-masonry-script',
		'src' => TBBS_URL . 'shortcodes/bears_masonry/assets/js/jquery.tbbs-masonry.js',
		'deps' => array( 'jquery', 'isotope' ),
		'localize_script' => array( 
			'obj_name' => 'tbbsMasonryObj', 
			'obj_data' => array( 
				'ajax_url' => admin_url( 'admin-ajax.php' ) 
				) 
			),
		'include' => 1,
		) );

	return $scripts;
}
add_filter( 'tbbs_register_scripts', 'tbbs_BearsMasonryIsotopeLib' );

/**
 * tbbs_BearsMasonryParams
 *
 */
function tbbs_BearsMasonryParams()
{
	return array(
		array(
			'name' => 'filter_by_taxonomy',
			'title' => __( 'Filter By Taxonomy', TBBS_NAME ),
			'type' => 'text',
			'value' => 'category',
			'description' => __( 'Note: Use for custom post type. (default: category, woocommerce: product_cat)', TBBS_NAME ),
			),
		array(
			'name' => 'layout_item',
			'title' => __( 'Layout Item', TBBS_NAME ),
			'value' => 'default',
			'type' => 'select',
			'options' => apply_filters( 'tbbs_ShortcodeMasonryLayoutItem', array( 
					array(
						'value' => 'default',
						'text' => __( 'Default', TBBS_NAME ),
						),
					array(
						'value' => 'woocommerce',
						'text' => __( 'Woocommerce', TBBS_NAME ),
						),
					)
				) 
			),
		array(
			'name' => 'display_filter',
			'title' => __( 'Display Filter', TBBS_NAME ),
			'value' => 1,
			'type' => 'select',
			'options' => array(
				array(
					'value' => 1,
					'text' => __( 'Show', TBBS_NAME ),
					),
				array(
					'value' => 0,
					'text' => __( 'Hide', TBBS_NAME ),
					),
				)
			),
		array(
			'name' => 'layout_filter',
			'title' => __( 'Layout Filter', TBBS_NAME ),
			'value' => 'default',
			'type' => 'select',
			'options' => apply_filters( 'tbbs_ShortcodeMasonryLayoutFilter', array( 
					array(
						'value' => 'default',
						'text' => __( 'Default', TBBS_NAME ),
						),
					array(
						'value' => 'line_black',
						'text' => __( 'Line Black', TBBS_NAME ),
						),
					array(
						'value' => 'select',
						'text' => __( 'Select', TBBS_NAME ),
						),
					)
				) 
			),
		array(
			'name' => 'filter_align',
			'title' => __( 'Filter Align', TBBS_NAME ),
			'value' => 1,
			'type' => 'select',
			'options' => array(
				array(
					'value' => 'center',
					'text' => __( 'Center', TBBS_NAME ),
					),
				array(
					'value' => 'left',
					'text' => __( 'Left', TBBS_NAME ),
					),
				array(
					'value' => 'right',
					'text' => __( 'Right', TBBS_NAME ),
					),
				)
			),
		array(
			'name' => 'load_more',
			'title' => __( 'Load More (Ajax)', TBBS_NAME ),
			'value' => '',
			'type' => 'select',
			'description' => __( 'Note: not use when build query: <b>order by random</b>', TBBS_NAME ),
			'options' => array(
				array(
					'value' => '',
					'text' => __( 'No', TBBS_NAME ),
					),
				array(
					'value' => 'scroll',
					'text' => __( 'Scroll', TBBS_NAME ),
					),
				array(
					'value' => 'click_button',
					'text' => __( 'Click button', TBBS_NAME ),
					),
				)
			),
		);
}

/**
 * tbbs_ShortcodeMasonrySaveDataGrid
 *
 */
function tbbs_ShortcodeMasonrySaveDataGrid()
{
	// print_r( $_POST );
	$gridDatas = tbbs_ShortcodeMasonryGetGridData();

	if( empty( $gridDatas ) || count( $gridDatas ) == 0 ) :
		$gridDatas[$_POST['elementid']] = $_POST['grid'];
		add_option( 'tbbs_ShortcodeMasonryGridDatas', $gridDatas );
	else :
		$gridDatas[$_POST['elementid']] = $_POST['grid'];
		update_option( 'tbbs_ShortcodeMasonryGridDatas', $gridDatas );
	endif;

	
	wp_die();
}
add_action( 'wp_ajax_tbbs_ShortcodeMasonrySaveDataGrid', 'tbbs_ShortcodeMasonrySaveDataGrid' );
add_action( 'wp_ajax_nopriv_tbbs_ShortcodeMasonrySaveDataGrid', 'tbbs_ShortcodeMasonrySaveDataGrid' );

/**
 * tbbs_ShortcodeMasonryGetGridData
 *
 * @param int $elementID
 */
function tbbs_ShortcodeMasonryGetGridData( $elementID = '' ) 
{
	$gridArr = get_option( 'tbbs_ShortcodeMasonryGridDatas', array() );

	if( empty( $elementID ) ) return $gridArr;

	if( isset( $gridArr[$elementID] ) ) return $gridArr[$elementID];
	else return;
}

/**
 * tbbs_MasonryGetFilterDataByTaxonomy
 *
 */
function tbbs_MasonryGetFilterDataByTaxonomy( $posts, $taxonomy )
{
	$filterData = array();

	while( $posts->have_posts() ) : 
		$posts->the_post();
		$cats = wp_get_post_terms( get_the_ID(), $taxonomy );
		if( ! empty( $cats ) && count( $cats ) > 0 ) :
			foreach( $cats as $cat_item ) : 
				if( ! isset( $filterData[$cat_item->slug] ) ) :
					$filterData[$cat_item->slug] = array( 'name' => $cat_item->name, 'count' => 1 );
				else :
					$filterData[$cat_item->slug]['count'] = $filterData[$cat_item->slug]['count'] += 1;
				endif;
			endforeach;
			endif;
	endwhile;
	wp_reset_postdata();

	return $filterData;
}

/**
 * tbbs_MasonyLayoutRender
 *
 */
function tbbs_MasonyLayoutCreativeRender( $atts )
{
	/* define variable settings */
	$atts['settings'] = array(
		'_id' 			=> sprintf( 'bears-element-%s', $atts['element_id'] ),
		'_template_name'=> str_replace( '.php', '', $atts['template_params']['template'] ),
		'_class' 		=> sprintf( 'bs-masonry-layout-%s %s', str_replace( '.php', '', $atts['template_params']['template'] ), $atts['class'] ),
		'_opts_masonry' => array(
			'tbbsPadding' 	=> (int) $atts['padding'],
			'tbbsHeight' 	=> (int) $atts['cell_height'],
			'tbbsGridData' 	=> tbbs_ShortcodeMasonryGetGridData( $atts['element_id'] ),
			),
		);

	/* query */
	$loop = tbbs_MasonryQueryPost( $atts['source'] );

	/* enable resize & button save */
	if( is_super_admin() ) :
		$atts['settings']['_opts_masonry']['tbbsResizable'] = true;
		$atts['settings']['_opts_masonry']['tbbsSave'] = true;
	endif;

	extract( $atts['settings'] );

	/* get filter HTML */
	$filter_Html = tbbs_MasonryFilterHeaderRender( $atts, $loop );
	$container_Html = tbbs_MasonryContentRender( $atts, $loop );
	$buttonLoadmore_Html = ( $atts['template_params']['load_more'] == 'click_button' )
		? apply_filters( 'tbbs_ShortcodeMasonryButtonLoadmore_' . $atts['settings']['_template_name'], sprintf( '<div class="tbbs-masonryloadmore-container"><a href="#" data-masonryloadmorebtn class="tbbs-btn-masonry-loadmore">%s</a></div>', __( 'Loadmore', TBBS_NAME ) ) ) 
		: '';

	$output = "
	<div id='{$_id}' class='bs-masonry {$_class}' data-elementid='{$atts['element_id']}'>
		{$filter_Html}
		{$container_Html}
		{$buttonLoadmore_Html}
	</div>";
	return $output;
}

/**
 * tbbs_MasonryQueryPost
 *
 * @param array $args
 * @param int $paged
 */
function tbbs_MasonryQueryPost( $source, $paged = 1 )
{	
	/* wp_query */
	list( $args, $wp_query ) = vc_build_loop_query( $source );
    
    if( $paged > 1 ) :
    	$args['paged'] = (int) $paged;
    	$wp_query = new WP_Query( $args );
    endif;

    return $wp_query;
}

/**
 * tbbs_MasonryFilterHeaderRender
 *
 * @param array $atts
 */
function tbbs_MasonryFilterHeaderRender( $atts, $loop )
{
	$output = '';
	
	if( (int) $atts['template_params']['display_filter'] == false ) return $output;

	$filterDatas = tbbs_MasonryGetFilterDataByTaxonomy( $loop, ( ! empty( $atts['template_params']['filter_by_taxonomy'] ) ? $atts['template_params']['filter_by_taxonomy'] : 'category' ) );
	$output = apply_filters( 
		sprintf( 
			'tbbs_ShortcodeMasonryFilter_%s_%s', 
			$atts['settings']['_template_name'], 
			$atts['template_params']['layout_filter'] 
			),
		'', 
		$atts, 
		$filterDatas );
	
	return sprintf( '<div class="tbbs-filter-container tbbs-text-%s">%s</div>', $atts['template_params']['filter_align'], $output );
}

/**
 * tbbs_MasonryContentRender
 *
 */
function tbbs_MasonryContentRender( $atts, $loop )
{
	extract( $atts['settings'] );

	$items_Html = tbbs_MasonryLoopItems( $atts, $loop );

	$output = "
	<div 
	class='bs-masonry-container tbbs-masonry-grid' 
	data-bs-masonry='". json_encode( $_opts_masonry ) ."'
	data-bs-atts='". json_encode( $atts ) ."'
	data-bs-ajaxloadmore='{$atts['template_params']['load_more']}'>

		<div class='gutter-sizer'></div>
		<div class='grid-sizer'></div>
		{$items_Html}

	</div>";
	return $output;
}

/**
 * tbbs_MasonryLoopItem
 *
 * @param array $atts
 * @param array $loop
 */
function tbbs_MasonryLoopItems( $atts, $loop ) 
{
	extract( $atts['settings'] );

	$output = '';
	while( $loop->have_posts() ) :
		$loop->the_post();

		/* thumbnail */
		$thumbnail = '#';
		if( has_post_thumbnail() ):
            $thumbnail_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium_large' );
        	$thumbnail = $thumbnail_data[0];
        endif;

        /* title */
        $title = get_the_title();

        /* content */
        $content = wp_trim_words( get_the_content(), 8, '...' );

        /* get category */
		$cats = wp_get_post_terms( get_the_ID(), ( ! empty( $atts['template_params']['filter_by_taxonomy'] ) ? $atts['template_params']['filter_by_taxonomy'] : 'category' ) );
		$cat_filter = array_map( function( $item ) { return $item->slug; }, $cats );
		array_push( $cat_filter, 'all' );

        $data = array(
        	'thumbnail' 	=> $thumbnail,
        	'title' 		=> $title,
        	'content' 		=> $content,
        	'link' 			=> get_the_permalink(),
        	'columns' 		=> $atts['columns'],
        	'cats' 			=> $cats,
        	'cat_filter' 	=> $cat_filter,
        	);

       	$output .= apply_filters( 
			sprintf( 'tbbs_ShortcodeMasonryItem_%s_%s', $atts['settings']['_template_name'], $atts['template_params']['layout_item'] ),
			'', 
			$atts, 
			$data );
	endwhile;
	wp_reset_postdata();

	return $output;
}

/**
 * tbbs_MasonryAjaxLoadmoreItems
 */
function tbbs_MasonryAjaxLoadmoreItems()
{	
	extract( $_POST );

	/* wp_query */
    $loop = tbbs_MasonryQueryPost( $atts['source'], $paged );

	echo tbbs_MasonryLoopItems( $atts, $loop );
	wp_die();
}
add_action( 'wp_ajax_tbbs_MasonryAjaxLoadmoreItems', 'tbbs_MasonryAjaxLoadmoreItems' );
add_action( 'wp_ajax_nopriv_tbbs_MasonryAjaxLoadmoreItems', 'tbbs_MasonryAjaxLoadmoreItems' );


/**************************************************************
Filter Header Layout Default
**************************************************************/
function tbbs_ShortcodeMasonryFilterHeaderLayout_default( $output, $atts, $filterDatas )
{
	$output .= sprintf( '<li class="tbbs-filter-item tbbs-filter-current">
		<a href="#" data-titlefilter=".all">
			<span>%s</span>
		</a>
	</li>', __( 'All', TBBS_NAME ) );
	if( count( $filterDatas ) > 0 ) :
		foreach( $filterDatas as $filterKey => $filterItem ) :
			$output .= sprintf( '<li class="tbbs-filter-item">
					<a href="#" data-titlefilter=\'.%s\'>
						<span>%s</span>
						<sup>%s</sup>
					</a>
				</li>', $filterKey, $filterItem['name'], $filterItem['count'] );
		endforeach;
	endif;
	return "
		<ul class='tbbs-filter-wrap' style='margin: 0 {$atts['padding']}px 20px;'>
			{$output}
		</ul>";
}
add_filter( 'tbbs_ShortcodeMasonryFilter_creative_default', 'tbbs_ShortcodeMasonryFilterHeaderLayout_default', 10, 3 );

/**************************************************************
Filter Header Layout Line Black
**************************************************************/
function tbbs_ShortcodeMasonryFilterHeaderLayout_line_black( $output, $atts, $filterDatas )
{
	$output .= sprintf( '<li class="tbbs-filter-item tbbs-filter-current">
		<a href="#" data-titlefilter=".all">
			<span>%s</span>
		</a>
	</li>', __( 'All', TBBS_NAME ) );
	if( count( $filterDatas ) > 0 ) :
		foreach( $filterDatas as $filterKey => $filterItem ) :
			$output .= sprintf( '<li class="tbbs-filter-item">
					<a href="#" data-titlefilter=\'.%s\'>
						<span>%s</span>
					</a>
				</li>', $filterKey, $filterItem['name'] );
		endforeach;
	endif;
	return "
		<ul class='tbbs-filter-line-black-wrap' style='margin: 0 {$atts['padding']}px;'>
			{$output}
		</ul>";
}
add_filter( 'tbbs_ShortcodeMasonryFilter_creative_line_black', 'tbbs_ShortcodeMasonryFilterHeaderLayout_line_black', 10, 3 );

/**************************************************************
Filter Header Layout Select
**************************************************************/
function tbbs_ShortcodeMasonryFilterHeaderLayout_select( $output, $atts, $filterDatas )
{
	$output = sprintf( '<li class="tbbs-filter-item tbbs-filter-current">
		<a href="#" data-titlefilter=".all" data-title="%s">
			<span>%s</span>
		</a>
	</li>', __( 'All', TBBS_NAME ), __( 'All', TBBS_NAME ) );

	if( count( $filterDatas ) > 0 ) :
		foreach( $filterDatas as $filterKey => $filterItem ) :
			$output .= sprintf( '<li class="tbbs-filter-item">
					<a href="#" data-titlefilter=".%s" data-title="%s">
						<span>%s</span>
						<sup>%s</sup>
					</a>
				</li>', $filterKey, $filterItem['name'], $filterItem['name'], $filterItem['count'] );
		endforeach;
	endif;

	return "
		<div class='tbbs-filter-select-wrap' style='margin: 0 {$atts['padding']}px 20px;'>
		 	<span class='tbbs-filter-value'>
		 		<span>". __( 'All', TBBS_NAME ) ."</span> 
		 		<i class='ion-arrow-down-b'></i>
		 	</span>
			<ul class='tbbs-filter-select-items'>{$output}</ul>
		</div>";
} 
add_filter( 'tbbs_ShortcodeMasonryFilter_creative_select', 'tbbs_ShortcodeMasonryFilterHeaderLayout_select', 10, 3 );

/**************************************************************
Item Layout Default
**************************************************************/
function tbbs_ShortcodeMasonryItemLayout_default( $output, $atts, $data )
{
	extract( $data );

	$taxonomy_name = empty( $atts['template_params']['filter_by_taxonomy'] ) ? 'category' : $atts['template_params']['filter_by_taxonomy'];
	$cats = get_the_term_list( get_the_ID(), $taxonomy_name, '', ' / ' );

	$output .= "
	<div class='tbbs-grid-item grid-item ". implode( ' ', $cat_filter ) ."' data-offset-height='1' data-size='' data-filter='". implode( ',',$cat_filter ) ."'>

		<div class='item-thumbnail'
		style='background: url({$thumbnail}) no-repeat center center / cover, #333;'>
		</div>

		<div class='item-info'>
			<div class='info-inner'>
				<a href='{$link}'><h2 class='title'>{$title}</h2></a>
				<div class='taxonomy'>{$cats}</div>
				<div class='handle'>
					<a href='{$link}' title='". __( 'detail', TBBS_NAME ) ."'><i class='ion-link'></i></a>
					<a href='{$thumbnail}' data-imagelightbox-thumbnail title='". __( 'view thumbnail', TBBS_NAME ) ."'><i class='ion-ios-search-strong'></i></a>
				</div>
			</div>
		</div>

	</div>";

	return $output;
}
add_filter( 'tbbs_ShortcodeMasonryItem_creative_default', 'tbbs_ShortcodeMasonryItemLayout_default', 10, 3 );

/**************************************************************
Item Layout Woocommerce
**************************************************************/
function tbbs_ShortcodeMasonryItemLayout_woocommerce( $output, $atts, $data )
{
	global $product;
	extract( $data );

	$taxonomy_name = empty( $atts['template_params']['filter_by_taxonomy'] ) ? 'category' : $atts['template_params']['filter_by_taxonomy'];
	$cats = get_the_term_list( get_the_ID(), $taxonomy_name, '', ' / ' );
	$price_html = $product->get_price_html();
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
	$quickview = do_shortcode( "[bears_quickview layout='woocommerce' pid={$product->id} icon='ion-ios-search-strong']" );

	$output .= "
	<div class='tbbs-grid-item grid-item ". implode( ' ', $cat_filter ) ." woocommerce-item' data-offset-height='1' data-size='' data-filter='". implode( ',',$cat_filter ) ."'>

		<div class='item-thumbnail'
		style='background: url({$thumbnail}) no-repeat center center / cover, #333;'>
		</div>

		<div class='item-info'>
			<div class='info-inner'>
				<div class='taxonomy'>{$cats}</div>
				<a href='{$link}'><h2 class='title'>{$title}</h2></a>
				<div class='price'>{$price_html}</div>
				<div class='handle'>
					<a href='{$link}' title='". __( 'detail', TBBS_NAME ) ."'><i class='ion-link'></i></a>
					{$add_to_cart_html}
					{$quickview}
					<!-- <a href='{$thumbnail}' data-imagelightbox-thumbnail title='". __( 'view thumbnail', TBBS_NAME ) ."'><i class='ion-ios-search-strong'></i></a> -->
				</div>
			</div>
		</div>

	</div>";

	return $output;
}
add_filter( 'tbbs_ShortcodeMasonryItem_creative_woocommerce', 'tbbs_ShortcodeMasonryItemLayout_woocommerce', 10, 3 );

