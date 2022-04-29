<?php
require_once('user.php');
if (isset($_POST['handle'])&&($_POST['handle']!=null)){
User::create($_POST['handle'],$_POST['password']);
} else{
    die("Enter a handle.");
};
header('Location:login.php');
?>
