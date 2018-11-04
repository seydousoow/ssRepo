/*jshint esversion: 6 */
/*global exports:true*/

var lineregion = null;

$(document).ready(function () {
    //if the user click on edit button on one of the edit button
    document.querySelectorAll(".edit-region").forEach(function (element) {
        element.addEventListener("click", function () {
            if (!document.getElementById("save-region")) {
                var element_index = element.id.toString().substr(6),
                    cancel_btn = document.getElementById("cancel-region-" + element_index);
                //edit the clicked button
                element.innerHTML = "Enregistrer";
                element.setAttribute("class", "btn btn-primary");
                element.setAttribute("id", "save-region");
                element.setAttribute("onclick", "submitDeliveryRegion()");

                //show the cancel button
                cancel_btn.style.display = "block";

                //enable the inputs of the selected line
                var temoin = false;
                document.querySelectorAll(".region" + element_index).forEach(function (ele) {
                    ele.disabled = false;
                    if (!(temoin)) {
                        ele.focus();
                        temoin = true;
                    }
                });
                //set the number of the line
                lineregion = element_index;
                //disabled the others edit button
                document.querySelectorAll(".edit-region").forEach(function (ele) {
                    ele.disabled = true;
                });
                document.querySelectorAll(".edit-delivery-btn").forEach(function (ele) {
                    ele.disabled = true;
                });
                var row = 2,
                    boucle = 1;

                //set the pen selector for employe selection button
                document.querySelectorAll(".fa-pen-region" + lineregion).forEach(function (ele) {
                    ele.style.pointerEvents = "auto";
                    ele.style.cursor = "pointer";
                    ele.setAttribute("onclick", "selectRegionEmploye(" + lineregion + ", " + row + ")");
                    if (boucle == 1)
                        boucle = 2;
                    else {
                        boucle = 1;
                        row++;
                    }
                });

                //auto select previous existing data if edition is started
                if (listData[lineregion])
                    showPreviousData(lineregion);
                // else
                //     document.querySelector(".idRegion.region" + lineregion).selected =


            }
        });
    });

    //set the region on change
    document.querySelectorAll(".idRegion").forEach(function (element) {
        element.addEventListener("change", function () {
            document.getElementById("form-region0").value = this.value;
        });
    });

    //set the data that already exist
    for (i = 0; i < listData.length; i++) {
        showPreviousData(i);
        if (!document.getElementById("save-region")) {
            for (var j = 1; j <= 3; j++)
                document.getElementById("form-region" + j).removeAttribute("value");
        }
    }

    //calculate and set the total for each row
    for (i = 5; i <= 15; i++) {
        calculateAndSetTotal(i);
    }
});

//function to set the show the previous data
function showPreviousData(index) {
    if (listData[index].length > 0) {
        var j = 0;
        //get the line
        var ligne = listData[index][17];
        //get the select tag of the list of region
        var select = document.querySelector(".idRegion.region" + ligne);
        // set the region as selected
        for (j = 1; j < select.length; j++) {
            if (select[j].innerHTML == listData[index][0]) {
                select[j].selected = 'selected';
                if (document.getElementById("save-region") != null)
                    document.getElementById("form-region0").value = select[j].value;
            }
        }

        //loop for inputs
        for (j = 5; j <= 17; j++) {
            document.querySelector(".region" + ligne + ".rowRegion" + j).value = listData[index][j - 1];
        }
        //set the employee
        for (j = 2; j <= 4; j++) {
            selectRegionEmploye(ligne, j);
            var x = document.getElementById("modal-employe");
            for (var k = 0; k < x.length; k++) {
                if (x.options[k].value == listData[index][j - 1]) {
                    x.selectedIndex = k;
                    $("#validate-modal").click();
                    document.getElementById('myModal').style.display =
                        "none";
                }
            }
        }

    }
}

//do the sum of each row then set the sum in the total row cell
function calculateAndSetTotal(index) {
    var total = null;
    document.querySelectorAll(".rowRegion" + index).forEach(function (element) {
        if (element.value.length > 0)
            total += parseInt(element.value);
    });

    document.querySelector(".rowTotal" + index).value = total != null ? total : "";
}

