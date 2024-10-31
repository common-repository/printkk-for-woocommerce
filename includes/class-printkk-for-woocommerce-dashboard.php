<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class PrintKK_Dashboard {
    const API_KEY_SEARCH_STRING = 'PrintKK';
    public static $_instance;
    /**
     * Instance.
     *
     * @return PrintKK_Dashboard
     */
    public static function instance() {

        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * PrintKK_Dashboard constructor.
     */
    public function __construct() {
    }

    public function view() {
        $dashboard = self::instance();
        $consumer_key = $dashboard->_get_consumer_key();
        if (!empty($consumer_key)) {
            $consumer_secret = $dashboard->_get_consumer_secret();
            $params['apiKey'] = $consumer_key;
            $params['apiSecret'] = $consumer_secret;
            // get Dashboard data
            $request = PrintKK_For_Woocommerce::make_http_request("/pkk-ecommerce/order/get-info-with-woocommerce-plugin",
                $params, "GET"
            );
            $resData = json_decode($request['body'], true);
            if (isset($resData['success']) && $resData['success']) {
                PrintKK_For_Woocommerce::load_template("dashboard", array(
                    "resData" => $resData['data']
                ));
            } else {
                PrintKK_For_Woocommerce::load_template("connect", array(
                    "text" => "Connect to PrintKK",
                    "connectUrl" => "https://dashboard.printkk.com/stores/settings"
                ));
            }

        } else {
            PrintKK_For_Woocommerce::load_template("connect", array(
                "text" => "Connect to PrintKK",
                "connectUrl" => "https://dashboard.printkk.com/stores/settings"
            ));
        }
    }

    public function get_connect_url() {
        $consumer_key = $this->_get_consumer_key();
        return PRINTKK_HOST . 'login?website=' . urlencode( trailingslashit( get_home_url() ) ) . '&key=' . urlencode( $consumer_key ) . '&returnUrl=' . urlencode( get_admin_url( null, 'admin.php?page=' . PrintKK_For_WooCommerce::MENU_SLUG_DASHBOARD ) );
    }
    /**
     * Get the last used consumer key fragment
     *
     * @return null|string
     */
    private function _get_consumer_key() {

        global $wpdb;

        // Get the API key
        $printfulKey = '%' . esc_sql( $wpdb->esc_like( wc_clean( self::API_KEY_SEARCH_STRING ) ) ) . '%';
        $consumer_key = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT truncated_key FROM {$wpdb->prefix}woocommerce_api_keys WHERE description LIKE %s ORDER BY key_id DESC LIMIT 1",
                $printfulKey
            )
        );

        //if not found by description, it was probably manually created. try the last used key instead
        if ( ! $consumer_key ) {
            $consumer_key = $wpdb->get_var(
                "SELECT truncated_key FROM {$wpdb->prefix}woocommerce_api_keys ORDER BY key_id DESC LIMIT 1"
            );
        }
        return $consumer_key;
    }

    /**
     * Get the last used consumer secret
     * @return null|string
     */
    private function _get_consumer_secret() {

        global $wpdb;

        // Get the API key
        $printfulKey = '%' . esc_sql( $wpdb->esc_like( wc_clean( self::API_KEY_SEARCH_STRING ) ) ) . '%';
        $consumer_secret = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT consumer_secret FROM {$wpdb->prefix}woocommerce_api_keys WHERE description LIKE %s ORDER BY key_id DESC LIMIT 1",
                $printfulKey
            )
        );

        //if not found by description, it was probably manually created. try the last used key instead
        if ( ! $consumer_secret ) {
            $consumer_secret = $wpdb->get_var(
                "SELECT consumer_secret FROM {$wpdb->prefix}woocommerce_api_keys ORDER BY key_id DESC LIMIT 1"
            );
        }
        return $consumer_secret;
    }

}