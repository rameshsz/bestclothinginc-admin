<?php
  require_once 'c:/xampp/htdocs/bestclothinginc/functions.php';

if (
    isset($_POST['first_name']) &&
    isset($_POST['last_name']) &&
    isset($_POST['email']) &&
    isset($_POST['username']) &&
    isset($_POST['password'])
) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $un_temp = $_POST['username'];
    $pw_temp = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
    $ret = dupUser($un_temp, $email);

    if ($ret == "email") {
        die(json_encode("Email is already registered."));
    } else 
    if ($ret == "user") {
        die(json_encode("Username is taken."));
    } else 
    if (signUp($first_name, $last_name, $email, $un_temp, $pw_temp)) {
        die(json_encode("Success!"));
        //$message = json_encode("Success!");
        //echo $message;
        //sqlsrv_close($connection);
    }
} else {
    die(json_encode("Fatal Error!"));
}
