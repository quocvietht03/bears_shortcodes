<?php
/**
* Plugin Name: Bears Shortcodes
* Plugin URI: http://bearsthemes.com
* Description: This plugin is addon visual composer, which is developed by BEARSTHEMES Team for Visual Comporser plugin.
* Version: 1.0.1
* Author: BEARS Themes
* Author URI: http://bearsthemes.com
* Copyright 2015 bearsthemes.com. All rights reserved.
*/

define( 'TBBS_NAME', 'bearsthemes' );
define( 'TBBS_DIR', plugin_dir_path(__FILE__) );
define( 'TBBS_URL', plugin_dir_url(__FILE__) );
define( 'TBBS_INCLUDES', TBBS_DIR . "includes/" );
define( 'TBBS_SHORTCODES', TBBS_DIR . "shortcodes/" );

define( 'TBBS_CSS', TBBS_URL . "assets/css/" );
define( 'TBBS_JS', TBBS_URL . "assets/js/" );
define( 'TBBS_IMAGES', TBBS_URL . "assets/images/" );

/**
 * Require functions on plugin
 */
require_once TBBS_INCLUDES . 'functions.php';

/**
 * Use bears_shortcodes class
 */
new bears_shortcodes;

/**
 * bears_shortcodes Class
 * 
 */

class bears_shortcodes
{
	function __construct()
	{
		/* init hook */
		add_action( 'init', array( $this, 'init_hook' ) );

		/* Visual Composer action */
		add_action( 'vc_before_init', array( $this, 'shortcode' ) );
	}

	/**
	 * init_hook
	 *
	 */
	function init_hook()
	{
		add_action( 'admin_menu', array( $this, 'add_page_settings' ) );
		add_action( 'admin_init', array( $this, 'include_scripts_admin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'include_scripts' ) );
	}

	function include_scripts_admin()
	{
		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'tbbs-script-admin', TBBS_JS . 'jquery.bears-shortcodes.admin.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'tbbs-script-admin', TBBS_CSS . 'bears-shortcodes.admin.css', array(), '1.0' );
	}

	/**
	 * include_scripts
	 *
	 */
	function include_scripts()
	{
		wp_enqueue_script( 'jquery' );
		
		/**
		 * Lib JS Dynamics
		 */
		wp_register_script( 'dynamics', TBBS_JS . 'dynamics.min.js', array(), '1.0', true );
		
		/**
		 * Extra scripts
		 */
		$scripts = tbbs_register_scripts();
		if( count( $scripts ) <= 0 ) return;

		foreach( $scripts as $script ) : 
			if( $script['include'] != 1 ) continue;

			switch ( $script['type'] ) {
				case 'js': 
					wp_enqueue_script( 
						$script['handle'], 
						$script['src'], 
						isset( $script['deps'] ) ? $script['deps'] : array(), 
						isset( $script['ver'] ) ? $script['ver'] : '1.0', 
						true ); 

						if( isset( $script['localize_script'] ) ) :
							wp_localize_script( 
								$script['handle'], 
								$script['localize_script']['obj_name'], 
								$script['localize_script']['obj_data'] );
						endif;
					break;

				case 'css': 
					wp_enqueue_style( 
						$script['handle'], 
						$script['src'], 
						isset( $script['deps'] ) ? $script['deps'] : array(), 
						isset( $script['ver'] ) ? $script['ver'] : '1.0' ); 
					break;
			}
		endforeach;

		/**
		 * Lib JS Tbbs Plugin
		 */
		wp_enqueue_script( 'tbbs-script', TBBS_JS . 'jquery.bears-shortcodes.js', array( 'jquery', 'dynamics' ), '1.0', true );
		wp_localize_script( 'tbbs-script', 'bsObj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_style( 'tbbs-script', TBBS_CSS . 'bears-shortcodes.css', array(), '1.0' );
	}

	/**
	 * shortcodes
	 *
	 */
	function shortcode()
	{
		require TBBS_INCLUDES . 'shortcode.php';
	}

	/**
	 * add_page_settings
	 *
	 */
	function add_page_settings()
	{ 
		$page_title		= __( 'Bears Shortcode', TBBS_NAME ); 
		$menu_title		= __( 'Bears Shortcode', TBBS_NAME );
		$capability		= 'manage_options'; 
		$menu_slug		= 'bears-shortcode-settings'; 
		$function 		= array( $this, 'add_page_settings_function' );

		add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function );
		add_action( 'admin_init', array( $this, 'register_tbbs_settings' ) );
	}

	function register_tbbs_settings()
	{
		register_setting( 'tbbs-plugin-settings-group-general', 'tbbs_general' );
		register_setting( 'tbbs-plugin-settings-group-manager-scripts', 'tbbs_manager_scripts' );
		register_setting( 'tbbs-plugin-settings-group-manager-upload-addon', 'tbbs_manager_upload_addon' );
	}

	/**
	 * add_page_settings_callback
	 *
	 */
	function add_page_settings_function()
	{
		wp_enqueue_style( 'grid-bootstrap3', TBBS_CSS . 'grid.bootstrap.css', array(), '1.0' );

		ob_start();
		require TBBS_DIR . 'templates/settings.php';
		echo ob_get_clean();
	}
}

/* do shortcode widget */
add_filter('widget_text', 'do_shortcode');