<?php
require_once('customer.php');
$ret = Customers::listCustomers();
echo($ret);
