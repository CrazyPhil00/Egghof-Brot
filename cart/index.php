<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brot Bestellung</title>
    <link rel="stylesheet" href="design.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script src="../script.js"></script>

</head>
<body>

<div class="menu-bar">
    <img  class="logo" src="img/logo.png" alt="">
    <span href="./cart/index.php" class="material-symbols-outlined">shopping_basket</span>
    <a href="/cart/">Wagen</a>
</div>
    
    

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

    <div class="cart" id="cart">


    </div>

    

    <script>

        if (sessionStorage.length <= 0) {
                        var card = document.createElement('div');
                            card.classList.add('product-card');
                            card.innerHTML = `
                                Nichts im Warenkorb!
                        `;
                            document.getElementById('cart').appendChild(card);
                    }

        jsProducts.forEach(function(product) {
            
            for (var i = 0; i < sessionStorage.length; i++) {
                var id = sessionStorage.key(i);
                var amount = sessionStorage.getItem(id);

                if (product.id == id) {
                    console.log("Product: " + product.name + " | Amount: " + amount);

                    var card = document.createElement('div');
                    card.classList.add('product-card');
                    card.innerHTML = `
                        <div class="item">
                            <img src="${product.image}" alt="${product.name}">
                            <div class="item-info">
                                <h3>${product.name}</h3>
                                <p>${product.price.toFixed(2)}€</p>
                            </div>
                            <div class="item-actions">
                                <button class="amount" onclick="removeAmount(${product.id}, true);">-</button>
                                <a class="amount" id="amount-${product.id}">${amount}</a>
                                <button class="amount" onclick="addAmount(${product.id}, true);">+</button><br>
                                <button class="remove" onclick="changeCart(${product.id}, 0);">Entfernen</button>
                            </div>
                        </div>
                `;
                    document.getElementById('cart').appendChild(card);
                    }
            }
            });

                        

    </script>


    <div>

            <a href="../checkout/">Checkout</a>

    </div>

    

</body>
</html>