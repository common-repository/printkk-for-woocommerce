<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class PrintKK_For_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {
        if($hook !== "toplevel_page_printkk-dashboard") {
            return;
        }
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/printkk-for-woocommerce-admin.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {
        if($hook !== "toplevel_page_printkk-dashboard") {
            return;
        }
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/printkk-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );
    }
    /**
     * menu logo
     */
    public function menu_logo() {
        $plugin_url = plugin_dir_url(__FILE__);
        return $plugin_url."/images/menu_logo.png";
    }

}
