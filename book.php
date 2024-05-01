<?php

class Book extends Product
{
    private $weight;

    public function __construct($sku, $name, $price, $type, $weight)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->weight = $weight;
    }


    public function save(Database $db)
    {
        $stmt = $db->getConnection()->prepare("INSERT INTO book_table (sku, name, price, weight) VALUES (?, ?, ?, ?)");
        $stmt->execute([$this->sku, $this->name, $this->price, $this->weight]);
    }

    public static function getAll(Database $db)
    {
        $stmt = $db->getConnection()->prepare("SELECT * FROM book_table");
        $stmt->execute();
        $books = [];
        while ($row = $stmt->fetch()) {
            $book = new Book($row['sku'], $row['name'], $row['price'], 'book', $row['weight']);
            $books[] = $book;
        }
        return $books;
    }

    public static function delete(Database $db, $sku)
    {
        $stmt = $db->getConnection()->prepare("DELETE FROM book_table WHERE sku = ?");
        $stmt->execute([$sku]);
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
