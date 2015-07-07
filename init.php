<?php
/**
 * Plugin Name: YITH WooCommerce Category Accordion
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-category-accordion/
 * Description: YITH WooCommerce Category Accordion allows you to add accordion menu in your pages.
 * Version: 1.0.1
 * Author: YIThemes
 * Author URI: http://yithemes.com/
 * Text Domain: ywcca
 * Domain Path: /languages/
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Category Accordion
 * @version 1.0.1
 */

/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( !defined( 'ABSPATH' ) ){

    exit;
}

if( !function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if( !function_exists( 'WC' ) ){

    function yith_ywcca_free_install_woocommerce_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'YITH WooCommerce Category Accordion  is enabled but not effective. It requires WooCommerce in order to work.', 'ywcca' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_ywcca_free_install_woocommerce_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}

if ( defined( 'YWCCA_PREMIUM' ) ) {
    function yith_ywcca_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Category Accordion while you are using the premium one.', 'ywcca' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_ywcca_install_free_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}

if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( !defined( 'YWCCA_VERSION' ) ) {
    define( 'YWCCA_VERSION', '1.0.1' );
}

if ( !defined( 'YWCCA_FREE_INIT' ) ) {
    define( 'YWCCA_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( !defined( 'YWCCA_FILE' ) ) {
    define( 'YWCCA_FILE', __FILE__ );
}

if ( !defined( 'YWCCA_DIR' ) ) {
    define( 'YWCCA_DIR', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'YWCCA_URL' ) ) {
    define( 'YWCCA_URL', plugins_url( '/', __FILE__ ) );
}

if ( !defined( 'YWCCA_ASSETS_URL' ) ) {
    define( 'YWCCA_ASSETS_URL', YWCCA_URL . 'assets/' );
}

if ( !defined( 'YWCCA_TEMPLATE_PATH' ) ) {
    define( 'YWCCA_TEMPLATE_PATH', YWCCA_DIR . 'templates/' );
}

if ( !defined( 'YWCCA_INC' ) ) {
    define( 'YWCCA_INC', YWCCA_DIR . 'includes/' );
}

if( !defined('YWCCA_SLUG' ) ){
    define( 'YWCCA_SLUG', 'yith-woocommerce-category-accordion' );
}

load_plugin_textdomain( 'ywcca', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

if( !function_exists( 'YITH_Category_Accordion' ) ){
    require_once( YWCCA_INC .'class.yith-category-accordion-widget.php' );
    require_once( YWCCA_INC .'class.yith-woocommerce-category-accordion.php' );

    if( defined( 'YWCCA_PREMIUM' ) && file_exists( YWCCA_INC . 'class.yith-woocommerce-category-accordion-premium.php' ) ){
        require_once( YWCCA_INC .'class.yith-category-accordion-shortcode.php');
        require_once( YWCCA_INC . 'class.yith-woocommerce-category-accordion-premium.php'  );
        return YITH_WC_Category_Accordion_Premium::get_instance();
    }

    return YITH_WC_Category_Accordion::get_instance();
}


YITH_Category_Accordion();