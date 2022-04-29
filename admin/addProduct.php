<?php
require_once('product.php');
if (isset($_POST['prod_itemid'])){
    $prod_itemid = $_POST['prod_itemid'];
    $prod_brand = $_POST['prod_brand'];
    $prod_name = $_POST['prod_name'];
    $prod_price = $_POST['prod_price'];
    $prod_img = $_POST['prod_img'];
    $prod_category = $_POST['prod_category'];
    

    $product = new Product($prod_itemid,$prod_brand,$prod_name,$prod_price,$prod_img,$prod_category);
    $product->addProduct();
}
header("Location:./list.php");
    
