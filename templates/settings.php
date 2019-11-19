<?php 
/* define variable */
$tabs = tbbs_settings_nav_tabs();
$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $tabs[0]['slug'];
$content_dir = '';
?>
<div id="tbbs-settings-page" class="wrap">
	<div class="tbbs-content">
		<div class="row">
			<div class="col-md-12">
				<h2 class="tbbs-name-plg"><?php _e( 'Bears Shortcode Settings', TBBS_NAME ); ?></h2>
			</div>
		</div>
	</div>
	
	<div class="tbbs-nav-tabs">
		<nav>
			<?php 
			foreach( $tabs as $tab ) :
				if ( $current_tab == $tab['slug'] ) $content_dir = $tab['layout_path'];

				$url = add_query_arg( array(
				    'page' => 'bears-shortcode-settings',
				    'tab' => $tab['slug'],
				), 'options-general.php' );
				$tab_active = ( $current_tab == $tab['slug'] ) ? 'current-tab' : ''; 
				$title = $tab['title'];
				echo sprintf( '<a href="%s" class="%s">%s</a>', $url, $tab_active, $title );
			endforeach; 
			?>
		</nav>
	</div>

	<div class="tbbs-content">
		<div class="row">
			<?php require $content_dir; ?>
		</div>
	</div>
</div>