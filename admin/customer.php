<?php
require_once 'singleton.php';

class Customers
{
    static function removeCustomer($id)
    {
        $db = connect();
        $stmt = null;
        if ($stmt === null)
            $stmt = $db->prepare('DELETE FROM customers WHERE customer_id=:customer_id;');
        $stmt->bindParam(":customer_id", $id);

        $ret = $stmt->execute();

        $stmt->closeCursor();

        return $ret;
    }

    static function listCustomers()
    {
        $db = connect();
        $stmt = null;
        if ($stmt === null)
            $stmt = $db->prepare(
                'SELECT *
                FROM Customers'
            );

        $ret = $stmt->execute();
        if ($ret) {
            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
        }
        echo json_encode($ret);
    }
}
