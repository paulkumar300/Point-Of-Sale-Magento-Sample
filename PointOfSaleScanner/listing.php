<?php

/**
* Listing will provide operations that will set and retrieve the
* prices for product listed, as well as checking
* if the product is avaliable in the inventory.
*/
class Listing {
	private $product_inventory;

	/**
	* Constructor
	* @param Inventory $product_inventory
	*/
	public function __construct($product_inventory) {
		$this->product_inventory = $product_inventory;
	}

	/**
	* Updates a product's unit price.
	* @param string $product_name
	* @param float  $new_unit_price
	*/
	public function updateUnitPrice($product_name, $new_unit_price) {
		if ($this->isProductAvaliable($product_name)) {
			$product = $this->getProductFromInventory($product_name);
			$product->setUnitPrice($new_unit_price);
		}
	}

	/**
	* Updates a product's existing volume price. Adds new one if there no existing volume price.
	* @param string   $product_name
	* @param integer  $volume          the volume unit
	* @param float    $new_vol_price   cost for that volume.
	*/
	public function updateVolumePrice($product_name, $volume, $new_vol_price) {
		if ($this->isProductAvaliable($product_name)) {
			$product = $this->getProductFromInventory($product_name);
			$vol_price = $product->getVolumePrice($volume);

			$product->setVolumePrice($volume, $new_vol_price);
		}
	}

  	/**
	* Updates product's existing volume prices. Adds new ones if there no existing volume prices.
	* @param string   $product_name
	* @param array    $volumes      key (integer) is the volume, value (float) is the cost.  
	*   
	*/
	public function updateVolumePrices($product_name, $volumes) {
		if ($this->isProductAvaliable($product_name)) {
			foreach ($volumes as $volume => $price) {
				$this->updateVolumePrice($product_name, $volume, $price);
			}
		}
	}

  	/**
	* Removes product's existing volume price.
	* @param string   $product_name
	* @param integer  $volume        the volume unit        
	*/
	public function removeVolumePrice($product_name, $volume) {
		if ($this->isProductAvaliable($product_name)) {
			$product = $this->getProductFromInventory($product_name);
			$product->removeVolumePrice($volume);
		}
	}


  	/**
	* Gets product's unit price.
	* @param string  $product_name
	*
	* @return float       
	*/
	public function getUnitPrice($product_name) {
		if ($this->isProductAvaliable($product_name)) {
			$product = $this->getProductFromInventory($product_name);
			return $product->getUnitPrice();
		}
	}


  	/**
	* Gets product's volume price for a specific volume unit.
	* @param string  $product_name
	* @param integer $volume        the volume unit 
	* 
	* @return float
	*/
	public function getVolumePrice($product_name, $volume) {
		if ($this->isProductAvaliable($product_name)) {
			$product = $this->getProductFromInventory($product_name);
			
			return $product->getVolumePrice($volume);
		}
	}

	/**
	* Gets product's volume (volume unit and volume price).
	* @param string  $product_name
	*
	* @return array
	*/
	public function getVolume($product_name) {
		if ($this->isProductAvaliable($product_name)) {
			$product = $this->getProductFromInventory($product_name);
			return $product->getVolume();
		}
	}

	/**
	* Checks if a product has volume prices.
	* @param string  $product_name
	*
	* @return boolean True if it does
	* @return boolean False if it does not
	*/
	public function hasVolumePrices($product_name) {
		if ($this->isProductAvaliable($product_name)) {
			$product = $this->getProductFromInventory($product_name);
			return !empty($product->getVolume());
		}

		return False;
	}

	/**
	* Checks if a product exists.
	* @param string  $product_name
	*
	* @return boolean True if it does
	* @return boolean False if it does not
	*/
	public function isProductAvaliable($product_name) {
		$product = $this->getProductFromInventory($product_name);

		return $product != null;
	}

	private function getProductFromInventory($product_name) {
		return $this->product_inventory->get($product_name);
	}
}
?>