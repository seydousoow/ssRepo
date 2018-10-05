//to resolve jshint6 warning
/*jshint esversion: 6 */

$(document).ready(function () {
    var stockArea = document.querySelectorAll(".tg-0gk5");
    for (var i = 0; i < 2; i++) {
        var value = stockArea[i].innerHTML;
        stockArea[i].style.color = "white";
        if (value <= 10000) {
            stockArea[i].style.backgroundColor = "red";
        } else if (value > 10000 && value <= 50000)
            stockArea[i].style.backgroundColor = "orange";
        else if (value > 50000)
            stockArea[i].style.backgroundColor = "green";
    }
});

document.getElementById("addstock05").addEventListener('keyup', function () {
    if (this.value.length > 0) {
        if (checkIfItsInteger("addstock05")) {
            document.getElementById("newStock05").value = (parseInt(document.getElementById("oldStock05").innerText) + parseInt(this.value));
        }
    } else {
        document.getElementById("newStock05").value = (parseInt(document.getElementById("oldStock05").innerText));
    }
});


document.getElementById("addstock19").addEventListener('keyup', function () {
    if (this.value.length > 0) {
        if (checkIfItsInteger("addstock19")) {
            document.getElementById("newStock19").value = (parseInt(document.getElementById("oldStock19").innerText) + parseInt(this.value));
        }
    } else {
        document.getElementById("newStock19").value = (parseInt(document.getElementById("oldStock19").innerText));
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

document.getElementById("validateUpdate").addEventListener('click', function () {
    var text = "Vous êtes sur le point d'effectuer les mises à jour suivantes:<br/>Nouveau stock de <b></b>préformes de 0,5L</b>: <u>" +
        document.getElementById("newStock19").value + "</u><br/>Nouveau stock de <b>préformes 19L</b>: <u>" + document.getElementById("newStock19").value + "</u><br/> Souhaitez vous continuer?";
    swal({
        title: '<strong><u>Mise à jour des préformes:</u></strong>',
        type: 'info',
        html: text,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Confirmer',
        confirmButtonAriaLabel: 'Thumbs up, great!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> Annuler',
        cancelButtonAriaLabel: 'Thumbs down',
    }).then((result) => {
        if (result.value)
            document.getElementById("formUpdate").submit();
    });
});