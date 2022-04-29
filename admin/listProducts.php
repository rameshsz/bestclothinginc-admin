<?php
require_once('product.php');
$ret = Product::listProducts();
echo($ret);
