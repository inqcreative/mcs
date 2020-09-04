$(document).ready(function () {
    function t(e) {
        return $(e).parents(".fieldcontainer").find("label")
    }
    var e = "input[type='text'], input[type='password'], input[type='email'],input[type='date'], select, textarea"
    
    $(document).on("focus", e, function (e) {
        t(e.currentTarget).addClass("focused")
    }), $(document).on("focusout", e, function (e) {
        e.currentTarget.value || t(e.currentTarget).removeClass("focused"), $(".form-errors").text("")
    })
})
