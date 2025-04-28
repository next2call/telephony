$(document).ready(function () {

    let openNav = false;

    function navControl() {
        if (openNav === true) {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            openNav = false;
        } else {
            document.getElementById("mySidebar").style.width = "300px";
            document.getElementById("main").style.marginLeft = "300px";
            openNav = true;
        }
    }

    $(".openbtn").click(function () {
        navControl();
    });

    if (my_dropdown) {
        $(".my-dropdown").each(function () {
            if ($(this).find("select").val().length > 0) {
                $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -130%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px", "z-index": "2" })
            } else {
                $(this).find("label").css({ "font-size": "100%", "transform": "translate3d(0, -40%, 0)", "opacity": "0.5", "background-color": "transparent", "padding": "15px 0 0 13px", "z-index": "0" })
            }
        })

        $(".my-dropdown").each(function () {
            $(this).focusin(function () {
                $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -130%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px", "z-index": "2" })
            });

            $(this).focusout(function () {
                if ($(this).find("select").val().length > 0) {
                    $(this).find("label").css({ "font-size": "75%", "transform": "translate3d(0, -130%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px", "z-index": "2" })
                } else {
                    $(this).find("label").css({ "font-size": "100%", "transform": "translate3d(0, -40%, 0)", "opacity": "0.5", "background-color": "transparent", "padding": "15px 0 0 13px", "z-index": "0" })
                }
            });
        })
    }


    const myFunction = () => {
        document.querySelector("#voicemail_id").value = event.path[0].innerText;
        $("label[for='voicemail_id'").css({ "font-size": "75%", "transform": "translate3d(0, -60%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px" })
    }

    $(".voicemail_table_data").click(function () {
        myFunction()
    })


    var myTable = $('.table').DataTable({
        searching: true,
        ordering: false,
        bLengthChange: true,
        language: {
            paginate: {
                next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>', // or '→'
                previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>' // or '←' 
            }
        }
    });

    $('#search-user').keyup(function () {
        myTable.search($(this).val()).draw();
    })

    $(".my-nav ul li input").css("width", "100px")
    $(".my-nav ul li input").focusin(function () {
        $(".my-nav ul li input").css("width", "200px")
    })

    $(".my-nav ul li input").focusout(function () {
        $(".my-nav ul li input").css("width", "100px")
    })

    //input label style change on focus and value input

    // $(".my-input input").keyup(function () {
    //     if ($(".my-input input").val().length > 0) {
    //         $(".my-input label").css({ "font-size": "75%", "transform": "translate3d(0, -60%, 0)", "opacity": "1", "background-color": "white", "padding": "0 5px" })
    //     } else{
    //         $(".my-input label").css({ "font-size": "100%", "transform": "translate3d(0, 0, 0)", "opacity": "0.5", "background-color": "transparent", "padding": "15px 0 0 13px" })
    //     }
    // });





})