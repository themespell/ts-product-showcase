<?php
namespace TSProduct;

use TSProduct\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Products {

	public static function init() {
		$self = new self();
		// Products Ajax
		add_action( 'wp_ajax_tsproduct/products/fetch', array( $self, 'get_products' ) );
// 		add_action( 'wp_ajax_tsteam/team_member/fetch/single', array( $self, 'get_team_member_by_id' ) );
	}

	// Products Ajax

	public function get_products() {
		check_ajax_referer( 'tsproduct_nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die();
		}

		$args = array(
			'post_type' => 'product',
			'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC'
		);

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			wp_send_json_error( array( 'message' => 'No Products found' ) );
		}

		$members = array();

		while ( $query->have_posts() ) {
			$query->the_post();

			$post_id            = get_the_ID();
            $product = wc_get_product( $post_id );

            // Get image ID and URL
            $image_id  = $product->get_image_id();
            $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : wc_placeholder_img_src();

			$members[] = array(
				'post_id'     => $post_id,
				'image' => $member_meta['image'],
				'name'        => get_the_title(),
				'image'   => $image_url,
				'price' => $product->get_price(),
                'sku'   => $product->get_sku(),
			);
		}

		wp_reset_postdata();

		wp_send_json_success( $members );
	}

	public function get_team_member_by_id() {
		check_ajax_referer( 'tsteam_nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die();
		}

		$team_member_id = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

		$args = array(
			'post_type' => 'tsteam-member',
			'p'         => $team_member_id,
		);

		$query = new \WP_Query( $args );

		if ( ! $query->have_posts() ) {
			wp_send_json_error( array( 'message' => 'Showcase not found' ) );
			return;
		}

		$query->the_post();

		$member_meta        = get_post_meta( $team_member_id, 'tsteam_member_info', true );

		$showcase = array(
			'post_id'   => $team_member_id,
			'title'     => get_the_title(),
			'content'   => get_the_content(),
			'meta_data' => $member_meta,
		);

		wp_reset_postdata();
		wp_send_json_success( $showcase );
	}
}
