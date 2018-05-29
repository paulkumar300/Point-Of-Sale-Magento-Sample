<?php 


$a = '1';
$b = &$a;
$b = "2$b";
echo $a.", ".$b;

/*
Description about Output:
$a = '1';
	$a value 1
$b = &$a;
	Passing by reference allows two variables to point to the same content under different names.
	$b assigns a new value to $a , which changes the value stored in the variable that was passed to the $b;
$b = 21;

Output: 21 21 ($a.", ".$b)

*/
?>