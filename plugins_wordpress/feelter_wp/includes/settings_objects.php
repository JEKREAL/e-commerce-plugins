<?php

class FeelterObjectsClass {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public $name;
	public $display_name;
	public $priority;
	// Methods
	function set_name($name) {
	  $this->name = $name;
	}
	function get_name() {
		return $this->name;
	  }
	function set_display_name($display_name) {
	  $this->display_name = $display_name;
	}
	function get_display_name() {
	  return $this->display_name;
	}
	function set_priority($priority) {
		$this->priority = $priority;
	  }
	function get_priority() {
		return $this->priority;
	  }
	function create_widget_locations() {
		// $choose = new FeelterObjectsClass;
		// $choose->set_name('Please Choose');
		// $choose->set_display_name('Please Choose');

		$woocommerce_after_single_product_summary = new FeelterObjectsClass;
		$woocommerce_after_single_product_summary->set_name('woocommerce_after_single_product_summary');
		$woocommerce_after_single_product_summary->set_display_name('After product summary');
		$woocommerce_after_single_product_summary->set_priority(10);

		$woocommerce_after_single_product = new FeelterObjectsClass;
		$woocommerce_after_single_product->set_name('woocommerce_after_single_product');
		$woocommerce_after_single_product->set_display_name('After product');
		$woocommerce_after_single_product->set_priority(10);

		$woocommerce_after_main_content = new FeelterObjectsClass;
		$woocommerce_after_main_content->set_name('woocommerce_after_main_content');
		$woocommerce_after_main_content->set_display_name('After main content');
		$woocommerce_after_main_content->set_priority(10);

		$widget_locations_arr = array($woocommerce_after_single_product_summary,$woocommerce_after_single_product,$woocommerce_after_main_content);
		return $widget_locations_arr;
	}
	function create_anchor_locations() {
		// $choose = new FeelterObjectsClass;
		// $choose->set_name('Please Choose');
		// $choose->set_display_name('Please Choose');

		$woocommerce_before_single_product = new FeelterObjectsClass;
		$woocommerce_before_single_product->set_name('woocommerce_before_single_product');
		$woocommerce_before_single_product->set_display_name('Before single product');
		$woocommerce_before_single_product->set_priority(10);
		
		$woocommerce_before_single_product_summary = new FeelterObjectsClass;
		$woocommerce_before_single_product_summary->set_name('woocommerce_before_single_product_summary');
		$woocommerce_before_single_product_summary->set_display_name('Before single product summary');
		$woocommerce_before_single_product_summary->set_priority(10);

		$woocommerce_single_product_summary = new FeelterObjectsClass;
		$woocommerce_single_product_summary->set_name('woocommerce_single_product_summary');
		$woocommerce_single_product_summary->set_display_name('In single product summary');
		$woocommerce_single_product_summary->set_priority(10);

		$woocommerce_before_add_to_cart_form = new FeelterObjectsClass;
		$woocommerce_before_add_to_cart_form->set_name('woocommerce_before_add_to_cart_form');
		$woocommerce_before_add_to_cart_form->set_display_name(_('Before add to cart form'));
		$woocommerce_before_add_to_cart_form->set_priority(10);

		$woocommerce_product_thumbnails = new FeelterObjectsClass;
		$woocommerce_product_thumbnails->set_name('woocommerce_product_thumbnails');
		$woocommerce_product_thumbnails->set_display_name('In product tumbnails');
		$woocommerce_product_thumbnails->set_priority(10);
		
		$woocommerce_before_variations_form = new FeelterObjectsClass;
		$woocommerce_before_variations_form->set_name('woocommerce_before_variations_form');
		$woocommerce_before_variations_form->set_display_name('Before variations form');
		$woocommerce_before_variations_form->set_priority(10);

		$woocommerce_before_add_to_cart_button = new FeelterObjectsClass;
		$woocommerce_before_add_to_cart_button->set_name('woocommerce_before_add_to_cart_button');
		$woocommerce_before_add_to_cart_button->set_display_name('Before add to cart button');
		$woocommerce_before_add_to_cart_button->set_priority(10);

		$woocommerce_before_single_variation = new FeelterObjectsClass;
		$woocommerce_before_single_variation->set_name('woocommerce_before_single_variation');
		$woocommerce_before_single_variation->set_display_name('Before single variation');
		$woocommerce_before_single_variation->set_priority(10);

		$woocommerce_single_variation = new FeelterObjectsClass;
		$woocommerce_single_variation->set_name('woocommerce_single_variation');
		$woocommerce_single_variation->set_display_name('In single variation');
		$woocommerce_single_variation->set_priority(10);

		$woocommerce_before_add_to_cart_quantity = new FeelterObjectsClass;
		$woocommerce_before_add_to_cart_quantity->set_name('woocommerce_before_add_to_cart_quantity');
		$woocommerce_before_add_to_cart_quantity->set_display_name('Before add to cart quantity');
		$woocommerce_before_add_to_cart_quantity->set_priority(10);

		$woocommerce_after_add_to_cart_quantity = new FeelterObjectsClass;
		$woocommerce_after_add_to_cart_quantity->set_name('woocommerce_after_add_to_cart_quantity');
		$woocommerce_after_add_to_cart_quantity->set_display_name('After add to cart quantity');
		$woocommerce_after_add_to_cart_quantity->set_priority(10);
		
		$woocommerce_after_single_variation = new FeelterObjectsClass;
		$woocommerce_after_single_variation->set_name('woocommerce_after_single_variation');
		$woocommerce_after_single_variation->set_display_name('After single variation');
		$woocommerce_after_single_variation->set_priority(10);

		$woocommerce_after_add_to_cart_button = new FeelterObjectsClass;
		$woocommerce_after_add_to_cart_button->set_name('woocommerce_after_add_to_cart_button');
		$woocommerce_after_add_to_cart_button->set_display_name('After single variation');
		$woocommerce_after_add_to_cart_button->set_priority(10);

		$anchor_locations_arr = array($woocommerce_before_single_product,$woocommerce_before_single_product_summary,$woocommerce_single_product_summary,$woocommerce_before_add_to_cart_form,$woocommerce_product_thumbnails,$woocommerce_before_variations_form,$woocommerce_before_add_to_cart_button,$woocommerce_before_single_variation,$woocommerce_single_variation,$woocommerce_before_add_to_cart_quantity,$woocommerce_after_add_to_cart_quantity,$woocommerce_after_single_variation,$woocommerce_after_add_to_cart_button);
		return $anchor_locations_arr;
	}
	function create_languages() {

		$english = new FeelterObjectsClass;
		$english->set_name('en_EN');
		$english->set_display_name('English');

		$french = new FeelterObjectsClass;
		$french->set_name('fr_FR');
		$french->set_display_name('French');

		$russian = new FeelterObjectsClass;
		$russian->set_name('ru_RU');
		$russian->set_display_name('Russian');
		
		$languages_arr = array ($english,$french,$russian );
		return $languages_arr;
	}
}

