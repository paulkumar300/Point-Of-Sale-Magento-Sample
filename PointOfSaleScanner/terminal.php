<?php

/**
* The point of scanner terminal. Scan products and get the total cost.
*/
include 'listing.php';
include 'invoice.php';
class Terminal {
	private $product_listing;
	private $product_invoice;

	/**
	* Constructor
	* @param Listing $product_listing A Listing object.
	*/
	public function __construct($product_listing) {
		$this->product_listing = $product_listing;
		$this->product_invoice = new Invoice($this->product_listing);
	}

	/**
	* Adds the product into the system.
	* @param string $product_name the product's name to enter into system.
	*
	* @return boolean True if the system was able to add the product into the system, 
	* @return boolean False if the system wasn't able to add the product.			
	*
	* Note: If the terminal was unable to scan the product, make sure that
	* the product is listed first.
	*/
	public function scan($product_name) {
		if ($this->product_listing->isProductAvaliable($product_name)) {
			$this->product_invoice->add($product_name);
			return True;
		} 

		return False;
	}

	/**
	* Clears the products that were scanned in the system.
	*/
	public function reset() {
		$this->product_invoice->clear();
	}

	/**
	* Gets the total cost of the products scanned into the system.
	* 
	* Note: the terminal will still maintain the products scanned
	* after this method is called. To clear the terminal, call 
	* the reset() method.
	*/
	public function getTotalCost() {
		return $this->product_invoice->getTotal();
	}

	/**
	* Sets the unit prices for the product.
	* @param string $product_name the product's name to change prices
	* @param float $unit_price the unit price of the product.
	*/ 
	public function setUnitPricing($product_name, $unit_price) {
		$this->product_listing->updateUnitPrice($product_name, $unit_price);
	}

	/**
	* Sets the volume prices for the product.
	* @param string $product_name the product's name to change prices
	* @param array $volume_prices an array with the volume (integer) as key 
	* and volume price (float) as value. 
	*/
	public function setVolumePricing($product_name, $volume_prices) {
		$this->product_listing->updateVolumePrices($product_name, $volume_prices);
	}
}
?>