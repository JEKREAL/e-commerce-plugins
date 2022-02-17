<?php

/*
Plugin Name: Feelter_WP
Plugin URI: No
Description: The Feelter_WP plugin allows to display Feelter widget on the customers storefront and control it's features.
Version: 1.0
Author: Feelter
Author URI: https://www.feelter.com/
Text Domain: feelter_wp
Domain Path:
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/

You can contact us at support@feelter.com
*/

// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FEELTER_WP_VERSION', '1.0.0' );
require_once( ABSPATH . 'wp-includes/pluggable.php' );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-feelter_wp-activator.php
 */
function activate_feelter_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-feelter_wp-activator.php';
	Feelter_wp_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-feelter_wp-deactivator.php
 */
function deactivate_feelter_wp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-feelter_wp-deactivator.php';
	Feelter_wp_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_feelter_wp' );
register_deactivation_hook( __FILE__, 'deactivate_feelter_wp' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-feelter_wp.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

add_action('plugins_loaded', 'wan_load_textdomain');
function wan_load_textdomain() {
	load_plugin_textdomain( 'feelter_wp', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

function general_admin_notice(){
	global $pagenow;
	if ( $pagenow === 'admin.php' ) {
		 echo '<div class="notice notice-success is-dismissible">
			 <p>Settings saved!</p>
		 </div>';
	}
	}

if(isset($_REQUEST['settings-updated']))
	{
		add_action('admin_notices', 'general_admin_notice');
	} 
	
function display_widget( ) {   

	$template1='template1.php';

	if (validate())
	 {		
		generate($template1);	
	}	
 }


 function display_anchor( ) { 

	$template2='template2.html';

	if (validate())
	 {		
		generate($template2);	
	}	
}
 

 function generate($template) // generating widteg content
 {		
	// echo file_get_contents($template, TRUE);
	ob_start();
	include($template);
	$content = ob_get_clean();
	echo $content;
 }



function validate() // checking toggle
{
	$widget_settings = get_option( 'feelter_wp-settings' );
	$selectedAnchHook = $widget_settings['select_anchor_location'];
	if ( $widget_settings['toggle-content-override'] )
	{
		return true;
	}
	else 
	{
		return false;
	}
}


function registerOurHooks(){   // removing previous selected hook from the page
	$hooks_arr = get_option('feelter_wp_hooks');
	$widget_settings = get_option( 'feelter_wp-settings' );
	$selectedHook = $widget_settings['select_widget_location'];
	$previous_choosen_hook_obj = null;
	$previous_selected_location = $widget_settings['previous_selected_location'];

	if ($previous_selected_location) {
		foreach($hooks_arr as $hook2){
			if ($previous_selected_location===$hook2->name) {
				$previous_choosen_hook_obj=$hook2;
				break;
			}
		}
		remove_action($previous_choosen_hook_obj->name,'display_widget',$previous_choosen_hook_obj->priority);
		$widget_settings['previous_selected_location'] =null;
	}
	$choosen_hook_obj = null;
	
	foreach($hooks_arr as $hook){
		if ($selectedHook===$hook->name) {
			$choosen_hook_obj=$hook;
			break;
		}
	}

	add_action($selectedHook, 'display_widget', $choosen_hook_obj->priority);
	$previous_selected_location= $selectedHook;
	$widget_settings['previous_selected_location'] = $selectedHook;
	update_option('feelter_wp-settings',$widget_settings);
	return;
}

 registerOurHooks();

 function registerAnchorHooks(){    // removing previous selected anchor hook from the page
	$anchor_locations_arr = get_option('feelter_wp_anchor_hooks');
	$widget_settings = get_option( 'feelter_wp-settings' );
	$selectedAnchHook = $widget_settings['select_anchor_location'];
	$previous_choosen_anch_hook_obj = null;
	$previous_selected_anch_location = $widget_settings['previous_selected_anch_location'];

	if ($previous_selected_anch_location) {
		foreach($anchor_locations_arr as $anch_hook2){
			if ($previous_selected_anch_location===$anch_hook2->name) {
				$previous_choosen_anch_hook_obj=$anch_hook2;
				break;
			}
		}
		remove_action($previous_choosen_anch_hook_obj->name,'display_anchor',$previous_choosen_anch_hook_obj->priority);
		$widget_settings['previous_selected_anch_location'] =null;
	}
	$choosen_hook_anch_obj = null;
	
	foreach($anchor_locations_arr as $anch_hook){
		if ($selectedAnchHook===$anch_hook->name) {
			$choosen_hook_anch_obj=$anch_hook;
			break;
		}
	}

	add_action($selectedAnchHook, 'display_anchor', $choosen_hook_anch_obj->priority);
	$previous_selected_anch_location= $selectedAnchHook;
	$widget_settings['previous_selected_location'] = $selectedAnchHook;
	update_option('feelter_wp-settings',$widget_settings);
	return;
}

 registerAnchorHooks();

 function pixelScript() {     //adding URL to the head of the page
	
    if (!is_singular('post')){
	  ?>
		  <script type="text/javascript" id="pixelScript">
				let pixelFilter = new Image();
				pixelFilter.src = "http://localhost:8080/1.png?r="+btoa(window.location.href);
				let newPix = pixelFilter.src;
		  </script>
	  <?php
 }
  }
  add_action('wp_head', 'pixelScript',2);

 /*
	  CSS functions. 
	*/
function settings_css() {
		wp_enqueue_style( 'feelter_wp',plugin_dir_url( __FILE__ ) . 'css/feelter_wp-admin.css' );
}


global $pagenow;
if (( $pagenow === 'admin.php' ) && ($_GET['page'] === 'feelter_wp')) {
	add_action('admin_head', 'settings_css');
}
/*
	  CSS functions. 
*/

function feelter_wp_sync() {		
		if ($_POST['prevToggleStatus'])
		{		
			update_option("prev_toggle_status",$_POST['prevToggleStatus']);
		}				
	}
	feelter_wp_sync();

	
function feelter_wp_set() {
		$ret=array();
		$vnonce=false;
		$widget_settings = get_option( 'feelter_wp-settings' );	
		if(!wp_verify_nonce( $_POST['n'], 'feelter_wp_nonce' )) return;	
		$verified=false;
		if (isset($_POST['apiKey'])) {
			$value = sanitize_text_field($_POST['apiKey']);
			$value = preg_replace("/[ ;]/", '', $value); // for now we take the space and coma out...
			delete_option("Feelter_wp_api_key");
			if (!empty($value)) {
				$option=get_option("Feelter_wp_api_key");
				if (empty($option)) {
					add_option( "Feelter_wp_api_key", $value);
				} else {
					update_option( "Feelter_wp_api_key", $value );
				}
				$target_url= 'https://self-service.feelter.com/api/public/validate-api-key?key=' . $value;				
				$request = wp_remote_get($target_url, array('timeout' => 10, 'redirection'=> 0, 'sslverify' => false ));
				$cid = json_decode(wp_remote_retrieve_body($request))->cid; 
					if ($cid != 2000 || is_wp_error($request) ) {
					$ret['connection']="nop";
					$widget_settings['toggle-content-override'] = false;
					$ret['toggle_override']=false;			
				} else {					 
					$ret['connection']="ya";	
						$prev_bool = (get_option("prev_toggle_status") === 'true');
						if ($prev_bool===true){
							$widget_settings['toggle-content-override'] = $prev_bool;
							$ret['toggle_override']=$prev_bool;
						}				
				}					
			} else {
				$ret['connection']="nop";
				$widget_settings['toggle-content-override'] = false;
				$ret['toggle_override']=false;
			}		  
			update_option( "feelter_wp-settings", $widget_settings );	
		}
		echo json_encode($ret);
		exit;	
	}

	feelter_wp_set(); 
	add_action('wp_ajax_feelter_wp_set', 'feelter_wp_set');
	add_action( 'wp_ajax_nopriv_feelter_wp_set', 'feelter_wp_set');	
	
function feelter_wp_settings_link( $links ) {
		$url = esc_url( add_query_arg(
			'page',
			'feelter_wp',
			get_admin_url() . 'admin.php'
		) );
		$url1 = esc_url( 			
			get_admin_url() . 'themes.php'
		);	
		$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
		$support_link = "<a href='$url1'>" . __( 'Settings' ) . '</a>';

		array_unshift(
			$links,
			$settings_link
		);
		return $links;
	}
	add_filter( 'plugin_action_links_feelter_wp/feelter_wp.php', 'feelter_wp_settings_link' );

function run_feelter_wp() {
	$plugin = new Feelter_wp();
	$plugin->run();
}

run_feelter_wp();
