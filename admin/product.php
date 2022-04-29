<?php
require_once 'singleton.php';

class Product
{
    public $prod_id;
    public $prod_itemid;
    public $prod_brand;
    public $prod_name;
    public $prod_price;
    public $prod_img;
    public $prod_category;

    public function __construct($prod_itemid, $prod_brand, $prod_name, $prod_price, $prod_img, $prod_category)
    {
        $this->prod_itemid = $prod_itemid;
        $this->prod_brand = $prod_brand;
        $this->prod_name = $prod_name;
        $this->prod_price = $prod_price;
        $this->prod_img = $prod_img;
        $this->prod_category = $prod_category;
    }

    function addProduct()
    {
        $db = connect();
        $stmt = null;
        if ($stmt === null)
            $stmt = $db->prepare('INSERT INTO products
            (prod_itemid,prod_brand,prod_name,prod_price,prod_img,prod_category)
            VALUES(:prod_itemid,:prod_brand,:prod_name,:prod_price,:prod_img,:prod_category);');
        $stmt->bindParam('prod_itemid', $this->prod_itemid);
        $stmt->bindParam('prod_brand', $this->prod_brand);
        $stmt->bindParam('prod_name', $this->prod_name);
        $stmt->bindParam('prod_price', $this->prod_price);
        $stmt->bindParam('prod_img', $this->prod_img);
        $stmt->bindParam('prod_category', $this->prod_category);

        if (!$stmt->execute()) {
            die("Can't add product.");
        }
        $this->prod_id = $this->getID($this->prod_itemid);
        $stmt->closeCursor();

        //return $ret;
    }


    static function removeProduct($prod_itemid)
    {
        $db = connect();
        $stmt = null;
        if ($stmt === null)
            $stmt = $db->prepare('DELETE FROM products WHERE prod_itemid=:prod_itemid;');
        $stmt->bindParam(":prod_itemid", $prod_itemid);

        $ret = $stmt->execute();

        $stmt->closeCursor();

        return $ret;
    }


    static function getID($prod_itemid)
    {
        $db = connect();
        $stmt = null;
        if ($stmt === null)
            $stmt = $db->prepare("
            SELECT prod_id FROM products 
            WHERE prod_itemid =:id;");
        $stmt->bindParam(":id", $prod_itemid);

        $ret = $stmt->execute();
        if ($ret) {
            $ret = $stmt->fetch(PDO::FETCH_NUM);
            $output = $ret[0];
            $stmt->closeCursor();
        }
        return $output;
    }


    static function updateProduct($property, $value, $id)
    {
        $db = connect();
        $stmt = null;
        if ($stmt === null)
            $stmt = $db->prepare("
                UPDATE products 
                SET :property = :value
                WHERE prod_id =:id;");
        $stmt->bindParam(":property", $property);
        $stmt->bindParam(":value", $value);
        $stmt->bindParam(":id", $id);


        $ret = $stmt->execute();
    }
    static function listProducts()
    {
        $db = connect();
        $stmt = null;
        if ($stmt === null)
            $stmt = $db->prepare(
                'SELECT *
            FROM Products'
            );
        $ret = $stmt->execute();
        if ($ret) {
            $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
        }
        echo json_encode($ret);
    }
}