class FeelterWidgetTypeClass {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public $name;
	public $display_name;
	public $templates;
	// Methods
	function set_name($name) {
	  $this->name = $name;
	}
	function get_name() {
		return $this->name;
	  }
	  function set_display_name($display_name) {
		$this->display_name = $display_name;
	  }
	  function get_display_name() {
		  return $this->display_name;
		} 
	function set_templates($templates) {
		$this->templates = $templates;
	  }
	function get_templates() {
		return $this->templates;
	  }
	function create_types_templates(){
		// $choose = new FeelterObjectsClass;
		// $choose->set_name('Please Choose');
		// $choose->set_display_name('Please Choose');

		$carusel = new FeelterWidgetTypeClass;
		$carusel->set_name('carusel');
		$carusel->set_display_name('Carusel');
		$carusel->set_templates(array('templateCar1','templateCar2','templateCar3'));

		$pop_up = new FeelterWidgetTypeClass;
		$pop_up->set_name('pop_up');
		$pop_up->set_display_name('Pop up');
		$pop_up->set_templates(array('templatePop1','templatePop2','templatePop3'));

		$social_wall = new FeelterWidgetTypeClass;
		$social_wall->set_name('social_wall');
		$social_wall->set_display_name('Social Wall');
		$social_wall->set_templates(array('templateSoc1','templateSoc2','templateSoc3'));

		$types_arr = array($carusel,$pop_up,$social_wall);
		return $types_arr;
	}
	
}