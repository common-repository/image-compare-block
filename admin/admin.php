<?php
/**
 * Admin Support Page
*/

class ICGB_Admin_Page {
    /**
     * Contructor 
    */
    public function __construct(){
        add_action( 'admin_menu', [ $this, 'icgb_plugin_admin_page' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'icgb_admin_page_assets' ] );

        // include admin data SDk 
        add_action( 'admin_init', [ $this, 'dci_icgb_plugin' ] );
    }

    // Admin Assets
    public function icgb_admin_page_assets($screen) {
        if( 'tools_page_icgb-image-compare' == $screen ) {
            $depencyFile = require_once( trailingslashit( ICGB_PATH ) . 'build/admin/admin.asset.php' );

            if( is_array( $depencyFile ) && !empty( $depencyFile ) ) {
                wp_enqueue_style( 'admin-css', trailingslashit( ICGB_URL ) . '/build/admin/style-admin.css', [], ICGB_VERSION, 'all' );
                wp_enqueue_script( 'admin-js', trailingslashit( ICGB_URL ) . '/build/admin/admin.js', $depencyFile['dependencies'], ICGB_VERSION, true );
            }
        }
    }

    // Include Admin SDK
    public function dci_icgb_plugin(){
        // Include DCI SDK.
        require_once dirname( __FILE__ ) . '/dci/start.php';
        wp_register_style('dci-sdk-beaf_lite', plugins_url('admin/dci/assets/css/dci.css', __FILE__), array(), '1.2.1', 'all');
        wp_enqueue_style('dci-sdk-beaf_lite');

        dci_dynamic_init( array(
            'sdk_version'  => '1.2.1',
            'product_id'   => 7,
            'plugin_name' => 'Beaf Lite', // make simple, must not empty
            'plugin_title' => 'Beaf Slider - Photo Comparison Block', // You can describe your plugin title here
            // 'plugin_icon'  => './assets/admin/imgs/logo.svg', // delete the line of you don't need
            'api_endpoint' => 'https://dashboard.codedivo.com/wp-json/dci/v1/data-insights',
            'slug'         => 'image-compare-block', // write 'no-need' if you don't want to use
            'menu'         => array(
                'slug' => 'icgb-image-compare',
            ),
            'public_key'   => 'pk_x0SQwuIPjqUHvg8y8456XaUf5xyspnBa',
            'is_premium'   => false,
            'popup_notice' => true,
            'deactivate_feedback' => false,
            'text_domain'  => 'image-comparision-block',
            'plugin_msg'   => 'Thanks for using Beaf Slider. We collect some non-sensitive data to improve our product and letting your konw our products update. <a href="https://gutenbergkits.com/privacy-policy/" target="_blank">Privacy Policy</a>',
        ) );
    } 

    // Admin Page
    public function icgb_plugin_admin_page(){
        add_submenu_page( 'tools.php', 'Image Comparison', 'Image Comparison', 'manage_options', 'icgb-image-compare', [ $this, 'icgb_admin_page_content_callback' ] );
    }
    public function icgb_admin_page_content_callback(){
        ?>
            <div id="photo-comparison-admin"></div>
        <?php 
    }
}
 new ICGB_Admin_Page();