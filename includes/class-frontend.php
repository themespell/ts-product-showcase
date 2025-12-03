<?php

namespace TSProduct;

use TSProduct\Common;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Frontend {

	public static function init() {
		$self = new self();
		add_action( 'wp_enqueue_scripts', array( $self, 'tsproduct_scripts' ) );
		add_action('elementor/editor/before_enqueue_scripts', array($self, 'tsproduct_scripts'));
		add_action( 'enqueue_block_editor_assets', array( $self, 'tsproduct_scripts' ) );
		add_shortcode( 'ts_product_showcase', array( $self, 'ts_product_showcase_shortcode' ) );
	}

	public function tsproduct_scripts() {
		$isPro      = Common::isProActivated();
		$dependency = array( 'jquery' );

		if ( $isPro ) {
			$dependency[] = 'tsproductpro-admin-script';
		}

			wp_enqueue_style( 'tsproduct-frontend-css', TSPRODUCT_ROOT_DIR_URL . 'includes/assets/frontend/frontend.css' );
			wp_enqueue_script( 'tsproduct-frontend-script', TSPRODUCT_ROOT_DIR_URL . 'includes/assets/frontend/frontend.js', $dependency, '1.0.3', true );
			wp_localize_script(
				'tsproduct-frontend-script',
				'tsproduct_settings',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'tsproduct_nonce' ),
					'is_pro'     => $isPro,
					'devmode'     => false,
				)
			);

		add_filter( 'script_loader_tag', array( $this, 'add_module_type_to_script' ), 10, 3 );
	}

	public function add_module_type_to_script( $tag, $handle, $src ) {
		if ( 'tsproduct-frontend-script' === $handle ) {
			$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
		}
		return $tag;
	}

	public function ts_product_showcase_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'id' => '',
			),
			$atts,
			'ts_product_showcase'
		);

		if ( empty( $atts['id'] ) ) {
			return 'Showcase ID Not Available';
		}
		return '<div class="ts-product-showcase" data-id="' . esc_attr( $atts['id'] ) . '"></div>';
	}
}
