/*jshint esversion: 6 */
/*global exports:true*/

//create a date prototype to get the desired date format
Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();
    return [this.getFullYear(),
        (mm > 9 ? '' : '0') + mm,
        (dd > 9 ? '' : '0') + dd,
    ].join('-');
};

//date to french
Date.prototype.frenchDate = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based 
    var dd = this.getDate();
    var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    return [(dd > 9 ? '' : '0') + dd,
        month[mm - 1],
        this.getFullYear()

    ].join(' ');
};

var firstDate = "";
var stock = {};

//create and instanciate flatpickr
flatpickr("#dateSelector", {
    dateFormat: "d F Y",
    minDate: "01-01-2016",
    maxDate: new Date(),
    "locale": {
        "firstDayOfWeek": 1 // start week on Monday
    },
    defaultDate: new Date().frenchDate(),
    onChange: function (selectedDates) {
        firstDate = new Date(selectedDates).yyyymmdd();
        document.getElementById("dateSelector").value = "Production du " + new Date(selectedDates).frenchDate();
    }
});

document.getElementById("showBtn").addEventListener('click', function () {
    location.href = "technic_homepage.php?production_monitoring&action=new&date=" + firstDate;
});

//give the value to the inputs
$(document).ready(function () {

    document.getElementById("newPreformStock05").value = CurrentStockPreform05;
    document.getElementById("newPreformStock19").value = CurrentStockPreform19;
    document.getElementById("newBottleStock05").value = CurrentStockBottle05;
    document.getElementById("newBottleStock19").value = CurrentStockBottle19;

    if (HasRecord) {
        //set old preform stock
        document.getElementById("prevStockPreform05").value = parseInt(CurrentStockPreform05) + parseInt(document.getElementById("produc05").value) + parseInt(document.getElementById("rebus05").value);
        document.getElementById("prevStockPreform19").value = parseInt(CurrentStockPreform19) + parseInt(document.getElementById("produc19").value) + parseInt(document.getElementById("rebus19").value);

        //set total bottle stock
        document.getElementById("totalBottle05").value = parseInt(CurrentStockBottle05) + parseInt(document.getElementById("deliv05").value);
        document.getElementById("totalBottle19").value = parseInt(CurrentStockBottle19) + parseInt(document.getElementById("deliv19").value);

        //set old bottle stock
        document.getElementById("prevStockBottle05").value = parseInt(document.getElementById("totalBottle05").value) - parseInt(document.getElementById("produc05").value);
        document.getElementById("prevStockBottle19").value = parseInt(document.getElementById("totalBottle19").value) - parseInt(document.getElementById("produc19").value);
    } else {
        //set old preform stock
        document.getElementById("prevStockPreform05").value = document.getElementById("prevStockPreform05").value = parseInt(CurrentStockPreform05);
        document.getElementById("prevStockPreform19").value = document.getElementById("prevStockPreform19").value = parseInt(CurrentStockPreform19);

        //set old Bottle stock
        document.getElementById("prevStockBottle05").value = document.getElementById("totalBottle05").value = parseInt(CurrentStockBottle05);
        document.getElementById("prevStockBottle19").value = document.getElementById("totalBottle19").value = parseInt(CurrentStockBottle19);
    }

    stock.oldPreform05 = document.getElementById("prevStockPreform05").value;
    stock.oldPreform19 = document.getElementById("prevStockPreform19").value;
    stock.oldBottle05 = document.getElementById("prevStockBottle05").value;
    stock.oldBottle19 = document.getElementById("prevStockBottle19").value;


    //update to do when the production change
    document.querySelectorAll("#produc05, #produc19").forEach(function (element) {
        //update to do when the production's field get focus and data entered
        element.addEventListener("keyup", function (event) {
            if (checkIfItsInteger(element) && element.textLength > 0) {
                if (element.id == "produc05") {
                    //update the total of available bottle
                    document.getElementById("totalBottle05").value = parseInt(stock.oldBottle05) + parseInt(document.getElementById("produc05").value);

                    document.getElementById("newPreformStock05").value = document.getElementById("rebus05").value.length > 0 ? parseInt(stock.oldPreform05) - parseInt(element.value) - parseInt(document.getElementById("rebus05").value) : parseInt(stock.oldPreform05) - parseInt(element.value);

                    document.getElementById("newBottleStock05").value = (document.getElementById("deliv05").value.length > 0) ? parseInt(document.getElementById("totalBottle05").value) - parseInt(document.getElementById("deliv05").value) : document.getElementById("totalBottle05").value;

                } else {
                    document.getElementById("totalBottle19").value = parseInt(stock.oldBottle19) + parseInt(document.getElementById("produc19").value);

                    document.getElementById("newPreformStock19").value = document.getElementById("rebus19").value.length > 0 ? parseInt(stock.oldPreform19) - parseInt(element.value) - parseInt(document.getElementById("rebus19").value) : parseInt(stock.oldPreform19) - parseInt(element.value);

                    document.getElementById("newBottleStock19").value = (document.getElementById("deliv19").value.length > 0) ? parseInt(document.getElementById("totalBottle19").value) - parseInt(document.getElementById("deliv19").value) : document.getElementById("totalBottle19").value;
                }
            }
        });
        //update to do when the production's field loose focus
        element.addEventListener("blur", function (event) {
            if (element.value.length < 1) {
                //set the value ot zero
                element.value = 0;
                if (element.id == "produc05") {
                    //set the value of the other field
                    document.getElementById("totalBottle05").value = stock.oldBottle05;

                    document.getElementById("newPreformStock05").value = document.getElementById("rebus05").value.length > 0 ? parseInt(stock.oldPreform05) - parseInt(document.getElementById("rebus05").value) : parseInt(stock.oldPreform05);

                    document.getElementById("newBottleStock05").value = (document.getElementById("deliv05").value.length > 0) ? parseInt(document.getElementById("totalBottle05").value) - parseInt(document.getElementById("deliv05").value) : document.getElementById("totalBottle05").value;
                } else if (element.id == "produc19") {
                    //set the value of the other field
                    document.getElementById("totalBottle19").value = stock.oldBottle19;

                    document.getElementById("newPreformStock19").value = document.getElementById("rebus19").value.length > 0 ? parseInt(stock.oldPreform19) - parseInt(document.getElementById("rebus19").value) : parseInt(stock.oldPreform19);

                    document.getElementById("newBottleStock19").value = (document.getElementById("deliv19").value.length > 0) ? parseInt(document.getElementById("totalBottle19").value) - parseInt(document.getElementById("deliv19").value) : document.getElementById("totalBottle19").value;
                }
            }
        });
    });

    //update to do when the delivery change
    document.querySelectorAll("#deliv05, #deliv19").forEach(function (element) {
        var BottleType = element.id.substr(element.id.length - 2);
        element.addEventListener("keyup", function () {
            if (checkIfItsInteger(element) && element.value.length > 0) {
                //get the bottle type (0,5 or 19)
                document.getElementById("newBottleStock" + BottleType).value = parseInt(document.getElementById("totalBottle" + BottleType).value) - parseInt(element.value);
            }
        });

        element.addEventListener("blur", function (event) {
            if (element.value.length < 1) {
                //set the value ot zero
                element.value = 0;
                //get the bottle type (0,5 or 19)
                document.getElementById("newBottleStock" + BottleType).value = parseInt(document.getElementById("totalBottle" + BottleType).value);
            }
        });
    });

    //update to do when the rebus change
    document.querySelectorAll("#rebus05, #rebus19").forEach(function (element) {
        var BottleType = element.id.substr(element.id.length - 2);
        element.addEventListener("keyup", function () {
            if (checkIfItsInteger(element) && element.value.length > 0) {
                if (element.id == "rebus05") {
                    document.getElementById("newPreformStock05").value = (document.getElementById("produc05").value.length > 0) ? parseInt(stock.oldPreform05) - parseInt(element.value) - parseInt(document.getElementById("produc05").value) : parseInt(stock.oldPreform05) - parseInt(element.value);
                } else {
                    document.getElementById("newPreformStock19").value = (document.getElementById("produc19").value.length > 0) ? parseInt(stock.oldPreform19) - parseInt(element.value) - parseInt(document.getElementById("produc19").value) : parseInt(stock.oldPreform19) - parseInt(element.value);
                }
            }
        });
        element.addEventListener("blur", function (event) {
            if (element.value.length < 1) {
                //set the value ot zero
                element.value = 0;
                document.getElementById("newPreformStock" + BottleType).value = document.getElementById("produc" + BottleType).value.length > 0 ? parseInt(document.getElementById("prevStockPreform" + BottleType).value) - parseInt(document.getElementById("produc" + BottleType).value) : document.getElementById("prevStockPreform" + BottleType).value;
            }
        });
    });
});

