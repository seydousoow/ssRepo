$(document).ready(function () {
    //fill the correct data for unaccessible data to the user
    var prod05 = document.getElementById("produc05").value,
        deliv05 = document.getElementById("deliv05").value,
        rebus05 = document.getElementById("rebus05").value,
        newPreformStock05 = document.getElementById("newPreformStock05").value,
        newBottleStock05 = document.getElementById("newBottleStock05").value,
        prod19 = document.getElementById("produc19").value,
        deliv19 = document.getElementById("deliv19").value,
        rebus19 = document.getElementById("rebus19").value,
        newPreformStock19 = document.getElementById("newPreformStock19").value,
        newBottleStock19 = document.getElementById("newBottleStock19").value;

    document.getElementById("prevStockPreform05").value = (parseInt(prod05) + parseInt(rebus05) + parseInt(newPreformStock05));
    document.getElementById("prevStockPreform19").value = (parseInt(prod19) + parseInt(rebus19) + parseInt(newPreformStock19));
    document.getElementById("prevStockBottle05").value = ((parseInt(deliv05) + parseInt(newBottleStock05)) - parseInt(prod05));
    document.getElementById("prevStockBottle19").value = ((parseInt(deliv19) + parseInt(newBottleStock19)) - parseInt(prod19));
    document.getElementById("totalBottle05").value = (parseInt(document.getElementById("prevStockBottle05").value) + parseInt(prod05));
    document.getElementById("totalBottle19").value = (parseInt(document.getElementById("prevStockBottle19").value) + parseInt(prod19));

});

//validate form when key enter is pressed
$('input[type=text]').on('keydown', function (e) {
    if (e.which == 13 || event.keyCode == 13) {
        formValidation();
    }
});

//do the actions needed when the user press a key
//for production of 05 bottle input
document.getElementById("produc05").addEventListener('keyup', function () {
    if (checkIfItsInteger("produc05")) {
        updateTotalBottle("05");
        if (checkIfCorrect2("produc05", document.getElementById("prevStockPreform05").value, "05"))
            updatePreformStock("05", document.getElementById("prevStockPreform05").value);
    }
});

//for production of 19 bottle input
document.getElementById("produc19").addEventListener('keyup', function () {
    if (checkIfItsInteger("produc19")) {
        updateTotalBottle("19");
        if (checkIfCorrect2("produc19", document.getElementById("prevStockPreform19").value, "19"))
            updatePreformStock("19", document.getElementById("prevStockPreform19").value);
    }
});

//for delivery of 05 bottle input
document.getElementById("deliv05").addEventListener('keyup', function () {
    if (checkIfItsInteger("deliv05")) {
        if (checkIfCorrect("05"))
            updateNewBottleStockOnDelivery("05");
    }
});

//for delivery of 19 bottle input
document.getElementById("deliv19").addEventListener('keyup', function () {
    if (checkIfItsInteger("deliv19")) {
        if (checkIfCorrect("19"))
            updateNewBottleStockOnDelivery("19");
    }
});

//for scrap of 05 bottle input
document.getElementById("rebus05").addEventListener('keyup', function () {
    if (checkIfItsInteger("rebus05")) {
        if (checkIfCorrect2("rebus05", document.getElementById("prevStockPreform05").value, "05"))
            updatePreformStock("05", document.getElementById("prevStockPreform05").value);
    }
});

//for scrap of 05 bottle input
document.getElementById("rebus19").addEventListener('keyup', function () {
    if (checkIfItsInteger("rebus19")) {
        if (checkIfCorrect2("rebus19", document.getElementById("prevStockPreform19").value, "19"))
            updatePreformStock("19", document.getElementById("prevStockPreform19").value);
    }
});

//verify if the current character entered by the user is an integer
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
            return false;
        } else return true;
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
            return false;
        } else return true;
    }
}

//check if the value of scrap or production and their sum also are not superior to the available preform.
function checkIfCorrect2(field, preformStock, typeBottle) {
    var test = true,
        fieldValue = parseInt(document.getElementById(field).value),
        availablePreform = parseInt(preformStock);
    //check the field it self
    if (fieldValue.toString.length > 0) {
        if (fieldValue > availablePreform) {
            swal("Attention ! Dépassement de stock", "Attention ! Vous avez dépassé le nombre de préformes disponibles en stock. Veuillez corriger vos données SVP!", "warning");
            if (fieldValue.toString.length == 1)
                document.getElementById(field).value = "";
            else
                document.getElementById(field).value = document.getElementById(field).value.substring(0, document.getElementById(field).value.length - 1);
            test = false; //the first test did not succeed
        }
    }
    //check if the sum of production field and scrap field are less or equal to the amount of available preform
    if (test == true) {
        var produc = "produc" + typeBottle,
            rebus = "rebus" + typeBottle,
            prodField = parseInt(document.getElementById(produc).value),
            rebusField = parseInt(document.getElementById(rebus).value);
        if (prodField.toString.length > 0 && rebusField.toString.length > 0) {
            if ((prodField + rebusField) > availablePreform) {
                swal("Attention ! Dépassement de stock", "Attention ! La somme des bouteilles produites et des rebuts est supérieure au nombre de préformes disponibles en stock. Veuillez corriger vos données s'il vous plaît!", "warning");
                if (fieldValue.length == 1)
                    document.getElementById(field).value = "";
                else
                    document.getElementById(field).value = document.getElementById(field).value.substring(0, document.getElementById(field).value.length - 1);
                test = false; //the second test did not succeed
            }
        }
    }
    return test;
}

//check if all the input has been correctly filled
function formValidation() {
    var inputs = document.getElementsByTagName("input"),
        temoin = true,
        focusOn = 0;

    for (var i = 5; i < inputs.length; i++) {
        if (i !== 13 && i !== 14 && i !== 19 && i !== 20 && i !== 21 && i !== 22 && i !== 27 && inputs[i].value.length == 0) {
            console.log(inputs[i], i);
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