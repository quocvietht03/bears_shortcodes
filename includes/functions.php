<?php
/**
 * tbbs_FileScanDirectory
 *
 * @param string $dir
 * @param string $reg
 */
function tbbs_FileScanDirectory( $dir = '' ) 
{
	$files = array();

	if( is_dir( $dir ) && $files = scandir( $dir ) ) $files = array_diff( $files, array( '.', '..' ) );

	return $files;
}

/**
 * tbbs_FilterShortcodeLayout
 *
 */
function tbbs_FilterShortcodeLayout( $dir = '', $reg = '' )
{
	$result_files = array();
	$files = tbbs_FileScanDirectory( $dir );

	if( count( $files ) <= 0 ) return $result_files; 

	foreach( $files as $filename ) :
		if( empty( $reg ) ) :
			$result_files[$filename] = str_replace( '\\', '/', $dir ) . $filename;
		else :
			if( TRUE == preg_match( $reg, $filename ) ) $result_files[$filename] = str_replace( '\\', '/', $dir ) . $filename;
		endif;
	endforeach;

	return $result_files;
}

/**
 * tbbs_GetComments
 *
 * @param string $filename 
 */
function tbbs_GetComments( $filename )
{
	$comments = array();
	$params = array();
	$expr = "/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/";
	
    $file = fopen( $filename, "r" );
    $length = filesize( $filename );
    $comments = fread( $file, $length );
    fclose($file);

    preg_match_all( $expr, $comments, $matches );
    $comments = ( isset( $matches[0] ) && isset( $matches[0][0] ) ) ? $matches[0][0] : '';

	if( empty( $comments ) ) return;

	/* filter string */
	$comments = str_replace( array( '/*', '/**', '*/', '**/', '*' ) , '', $comments );

	/*  */
	$segments = explode( chr(10), $comments );

	/* build params */
	if( count( $segments ) == 0 ) return;
	foreach( $segments as $segment ) {
		$segment = trim( $segment );
		if( ! empty( $segment ) ) { 
			$_arr = explode( ':', $segment, 2 );
			if( count( $_arr ) == 2 )
				$params[strtolower( $_arr[0] )] = ltrim( $_arr[1] );
		}
	}

    return( $params );
}

/**
 * tbbs_LoadTemplate
 * 
 * @param string $shortcode
 * @param array $attr
 * @param string $content
 */
function tbbs_LoadTemplate( $shortcode, $atts, $content = null )
{
	$plg_dir_temp = TBBS_SHORTCODES . $shortcode . '/templates/';
	$theme_dir_temp = get_template_directory() . '/bears-shortcode-templates/';
	
	if ( base64_decode( $atts['template'], true ) ) {
	    // Plg version 1.0.1
		$templateParams = json_decode( base64_decode( $atts['template'] ), true );
	} else {
	    // Plg version 1.0.0
		$templateParams = json_decode( $atts['template'], true );
	}
	
	$atts['template_params'] = $templateParams;
	$atts['content'] = $content;
	
	unset( $atts['template'] );

	/**
	 * Set template path
	 */
	$template_path = ( is_file( $theme_dir_temp . $atts['template_params']['template'] ) ) 
		? $theme_dir_temp . $atts['template_params']['template']
		: $plg_dir_temp . $atts['template_params']['template']; 
	
	/**
	 * Check template path exist
	 */
	if ( is_file( $template_path ) ) :
		ob_start(); include $template_path; return ob_get_clean();
	else :
		return __( 'Template not exist!', TBBS_NAME );
	endif;
}

/**
 * lgRenderFieldTemplate
 *
 * @param array $field
 * @return HTML
 */
