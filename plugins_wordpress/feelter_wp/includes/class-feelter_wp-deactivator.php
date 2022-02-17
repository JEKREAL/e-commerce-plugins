<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://github.com/evgeniifeelter
 * @since      1.0.0
 *
 * @package    Feelter_wp
 * @subpackage Feelter_wp/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Feelter_wp
 * @subpackage Feelter_wp/includes
 * @author     Evgenii <evgenii@feelter.com>
 */
class Feelter_wp_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option('feelter_wp_hooks');
		delete_option('feelter_wp_types');
		delete_option('feelter_wp_anchor_hooks');
		}

}
