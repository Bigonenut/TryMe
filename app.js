
$("#top_to").hide();$(window).scroll(function(){if($(this).scrollTop()>200){$("#top_to").fadeIn(100)}else{$("#top_to").fadeOut(200)}});$("#top_to").click(function(){$("body,html").animate({scrollTop:0},400);return false})


function switchNightMode() {
    var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || "0";
    if (night == "0") {
        document.body.classList.add("nice-dark-mode");
        document.cookie = "night=1;path=/";
        console.log("夜间模式开启")
    } else {
        document.body.classList.remove("nice-dark-mode");
        document.cookie = "night=0;path=/";
        console.log("夜间模式关闭")
    }
} (function() {
    if (document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") === "") {
        if (new Date().getHours() > 21 || new Date().getHours() < 6) {
            document.body.classList.add("nice-dark-mode");
            document.cookie = "night=1;path=/";
            console.log("夜间模式开启");
        } else {
            document.body.classList.remove("nice-dark-mode");
            document.cookie = "night=0;path=/";
            console.log("夜间模式关闭")
        }
    } else {
        var night = document.cookie.replace(/(?:(?:^|.*;\s*)night\s*\=\s*([^;]*).*$)|^.*$/, "$1") || "0";
        if (night == "0") {
            document.body.classList.remove("nice-dark-mode")
        } else {
            if (night == "1") {
                document.body.classList.add("nice-dark-mode")
            }
        }
    }
})();