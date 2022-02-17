<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/evgeniifeelter
 * @since      1.0.0
 *
 * @package    Feelter_wp
 * @subpackage Feelter_wp/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Feelter_wp
 * @subpackage Feelter_wp/includes
 * @author     Evgenii <evgenii@feelter.com>
 */
require_once plugin_dir_path( __FILE__ ) . 'settings_objects.php';

class Feelter_wp_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	 	
	public static function activate() {
		//WIDGET LOCATION HOOKS:
		$widget_locations_arr = FeelterObjectsClass::create_widget_locations();
		add_option( 'feelter_wp_hooks', $widget_locations_arr );

		//ANCHOR LOCATION HOOKS:
		$anchor_locations_arr = FeelterObjectsClass::create_anchor_locations();
		add_option( 'feelter_wp_anchor_hooks', $anchor_locations_arr);
		
		//Types & templates:
		$types_arr = FeelterWidgetTypeClass::create_types_templates();
		add_option( 'feelter_wp_types', $types_arr );

		//Languages:
		$languages_arr = FeelterObjectsClass::create_languages();
		add_option( 'feelter_wp_languages', $languages_arr );

	}
}