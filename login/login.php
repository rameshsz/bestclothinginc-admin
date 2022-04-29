<?php
require_once 'c:/xampp/htdocs/bestclothinginc/functions.php';

if (
    isset($_POST['username']) &&
    isset($_POST['password'])
) {
    $un_temp = $_POST['username'];
    $pw_temp = $_POST['password'];

    $message=checkLogin($un_temp, $pw_temp);
    die(json_encode($message));
}
