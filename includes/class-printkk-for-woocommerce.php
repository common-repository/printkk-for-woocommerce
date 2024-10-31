<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    PrintKK for Woocommerce
 * @subpackage PrintKK for Woocommerce/includes
 * @author     PrintKK
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
class PrintKK_For_Woocommerce {

    const MENU_TITLE_TOP = 'PrintKK';
    const PAGE_TITLE_DASHBOARD = 'Dashboard';
    const MENU_TITLE_DASHBOARD = 'Dashboard';
    const MENU_SLUG_DASHBOARD = 'printkk-dashboard';
    const CAPABILITY = 'manage_options';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PrintKK_For_Woocommerce_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PRINTKK_FOR_WOOCOMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'printkk-for-woocommerce';

		$this->load_dependencies();
        $this->set_menu();
		$this->define_admin_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-printkk-for-woocommerce-loader.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-printkk-for-woocommerce-admin.php';


		$this->loader = new PrintKK_For_Woocommerce_Loader();
	}

    private function  set_menu() {
        if ( PrintKK_For_WooCommerce::check_woocommerce_active() ) {
            $this->loader->add_action("admin_menu", $this, "register_admin_menu_page");
        }
    }

	/**
	 * Loads scripts used in printKK admin pages
	 */
	private function define_admin_hooks() {

		$plugin_admin = new PrintKK_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    PrintKK_For_Woocommerce_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

    /**
     * Register admin menu pages
     */
    public function register_admin_menu_page() {
        $plugin_admin = new PrintKK_For_Woocommerce_Admin( $this->get_plugin_name(), $this->get_version() );
        add_menu_page(
            __( 'Dashboard', 'printkk-for-woocommerce' ),
            self::MENU_TITLE_TOP,
            self::CAPABILITY,
            self::MENU_SLUG_DASHBOARD,
            array("PrintKK_For_Woocommerce", 'route'),
            $plugin_admin -> menu_logo(),
            58
        );
    }
    /**
     * callback route
     */
    public static function route() {
        call_user_func( array( 'PrintKK_Dashboard', 'view' ) );
    }
    /**
     * Load a template file. Extract any variables that are passed
     *
     * @param $name
     * @param array $variables
     */
    public static function load_template( $name, $variables = array() ) {
        $name = sanitize_file_name( $name );

        if ( ! empty( $variables ) ) {
            extract( $variables );
        }

        $filename = plugin_dir_path( __FILE__ ) . 'templates/' . $name . '.php';
        if ( file_exists( $filename ) ) {
            include $filename ;
        }
    }
    /**
     * make http request
     */
    public static function make_http_request($url, $params, $method) {
        $wp_http = new WP_Http();
        $request_args = [
            'timeout' => 15
        ];
        $apiUrl = PRINTKK_API_HOST . $url;

        if ($method === 'POST') {
            $request_args['method'] = 'POST';
            $request_args['body'] = $params;
        } elseif ($method === 'GET') {
            // 如果是GET请求，则将参数附加到URL中
            $query_string = http_build_query($params);
            $apiUrl .= '?' . $query_string;
        }

        $response = $wp_http->request($apiUrl, $request_args );

        // 处理响应
        if ( ! is_wp_error( $response ) ) {
            $response_code = wp_remote_retrieve_response_code($response);
            $response_body = wp_remote_retrieve_body($response);
            return [
                'error' => false,
                'code' => $response_code,
                'body' => $response_body,
            ];
        } else {
            return [
                'error' => true,
                'message' => $response->get_error_message(),
            ];
        }
    }

    public function check_woocommerce_active() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        return  is_plugin_active('woocommerce/woocommerce.php');
    }
}