//verify if the current character is an integer
function checkIfItsInteger(element) {
    var list = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
    if (element.value.length > 0) {
        if (!(element.value.charAt(element.value.length - 1) in list)) {
            swal("ERROR", "Ce champ ne peut contenir que des chiffres", "error").then((value) => {
                element.focus();
            });
            if (element.value.length == 1)
                element.value = "";
            else
                element.value = element.value.substring(0, element.value.length - 1);
        } else {
            if (element.id == "deliv05" || element.id == "deliv19")
                return (checkIfDelivCorrect(element) ? true : false);
            else if (element.id == "produc05" || element.id == "produc19")
                return (checkIfProductionCorrect(element) ? true : false);
            else if (element.id == "rebus05" || element.id == "rebus19")
                return (checkIfRebusCorrect(element) ? true : false);
        }
    }
}

//check if data entered in delivery is correct in regard of the amount of the available bottle
function checkIfDelivCorrect(element) {
    if (element.value.length > 0) {
        var delivered = parseInt(element.value),
            availableBottle = element.id == "deliv05" ? parseInt(document.getElementById("totalBottle05").value) : parseInt(document.getElementById("totalBottle19").value);
        if (delivered > availableBottle) {
            swal("Attention ! Dépassement de stock", "Le nombre de bouteilles livrées ne peut pas être supérieur au nombre de bouteille total disponible. ", "warning");
            if (delivered.length == 1)
                element.value = "";
            else
                element.value = element.value.substring(0, element.value.length - 1);
            return false;
        } else
            return true;
    }
}

