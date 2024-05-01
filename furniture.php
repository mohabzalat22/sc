<?php
class Furniture extends Product
{
    private $length;
    private $width;
    private $height;

    public function __construct($sku, $name, $price, $type, $length, $width, $height)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    public function save(Database $db)
    {
        $stmt = $db->getConnection()->prepare("INSERT INTO furniture_table (sku, name, price, length, width, height) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->sku, $this->name, $this->price, $this->length, $this->width, $this->height]);
    }

    public static function getAll(Database $db)
    {
        $stmt = $db->getConnection()->prepare("SELECT * FROM furniture_table");
        $stmt->execute();
        $furnitures = [];
        while ($row = $stmt->fetch()) {
            $furniture = new Furniture($row['sku'], $row['name'], $row['price'], 'furniture', $row['length'], $row['width'], $row['height']);
            $furnitures[] = $furniture;
        }
        return $furnitures;
    }

    public static function delete(Database $db, $sku)
    {
        $stmt = $db->getConnection()->prepare("DELETE FROM furniture_table WHERE sku = ?");
        $stmt->execute([$sku]);
    }

    public function getLength()
    {
        return $this->length;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }
}
