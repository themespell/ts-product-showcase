<?php

	/**
	 *
	 * @link              https://themespell.com/
	 * @since             0.0.1
	 * @package           Showcase Product Beautifully
	 *
	 * @wordpress-plugin
	 * Plugin Name:       TS Product Showcase
	 * Plugin URI:        https://themespell.com/ts-product-showcase
	 * Description:       Showcase Product Beautifully
	 * Version:           0.0.1
	 * Author:            Themespell
	 * Author URI:        https://themespell.com/
	 * License:           GPL-2.0+
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
	 * Text Domain:       ts-product-showcase
	 * Tested up to:      6.8
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TSPRODUCT {

	private function __construct() {
		$this->define_constants();
		$this->load_dependency();
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		add_action( 'admin_init', array( $this, 'check_activation_redirect' ) );
	}

	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

			return $instance;
	}

	public function define_constants() {
		define( 'TSPRODUCT_VERSION', '0.0.1' );
		define( 'TSPRODUCT_PLUGIN_FILE', __FILE__ );
		define( 'TSPRODUCT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		define( 'TSPRODUCT_ROOT_DIR_PATH', plugin_dir_path( __FILE__ ) );
		define( 'TSPRODUCT_ROOT_DIR_URL', plugin_dir_url( __FILE__ ) );
		define( 'TSPRODUCT_INCLUDES_DIR_PATH', TSPRODUCT_ROOT_DIR_PATH . 'includes/' );
		define( 'TSPRODUCT_PLUGIN_SLUG', 'ts-product-showcase' );
	}

	public function on_plugins_loaded() {
		do_action( 'tsproduct_loaded' );
	}

	public function init_plugin() {
		//$this->init_freemius();
		$this->dispatch_hooks();
	}

	public function dispatch_hooks() {
		TSProduct\Autoload::init();
		TSProduct\Database::init();
		TSProduct\Admin::init();
		TSProduct\AJAX::init();
		TSProduct\Enqueue::init();
		TSProduct\Frontend::init();
		//TSProduct\Addons::init();
	}

	public function load_dependency() {
		require_once TSPRODUCT_INCLUDES_DIR_PATH . 'class-autoload.php';
	}

	public function activate() {
	    set_transient( 'tsproduct_plugin_activated', true, 30 );
	}

	public function deactivate() {
	    delete_transient( 'tsproduct_plugin_activated' );
	}

    public function check_activation_redirect() {
            if ( get_transient( 'tsproduct_plugin_activated' ) ) {
                delete_transient( 'tsproduct_plugin_activated' );
                wp_redirect( admin_url( 'admin.php?page=ts-product-showcase' ) );
                exit;
            }
    }

    public function init_freemius() {
            if ( ! function_exists( 'tsproductshowcase' ) ) {
                function tsproductshowcase() {
                    global $tsproductshowcase;

                    if ( ! isset( $tsproductshowcase ) ) {
                        require_once TSPRODUCT_INCLUDES_DIR_PATH . 'library/vendor/freemius/wordpress-sdk/start.php';
                        $tsproductshowcase = fs_dynamic_init( array(
                            'id'                  => '17306',
                            'slug'                => 'ts-product-showcase',
                            'type'                => 'plugin',
                            'public_key'          => 'pk_cb7074e85c7a5734ac990c844add0',
                            'is_premium'          => false,
                            'is_org_compliant'    => true,
                            'premium_suffix'      => 'Personal',
                            'has_addons'          => false,
                            'has_paid_plans'      => false,
                            'menu' => array(
                                'slug'           => 'tsteam-admin',
                                'first-path'     => 'admin.php?page=tsteam-showcase',
                            ),
                        ) );
                    }

                    return $tsproductshowcase;
                }
                tsproductshowcase();
                do_action( 'tsproductshowcase_loaded' );
            }
    }
}

function tsproduct_start() {
	return TSPRODUCT::init();
}


	tsproduct_start();
