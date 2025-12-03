<?php
namespace TSProduct;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Helper {

    public static function get_products_by_ids( $product_ids ) {
        $product_ids = is_array( $product_ids ) ? array_map( 'intval', $product_ids ) : array();

        if ( empty( $product_ids ) ) {
            return array(
                'error'   => true,
                'message' => 'No product IDs provided',
            );
        }

        $args = array(
            'post_type'      => 'product',
            'post__in'       => $product_ids,
            'posts_per_page' => -1,
            'orderby'        => 'ID',
            'order'          => 'ASC',
        );

        $query = new \WP_Query( $args );

        if ( ! $query->have_posts() ) {
            return array(
                'error'   => true,
                'message' => 'No products found',
            );
        }

        $products = array();

        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();

            // Get WooCommerce product object
            $product = wc_get_product( $post_id );

            if ( ! $product ) {
                continue;
            }

            // Get image URL instead of ID
            $image_url = wp_get_attachment_url( $product->get_image_id() );

            // Get gallery image URLs instead of IDs
            $gallery_urls = array();
            $gallery_ids = $product->get_gallery_image_ids();
            if ( ! empty( $gallery_ids ) ) {
                foreach ( $gallery_ids as $gallery_id ) {
                    $gallery_url = wp_get_attachment_url( $gallery_id );
                    if ( $gallery_url ) {
                        $gallery_urls[] = $gallery_url;
                    }
                }
            }

            $products[] = array(
                'post_id'     => $post_id,
                'title'       => get_the_title(),
                'content'     => get_the_content(),
                'price'       => $product->get_price(),
                'regular_price' => $product->get_regular_price(),
                'sale_price'  => $product->get_sale_price(),
                'sku'         => $product->get_sku(),
                'stock_status' => $product->get_stock_status(),
                'image_url'   => $image_url,  // Changed from image_id to image_url
                'gallery_urls' => $gallery_urls,  // Changed from gallery_ids to gallery_urls
                'categories'  => wp_get_post_terms( $post_id, 'product_cat', array( 'fields' => 'names' ) ),
                'add_to_cart_url' => home_url( '/?add-to-cart=' . $product->get_id() )
            );
        }

        wp_reset_postdata();

        return array(
            'error'    => false,
            'products' => $products,
        );
    }

// 	public static function team_member_fields($actiontype) {
// 		$post_data = ($actiontype === 'update') ? $_POST['data'] : $_POST;
//
// 		return array(
// 			'name'         => isset( $post_data['member_name'] ) ? sanitize_text_field( wp_unslash( $post_data['member_name'] ) ) : '',
// 			'description'  => isset( $post_data['member_description'] ) ? sanitize_text_field( wp_unslash( $post_data['member_description'] ) ) : '',
// 			'designation'  => isset( $post_data['member_designation'] ) ? sanitize_text_field( wp_unslash( $post_data['member_designation'] ) ) : '',
// 			'image'        => isset( $post_data['member_image'] ) ? esc_url_raw( wp_unslash( $post_data['member_image'] ) ) : '',
// 			'email'        => isset( $post_data['member_email'] ) ? sanitize_email( wp_unslash( $post_data['member_email'] ) ) : '',
// 			'phone'        => isset( $post_data['member_phone'] ) ? sanitize_text_field( wp_unslash( $post_data['member_phone'] ) ) : '',
// 			'telephone'    => isset( $post_data['member_telephone'] ) ? sanitize_text_field( wp_unslash( $post_data['member_telephone'] ) ) : '',
// 			'experience'   => isset( $post_data['member_experience'] ) ? sanitize_text_field( wp_unslash( $post_data['member_experience'] ) ) : '',
// 			'company'      => isset( $post_data['member_company'] ) ? sanitize_text_field( wp_unslash( $post_data['member_company'] ) ) : '',
// 			'location'     => isset( $post_data['member_location'] ) ? sanitize_text_field( wp_unslash( $post_data['member_location'] ) ) : '',
// 			'information'  => isset( $post_data['member_information'] ) ? $post_data['member_information'] : '',
// 			'website'      => isset( $post_data['member_website'] ) ? sanitize_text_field( wp_unslash( $post_data['member_website'] ) ) : '',
// 			'resume'       => isset( $post_data['member_resume'] ) ? sanitize_text_field( wp_unslash( $post_data['member_resume'] ) ) : '',
// 			'hireLink'     => isset( $post_data['member_hire'] ) ? sanitize_text_field( wp_unslash( $post_data['member_hire'] ) ) : '',
// 			'donationLink' => isset( $post_data['member_donation'] ) ? sanitize_text_field( wp_unslash( $post_data['member_donation'] ) ) : '',
// 			'socialLinks'  => isset( $post_data['member_social'] ) ? wp_json_encode( wp_unslash( $post_data['member_social'] ), true ) : array(),
// 			'skills'       => isset( $post_data['member_skills'] ) ? wp_json_encode( wp_unslash( $post_data['member_skills'] ), true ) : array()
// 		);
// 	}
	
}
