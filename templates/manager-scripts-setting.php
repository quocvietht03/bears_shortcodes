<?php 
/* define variable */
$scripts = tbbs_group_scripts();

/**
 * tbbs_render_field_script function
 *
 */
if( ! function_exists( 'tbbs_render_field_script' ) ) :
	function tbbs_render_field_script( $scripts )
	{
		$output = '';
		if( count( $scripts ) <= 0 ) return;

		$output .= sprintf( '<h5 class="tbbs-title-small">%s</h5>', $scripts[0]['type'] );

		foreach( $scripts as $script ) :
			$checked = ( $script['include'] == 1 ) ? 'checked' : '';
			$output .= "
			<div class='tbbs-script-item'>
				<label>
					<input type='hidden' name='tbbs_manager_scripts[{$script['handle']}_{$script['type']}]' value='0'>
					<input type='checkbox' name='tbbs_manager_scripts[{$script['handle']}_{$script['type']}]' value='1' {$checked}>
					<span title='uri: {$script['src']}'>[{$script['handle']}] {$script['src']}</span>
				</label>
			</div>";
		endforeach;

		return sprintf( '<div class="tbbs-script-items">%s</div>', $output );
	}
endif;
?>
<form action="options.php" method="POST" class="tbbs-form">
	<?php settings_fields( 'tbbs-plugin-settings-group-manager-scripts' ); ?>
	<?php do_settings_sections( 'tbbs-plugin-settings-group-manager-scripts' ); ?>
	<div class="col-md-12 tbbs-content-<?php echo esc_attr( $current_tab ); ?>">
		<!-- <pre><?php //print_r( $scripts ); ?></pre>
		<pre><?php //print_r( get_option('manager_scripts') ); ?></pre> -->
		<p><i><?php _e( '* Manager include lib scripts(js, css).', TBBS_NAME ); ?></i></p>
		<?php 
		if( count( $scripts ) > 0 ) :
			foreach( $scripts as $sname => $script ) :
				$script_html = tbbs_render_field_script( $script['js'] );
				$style_html 	= tbbs_render_field_script( $script['css'] );
				echo "
				<div class='tbbs-block-scripts'>
					<h4 class='tbbs-title'>{$sname}</h4>
					{$script_html}
					{$style_html}
				</div>";
			endforeach;
		endif;
		?>
	</div>
	<div class="col-md-12 tbbs-submit-btn-content">
		<?php submit_button(); ?>
	</div>
</form>