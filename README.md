# Point-Of-Sale-Magento-Sample



##Point-of-sale scanner program has several classes:

Terminal class in terminal.php

This class is an interface for scanning products and getting total cost (volume + unit) for products.

Product class in product.php

Represents a product object. Contains information about that product's name, volume and unit prices.

Inventory class in inventory.php

Stores the products, including adding and removing products.


Invoice class in invoice.php
This class tallys the number of times each product is scanned and calculates the total cost of all scanned products.

Listing class in listing.php
This class provides operations to update a product unit and volume costs and other information about the product, such
as whether the product is in the inventory.

---
###How the program works
Use the Inventory class to create and stores product object.

The Listing class will will manage prices for all products stored in the Inventory class.

The Terminal will use the Listing class to get price data for a specific object and set prices. It will
use the Invoice class to calculate total cost of scanned products.
 
The Invoice class will also use the Listing class given by Terminal to perform calculations.

###NOTE:
I did not handle all possibie exceptions if someone tries inputting non-numeric or negative unit and volume prices, except for the add() method in Inventory class.  

---
How to Use:

1. Extract this folder to any of the php server root.
2. Browse url : http://hostname/PointOfSaleScanner/index.php
3. Type the product code (A,B,C,D) sequence in inout field to get the final price