//check if data entered in production is correct in regard of the amount of the available preform
function checkIfProductionCorrect(element) {
    if (element.value.length > 0) {
        var production = parseInt(element.value),
            availablePreform = element.id == "produc05" ? parseInt(stock.oldPreform05) : parseInt(stock.oldPreform19),
            rebus = element.id == "produc05" ? parseInt(document.getElementById("rebus05").value) : parseInt(document.getElementById("rebus19").value);
        if ((production + rebus) > availablePreform) {
            swal("Attention ! Dépassement de stock", "La production ne peut pas être supérieur au nombre total de preforme disponible en stock.", "warning");
            if (production.length == 1)
                element.value = "";
            else
                element.value = element.value.substring(0, element.value.length - 1);
            return false;
        } else
            return true;
    }
}

//check if data entered in production is correct in regard of the amount of the available preform
function checkIfRebusCorrect(element) {
    if (element.value.length > 0) {
        var rebus = parseInt(element.value),
            availablePreform = element.id == "rebus05" ? parseInt(stock.oldPreform05) : parseInt(stock.oldPreform19),
            production = element.id == "rebus05" ? parseInt(document.getElementById("produc05").value) : parseInt(document.getElementById("produc19").value);
        if ((production + rebus) > availablePreform) {
            swal("Attention ! Dépassement de stock", "La production ne peut pas être supérieur au nombre total de preforme disponible en stock.", "warning");
            if (production.length == 1)
                element.value = "";
            else
                element.value = element.value.substring(0, element.value.length - 1);
            return false;
        } else
            return true;
    }
}

//check if all the input has been correctly filled
function formValidation() {
    var inputs = document.querySelectorAll(".technicalProduction_input"),
        unfilled05 = 0,
        unfilled19 = 0;

    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].id.substr(-2) == "05") {
            if (inputs[i].value.length <= 0) unfilled05 += 1;
        }
        if (inputs[i].id.substr(-2) == "19") {
            if (inputs[i].value.length <= 0) unfilled19 += 1;
        }
    }

    document.querySelectorAll("#newPreformStock05, #newPreformStock19, #newBottleStock05, #newBottleStock19").forEach(function (element) {
        element.disabled = "";
    });

    if (unfilled05 != 0 && unfilled19 != 0)
        swal({
            title: "Attention",
            text: "Tous les champs ne sont pas remplis! Les champs non remplis auront comme valeur `0`. Voulez-vous toujours continuer?",
            icon: "warning",
            buttons: ["Non", "Oui, continue"],
            dangerMode: false,
        })
        .then((willAdd) => {
            if (willAdd) {
                setLastTwoFields();
                document.querySelector(".tg-wrap form").submit();
            } else {
                document.querySelectorAll("#newPreformStock05, #newPreformStock19, #newBottleStock05, #newBottleStock19").forEach(function (element) {
                    element.disabled = true;
                });
            }
        });
    else {
        setLastTwoFields();
        document.querySelector(".tg-wrap form").submit();
    }
}

//set responsable and visa field
function setLastTwoFields() {
    document.querySelectorAll("#visa05, #visa19, #resp05, #resp19").forEach(function (element) {
        var index = element.id.substring(element.id.length - 2),
            productionValue = parseInt(document.getElementById("produc" + index).value),
            deliveryValue = parseInt(document.getElementById("deliv" + index).value);
        if (((!(isNaN(productionValue))) || (!(isNaN(deliveryValue)))) && element.value.length < 1) {
            element.value = element.placeholder;
        }
    });
}