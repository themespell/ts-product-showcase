<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class TSTeam_Showcase extends Widget_Base {

    public function get_name() {
        return 'ts_product_showcase';
    }

    public function get_title() {
        return esc_html__( 'TS Product Showcase', 'ts-product-showcase' );
    }

    public function get_icon() {
        return 'eicon-person';
    }

    public function get_categories() {
            return ['ts-product-widgets'];
    }

    public function get_keywords() {
        return [ 'team', 'member', 'staff', 'showcase' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'ts-product-showcase' ),
            ]
        );

        // Get all TSTeam posts
        $team_posts = get_posts([
            'post_type' => 'tsteam-showcase',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
        ]);

        // Prepare options
        $options = ['' => esc_html__('Select a Team Showcase', 'ts-product-showcase')];
        foreach ( $team_posts as $post ) {
            // translators: %d is the post ID number
            $options[$post->ID] = !empty($post->post_title) ? $post->post_title : sprintf(__('#%d (No title)', 'ts-product-showcase'), $post->ID);
        }

        // Team post selector
        $this->add_control(
            'team_id',
            [
                'label' => esc_html__( 'Select Team Showcase', 'ts-product-showcase' ),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => '',
                'label_block' => true,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['team_id'] ) ) {
            echo '<div class="tsteam-placeholder">';
            echo esc_html__( 'Please select a team showcase to display', 'ts-product-showcase' );
            echo '</div>';
            return;
        }
        echo do_shortcode( '[tsteam_showcase id="' . esc_attr( $settings['team_id'] ) . '"]' );
    }
}