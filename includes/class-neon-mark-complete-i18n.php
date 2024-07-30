<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://atomichouse.com
 * @since      1.0.0
 *
 * @package    Neon_Mark_Complete
 * @subpackage Neon_Mark_Complete/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Neon_Mark_Complete
 * @subpackage Neon_Mark_Complete/includes
 * @author     Atomic House <info@atomichouse.com>
 */
class Neon_Mark_Complete_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'neon-mark-complete',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
