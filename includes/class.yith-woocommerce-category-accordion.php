<?php
if( !defined( 'ABSPATH' ) ){
    exit;
}

if( ! class_exists( 'YITH_WC_Category_Accordion' ) ){

    class YITH_WC_Category_Accordion{

        protected static $_instance  =   null;
        protected $_panel   =   null;
        protected $_panel_page    =   'yith_wc_category_accordion';
        protected $_official_documentation='https://yithemes.com/docs-plugins/yith-woocommerce-category-accordion';
        protected $_premium_landing_url = 'https://yithemes.com/themes/plugins/yith-woocommerce-category-accordion';
        protected $_premium =   'premium.php';


        public function __construct(){
            // Load Plugin Framework
            add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );
            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YWCCA_DIR . '/' . basename( YWCCA_FILE ) ), array( $this, 'action_links' ) );
            //Add row meta
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );
            //Add menu field under YITH_PLUGIN
            add_action( 'yith_wc_category_accordion_premium', array( $this, 'premium_tab' ) );
            add_action( 'admin_menu', array( $this, 'add_category_accordion_menu' ),5 );

            //register widget
            add_action( 'widgets_init', array( $this, 'register_accordion_widget' ) );
            //enqueue style
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style_script' ) );
        }

    /* Returns single instance of the class
    *
    * @return \YITH_WC_Category_Accordion
    * @since 1.0.0
    */
        public static  function get_instance(){
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }


        public function plugin_fw_loader(){
            if ( ! defined( 'YIT' ) || ! defined( 'YIT_CORE_PLUGIN' ) ) {
                require_once( YWCCA_DIR .'plugin-fw/yit-plugin.php' );
            }
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'ywcca' ) . '</a>';

            if ( defined( 'YWCCA_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'ywcca' ) . '</a>';
            }

            return $links;
        }
        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
            if ( ( defined( 'YWCCA_INIT' ) && ( YWCCA_INIT == $plugin_file ) ) ||
                ( defined( 'YWCCA_FREE_INIT' ) && ( YWCCA_FREE_INIT == $plugin_file ) )
            ) {

               $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __( 'Plugin Documentation', 'ywcca' ) . '</a>';
            }

            return $plugin_meta;
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri(){
            return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing_url . '?refer_id=1030585';
        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  void
         */
        public function premium_tab() {
            $premium_tab_template = YWCCA_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if ( file_exists( $premium_tab_template ) ) {
                include_once( $premium_tab_template );
            }
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function add_category_accordion_menu() {
            if ( ! empty( $this->_panel ) ) {
                return;
            }


            if( !defined( 'YWCCA_PREMIUM' ) )
                $admin_tabs['premium-landing'] = __( 'Premium Version', 'ywcca' );

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Category Accordion', 'ywcca' ),
                'menu_title'       => __( 'Category Accordion', 'ywcca' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YWCCA_DIR . '/plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        public function register_accordion_widget()
        {
            register_widget('YITH_Category_Accordion_Widget');
        }

        public function enqueue_style_script(){

            wp_register_style( 'ywcca_accordion_style', YWCCA_ASSETS_URL .'css/ywcca_style.css' );
            wp_enqueue_style( 'ywcca_accordion_style' );

            wp_register_script( 'ywcca_accordion', YWCCA_ASSETS_URL .'js/ywcca_accordion.js', array('jquery'), '1.0.0', true );
            wp_enqueue_script( 'ywcca_accordion' );

            $ywcca_params   =   apply_filters( 'ywcca_script_params', array(
                        'highlight_current_cat' =>  get_option( 'ywcca_highlight_category' )=='yes'
                    )   );

            wp_localize_script( 'ywcca_accordion', 'ywcca_params', $ywcca_params );

        }

    }
}