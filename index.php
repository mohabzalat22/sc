<?php
// Include the Database and Product classes
include_once 'database.php';
include_once 'product.php';
include_once 'book.php';
include_once 'dvd.php';
include_once 'furniture.php';

// Create a new Database instance
$db = new Database();

// Get all products from the database
$products = [];
$products = array_merge($products, Book::getAll($db));
$products = array_merge($products, DVD::getAll($db));
$products = array_merge($products, Furniture::getAll($db));

?>

<html>

<head>
    <title>Product List</title>
    <link rel="stylesheet" type="text/css" href="styling_list.css">
</head>

<body>
    <h1>Product List</h1>
    <form action="delete_products.php" method="POST">
        <button type="submit" name="delete" id="delete-product-btn">Mass delete</button>
        <button type="button" onclick="window.location.href='form.html'" class="add-button">Add Product</button>
        <?php foreach ($products as $p) : ?>
            <div class="product-box">
                <input type="checkbox" name="selected_products[]" value="<?php echo $p->sku; ?>">
                <input type="hidden" name="selected_types[]" value="<?php echo $p->type; ?>" />
                <p>SKU: <?php echo $p->sku; ?></p>
                <p>Name: <?php echo $p->name; ?></p>
                <p>Price: <?php echo $p->price; ?> $</p>
                <?php if ($p instanceof DVD) : ?>
                    <p>Size: <?php echo $p->getSize(); ?> MB</p>
                <?php elseif ($p instanceof Furniture) : ?>
                    <p>Dimensions: <?php echo $p->getLength() . ' x ' . $p->getWidth() . ' x ' . $p->getHeight(); ?> CM</p>
                <?php elseif ($p instanceof Book) : ?>
                    <p>Weight: <?php echo $p->getWeight(); ?> KG</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </form>
    <?php
    // Close

    // Close the database connection
    $db->closeConnection();
    ?>
    <script src="product_delete.js"></script>
</body>

</html>