<?php
/* Make sure we have a session of some kind */
session_start();
require_once('User.php');
ini_set('display_errors', 'true');
function bail($message)
{
    /* Set the message to be consumed by the login page. */
    $_SESSION['loginError'] = $message;
    /* Perform the header redirect */
    header('Location: home.php');
    /* We're done now. */
    exit();
}
/* Try to authenticate the user */
if (isset($_POST['handle']) && !empty($_POST['handle'])) {
    /* Look up the user by the handle. */
    try {
        $user = User::forHandle($_POST['handle']);
    }
    /* Deal with an exception here. We should escape the message
* in case it contains invalid characters.
*/ catch (Exception $e) {
        bail('Internal server error, ' .
            htmlspecialchars($e->getMessage()));
    }
    /* User does not exist. Note that it does not matter whether
* or not the password is set here: we're dealing with the
* literal value of the password and not escaping it.
*/
    if (!$user || !$user->challenge($_POST['password'])) {
        bail('Invalid handle or password.');
    }
    /* Otherwise, we have successfully authenticated. */ else {
        $_SESSION['uid'] = $user->id();
    }
}
/* Cannot possibly authenticate without a handle. */ else {
    bail('No login handle supplied.');
}
/* Redirect to another page page. */
header('Location: list.php');
