/*jshint esversion: 6 */
/*global exports:true*/

for (var i = 1; i < 16; i++) {
    if (data['line' + i].length > 0) {
        for (var j = 0; j < 16; j++) {
            t = j + 1;
            var line = document.querySelector(".line" + i + ".row" + t);
            for (x = 0; x < list_employe.length; x++) {
                if (list_employe[x][4] === data['line' + i][j]) {
                    line.value = list_employe[x][2] + " " + list_employe[x]
                        [1];
                    break;
                } else
                    line.value = data['line' + i][j];
            }
        }
    }
}

//calculate the total
for (var i = 4; i < 15; i++) {
    var row = document.getElementsByClassName("row" + i),
        total = 0;
    for (var j = 0; j < row.length; j++) {
        if (row[j].value.length > 0)
            total = total + parseInt(row[j].value);
    }
    //column that contain the total of each row
    row[row.length - 1].value = total;
}

//set the value for ery line the driver the deliver and the helper
$(document).ready(function () {
    //loop for the number of line (column)
    for (var i = 0; i < 15; i++) {
        //loop for the three first line that contain the driver, deliver and the deliver's helper
        for (var j = 0; j < 3; j++) {
            var line = i + 1,
                row = j + 1;
            //function that open the modal to select an employe
            selectEmploye(line, row);
            var x = document.getElementById("modal-employe");
            for (var k = 0; k < x.length; k++) {
                if (x.options[k].value == listPreselected[i][j]) {
                    x.selectedIndex = k;
                    $("#validate-modal").click();
                    document.getElementById('myModal').style.display =
                        "none";
                }
            }
        }
    }
    //hide the modal
    document.getElementById('myModal').style.display = "none";
    //delete the value that has been automatically added to the form
    for (i = 1; i < 4; i++)
        document.getElementById("form-row" + i).value = "";
});

//function for the modal of the employe selection
function selectEmploye(line, row) {
    var text = "",
        title = document.getElementById("modal-title");
    if (row == 1)
        text = "Selection du livreur";
    else if (row == 2)
        text = "Selection de l'aide livreur";
    else if (row == 3)
        text = "Selection du Chauffeur";

    title.textContent = text;

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
        var selected_line = document.getElementsByClassName("line" +
            line + " row" + row)[0];
        selected_line.value = choice.options[index].text;
        document.getElementById("form-row" + row).value = choice.options[
            index].value;
        modal.style.display = "none";

        var form_row = document.getElementById("form-row" + row);
        form_row.value = choice.value;
        choice.selectedIndex = 0;
    };

    cancel.onclick = function () {
        modal.style.display = "none";
    };
}

function edit(index) {
    var test = false;
    var line = null;

    for (var i = 1; i < 16; i++) {
        if (document.getElementById("save" + i)) {
            test = true;
            line = i;
        }
    }

    if (!(test)) {
        line = document.getElementsByClassName("line" + index);
        for (i = 0; i < line.length; i++) {
            line[i].disabled = false;
        }
        var btn = document.getElementById("editer" + index),
            btn_cancel = document.getElementById("annuler" + index);
        btn_cancel.style.display = "block";
        btn.innerHTML = "Enregistrer";
        btn.removeAttribute("id");
        btn.setAttribute("id", "save" + index);
        btn.removeAttribute("onclick");
        btn.setAttribute("onclick", "save(" + index + ")");

        var choice = document.getElementsByClassName("fa-pen sel_line" + index);
        for (var k = 0; k < choice.length; k++) {
            choice[k].style.pointerEvents = "auto";
            choice[k].style.cursor = "pointer";
        }

    } else alert("la modification de la ligne " + line + " n'est pas encore terminee");

    //disable tab scroll on the buttons of the other line
    for (i = 1; i <= 15; i++) {
        if (document.getElementById("editer" + i) != null)
            document.getElementById("editer" + i).setAttribute("tabindex", "-1");
    }
}

function save(index) {
    index = parseInt(index) - 1;
    var row = document.getElementsByClassName("line" + (index + 1)),
        i = 3,
        t = 0,
        form_equiv = null;

    //set the employe in the form
    for (i = 1; i < 4; i++) {
        if (document.getElementById("form-row" + i).value.length == 0)
            document.getElementById("form-row" + i).value = listPreselected[index][i - 1];
    }

    for (i = 3; i < row.length; i++) {
        t = i + 1;
        form_equiv = document.getElementById("form-row" + t);
        form_equiv.value = (t == 15 || t == 16) ? ((t == 15) ? (row[i].value.length > 0 ? row[i].value : "Aucun client") : (row[i].value.length > 0 ? row[i].value : "Aucune remarque")) : (row[i].value.length > 0 ? row[i].value : "0");
    }

    document.getElementById("form-line").value = index + 1;
    //document.getElementById("new-delivery-form").submit();
}

function annuler(index) {
    swal({
        title: "Annuler",
        text: "Vous êtes sur le point d'annuler vos modifications souhaitez-vous continuer ?",
        type: "warning",
        buttons: ["Annuler", "Continuer"],
        dangerMode: false
    }).then((value) => {
        if (value)
            location.href = "delivery_homepage.php?new_delivery&date=" + numericDateFormat;
    });
}