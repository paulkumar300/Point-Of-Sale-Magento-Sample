<?php

/*
* The product class. Contains basic information about product such as name and prices.
*/
class Product {
	private $name;
	private $unit_price;
	private $volume_prices;

	public function __construct($product_name, $unit_price = 0.00, $volume_prices = array()) {
		$this->name = $product_name;
		$this->unit_price = $unit_price;
		$this->volume_prices = $volume_prices;
	}

	public function getName() {
		return $this->name;
	}

	public function getVolumePrice($number_of_items) {
		if (array_key_exists($number_of_items , $this->volume_prices))
			return $this->volume_prices[$number_of_items];
	}

	public function getVolume() {
		return $this->volume_prices;
	}

	public function setVolumePrice($number_of_items, $price) {
		if ($number_of_items > 1 && $price >= 0.00)
			$this->volume_prices[$number_of_items] = $price;
	}

	public function removeVolumePrice($number_of_items) {
		unset($this->volume_prices[$number_of_items]);
	}

	public function getUnitPrice() {
		return $this->unit_price;
	}

	public function setUnitPrice($price) {
		if ($price >= 0.00)
			$this->unit_price = $price;
	}
}
?>