<?php
/**
 * tbbs_ShortcodeSupperTemplate
 *
 * @param array $settings
 * @param string $value
 */
function tbbs_ShortcodeSupperTemplate( $settings, $value ) 
{	
	$shortcode = $settings['shortcode'];
	$plg_dir_temp = TBBS_SHORTCODES . $shortcode . '/templates/';
	$theme_dir_temp = get_template_directory() . '/bears-shortcode-templates/';
	$reg = "/^({$shortcode}\.php|{$shortcode}--.*\.php)/";
	
	if ( base64_decode( $value, true ) ) {
	    // Plg version 1.0.1
		$valueArr = json_decode( base64_decode( $value ), true );
	} else {
	    // Plg version 1.0.0
		$valueArr = json_decode( $value, true );
	}
	
	$setting_name = $settings['param_name'];

	$files = tbbs_FilterShortcodeLayout( $plg_dir_temp, '' );
	$files = array_merge( $files, tbbs_FilterShortcodeLayout( $theme_dir_temp, $reg ) );
	
	$output = '';
	$output .= "<select data-loadparambytemplate name=\"" . esc_attr( $setting_name ) . "\">";
    foreach ( $files as $name_file => $dir_file ) :
    	$params = tbbs_GetComments( $dir_file );
    	$field_HTML = isset( $params['param'] ) ? tbbs_FieldTemplate( $params['param'], $valueArr ) : '';
    	$selected = ( isset( $valueArr["{$setting_name}"] ) && $name_file == $valueArr["{$setting_name}"] ) ? 'selected' : '';

        $output .= sprintf( '<option data-fieldhtml=\'%s\' value="%s" %s>%s</option>', 
        	base64_encode( $field_HTML ), 
        	$name_file, 
        	$selected, 
        	isset( $params['layout name'] ) ? $params['layout name'] . " ({$name_file})" : $name_file );
    endforeach;
    $output .= "</select>";
    $output .= sprintf( '<div class="tbbs-params-container"></div>' );

    return sprintf( '
    	<div class="tbbs-shortcode-supper-template">
    		<textarea class="tbbs-hidden wpb_vc_param_value" name="%s" data-jsoncontent>%s</textarea>
    		<div class="tbbs-template-group-field">
				%s
    		</div>
    	</div>', esc_attr( $settings['param_name'] ), $value, $output );
}
vc_add_shortcode_param('btbs_supper_template', 'tbbs_ShortcodeSupperTemplate');

/**
 * tbbs_FieldTemplate
 * 
 * @param String $func_name
 */
function tbbs_FieldTemplate( $func_name, $value = array() )
{
	if( ! function_exists( $func_name ) )
		return;

	$output = '';
	$fields = call_user_func( $func_name );
	if( ! empty( $fields ) && is_array( $fields ) ) :
		foreach( $fields as $field ) :
			/* Set value */
			if( isset( $value[$field['name']] ) )
				$field['value'] = $value[$field['name']];
			
			$output .= tbbs_RenderFieldTemplate( $field );
		endforeach;
	endif;

	return sprintf( '
		<div class="tbbs-params-container-inner">
			%s
		</div>', 
		! empty( $output ) ? $output : __( 'Empty...!' ) );
}