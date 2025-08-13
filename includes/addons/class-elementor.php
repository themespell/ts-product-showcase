<?php

namespace TSProduct;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Elementor {

    public static function init() {
        $self = new self();
        add_action('elementor/elements/categories_registered', array($self, 'register_ts_product_category'));
        add_action('elementor/widgets/register', array($self, 'register_ts_product_showcase_widget'));
    }

    public function register_ts_product_category($elements_manager) {
        $elements_manager->add_category(
            'ts-team-widgets',
            [
                'title' => esc_html__('TS Team Widgets', 'ts-product-showcase'),
            ]
        );
    }

    public function register_ts_product_showcase_widget($widgets_manager) {
        require_once(__DIR__ . '/elementor/ts-product-showcase.php');
        $widgets_manager->register(new \TSTeam_Showcase());
    }
}