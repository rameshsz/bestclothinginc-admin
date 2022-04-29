<!DOCTYPE html>
<html>
<head>
<title>Log in</title>
</head>
<body>
<h1>Log in</h1>
<?php
/* Pull session information */
session_start();
if (isset($_SESSION['loginError'])) {
// We could escape this, but it comes from a trusted source.
echo '<div><b>Error:</b> ' . $_SESSION['loginError'] .
'</div>';
// The error no longer applies.
unset($_SESSION['loginError']);
}
?>
<form action='doLogin.php' method='post'>
<table>
<tr>
<th><label for="handle">Handle</label></th>
<td><input type="text" name="handle"/></td>
</tr>
<tr>
<th><label for="handle">Password</label></th>
<td><input type="password"
name="password"/></td>
</tr>
</table>
<input type="submit" value="Log in"/>
</form>
</body>
</html>
