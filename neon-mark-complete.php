<?php
/**
 * Plugin Name:     Neon Mark Complete
 * Plugin URI:      https://neonsuite.com
 * Description:     It allows readers or students to mark complete once they have completed a lesson or course
 * Author:          Atomic House
 * Author URI:      https:/atomichouse.com
 * Text Domain:     neon-mark-complete
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Neon_Mark_Complete
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

define( 'NEON_MARK_COMPLETE_VERSION', '1.0.0' );

function activate_neon_mark_complete() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-neon-mark-complete-activator.php';
    Neon_Mark_Complete_Activator::activate();
}

function deactivate_neon_mark_complete() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-neon-mark-complete-deactivator.php';
    Neon_Mark_Complete_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_neon_mark_complete' );
register_deactivation_hook( __FILE__, 'deactivate_neon_mark_complete' );

require plugin_dir_path( __FILE__ ) . 'includes/class-neon-mark-complete.php';

/*function run_neon_mark_complete() {
    $plugin = new Neon_Mark_Complete();
    $plugin->run();
}
run_neon_mark_complete();*/

require plugin_dir_path( __FILE__ ) . 'includes/class-neon-mark-complete-settings.php';

function run_neon_mark_complete() {
    $plugin = new Neon_Mark_Complete();
    $plugin->run();
    $settings = new Neon_Mark_Complete_Settings();
    $settings->register_settings();
}
run_neon_mark_complete();

// Include frontend display
// require_once plugin_dir_path(__FILE__) . 'includes/frontend-display.php';