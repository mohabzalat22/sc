<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["selected_products"]) && $_POST["selected_types"]) {
    $selectedProducts = $_POST["selected_products"];
    $selectedtypes = $_POST["selected_types"];
    $db = new Database();

    for ($i = 0; $i < count($selectedProducts); $i++) {
        echo $selectedtypes[$i];
        echo $selectedProducts[$i];

        switch ($selectedtypes[$i]) {
            case 'book':
                $sql = "DELETE FROM book_table WHERE sku=?";
                $stmt = $db->getConnection()->prepare($sql);
                $stmt->execute([$selectedProducts[$i]]);
                break;

            case 'dvd':
                $sql = "DELETE FROM dvd_table WHERE sku=?";
                $stmt = $db->getConnection()->prepare($sql);
                $stmt->execute([$selectedProducts[$i]]);
                break;

            case 'furniture':
                $sql = "DELETE FROM furniture_table WHERE sku=?";
                $stmt = $db->getConnection()->prepare($sql);
                $stmt->execute([$selectedProducts[$i]]);
                break;
        }
    }

    $db->closeConnection();
    header("Location: index.php");
    exit();
} else {
    header("Location: index.php");
    exit();
}
