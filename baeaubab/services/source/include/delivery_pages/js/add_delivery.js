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
        document.getElementById("dateSelector").value = "Livraison du " + new Date(selectedDates).frenchDate();
    }
});

document.getElementById("showBtn").addEventListener('click', function () {
    if (firstDate == "")
        swal("Erreur",
            "Veillez choisir une date a afficher SVP!",
            "error");
    else
        location.href = "delivery_homepage.php?new_delivery&date=" + firstDate;
});