<?php

namespace TSProduct;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Database {

	public static function init() {
		$self            = new self();
		$self->rest_base = 'ts-product-showcase';
		add_action( 'init', array( $self, 'tsproduct_showcase_post_type' ) );
		add_action( 'rest_api_init', array( $self, 'register_tsproduct_showcase_meta' ) );
		add_action( 'rest_api_init', array( $self, 'tsteam_rest_routes' ) );
	}

	public function tsproduct_showcase_post_type() {
		$args = array(
			'label'               => __( 'TS Product Showcase', 'ts-product-showcase' ),
			'description'         => __( 'Post Type For TS Product Showcase', 'ts-product-showcase' ),
			'supports'            => array( 'title', 'author' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
		);

		register_post_type( $this->rest_base, $args );
	}

	public function register_tsproduct_showcase_meta() {
		$meeting_meta = array(
			'tsproduct_showcase_information'  => 'string',
			'tsproduct_showcase_products' => 'array',
		);

		foreach ( $meeting_meta as $meta_key => $meta_value_type ) {
			register_meta(
				'post',
				$meta_key,
				array(
					'object_subtype'    => 'ts-product-showcase',
					'type'              => $meta_value_type,
					'single'            => true,
					'show_in_rest'      => false,
					'sanitize_callback' => array( $this, 'sanitize_team_members_meta' ),
					'auth_callback'     => function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}

	public function sanitize_team_members_meta( $meta_value ) {
		return array_map( 'intval', (array) $meta_value );
	}

	public function tsteam_rest_routes() {
		register_rest_route(
			'tsteam-showcase/v1',
			'/' . $this->rest_base,
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_team_data' ),
				'permission_callback' => function() {
                    return current_user_can( 'manage_options' );
                }
			)
		);
	}

	public function get_team_data() {
		$args = array(
			'post_type' => $this->rest_base,
		);

		$meetings = get_posts( $args );

		$enhanced_meetings = array();
		if ( ! empty( $meetings ) ) {
			foreach ( $meetings as $meeting ) {
				$meeting_meta = array(
					'meetingwp_meeting_title' => get_the_title( $meeting->ID ),
					'tsteam_information'      => get_post_meta( $meeting->ID, 'tsteam_information', true ),
				);

				$enhanced_meeting    = $meeting_meta;
				$enhanced_meetings[] = $enhanced_meeting;
			}

			return rest_ensure_response( $enhanced_meetings );
		} else {
			return wp_send_json_error( 'no_meetings_found', 'No meetings found.', array( 'status' => 404 ) );
		}
	}
}