function tbbs_RenderFieldTemplate( $field )
{
	extract( $field );
	$output = '';

	switch ( $type ) {
		case 'select':
			$_options = '';
			$_value = isset( $value ) ? $value : '';
			foreach( $options as $o ) :
				$selected = ( $_value == $o['value'] ) ? 'selected' : '';
				$_options .= sprintf( '<option value="%s" %s>%s</option>', $o['value'], $selected, $o['text'] );
			endforeach;

			$output .= sprintf( '
				<div class="tbbs-group-field-param">
					<label class="wpb_element_label">%s</label>
					<select name="%s">
						%s
					</select>
					%s
				</div>', $title, $name, $_options, isset( $description ) ? "<p>{$description}</p>" : '' );
			break;
		
		case 'textarea':
			
			$_rows = isset( $rows ) ? $rows : '';
			$output .= sprintf( '
				<div class="tbbs-group-field-param">
					<label class="wpb_element_label">%s</label>
					<textarea name="%s" rows="%s">%s</textarea>
					%s
				</div>', $title, $name, $_rows, $value, isset( $description ) ? "<p>{$description}</p>" : '' );
			break;
		
		case 'link':
		
			$_text 	= isset( $value[$name]['text'] ) ? $value[$name]['text'] : $value['text'];
			$_url 	= isset( $value[$name]['url'] ) ? $value[$name]['url'] : $value['url'];
			
			$output .= sprintf( '
				<div class="tbbs-group-field-param">
					<label class="wpb_element_label">%s</label>
					<div class="tbbs-group-field-type-link">
						<label><small>Text:</small> <input type="text" name="%s[text]" value="%s"></label>
						<label><small>Url:</small> <input type="text" name="%s[url]" value="%s"></label>
					</div> 
					%s
				</div>', $title, $name, $_text, $name, $_url, isset( $description ) ? "<p>{$description}</p>" : '' );
			break;

		case 'price':

			$_symbols 	= isset( $value[$name]['symbols'] ) ? $value[$name]['symbols'] : $value['symbols'];
			$_price 	= isset( $value[$name]['price'] ) ? $value[$name]['price'] : $value['price'];
			$_position_symbols 	= isset( $value[$name]['position_symbols'] ) ? $value[$name]['position_symbols'] : $value['position_symbols'];
			$description = isset( $description ) ? "<p>{$description}</p>" : '';

			$position_symbols_arr = array( 'left' => __( 'Left', TBBS_NAME ), 'right' => __( 'Right', TBBS_NAME ) );
			$position_symbols_opts = '';
			foreach( $position_symbols_arr as $k => $v ) :
				$selected = ( $k == $_position_symbols ) ? 'selected' : '';
				$position_symbols_opts .= '<option value="'. $k .'" {$selected}>'. $v .'</option>';
			endforeach;

			$output .= '
			<div class="tbbs-group-field-param">
				<label class="wpb_element_label">'. $title .'</label>
				<div class="tbbs-group-field-type-price">
					<label class="tbbs-group-col-3">
						<small>Currency symbols:</small> 
						<input type="text" name="'. $name .'[symbols]" value="'. $_symbols .'"></label>
					<label class="tbbs-group-col-3">
						<small>Price:</small> 
						<input type="text" name="'. $name .'[price]" value="'. $_price .'"></label>
					<label class="tbbs-group-col-3">
						<small>Position symbols:</small> 
						<select name="'. $name .'[position_symbols]">'. $position_symbols_opts .'</select>
					</label>
				</div> 
				'. $description .'
			</div>';
			break;

		case 'media':

			$output .= sprintf( '
				<div class="tbbs-group-field-param">
					<label class="wpb_element_label">%s</label>
					<div class="tbbs-group-field-type-media">
						<input class="tbbs-media-data-field" name="%s" type="text" value="%s" data-multiple="%s" data-typedata="%s"/>
						<a href="#" class="tbbs-field-media-choose" title="Choose image">
							<span class="typcn typcn-camera"></span>
						</a>
					</div>
					%s
				</div>', 
				$title, 
				$name, 
				$value, 
				isset( $multiple ) ? $multiple : false,
				isset( $data ) ? $data : 'url',
				isset( $description ) ? "<p>{$description}</p>" : '' );
			break;
		
		case 'message':

			$output .= sprintf( '<p>%s</p>', $text );
			break;

		case 'group':
			$columns = ( isset( $columns ) && ! empty( $columns ) ) ? $columns : '3';
			$description = isset( $description ) ? "<p>{$description}</p>" : '';
			$addmore_temp = ( isset( $addmore ) && $addmore == true ) 
				? '
					<div>
						<a href="#" class="bs-addmore-fields"><span class="typcn typcn-plus"></span> Add more</a>
						<a href="#" class="bs-del-fields"><span class="typcn typcn-delete"></span> Delete</a>
					</div>' 
				: '';
			$group_item_temp = '<label class="tbbs-group-col-'. $columns .'"><small>%s</small> %s</label>';
			$group_field_content = '';
			$full_content = '';

			if( isset( $value ) & ! empty( $value ) ) : $wrap_html = 'dev1';
				$_count = count( $value[$fields[0]['name']] );
				for( $i = 0; $i <= $_count - 1; $i++ ) :

					$group_field_content = '';

					if( count( $fields ) > 0 ) :
						foreach( $fields as $field_data ) :
							$field_data['value'] = $value[$field_data['name']][$i];
							$field_data['name'] = sprintf( '%s[%s]%s', $name, $field_data['name'], ( isset( $addmore ) && $addmore == true ) ? '[]' : '' );			
							$field_result = tbbs_RenderFieldSingle( $field_data );
							$group_field_content .= sprintf( $group_item_temp, $field_data['title'], $field_result );
						endforeach;

						$full_content .="
						<div class='tbbs-group-field-type-group addmore-{$addmore}'>
							{$group_field_content}
							{$addmore_temp}
						</div>";
					endif; 

				endfor;
			else : 
				if( count( $fields ) > 0 ) :
					
					foreach( $fields as $field_data ) :
						$field_data['name'] = sprintf( '%s[%s]%s', $name, $field_data['name'], ( isset( $addmore ) && $addmore == true ) ? '[]' : '' );
						$field_result = tbbs_RenderFieldSingle( $field_data );
						$group_field_content .= sprintf( $group_item_temp, $field_data['title'], $field_result );
					endforeach;

					$full_content .="
					<div class='tbbs-group-field-type-group addmore-{$addmore}'>
						{$group_field_content}
						{$addmore_temp}
					</div>";
				endif; 
			endif;

			$output .= "
			<div class='tbbs-group-field-param'>
				<label class='wpb_element_label'>{$title}</label>
				{$full_content}
				{$description}
			</div>";
			break;

		default:
			$output .= sprintf( '
				<div class="tbbs-group-field-param">
					<label class="wpb_element_label">%s</label>
					<input name="%s" type="%s" value="%s" />
					%s
				</div>', $title, $name, $type, $value, isset( $description ) ? "<p>{$description}</p>" : '' );
			break;
	}

	return $output;
}

/**
 * tbbs_RenderFieldSingle
 *
 * @param [array] $field_data
 * @return [html] $output
 */
function tbbs_RenderFieldSingle( $field_data = array() )
{
	extract( $field_data );
	$output = '';
	$value = isset( $value ) ? $value : '';

	switch ( $type ) {
		case 'text':
			$output .= "<input type='text' name='{$name}' value='{$value}'/>";
			break;
		
		case 'textarea':
			$rows = isset( $rows ) ? $rows : '4';
			$output .= "<textarea name='{$name}' rows='{$rows}'>{$value}</textarea>";
			break;

		default:
			$output .= "<input type='{$type}' name='{$name}' value='{$value}'/>";
			break;
	}

	return $output;
}

/**
 * tbbs_settings_nav_tabs
 *
 */
function tbbs_settings_nav_tabs()
{
	$tabs = apply_filters( 'tbbs_settings_register_nav_tabs', array(
		// array(
		// 	'slug' => 'general',
		// 	'title' => __( 'General', TBBS_NAME ),
		// 	'layout_path' => TBBS_DIR . 'templates/general-setting.php',
		// 	),
		array(
			'slug' => 'news',
			'title' => __( 'News', TBBS_NAME ),
			'layout_path' => TBBS_DIR . 'templates/news.php',
			),
		array(
			'slug' => 'manager-scripts',
			'title' => __( 'Manager Scripts', TBBS_NAME ),
			'layout_path' => TBBS_DIR . 'templates/manager-scripts-setting.php',
			),
		array(
			'slug' => 'manager-upload',
			'title' => __( 'Manager & Upload Add-ons', TBBS_NAME ),
			'layout_path' => TBBS_DIR . 'templates/manager-upload-setting.php',
			),
		) );

	return $tabs;
}

/**
 * tbbs_register_scripts
 *
 */
function tbbs_register_scripts()
{
	$scripts = apply_filters( 'tbbs_register_scripts', array() );
	// $manager_scripts = get_option('tbbs_manager_scripts');

	// foreach( $scripts as $index => $script ) :
	// 	$inc = isset( $manager_scripts[$script['handle'].'_'.$script['type']] ) 
	// 		? $manager_scripts[$script['handle'].'_'.$script['type']]
	// 		: isset( $script['include'] ) 
	// 			? $script['include'] 
	// 			: 0;

	// 	$scripts[$index]['include'] = $inc;
	// endforeach;

	return $scripts;
}

/**
 * tbbs_group_scripts
 *
 */
function tbbs_group_scripts()
{
	$scripts = tbbs_register_scripts();
	$result = array();

	if( count( $scripts ) <= 0 ) return $result;
	foreach( $scripts as $script ) :

		if( ! isset( $result[$script['group']] ) ) :
			$result[$script['group']]['js'] = array();
			$result[$script['group']]['css'] = array();
		endif;

		$sdata = array(
			'type' => $script['type'],
			'handle' => $script['handle'],
			'src' => $script['src'],
			'deps' => isset( $script['deps'] ) ? $script['deps'] : array(),
			'ver' => isset( $script['ver'] ) ? $script['ver'] : false,
			'include' => $script['include'],
			);

		switch ( $script['type'] ) {
			case 'js': array_push( $result[$script['group']]['js'], $sdata ); break;
			case 'css': array_push( $result[$script['group']]['css'], $sdata ); break;
		}
	endforeach;

	return $result;
}