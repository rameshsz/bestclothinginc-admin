<?php require_once 'connection.php';

function dupUser($un_temp, $email)
{
    global $serverName;
    global $connectioninfo;
    $connection = sqlsrv_connect($serverName, $connectioninfo);
    if (!$connection) {
        die("Fatal Error");
    }
    $ret = "";
    $sql = "EXEC ? = dbo.DupUser ?,?;";
    $params = array(
        array(&$ret, SQLSRV_PARAM_OUT, null, SQLSRV_SQLTYPE_VARCHAR(5)),
        array($un_temp, SQLSRV_PARAM_IN),
        array($email, SQLSRV_PARAM_IN)
    );
    $stmt = sqlsrv_prepare($connection, $sql, $params);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($connection);
    return $ret;
}

function signUp($first_name, $last_name, $email, $un_temp, $pw_temp)
{
    global $serverName;
    global $connectioninfo;
    $connection = sqlsrv_connect($serverName, $connectioninfo);
    if (!$connection) {
        die("Fatal Error");
    }
    $sql = "EXEC AddUser ?,?,?,?,?;";
    $procedure_params = array(
        array($first_name, SQLSRV_PARAM_IN), //<--- need extra )?
        array($last_name, SQLSRV_PARAM_IN),
        array($email, SQLSRV_PARAM_IN),
        array($un_temp, SQLSRV_PARAM_IN),
        array($pw_temp, SQLSRV_PARAM_IN)
    );

    $stmt = sqlsrv_prepare($connection, $sql, $procedure_params);
    if (!$stmt) {
        //sqlsrv_close($connection);
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt) === false) {
        //sqlsrv_close($connection);
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($connection);

    return true;
}

function checkLogin($un_temp, $pw_temp)
{
    global $serverName;
    global $connectioninfo;
    $connection = sqlsrv_connect($serverName, $connectioninfo);
    if (!$connection) {
        die("Fatal Error");
    }
    $procedure_params = array(
        array($un_temp, SQLSRV_PARAM_IN),
    );

    $sql = "EXEC CheckLogin ?;";

    $stmt = sqlsrv_prepare($connection, $sql, $procedure_params);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $num = sqlsrv_has_rows($stmt);

    if ($num === false) {
        $message = json_encode("Invalid username/password combination");
        sqlsrv_close($connection);
        die($message);
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if (password_verify($pw_temp, $row['password'])) {
        $message = "Success!";
        return $message;
        sqlsrv_close($connection);
    } else {
        $message = "Invalid username/password combination";
        return $message;
        sqlsrv_close($connection);
    }
}

function getFeatured()
{
    global $serverName;
    global $connectioninfo;
    $connection = sqlsrv_connect($serverName, $connectioninfo);
    if (!$connection) {
        die("Fatal Error");
    }
    $sql = "EXEC getFeatured";
    $stmt = sqlsrv_prepare($connection, $sql);
    if (!$stmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_execute($stmt) === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $message[] = $row;
    }
    return $message;
}
