//create a date prototype to get the desired date format
Date.prototype.yyyymmdd = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();
    return [this.getFullYear(),
        (mm > 9 ? '' : '0') + mm,
        (dd > 9 ? '' : '0') + dd,
    ].join('-');
};

var firstDate = "",
    lastDate = "";

//create and instanciate flatpickr
flatpickr("#dateSelector", {
    dateFormat: "d-F-Y",
    minDate: "01-01-2017",
    maxDate: new Date(),
    "locale": {
        "firstDayOfWeek": 1 // start week on Monday
    },
    // mode: "multiple",
    mode: "range",
    onChange: function (selectedDates) {
        if (selectedDates.length > 1) {
            firstDate = selectedDates[0].yyyymmdd();
            lastDate = selectedDates[1].yyyymmdd();
        } else {
            firstDate = selectedDates[0].yyyymmdd();
            lastDate = "";
        }
    }
});

//do the correct action when the user click on the button
document.getElementById("showBtn").addEventListener("click", function () {
    //check if at least one date has been seleted
    if (firstDate == "")
        swal("Erreur", "Veillez choisir une date ou une range de date a afficher SVP!", "error");
    else
        location.href = "technic_homepage.php?water-treatment&action=view&sheet=1&date1=" + firstDate + "&date2=" +
        lastDate;

});

//date to french
Date.prototype.frenchDate = function () {
    var mm = this.getMonth() + 1; // getMonth() is zero-based
    var dd = this.getDate();
    var month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    return [(dd > 9 ? '' : '0') + dd,
        month[mm-1],
        this.getFullYear()
        
    ].join(' ');
};