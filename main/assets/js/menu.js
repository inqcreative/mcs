$(window).scroll(function () {
    if ($(this).scrollTop() > 150) {
        $('.menu').addClass('opaque');
    } else {
        $('.menu').delay(1000).removeClass('opaque');
    }
});

$(document).ready(function () {

    'use strict';

    var c, currentScrollTop = 0,
        navbar = $('.menu');

    $(window).scroll(function () {
        var a = $(window).scrollTop();
        var b = navbar.height();

        currentScrollTop = a;

        if (c < currentScrollTop && a > b + b) {
            navbar.addClass("scrollUp");
        } else if (c > currentScrollTop && !(a <= b)) {
            navbar.removeClass("scrollUp");
        }
        c = currentScrollTop;
    });

});

$(document).ready(function () {

    'use strict';

    var f, currentScrollTop = 0,
        navbarMobile = $('.mobmenu');

    $(window).scroll(function () {
        var d = $(window).scrollTop();
        var e = navbarMobile.height();

        currentScrollTop = d;

        if (f < currentScrollTop && d > e + e) {
            navbarMobile.addClass("scrollUp");
        } else if (f > currentScrollTop && !(d <= e)) {
            navbarMobile.removeClass("scrollUp");
        }
        f = currentScrollTop;
    });

});

$('#toggle').click(function () {
    $(this).toggleClass('active');
    $('#overlay').toggleClass('open');
});

var tabs = $('.tabs');
var selector = $('.tabs').find('a').length;
//var selector = $(".tabs").find(".selector");
var activeItem = tabs.find('.active');
var activeWidth = activeItem.innerWidth();
$(".selector").css({
    "left": activeItem.position.left + "px",
    "width": activeWidth + "px"
});

$(".tabs").on("click", "a", function (e) {
    e.preventDefault();
    $('.tabs a').removeClass("active");
    $(this).addClass('active');
    var activeWidth = $(this).innerWidth();
    var itemPos = $(this).position();
    $(".selector").css({
        "left": itemPos.left + "px",
        "width": activeWidth + "px"
    });
});
