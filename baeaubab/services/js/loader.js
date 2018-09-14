// Wait for window load
$(window).on('load', function () {
    $('.loader').fadeOut(1000);
    new WOW().init();
});

//    var ele = document.querySelectorAll('.head2menu li'),
//        i = 0;
//
//    if (sessionStorage.getItem("activeTab")) {
//        var index = sessionStorage.getItem("activeTab");
//        for (i = 0; i < ele.length; i++) {
//            if (ele[i].hasAttribute("class"))
//                ele[i].removeAttribute("class");
//        }
//        ele[index].setAttribute("class", "active");
//        sessionStorage.removeItem("activeTab");
//    } else {
//        ele[0].setAttribute("class", "active");
//    }
//
//    //inject the css of the header
//    var link = document.createElement("link");
//    link.id = "headerLink";
//    link.href = "css/header.css";
//    link.rel = "stylesheet";
//    document.getElementsByTagName("head")[0].appendChild(link);


////hise some part of the header on scrool
//
//$(document).on('scroll', function () {
//    var scrollTop = document.documentElement.scrollTop,
//        head = document.getElementById("head3");
//
//    if (Number(scrollTop) >= 50)
//        head.style.display = "none";
//    else
//        head.style.display = "";
//});


// ===== Scroll to Top ==== 
$(window).scroll(function () {
    if ($(this).scrollTop() >= 50) { // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(500); // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(500); // Else fade out the arrow
    }
});
$('#return-to-top').click(function () { // When arrow is clicked
    $('body,html').animate({
        scrollTop: 0 // Scroll to top of body
    }, 500);
});
