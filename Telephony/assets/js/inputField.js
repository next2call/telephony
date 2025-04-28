//Input label
let my_input = document.querySelector(".my-input")
let my_dropdown = document.querySelector(".my-dropdown")
if (my_input) {
    $(".my-input").each(function () {
        if ($(this).find("input").length > 0 ) {
            $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -60%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px" })
        }
        // else {
        //     $(this).find("label").css({ "font-size": "100%", "transform": "translate3d(0, 0, 0)", "opacity": "0.5", "background-color": "transparent", "padding": "15px 0 0 13px" })
        // }
    })

    $(".my-input").each(function () {
        $(this).focusin(function () {
            $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -60%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px" })
        });

        $(this).focusout(function () {
            if ($(this).find("input").val().length > 0) {
                $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -60%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px" })
            } 
            // else {
            //     $(this).find("label").css({ "font-size": "100%", "transform": "translate3d(0, 0, 0)", "opacity": "0.5", "background-color": "transparent", "padding": "15px 0 0 13px" })
            // }
        });
    })


}

if (my_dropdown) {
    $(".my-dropdown").each(function () {
        if ($(this).find("select").val().length > 0) {
            $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -130%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px", "z-index": "2" })
        } 
        // else {
        //     $(this).find("label").css({ "font-size": "100%", "transform": "translate3d(0, -40%, 0)", "opacity": "0.5", "background-color": "transparent", "padding": "15px 0 0 13px", "z-index": "0" })
        // }
    })

    $(".my-dropdown").each(function () {
        $(this).focusin(function () {
            $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -130%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px", "z-index": "2" })
        });

        $(this).focusout(function () {
            if ($(this).find("select").val().length > 0) {
                $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -130%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px", "z-index": "2" })
            } 
            // else {
            //     $(this).find("label").css({ "font-size": "100%", "transform": "translate3d(0, -40%, 0)", "opacity": "0.5", "background-color": "transparent", "padding": "15px 0 0 13px", "z-index": "0" })
            // }
        });
    })
}