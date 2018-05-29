<?php

/*
* Inventory manages products, including adding and removing products.
*/
include 'product.php';
class Inventory {
	private $inventory;

	public function __construct() {
		$this->inventory = array();
	}

	/**
	* Add product to the inventory.
	* @param string $product_name
	* @param float $unit_price     the unit price of the product 
	* @param array $vol_prices     the volume prices of the product
	*
	* @throws Exception if either $unit_price or $vol_prices's values are not numbers.
	*/
	public function add($product_name, $unit_price=0.00, $vol_prices=array()) {
		try {
			$this->checkVolumePricesAreValid($vol_prices);
			$this->checkUnitPriceIsValid($unit_price);

			if (!$this->isInInventory($product_name))
				$this->inventory[$product_name] = new Product($product_name, $unit_price, $vol_prices);
		} catch (Exception $e) {
			echo nl2br($e->getMessage() . " for Product <b>" . $product_name. "</b>\n");
			echo nl2br("Product <b>" . $product_name . "</b> has not been added to the system\n");
		}
	}

	private function checkVolumePricesAreValid($vol_prices) {
		foreach($vol_prices as $key=>$value) {
			if (!is_numeric($value) || !is_numeric($key))
				throw new Exception("Cannot process volume: <b>" . $key . "," .$value . "</b>");
		}
	}

	private function checkUnitPriceIsValid($unit_price) {
		if (!is_numeric($unit_price)) {
			throw new Exception("Cannot process unit price: <b>" . $unit_price . "</b>");
		}
	}
	/**
	* Retrieves product from the inventory.
	* @param string $product_name
	*
	* @return Product
	*/
	public function get($product_name) {
		if ($this->isInInventory($product_name))
			return $this->inventory[$product_name]; 
	}

	/**
	* Removes product from the inventory.
	* 
	* @param string $product_name
	*/
	public function remove($product_name) {
		unset($this->inventory[$product_name]);
	}

	/**
	* Checks if product is in the inventory.
	* 
	* @param string $product_name
	*
	* @return boolean
	*/
	public function isInInventory($product_name) {
		return array_key_exists($product_name, $this->inventory);
	}
}
?>