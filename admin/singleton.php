<?php
function connect()
{
    static $pdo = null;
    if ($pdo === null) {
        require('config.php');
        $pdo = new PDO("sqlsrv:server=$dsn ; Database=BestClothing");
    }
    return $pdo;
}
