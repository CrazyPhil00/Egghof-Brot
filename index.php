<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brot Bestellung</title>
    <link rel="stylesheet" href="design.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="script.js"></script>
</head>
<body>
<div class="menu-bar">
    <img  class="logo" src="img/logo.png" alt="">
    <span href="./cart/index.php" class="material-symbols-outlined">shopping_basket</span>
    <a href="/cart/">Wagen</a>
</div>

<div class="container">
<?php
    $jsonFile = 'data.json';
    $products = json_decode(file_get_contents($jsonFile), true);

    if ($products) {
        foreach ($products as $product) {
            echo '<div class="product-card">';
            echo '<img src="' . $product['image'] . '" alt="' . $product['name'] . '">';
            echo '<div class="product-title">' . $product['name'] . '</div>';
            echo '<div class="product-price">' . number_format($product['price'], 2) . '€</div>';
            echo '<div class="product-description">';
            $shortenedDescription = substr($product['description'], 0, 40);
            $remainingDescription = substr($product['description'], 40);
            echo $shortenedDescription;
            echo '<span class="more-text" id="more-text-' . $product['id'] . '">' . $remainingDescription . '</span>';
            echo '<span class="see-more-button" id="more-button-' . $product['id'] . '" onclick="toggleDescription(' . $product['id'] . ');"> [mehr Anzeigen]</span>';

            echo '</div>';
            echo '<div class="add-to-cart">';
            echo '<button class="amount" onclick="removeAmount(' . $product['id'] . ', false);">-</button>';
            echo '<a class="amount" id="amount-' . $product['id'] . '">1</a>';
            echo '<button class="amount" onclick="addAmount(' . $product['id'] . ', false);">+</button>';
            echo '<button class="cart-button" onclick="addToCart(' . $product['id'] . ');">HINZUFÜGEN</button>';
            echo '<div id="cart-message-' . $product['id'] . '" class="cart-message"></div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'No products found.';
    }
?>
</div>
</body>
</html>
