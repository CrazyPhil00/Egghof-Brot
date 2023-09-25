

function addToCart(id) {

    var amount = parseInt(document.getElementById("amount-" + id).innerText);

    if (amount <= 0 || amount > 10) {
        console.log("Invalid Amount! \n" + new Error().stack);
        return null;
    }

    console.log(id, amount);

    if (sessionStorage.getItem(id) == null) sessionStorage.setItem(id, amount);
    else{
        if (amount + parseInt(sessionStorage.getItem(id)) >= 10) {
            sessionStorage.setItem(id, 10);
        }else {
            sessionStorage.setItem(id, amount + parseInt(sessionStorage.getItem(id)));
        }
    }
}

function changeCart(id, amount) {

    if (amount < 0 || amount > 10) alert("Amount is invalid");
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

    if (amount >= 10) console.log("Amount can't be larger than 10!\n" + new Error().stack);
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