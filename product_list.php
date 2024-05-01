<?php
// Include the Database and Product classes
include_once 'database.php';
include_once 'Product.php';
include_once 'Book.php';
include_once 'DVD.php';
include_once 'Furniture.php';

// Create a new Database instance
$db = new Database();

// Get all products from the database
$products = [];
$products = array_merge($products, Book::getAll($db));
$products = array_merge($products, DVD::getAll($db));
$products = array_merge($products, Furniture::getAll($db));

// Product type classes
$productTypes = [
    'DVD' => DVD::class,
    'Furniture' => Furniture::class,
    'Book' => Book::class
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    $sku = $_POST["sku"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $productType = $_POST["productType"];

    // Check if the SKU is unique
    $stmt = $db->getConnection()->prepare("SELECT * FROM product_table WHERE sku = ?");
    $stmt->execute([$sku]);
    $existingProduct = $stmt->fetch();

    if ($existingProduct) {
        echo "Error: SKU must be unique.";
        exit();
    }

    // Check if the product type is valid
    if (!isset($productTypes[$productType])) {
        echo "Error: Invalid product type.";
        exit();
    }

    // Create an instance of the product type class
    $productClass = $productTypes[$productType];
    switch ($productType) {
        case 'Book':
            $productInstance = new $productClass($sku, $name, $price, 'Book', $_POST['weight']);
            break;
        case 'DVD':
            $productInstance = new $productClass($sku, $name, $price, 'DVD', $_POST['size']);
            break;
        case 'Furniture':
            $productInstance = new $productClass($sku, $name, $price, 'Furniture', $_POST['length'], $_POST['width'], $_POST['height']);
            break;
    }

    // $productInstance = new Book($sku, $name, $price, $_POST['weight']);


    // Save the product
    $productInstance->save($db);

    // Redirect to index.php
    header("Location: index.php");
    exit();
}
