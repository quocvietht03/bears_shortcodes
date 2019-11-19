<?php
/**
 * Layout Name: Bears Document Masonry Grid Resize Builder
 * Author: Bearsthemes
 * Author URI: http://bearsthemes.com
 * Email: bearsthemes@gmail.com
 * Version: 1.0.0
 */
?>
<div class="tbbs-document">
	<div class="tbbs-document-inner">
		<div class="col-md-3">
			<div class="tbbs-group-tabs">
				<h4 class="title"><?php _e( 'Filter Hook', TBBS_NAME ); ?></h4>
				<ol class="tbbs-tabs-content">
					<li class="tbbs-tab-item tbbs-current-tab"><a data-tabid="override-filter-bar" href="#override-filter-bar"><?php _e( 'Override Filter Bar', TBBS_NAME ); ?></a></li>
					<li class="tbbs-tab-item"><a data-tabid="override-content" href="#override-content"><?php _e( 'Override Content', TBBS_NAME ); ?></a></li>
				</ol>
			</div>
		</div>
		<div class="col-md-9">
			<div id="override-filter-bar" class="tbbs-tab-body">
				<h2 class="tbbs-tab-title">Override Layout Filter Bar</h2>
				<p class="tbbs-doc-des">
					Masonry Grid Resize Build support 3 layout filter bar( Default, Line Black & Select ).
				</p>
				<div class="tbbs-doc-des-line">
					<p><strong># {function_name}</strong> Your name function to override layout (Ex: MasonryGridFilterLayout_custom)</p>
					<p>
						<strong># {layout_filter}</strong> Layout filter bar you want override (Ex: default, line-black, select)
						<ul>
							<li>
								<img class="tbbs-doc-image-note" src="<?php echo esc_attr( TBBS_URL . 'shortcodes/bears_doc/assets/images/masonrygrid/layout-filter.png' ); ?>">
							</li>
						</ul>
					</p>
				</div>
				<h4>Code</h4>
<pre>
<code data-language="php">	
/**
 * {function_name}: your name function to override layout
 * {layout_filter}: default, line-black, select
 */
function {function_name}( $output, $atts, $data )
{
  /** 
   * your code handle at here 
   *
   * pirnt_r( $atts );
   * print_r( $data );
   */
	 

  return $output;
}
add_filter( 'tbbs_ShortcodeMasonryFilter_creative_{layout_filter}', '{function_name}', 10, 3 );
</code>
</pre>
				<h4>Video (Coming soon)</h4>
			</div>
			
			<div id="override-content" class="tbbs-tab-body">
				<h2 class="tbbs-tab-title">Override Content</h2>
				<p class="tbbs-doc-des">
					Masonry Grid Resize Build support 2 layout content( Default, Woocommerce ).
				</p>
				<div class="tbbs-doc-des-line">
					<p><strong># {function_name}</strong> Your name function to override layout (Ex: MasonryGridContentLayout_custom)</p>
					<p>
						<strong># {layout_filter}</strong> Layout filter bar you want override (Ex: default, woocommerce)
						<ul>
							<li>
								<img class="tbbs-doc-image-note" src="<?php echo esc_attr( TBBS_URL . 'shortcodes/bears_doc/assets/images/masonrygrid/layout-content.png' ); ?>">
							</li>
						</ul>
					</p>
				</div>
				<h4>Code</h4>
<pre>
<code data-language="php">	
/**
 * {function_name}: your name function to override layout
 * {layout_filter}: default, woocommerce
 */
function {function_name}( $output, $atts, $data )
{
  /** 
   * your code handle at here 
   *
   * pirnt_r( $atts );
   * print_r( $data );
   */
	 

  return $output;
}
add_filter( 'tbbs_ShortcodeMasonryItem_creative_{layout_filter}', '{function_name}', 10, 3 );
</code>
</pre>
				<h4>Video (Coming soon)</h4>
			</div>
		</div>
	</div>
</div>
