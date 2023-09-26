<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    


    <style>

/* Reset some default styles */
body, div, h2, form, label, input, span, button {
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
}

.menu-bar {
    background-color: #333;
    color: white;
    text-align: center;
    padding: 10px 0;
}

.menu-bar .logo {
    width: auto;
    height: 40px;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.checkout-form {
    max-width: 400px;
    margin: 0 auto;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

label {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    display: block;
    margin-bottom: 5px;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

#total-cost {
    display: inline-block;
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-top: 10px;
}

.checkout-button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #333;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.checkout-button:hover {
    background-color: #555;
}


    </style>


</head>
<body>

    <?php

    $jsonFile = '../data.json';
    $products = json_decode(file_get_contents($jsonFile), true);

    if ($products) {
        $jsArray = [];

        foreach ($products as $product) {
            $jsArray[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'description' => $product['description'],
                'image' => $product['image'],
            ];
        }

        $jsArrayJSON = json_encode($jsArray, JSON_UNESCAPED_SLASHES);
        
        echo "<script>";
        echo "var jsProducts = {$jsArrayJSON};";
        echo "</script>";

    }

    ?>

    <script>
    var price = 0;
    jsProducts.forEach(function(product) {
                
                for (var i = 0; i < sessionStorage.length; i++) {
                    var id = sessionStorage.key(i);
                    var amount = sessionStorage.getItem(id);
                    

                    if (product.id == id) {
                        price += product.price * amount;
                    }
                }
            });


    
    </script>

<div class="menu-bar">
    <img class="logo" src="img/logo.png" alt="">
    <span href="./cart/index.php" class="material-symbols-outlined">shopping_basket</span>
    <a href="/cart/">Wagen</a>
</div>

<div class="container">
    <div class="checkout-form">
        <h2>Checkout</h2>
        <form action="process.php" method="POST"> <!-- Create a PHP script for processing checkout data -->
            <div class="form-group">
                <label for="room-id">Appartment Nummer:</label>
                <input type="text" id="room-id" name="room_id" required>
            </div>
            <div class="form-group">
                <label for="second-name">Nachname:</label>
                <input type="text" id="second-name" name="second_name" required>
            </div>
            <div class="form-group">
                <label for="total-cost">Gesamte Kosten:</label>
                <span id="total-cost">0.00€</span>
            </div>
            <input type="hidden" id="product-data" name="product_data">
            <button type="submit" class="checkout-button">Checkout</button>
        </form>
    </div>
</div>

<script>

    
var products = [];

for (var i = 0; i < sessionStorage.length; i++) {
    var key = sessionStorage.key(i);
    var value = sessionStorage.getItem(key);

    var productId = parseInt(key);

    var quantity = parseInt(value);

    var productData = {
        'id': productId,
        'amount': quantity,
    };

    products.push(productData);
}

var productDataJSON = JSON.stringify(products);

document.getElementById('product-data').value = productDataJSON;


    document.getElementById("total-cost").innerText=price.toFixed(2) + "€";

</script>
</body>
</html>
