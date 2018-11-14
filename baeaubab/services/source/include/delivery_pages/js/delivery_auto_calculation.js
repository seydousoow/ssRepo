/*jshint esversion: 6 */
/*global exports:true*/

//auto calculation of the data entered to reduce the number of modification and the reduce the amount of time to increase performance and rapidity.

var loaded = null,
    delivered = null,
    consignated = null,
    deconsignated = null,
    r_full = null,
    r_empty = null,
    r_lended = null,
    lended = null,
    warehouse_drilled = null,
    car_drilled = null,
    lost = null,
    line_index = null;

function assign_variable_region() {
    loaded = document.querySelector(".region" + line_index + ".rowRegion5");
    delivered = document.querySelector(".region" + line_index + ".rowRegion6");
    consignated = document.querySelector(".region" + line_index + ".rowRegion7");
    deconsignated = document.querySelector(".region" + line_index + ".rowRegion8");
    r_full = document.querySelector(".region" + line_index + ".rowRegion9");
    r_empty = document.querySelector(".region" + line_index + ".rowRegion10");
    r_lended = document.querySelector(".region" + line_index + ".rowRegion11");
    lended = document.querySelector(".region" + line_index + ".rowRegion12");
    warehouse_drilled = document.querySelector(".region" + line_index + ".rowRegion13");
    car_drilled = document.querySelector(".region" + line_index + ".rowRegion14");
    lost = document.querySelector(".region" + line_index + ".rowRegion15");
}

function assign_variable_dakar() {
    loaded = document.querySelector(".line" + line_index + ".row4");
    delivered = document.querySelector(".line" + line_index + ".row5");
    consignated = document.querySelector(".line" + line_index + ".row6");
    deconsignated = document.querySelector(".line" + line_index + ".row7");
    r_full = document.querySelector(".line" + line_index + ".row8");
    r_empty = document.querySelector(".line" + line_index + ".row9");
    r_lended = document.querySelector(".line" + line_index + ".row10");
    lended = document.querySelector(".line" + line_index + ".row11");
    warehouse_drilled = document.querySelector(".line" + line_index + ".row12");
    car_drilled = document.querySelector(".line" + line_index + ".row13");
    lost = document.querySelector(".line" + line_index + ".row14");
}

//function that do all the calculs required and check up the data entered
function auto_calculation() {
    if (loaded.value.length > 0 && delivered.value.length > 0) {
        var test = true;
        //if the delivery cell loose the focus and its superior to the loaded champ, then throw an error
        delivered.addEventListener("blur", function (element) {
            if (parseInt(loaded.value) < parseInt(delivered.value))
                swal("Erreur", "Le nombre de bouteille chargee ne peut etre inferieur au nombre de bouteille livree. Veuillez verifer les donnees inserees SVP!", "error").then((value) => {
                    if (value) {
                        delivered.value = delivered.value.substr(0, delivered.value.length - 1);
                        test = false;
                        delivered.focus();
                    }
                });
        });
        if (test) {
            r_full.value = parseInt(loaded.value) - parseInt(delivered.value);
            r_empty.value = parseInt(delivered.value);
            if (consignated.value.length > 0)
                r_empty.value = parseInt(r_empty.value) - parseInt(consignated.value);
            if (deconsignated.value.length > 0)
                r_empty.value = parseInt(r_empty.value) + parseInt(deconsignated.value);
            if (r_lended.value.length > 0)
                r_empty.value = parseInt(r_empty.value) + parseInt(r_lended.value);
            if (lended.value.length > 0)
                r_empty.value = parseInt(r_empty.value) - parseInt(lended.value);
            if (warehouse_drilled.value.length > 0)
                r_full.value = parseInt(r_full.value) - parseInt(warehouse_drilled.value);
            if (car_drilled.value.length > 0)
                r_full.value = parseInt(r_full.value) - parseInt(car_drilled.value);
            if (lost.value.length > 0)
                r_full.value = parseInt(r_full.value) - parseInt(lost.value);
        }
    }
}

//function that create event on selected input when the user type a key (for the region)
function createEventRegion(index) {
    document.querySelector(".region" + line_index + ".rowRegion" + index).addEventListener("keyup", function (element) {
        auto_calculation();
    });
}

//function that create event on selected input when the user type a key (for the region)
function createEventDakar(index) {
    document.querySelector(".line" + line_index + ".row" + index).addEventListener("keyup", function (element) {
        auto_calculation();
    });
}

//if the user click on edit button on one of the edit button of region's table
document.querySelectorAll(".edit-region").forEach(function (element) {
    element.addEventListener("click", function () {
        if (!document.getElementById("save-region")) {
            var line_index = element.id.toString().substr(6);
            assign_variable_region();
            //add even to the input to grab when the user enter a key and do checking and calculation needed
            for (var i = 5; i <= 15; i++)
                createEventRegion(i);
        }
    });
});

//if the user click on edit button on one of the edit button on Dakar's table
document.querySelectorAll(".edit-delivery-btn").forEach(function (element) {
    element.addEventListener("click", function () {
        line_index = element.id.toString().substr(4);
        assign_variable_dakar();
        //add even to the input to grab when the user enter a key and do checking and calculation needed
        for (var i = 4; i <= 14; i++)
            createEventDakar(i);
    });
});