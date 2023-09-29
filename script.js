//defines 

var max_products = 5;




function addToCart(id) {
    var amount = parseInt(document.getElementById("amount-" + id).innerText);

    if (amount <= 0 || amount > max_products) {
        console.log("Invalid Amount! \n" + new Error().stack);
        displayCartMessage(id, "Ungülte menge", 700)
        return null;
    }

    if (sessionStorage.getItem(id) == null) {
        sessionStorage.setItem(id, amount);
        displayCartMessage(id, "Zum Warenkorb hinzugefügt", 700)
    } else {
        if (amount + parseInt(sessionStorage.getItem(id)) >= max_products) {
            sessionStorage.setItem(id, max_products);
            displayCartMessage(id, `Es können maximal ${max_products} Brote hinzugefügt werden`, 1000)
        } else {
            sessionStorage.setItem(id, amount + parseInt(sessionStorage.getItem(id)));
            displayCartMessage(id, "Zum Warenkorb hinzugefügt", 700)

        }
    }

    
    
}

function displayCartMessage(id, text, time) {
    var cartMessage = document.getElementById("cart-message-" + id);
    cartMessage.innerText = text;
    cartMessage.style.display = "block";
    cartMessage.style.opacity = 1;
   

    setTimeout(function () {
        cartMessage.style.opacity = 0;
    }, time);
}

function changeCart(id, amount) {

    if (amount < 0 || amount > max_products) alert("Amount is invalid");
    else if (amount == 0) {
        sessionStorage.removeItem(id);
        location.reload();
    }
    else {
        sessionStorage.setItem(id, amount);
    }
}


function addAmount(id, editCart) {
    var amount = parseInt(document.getElementById("amount-" + id).innerText);

    if (amount >= max_products) console.log(`Amount can't be larger than ${max_products}!\n" ${new Error().stack}`);
    else {
        if (editCart) {
            document.getElementById("amount-" + id).innerText = amount + 1;
            changeCart(id, amount + 1);
        }else {
            document.getElementById("amount-" + id).innerText = amount + 1;
        }
    }
}


function removeAmount(id, editCart) {
    var amount = parseInt(document.getElementById("amount-" + id).innerText);

    if (amount <= 1) console.log("Amount can't be smaller than 1!\n" + new Error().stack);
    else {
        if (editCart) {
            document.getElementById("amount-" + id).innerText = amount - 1;
            changeCart(id, amount - 1);
        }else {
            document.getElementById("amount-" + id).innerText = amount - 1;
        }
    }

}

function toggleDescription(productId) {
    const moreText = document.getElementById(`more-text-${productId}`);
    const seeMoreButton = document.getElementById(`more-button-${productId}`);

    if (moreText.style.display === 'none' || moreText.style.display === '') {
        moreText.style.display = 'inline'; // Show the remaining description
        seeMoreButton.textContent = '[weniger Anzeigen]';
    } else {
        moreText.style.display = 'none'; // Hide the remaining description
        seeMoreButton.textContent = '[mehr Anzeigen]';
    }
}