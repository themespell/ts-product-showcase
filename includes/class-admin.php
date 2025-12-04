<?php

namespace TSProduct;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Admin {

	public static function init() {
		$self = new self();
		add_action( 'admin_menu', array( $self, 'add_admin_menu' ) );
	}

	public function add_admin_menu() {
		$parent = 'ts-product-showcase';

		add_menu_page(
			__( 'TS Product Showcase', 'ts-product-showcase' ),
			'TS Product Showcase',
			'manage_options',
			$parent,
			array( $this, 'tsproduct_callback' ),
			plugin_dir_url( __FILE__ ) . 'library/icon-16x16.png',
			30
		);

		add_submenu_page(
        	$parent,
        	__( 'Dashboard', 'ts-product-showcase' ),
        	__( 'Dashboard', 'ts-product-showcase' ),
        	'manage_options',
        	'ts-product-showcase&path=dashboard',
        	array( $this, 'tsproduct_callback' ),
        );

		add_submenu_page(
			$parent,
			__( 'Product Showcase', 'ts-product-showcase' ),
			__( 'Product Showcase', 'ts-product-showcase' ),
			'manage_options',
			'ts-product-showcase&path=showcase',
			array( $this, 'tsproduct_callback' ),
		);
// 		add_submenu_page(
//         	$parent,
//         	__( 'Tools', 'ts-product-showcase' ),
//         	__( 'Tools', 'ts-product-showcase' ),
//         	'manage_options',
//         	'tsteam-showcase&path=tools',
//         	array( $this, 'tsproduct_callback' ),
//         );

		remove_submenu_page($parent, $parent);
	}

	public function tsproduct_callback() {
		?>
		<div id="ts-product-showcase"></div>
		<?php
	}
}