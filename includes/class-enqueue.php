<?php

namespace TSProduct;

use TSProduct\Common;
use TSProduct\Strings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Enqueue {

	public static function init() {
		$self = new self();
		add_action( 'admin_enqueue_scripts', array( $self, 'tsproduct_admin_scripts' ) );
	}

	public function tsproduct_admin_scripts() {
		$screen_info = Common::get_current_screen_info();
		$isPro       = Common::isProActivated();
		$dependency  = array( 'jquery', 'wp-i18n' );

		if ( $isPro ) {
			$dependency[] = 'tsproductpro-admin-script';
		}

		if ( $screen_info ) {
			wp_enqueue_media();
			wp_enqueue_style( 'tsproduct-admin-css', TSPRODUCT_ROOT_DIR_URL . 'includes/assets/admin/admin.css' );
			wp_enqueue_script( 'tsproduct-admin-script', TSPRODUCT_ROOT_DIR_URL . 'includes/assets/admin/admin.js', $dependency, '1.0.2', true );
			wp_set_script_translations('tsproduct-admin-script', 'ts-product-showcase', plugin_dir_path(__FILE__)  . 'languages');

			wp_localize_script(
				'tsproduct-admin-script',
				'tsteam_settings',
				array(
					'ajax_url'   => admin_url( 'admin-ajax.php' ),
					'admin_url'  => get_admin_url(),
					'nonce'      => wp_create_nonce( 'tsproduct_nonce' ),
					'wp_url'     => site_url(),
					'assets_path'=> TSPRODUCT_ROOT_DIR_URL . 'includes/library/',
					'is_pro'     => $isPro,
				)
			);

			wp_localize_script(
                'tsproduct-admin-script',
                'tsteam_i18n',
                 Strings::get_translated_strings()
            );
			remove_all_actions( 'admin_notices' );
			remove_all_actions( 'all_admin_notices' );
		}

		add_filter( 'script_loader_tag', array( $this, 'add_module_type_to_script' ), 10, 3 );
	}

	public function add_module_type_to_script( $tag, $handle, $src ) {
		if ( 'tsproduct-admin-script' === $handle ) {
			$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		}
		return $tag;
	}
}
