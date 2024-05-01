<?php
class DVD extends Product
{
    private $size;

    public function __construct($sku, $name, $price, $type, $size)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->size = $size;
    }

    public function save(Database $db)
    {
        $stmt = $db->getConnection()->prepare("INSERT INTO dvd_table (sku, name, price, size) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->sku, $this->name, $this->price, $this->size]);
    }

    public static function getAll(Database $db)
    {
        $stmt = $db->getConnection()->prepare("SELECT * FROM dvd_table");
        $stmt->execute();
        $dvds = [];
        while ($row = $stmt->fetch()) {
            $dvd = new DVD($row['sku'], $row['name'], $row['price'], 'dvd', $row['size']);
            $dvds[] = $dvd;
        }
        return $dvds;
    }

    public static function delete(Database $db, $sku)
    {
        $stmt = $db->getConnection()->prepare("DELETE FROM dvd_table WHERE sku = ?");
        $stmt->execute([$sku]);
    }

    public function getSize()
    {
        return $this->size;
    }
}
