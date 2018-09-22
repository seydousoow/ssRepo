//verify if the current character is an integer
function checkIfItsInteger(title) {
    var list = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        inputVal = document.getElementById(title).value,
        inputLen = document.getElementById(title).value.length;
    if (inputLen > 0) {
        if (!(inputVal.charAt(inputLen - 1) in list)) {
            swal("ERROR", "Ce champ ne peut contenir que des chiffres", "error").then((value) => {
                document.getElementById(title).focus();
            });
            if (inputLen == 1)
                document.getElementById(title).value = "";
            else
                document.getElementById(title).value = inputVal.substring(0, inputLen - 1);
        }
    }
}

//do the sum of the previous stock and the amount of bottle the has been produced today and finally set it as the value of the total of bottle
function updateTotalBottle(id) {
    if (document.getElementById("produc" + id).value.length > 0) {
        document.getElementById("totalBottle" + id).value = parseInt(document.getElementById("produc" + id).value) + parseInt(document.getElementById("prevStockBottle" + id).value);
        if (document.getElementById("deliv" + id).value.length > 0) {
            document.getElementById("newBottleStock" + id).value = parseInt(document.getElementById("totalBottle" + id).value) - parseInt(document.getElementById("deliv" + id).value);
        } else
            document.getElementById("newBottleStock" + id).value = document.getElementById("totalBottle" + id).value;
    } else {
        document.getElementById("totalBottle" + id).value = document.getElementById("prevStockBottle" + id).value;
        document.getElementById("newBottleStock" + id).value = document.getElementById("prevStockBottle" + id).value;
    }
}


//update available preform when produced or delivered bottle are done
function updatePreformStock(id, stock) {
    if (document.getElementById("produc" + id).value.length > 0)
        stock -= parseInt(document.getElementById("produc" + id).value);
    if (document.getElementById("rebus" + id).value.length > 0)
        stock -= parseInt(document.getElementById("rebus" + id).value);
    document.getElementById("newPreformStock" + id).value = stock;
}


//update available bottle when delivery added
function updateNewBottleStockOnDelivery(id) {
    if (document.getElementById("deliv" + id).value.length > 0) {
        var delivered = parseInt(document.getElementById("deliv" + id).value),
            availableBottle = parseInt(document.getElementById("totalBottle" + id).value);
        document.getElementById("newBottleStock" + id).value = availableBottle - delivered;
    }
}


//check if data entered in delivery is correct in regard of the amount of the available bottle
function checkIfCorrect(id) {
    if (document.getElementById("deliv" + id).value.length > 0) {
        var delivered = parseInt(document.getElementById("deliv" + id).value),
            availableBottle = parseInt(document.getElementById("totalBottle" + id).value);
        if (delivered > availableBottle) {
            swal("Attention ! Dépassement de stock", "Le nombre de bouteilles livrées ne peut pas être supérieur au nombre de bouteille total disponible. ", "warning");
            if (delivered.length == 1)
                document.getElementById("deliv" + id).value = "";
            else
                document.getElementById("deliv" + id).value = document.getElementById("deliv" + id).value.substring(0, document.getElementById("deliv" + id).value.length - 1);
        }
    }

}

//check if all the input has been correctly filled
function formValidation() {
    var inputs = document.getElementsByTagName("input"),
        temoin = true,
        focusOn = 0;

    for (var i = 1; i < inputs.length; i++) {
        if (i !== 13 && i !== 14 && inputs[i].value.length == 0) {
            if (focusOn == 0) focusOn = i;
            temoin = false;
            inputs[i].style.borderBottom = "2px solid red";
        } else {
            inputs[i].style.borderBottom = "1px dotted darkgray";
        }
    }
    if (temoin)
        document.querySelector(".tg-wrap form").submit();
    else
        swal("Erreur", "Tous les champs ne sont pas remplis! Veillez les remplir", "error").then((value) => {
            inputs[focusOn].focus();
        });

}


//print table
function printData() {
    var divToPrint = document.querySelector(".tg-wrap form");
    newWin = window.open("");
    newWin.document.write(divToPrint.outerHTML);
    newWin.print();
    newWin.close();
}