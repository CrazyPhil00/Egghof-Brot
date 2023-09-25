<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brot Bestellung</title>
    <link rel="stylesheet" href="design.css">

    <script src="../script.js"></script>

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

<div class="container" id="product-container">

    <script>

    jsProducts.forEach(function(product) {
        for (var i = 0; i < sessionStorage.length; i++) {
            var id = sessionStorage.key(i);
            var amount = sessionStorage.getItem(id);

            if (product.id == id) {
                console.log("Product: " + product.name + " | Amount: " + amount);

                var card = document.createElement('div');
                card.classList.add('product-card');
                card.innerHTML = `
                    <img src="${product.image}" alt="${product.name}">
                    <div class="product-title">${product.name}</div>
                    <div class="product-price">$${product.price.toFixed(2)}</div>
                    <div class="add-to-cart">
                        <button class="amount" onclick="removeAmount(${product.id}, true);">-</button>
                        <a class="amount" id="amount-${product.id}">${amount}</a>
                        <button class="amount" onclick="addAmount(${product.id}, true);">+</button>
                        <button class="remove-button" onclick="changeCart(${product.id}, 0);">Entfernen</button>
                    </div>
            `;
                document.getElementById('product-container').appendChild(card);
                }
        }
        });



    </script>

    

</body>
</html>