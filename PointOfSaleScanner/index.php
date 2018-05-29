<!DOCTYPE html>
<html>
<head>

  <title>Point of Sale Scanner</title>
  <script src="https://code.jquery.com/jquery-2.1.4.js"></script>
</head>
<body>
	<h2>Scan your code here</h2>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="target">
	  <input type="text" name="product_txt"/>
	  <button type="submit" name="submit" id="process">Scan</button>
	</form>
<div class="result">
	<?php 
		include 'terminal.php';
		include 'inventory.php';

		// Initialize inventory, listings, and terminal objects.
		$product_inventory = new Inventory();

		// add products and prices here. 
		$product_inventory->add("A", 2.00, [4=>'7.00']);
		$product_inventory->add("B", 12.00);
		$product_inventory->add("C", 1.25, [6=>6.00]);
		$product_inventory->add("D", 0.15);

		$product_listing = new Listing($product_inventory);
		$terminal = new Terminal($product_listing);

		// process form data
		if (isset($_POST["submit"])) {
			$products = $_POST["product_txt"];

			for ($i = 0; $i < strlen($products); $i++) {

				if ($products[$i] != " ")
					$scannable = $terminal->scan($products[$i]);

				// did the product go into the system?
				if (!$scannable)
					echo "Unable to get price for: " . $products[$i] . "<br>";
			}

			echo "<b>The total cost of: " . $products . " is: <i>$" . number_format($terminal->getTotalCost(), 2, '.', ',') . "</i></b>";
		}
	?>
</div>
  <h3>Question</h3>
  <pre>Consider a store where items have prices per unit but also volume
prices. For example, apples may be $1.00 each or 4 for $3.00.

Implement a point-of-sale scanning API that accepts an arbitrary
ordering of products (similar to what would happen at a checkout line)
and then returns the correct total price for an entire shopping cart
based on the per unit prices or the volume prices as applicable.

Here are the products listed by code and the prices to use (there is
no sales tax):

Product Code 	| Price
_____________________________________________

A 		| $2.00 each or 4 for $7.00
B 		| $12.00
C 		| $1.25 or $6 for a six pack
D 		| $0.15
_____________________________________________

There should be a top level point of sale terminal service object that
looks something like the pseudo-code below. You are free to design and
implement the rest of the code however you wish, including how you
specify the prices in the system:

terminal->setPricing(...)
terminal->scan("A")
terminal->scan("C")
... etc.
result = terminal->total

Here are the minimal inputs you should use for your test cases. These
test cases must be shown to work in your program:

Scan these items in this order: ABCDABAA; Verify the total price is $32.40.
Scan these items in this order: CCCCCCC; Verify the total price is $7.25.
Scan these items in this order: ABCD; Verify the total price is $15.40.

</pre>

</body>
</html>