$(function () {
  $("#friendlistBtn").click(function () {
    $(".friendelement").css("display", "block")
    $(".waitingelement").css("display", "none")
    $(".sendelement").css("display", "none")
    $("#search").css("display", "block")
    $("#addfriend").css("display", "none")
  });
  $("#sendlistBtn").click(function () {
    $(".friendelement").css("display", "none")
    $(".waitingelement").css("display", "none")
    $(".sendelement").css("display", "block")
    $("#search").css("display", "none")
    $("#addfriend").css("display", "block")
  });
  $("#waitingsBtn").click(function () {
    $(".friendelement").css("display", "none")
    $(".waitingelement").css("display", "block")
    $(".sendelement").css("display", "none")
    $("#search").css("display", "none")
    $("#addfriend").css("display", "none")
  });
  $("#dodajZnajomegoBtn").click(function(){
    var fd=new FormData();
    fd.append("email", $("#dodajZnajomegoInput").val())
    fd.append("_token", $('meta[name="csrf-token"]').attr('content'))
    $.ajax({
        url: '/dodaj-znajomych',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        dataType: "JSON",
        success:function(json){
             console.log(json)  
             var html=`<li class="contact sendelement">
             <div class="wrap">
               <span class="contact-status online"></span>
               <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
               <div class="meta">
                 <p class="name">`+json.user.name+`</p>
               </div>
             </div>
           </li>`
           var html2=$("#listaUzytkownikow").html();
           $("#listaUzytkownikow").html(html2+html); 
        },
        error:function(json){
            // console.log(json)
            
        }
    });
  });
});
