<?php
require_once('customer.php');
$_POST = json_decode(file_get_contents("php://input"),true);
if (isset($_POST['id'])) {

$id = $_POST['id'];
Customers::removeCustomer($id);
}

header("Location:./index.html");
