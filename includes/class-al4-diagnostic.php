<?php
/**
 * کلاس اصلی پلاگین عیب‌یابی AL4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AL4_Diagnostic {

    public function run() {
        add_shortcode( 'al4_diagnostic', array( $this, 'render_form' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_action( 'wp_ajax_al4_diagnose', array( $this, 'ajax_diagnose' ) );
        add_action( 'wp_ajax_nopriv_al4_diagnose', array( $this, 'ajax_diagnose' ) );
    }

    public function enqueue_assets() {
        global $post;
        if ( ! is_a( $post, 'WP_Post' ) || ! has_shortcode( $post->post_content, 'al4_diagnostic' ) ) {
            return;
        }

        wp_enqueue_style(
            'al4-diagnostic-css',
            AL4_DIAG_URL . 'assets/css/style.css',
            array(),
            AL4_DIAG_VERSION
        );

        wp_enqueue_script(
            'al4-diagnostic-js',
            AL4_DIAG_URL . 'assets/js/script.js',
            array(),
            AL4_DIAG_VERSION,
            true
        );

        wp_localize_script( 'al4-diagnostic-js', 'al4_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'al4_diagnose_nonce' ),
        ) );
    }

    public function render_form( $atts = array() ) {
        ob_start();
        include AL4_DIAG_PATH . 'includes/form-template.php';
        return ob_get_clean();
    }

    public function ajax_diagnose() {
        check_ajax_referer( 'al4_diagnose_nonce', 'nonce' );

        $data = array(
            'model'         => isset( $_POST['model'] ) ? sanitize_text_field( wp_unslash( $_POST['model'] ) ) : '',
            'prechecks'     => isset( $_POST['prechecks'] ) ? array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['prechecks'] ) ) : array(),
            'codes'         => isset( $_POST['codes'] ) ? array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['codes'] ) ) : array(),
            'symptoms'      => isset( $_POST['symptoms'] ) ? array_map( 'sanitize_text_field', (array) wp_unslash( $_POST['symptoms'] ) ) : array(),
            'oil_temp'      => isset( $_POST['oil_temp'] ) ? sanitize_text_field( wp_unslash( $_POST['oil_temp'] ) ) : '',
            'battery'       => isset( $_POST['battery'] ) ? sanitize_text_field( wp_unslash( $_POST['battery'] ) ) : '',
            'res_evm'       => isset( $_POST['res_evm'] ) ? sanitize_text_field( wp_unslash( $_POST['res_evm'] ) ) : '',
            'res_evlu'      => isset( $_POST['res_evlu'] ) ? sanitize_text_field( wp_unslash( $_POST['res_evlu'] ) ) : '',
            'res_evs'       => isset( $_POST['res_evs'] ) ? sanitize_text_field( wp_unslash( $_POST['res_evs'] ) ) : '',
            'res_flow'      => isset( $_POST['res_flow'] ) ? sanitize_text_field( wp_unslash( $_POST['res_flow'] ) ) : '',
            'press_compare' => isset( $_POST['press_compare'] ) ? sanitize_text_field( wp_unslash( $_POST['press_compare'] ) ) : '',
            'press_stable'  => isset( $_POST['press_stable'] ) ? sanitize_text_field( wp_unslash( $_POST['press_stable'] ) ) : '',
            'stall'         => isset( $_POST['stall'] ) ? sanitize_text_field( wp_unslash( $_POST['stall'] ) ) : '',
        );

        $logic  = new AL4_Logic();
        $result = $logic->diagnose( $data );

        wp_send_json_success( $result );
    }
}
