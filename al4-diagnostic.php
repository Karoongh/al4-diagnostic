<?php
/**
 * Plugin Name: عیب‌یابی گیربکس AL4 / DP0
 * Plugin URI:  https://github.com/Karoongh/al4-diagnostic
 * Description: پلاگین تخصصی عیب‌یابی شیرهای برقی و فشار روغن گیربکس AL4/DP0. کد خطا، علائم و مقادیر اندازه‌گیری را وارد کنید تا تشخیص هوشمند دریافت کنید.
 * Version:     2.0.0
 * Author:      Karoongh
 * Author URI:  https://github.com/Karoongh
 * Text Domain: al4-diagnostic
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License:     GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'AL4_DIAG_VERSION', '2.0.0' );
define( 'AL4_DIAG_PATH', plugin_dir_path( __FILE__ ) );
define( 'AL4_DIAG_URL', plugin_dir_url( __FILE__ ) );

require_once AL4_DIAG_PATH . 'includes/class-al4-diagnostic.php';
require_once AL4_DIAG_PATH . 'includes/class-al4-logic.php';

function al4_diagnostic_init() {
    $plugin = new AL4_Diagnostic();
    $plugin->run();
}
add_action( 'plugins_loaded', 'al4_diagnostic_init' );

register_activation_hook( __FILE__, function () {
    flush_rewrite_rules();
} );

register_deactivation_hook( __FILE__, function () {
    flush_rewrite_rules();
} );
