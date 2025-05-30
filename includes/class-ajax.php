<?php
namespace TSProduct;

use TSProduct\Products;
use TSProduct\ProductShowcase;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AJAX {

	public static function init() {
		$self = new self();
		Products::init();
		ProductShowcase::init();
	}
}
