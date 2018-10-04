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