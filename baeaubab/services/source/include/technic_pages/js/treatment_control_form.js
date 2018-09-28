//to resolve jshint6 warning
/*jshint esversion: 6 */

//disable input autocompletion
document.querySelectorAll("input[type=text]").forEach(function(element){
    element.autocomplete = "off";
});

// when user click on the edit btn of the first sheet
document.getElementById("editTreatmentControlBtn1").addEventListener('click', function () {
    //set changement in the button
    this.textContent = "Enregistrer";
    this.setAttribute("id", "saveTreatmentControlBtn1");
    this.setAttribute("onclick", "saveSheet1()");
    //enable the inputs
    document.querySelectorAll(".control1").forEach(function (element) {
        element.disabled = false;
        element.style.backgroundColor = "#D2E4FC";
    });
    //set the focus
    document.querySelector(".control1").focus();
    //disable the other button. two editions cant be done at the same time
    document.getElementById("editTreatmentControlBtn2").style.pointerEvents = "none";
});

// when user click on the edit btn of the first sheet
document.getElementById("editTreatmentControlBtn2").addEventListener('click', function () {
    //set changement in the button
    this.textContent = "Enregistrer";
    this.setAttribute("id", "saveTreatmentControlBtn2");
    this.setAttribute("onclick", "saveSheet2()");
    //enable the inputs
    document.querySelectorAll(".control2").forEach(function (element) {
        element.disabled = false;
        element.style.backgroundColor = "#D2E4FC";
    });
    //set the focus
    document.querySelector(".control2").focus();
    //disable the other button. two editions cant be done at the same time
    document.getElementById("editTreatmentControlBtn1").style.pointerEvents = "none";
});

//check if the user's data are integers
var listInteger = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
document.querySelectorAll(".control1, .control2").forEach(function (element) {
    element.addEventListener("keyup", function () {
        //if there is at least one character and the last typed character is different from the characters that are in the list of integers
        if (element.value.length > 0 && ( (!(element.value.charAt(element.value.length - 1) in listInteger)) &&  (element.value.charAt(element.value.length - 1) != ",") ) ) {
            //remove the foreign character
            element.value = element.value.replace(element.value.charAt(element.value.length - 1), "");
            //show an alert
            swal("Attention", "Ce champ ne peut contenir que des caractères numériques et éventuellement le point \".\" pour les numéros à virgule!", "warning").then((value) => {
                //give back the focus to the element
                element.focus();
            });
        }
    });
});

//when user save the sheet 1
function saveSheet1() {
    //check if all the input have been filled
    var bool = true;
    document.querySelectorAll(".control1").forEach(element => {
        if (element.value.length <= 0) {
            bool = false;
            element.style.borderBottom = "2px groove red";
            swal("Error", "Tous les champs sont requis. Veillez remplir tous les champs soulignes en rouge SVP!", "error");

        } else
            element.style.borderBottom = "none";
    });
    if (bool) {
        document.getElementById("treatmentForm1").submit();
    }
}

//when user save the sheet 2
function saveSheet2() {
    //check if all the input have been filled
    var bool = true;
    document.querySelectorAll(".control2").forEach(element => {
        if (element.value.length <= 0) {
            bool = false;
            element.style.borderBottom = "2px groove red";
            swal("Error", "Tous les champs sont requis. Veillez remplir tous les champs soulignes en rouge SVP!", "error");

        } else
            element.style.borderBottom = "none";
    });
    if (bool) {
        document.getElementById("treatmentForm2").submit();
    }
}