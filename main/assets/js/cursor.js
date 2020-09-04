$(document).ready((function () {
    var s = $(".cursor");
    $(window).mousemove((function (o) {
        s.css({
            top: o.clientY - s.height() / 2,
            left: o.clientX - s.width() / 2
        });
        for (var e = 0; e <= 11; e++)
            $(".bg-icon-container-" + e).css({
                transform: "translate(" + o.clientX * (e / 55) + "px , " + o.clientY * (e / 55) + "px)",
                opacity: "1"
            })
    })), $(window).mouseleave((function () {
        $(".cursor").css({
            opacity: "0"
        })
    })).mouseenter((function () {
        $(".cursor").css({
            opacity: "1"
        })
    })), $("a, button, .dmode, .linky, .filepond--dropzone-label").mouseenter((function () {
        $(".cursor").css({
            transform: "scale(2)"
        })
    })).mouseleave((function () {
        $(".cursor").css({
            transform: "scale(1)"
        })
    })), $(window).mousedown((function () {
        $(".cursor").css({
            transform: "scale(.5)"
        })
    })).mouseup((function () {
        $(".cursor").css({
            transform: "scale(1)"
        })
    }))
}));
