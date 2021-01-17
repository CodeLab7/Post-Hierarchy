<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Post Hierarchy
 * Plugin URI:        #
 * Description:       Set Post as a sub-post of other posts Like a Page
 * Version:           1.0.0
 * Author:            Codelab7
 * Author URI:        https://codelab7.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       post-hierarchy
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
define('POSTHIERARCHY_VERSION', '1.0.0');
function activate_posthierarchy() {
    require_once plugin_dir_path(__FILE__) . 'includes/Posthierarchy_Activator.php';
    Posthierarchy_Activator::activate();
}

function deactivate_posthierarchy() {
    require_once plugin_dir_path(__FILE__) . 'includes/Posthierarchy_Deactivator.php';
    Posthierarchy_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_posthierarchy');
register_deactivation_hook(__FILE__, 'deactivate_posthierarchy');

require plugin_dir_path(__FILE__) . 'includes/Posthierarchy.php';
function run_posthierarchy() {
    $plugin = new Posthierarchy();
    $plugin->run();
}

run_posthierarchy();