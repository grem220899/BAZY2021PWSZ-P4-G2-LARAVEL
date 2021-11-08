$(document).ready(function () {
    $("#friendlistBtn").click(function () {
        $(".friendelement").css("display", "block")
        $(".waitingelement").css("display", "none")
        $(".sendelement").css("display", "none")
        $(".bannedelement").css("display", "none")
        $(".grupyelement").css("display", "block")
        $("#search").css("display", "block")
        $("#addfriend").css("display", "none")
    });
    $("#sendlistBtn").click(function () {
        $(".friendelement").css("display", "none")
        $(".waitingelement").css("display", "none")
        $(".sendelement").css("display", "block")
        $(".bannedelement").css("display", "none")
        $(".grupyelement").css("display", "none")
        $("#search").css("display", "none")
        $("#addfriend").css("display", "block")
    });
    $("#waitingsBtn").click(function () {
        $(".friendelement").css("display", "none")
        $(".waitingelement").css("display", "block")
        $(".sendelement").css("display", "none")
        $(".bannedelement").css("display", "none")
        $(".grupyelement").css("display", "none")
        $("#search").css("display", "none")
        $("#addfriend").css("display", "none")
    });
    $("#bannedBtn").click(function () {
        $(".friendelement").css("display", "none")
        $(".waitingelement").css("display", "none")
        $(".sendelement").css("display", "none")
        $(".bannedelement").css("display", "block")
        $(".grupyelement").css("display", "none")
        $("#search").css("display", "none")
        $("#addfriend").css("display", "none")
    });
    $(".grupyelement").click(function () {
        $(".uzytkownicy").css("display", "none")
        $(".grupowe").css("display", "block")
    });
    $(".friendelement").click(function () {
        $(".uzytkownicy").css("display", "block")
        $(".grupowe").css("display", "none")
    });


    $("#dodajZnajomegoBtn").click(function () {
        var fd = new FormData();
        fd.append("email", $("#dodajZnajomegoInput").val())
        fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

        $.ajax({
            url: '/dodaj-znajomych',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (json) {
                console.log(json)
                if (json.error)
                    $.notify(json.error, "warning");
                else {
                    $.notify("Udało Ci się zaprośić znajomego.", "success");
                    var html = `<li class="contact sendelement" style="display:block">
             <div class="wrap">
               <span class="contact-status online"></span>
               <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
               <div class="meta">
                 <p class="name">` + json.user.name + ` ` + json.user.surname + `</p>
               </div>
             </div>
           </li>`;
                    var html2 = $("#listaUzytkownikow").html();
                    $("#listaUzytkownikow").html(html2 + html);
                    $("#dodajZnajomegoInput").val("");
                }
            },
            error:
                function (json) {

                    console.log("error");
                    console.log(json);
                }
        });


    });
    $(".akceptuj").click(function () {
        var fd = new FormData();
        fd.append("id", $(this).attr("data-id"))
        fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

        $.ajax({
            url: '/akceptuj-zaproszenie',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (json) {
                if (json.error)
                    $.notify(json.error, "warning");
                else {
                    $.notify("Udało Ci się zaakceptować znajomego.", "success");
                    console.log(json)
                    location.reload()
                }
            },
            error: function (json) {
                console.log("error")
                console.log(json)
            }
        });
});
$(".usun").click(function () {
    var fd = new FormData();
    fd.append("id", $(this).attr("data-id"))
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/usun-znajomego',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
                $.notify(json.error, "warning");
            else {
                $.notify("Udało Ci się usunąć zaproszenie do znajomych.", "success");
                console.log(json)
                location.reload()
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
$("#usunGrp").click(function () {
    var fd = new FormData();
    fd.append("id", $(this).attr("data-id"))
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/usun-grupe',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
                $.notify(json.error, "warning");
            else {
                $.notify("Udało Ci się usunąć grupę.", "success");
                console.log(json)
                location.reload()
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
$("#usunCzl").click(function () {
    var fd = new FormData();
    // fd.append("user_id", $(this).attr("data-id"))
    fd.append("name_group_id", $(this).attr("data-id"))
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/usun-czlonka',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
                $.notify(json.error, "warning");
            else {
                $.notify("Udało Ci się usunąć członka grupy.", "success");
                console.log(json)
                location.reload()
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
$("#opuscGrp").click(function () {
    var fd = new FormData();
    fd.append("id", $(this).attr("data-id"))
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/opusc-grupe',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
                $.notify(json.error, "warning");
            else {
                $.notify("Udało Ci się usunąć członka grupy.", "success");
                console.log(json)
                location.reload()
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
$(".zbanuj").click(function () {
    var fd = new FormData();
    fd.append("user_id", $(this).attr("data-id"))
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/banowanie-znajomych',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
                $.notify(json.error, "warning");
            else {
                $.notify("Udało Ci się zbanować znajomego.", "success");
                console.log(json)
                location.reload()
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
$(".odbanuj").click(function () {
    var fd = new FormData();
    fd.append("user_id", $(this).attr("data-id"))
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/odbanuj-znajomego',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
                $.notify(json.error, "warning");
            else {
                $.notify("Udało Ci się odbanować znajomego.", "success");
                console.log(json)
                location.reload()
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
$("#profile-img").click(function () {
    $("#avatar_file").click();
})
$("#avatar_file").change(function () {
    console.log($(this)[0].files[0])
    var fd = new FormData();
    fd.append("file", $(this)[0].files[0])
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/zmien-avatar',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
            $.notify(json.error, "warning");
        else {
            $.notify("Udało Ci się zmienić awatara.", "success");
            console.log(json)
            $("#profile-img").attr("src", "/uploads/avatars/" + json)
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
$("#dodajPlik").click(function () {
    $("#plikWiadomosci").click();
})
$("#plikWiadomosci").change(function () {
    console.log($(this)[0].files[0])
    var fd = new FormData();
    fd.append("file", $(this)[0].files[0])
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))

    $.ajax({
        url: '/dodaj-plik',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success: function (json) {
            if (json.error)
            $.notify(json.error, "warning");
            else {
            $.notify("Udało Ci się dodać plik", "success");
            console.log(json)
            $("#podglad").append(json.plik)
            }
        },
        error: function (json) {
            console.log("error")
            console.log(json)

        }
    });
});
});
