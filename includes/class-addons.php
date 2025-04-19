<?php
namespace TSProduct;

use TSProduct\Gutenberg;
use TSProduct\Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Addons {
    public static function init() {
        $self = new self();
        Gutenberg::init();
        Elementor::init();
    }
}