//if the user cancel the editing
function cancelDelivery() {
    swal({
        title: "Annuler",
        text: "Vous êtes sur le point d'annuler vos modifications souhaitez-vous continuer ?",
        icon: "warning",
        buttons: ["Annuler", "Continuer"],
        dangerMode: false
    }).then((value) => {
        if (value)
            location.href = "delivery_homepage.php?new_delivery&date=" + numericDateFormat;
    });
}

//function for the modal of the employe selection
function selectRegionEmploye(line, row) {
    var text = "",
        title = document.getElementById("modal-title");
    if (row == 2)
        text = "Selection du livreur";
    else if (row == 3)
        text = "Selection de l'aide livreur";
    else if (row == 4)
        text = "Selection du Chauffeur";

    title.textContent = text;
    document.getElementById("modal-employe").focus();

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Open the modal
    modal.style.display = "block";

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    var validate = document.getElementById("validate-modal"),
        cancel = document.getElementById("cancel-modal");

    validate.onclick = function () {
        var choice = document.getElementById("modal-employe"),
            index = choice.selectedIndex;
        var selected_line = document.getElementsByClassName("region" +
            line + " rowRegion" + row)[0];
        selected_line.value = choice.options[index].text;
        document.getElementById("form-region" + (row - 1)).value = choice.options[
            index].value;
        modal.style.display = "none";

        var form_row = document.getElementById("form-row" + (row - 1));
        form_row.value = choice.value;
        choice.selectedIndex = 0;
    };

    cancel.onclick = function () {
        modal.style.display = "none";
    };
}

//check if the value is an integer when necessary
document.querySelectorAll(".isInt").forEach(function (element) {
    element.addEventListener("keyup", function () {
        var integers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            val = element.value,
            len = element.value.length;
        if (len > 0 && !(val.substr(len - 1) in integers)) {
            swal("Erreur", "Ce champ ne peut contenir que des chiffres!", "error").then((value) => {
                element.value = val.substr(0, len - 1);
                element.focus();
            });
        }
    });
});



//if the user click on save
function submitDeliveryRegion() {
    //verify if a region has been selected
    var temoinRegion = (isNaN(parseInt(document.getElementById("form-region0").value))) ? false : true;

    //check if at least on employe has been selected
    var temoinEmploye = false;
    for (var i = 1; i < 4; i++) {
        if (document.getElementById("form-region" + i).value.length > 0) {
            temoinEmploye = true;
            break;
        }
    }
    if (!temoinRegion)
        swal("Erreur", "Veillez selectionner une region svp!", "error").then((value) => {
            if (value) {
                document.querySelector(".region" + lineregion).focus();
            }
        });
    else if (!temoinEmploye)
        swal("Erreur", "La ligne doit avoir au moins un employé! Veuillez sélectionner un employé SVP!", "warning");

    //set the datas if they exist. if not put a zero
    if (temoinEmploye === true && temoinRegion == true) {
        //set null user if no user selected
        for (let i = 1; i <= 3; i++) {
            var input = document.getElementById("form-region" + i);
            if (input.value.length == 0) input.value = "2018-liv-0043";
        }
        //set the bottles data to 0 if no data entered
        for (let i = 5; i <= 15; i++) {
            let input = document.querySelector(".region" + lineregion + ".rowRegion" + i);
            if (input.value.length == 0) input.value = 0;
            document.getElementById("form-region" + (i - 1)).value = input.value;
        }
        //set the textbox to default if no data entered
        //for the client special delivery
        if (document.querySelector(".region" + lineregion + ".rowRegion16").value.length == 0)
            document.querySelector(".region" + lineregion + ".rowRegion16").value = "Aucun Client";
        document.getElementById("form-region15").value = document.querySelector(".region" + lineregion + ".rowRegion16").value;
        //for the remarks
        if (document.querySelector(".region" + lineregion + ".rowRegion17").value.length == 0)
            document.querySelector(".region" + lineregion + ".rowRegion17").value = "Pas de remarque";
        document.getElementById("form-region16").value = document.querySelector(".region" + lineregion + ".rowRegion17").value;
        //set the line
        document.getElementById("form-line-region").value = lineregion;

        //submit the form
        document.getElementById("new-delivery-region-form").submit();
    }

}