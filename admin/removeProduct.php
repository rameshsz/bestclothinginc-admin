<?php
require_once('product.php');
$_POST = json_decode(file_get_contents("php://input"),true);
if (isset($_POST['prod_itemid'])) {

$prod_itemid = $_POST['prod_itemid'];
Product::removeProduct($prod_itemid);
}

header("Location:./index.html");
