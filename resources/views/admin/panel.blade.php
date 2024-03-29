@extends('layouts.app')

@section('content')
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
            <div class="wrap" style="text-align: center;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 21px;
            font-weight: bold;">
                Projektkt.pl <br> panel admina
            </div>
        </div>
        <div id="contacts">
			<ul id="listaUzytkownikow" style="padding-left: 0px; list-style: none;">
                <li id="listaUsers" class="adminMenu">Lista Użytkowników</li>
                <li id="listaWulgaryzmow" class="adminMenu">Lista Wylgaryzmów</li>
                <li id="listaZamiennikow" class="adminMenu">Lista Zamienników</li>
            </ul>
        </div>
        <div id="bottom-bar">


            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form2').submit();"><button id="logoutBtn" ><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> <span>Wyloguj</span></button></a> <form id="logout-form2" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
		</div>
    </div>
    <div class="content" id="wybranaLista" style="overflow:auto">
        <div class="contact-profile">

			<p id="nazwaListy" style="padding: 5px"></p>


        </div>
        <div>
            <div class="tabelki" id="datatableWulgaryzmy_">
                <table class=" table table-striped- table-bordered table-hover table-checkable responsive" id="datatableWulgaryzmy">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Słowo</th>
                            <th>Aktywny</th>
                            <th>Dodano</th>
                            <th>Zmieniono</th>
                        </tr>
                    </thead>
                </table>
                <input type="text" class="dodajZnajomego" id="nowyWulgaryzm" style="width:200px;">
                <button id="dodajWulgaryzmBtn" ><span>Dodaj</span></button>
            </div>
        </div>
        <div>
            <div class="tabelki" id="datatableZamienniki_">
                <table class=" table table-striped- table-bordered table-hover table-checkable responsive" id="datatableZamienniki">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Słowo</th>
                            <th>Aktywny</th>
                            <th>Dodano</th>
                            <th>Zmieniono</th>
                        </tr>
                    </thead>
                </table>
                <input type="text" class="dodajZnajomego" id="nowyZamiennik" style="width:200px;">
                <button id="dodajZamiennikBtn" ><span>Dodaj</span></button>
            </div>
        </div>
        <div>
            <div class="tabelki" id="datatableUsers_">
                <table class=" table table-striped- table-bordered table-hover table-checkable responsive" id="datatableUsers">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Imię</th>
                            <th>Nazwisko</th>
                            <th>E-mail</th>
                            <th>Status</th>
                            <th>Weryfikacja</th>
                            <th>Dodano</th>
                            <th>Zmieniono</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
	</div>
</div>

@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script>
<link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/datatables.responsive.bootstrap4.min.css') }}">
<script src="{{ asset('js/datatables.min.js') }}" defer></script>
<style>
    .zmianaStatusu{
        cursor:pointer;
    }
    </style>
    <script>
        //Zamienniki
        $(function () {
            $("#dodajZamiennikBtn").click(function(){
                let url = "/dodaj-zamiennik"
                let fd = new FormData();
                let token = "{{ csrf_token() }}"
                fd.append("_token", token)
                fd.append("nazwa",$("#nowyZamiennik").val())
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                        $("#nowyZamiennik").val("")
                    },
                    error: function (response) {

                        console.log(response)
                    }
                })
            })
            $(".tabelki").css("display","none")
            $(".adminMenu").click(function(){
                if($(this).attr("id")=="listaZamiennikow"){
                    $(".tabelki").css("display","none")
                    $("#datatableZamienniki_").css("display","block")
                    $("#nazwaListy").html("Lista Zamienników")
                    var DTabela = $("#datatableZamienniki").DataTable({
                        "columnDefs": [
                            {"className": "dt-center", "targets": "_all"}
                        ],
                        bLengthChange: !1,
                        searching: false,
                        destroy: !0,
                        info: !1,
                        sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
                        pageLength: 10,
                        processing: false,
                        columns: [
                            { data: 0 },
                            { data: 1 },
                            { data: 2 },
                            { data: 3 },
                            { data: 4 }

                        ],
                        serverSide: true,
                        aaSorting: [
                                        [1, "asc"]
                                    ],
                    "ajax": {
                            "url": "/tabela-zamienniki",
                            "data": function ( d ) {
                            }
                        },
                        language: {
                            paginate: {
                                previous: "<",
                                next: ">"
                            }
                        },
                        drawCallback: function() {
                            $($(".dataTables_wrapper .pagination li:first-of-type")).find("a").addClass("prev"), $($(".dataTables_wrapper .pagination li:last-of-type")).find("a").addClass("next"), $(".dataTables_wrapper .pagination").addClass("pagination-sm");
                        }
                    });

                }else if($(this).attr("id")=="listaWulgaryzmow"){
                    $("#nazwaListy").html("Lista Wulgaryzmow")
                    $(".tabelki").css("display","none")
                    $("#datatableWulgaryzmy_").css("display","block")
                }else if($(this).attr("id")=="listaUsers"){
                    $("#nazwaListy").html("Lista Użytkowników")
                    $(".tabelki").css("display","none")
                    $("#datatableUsers_").css("display","block")
                }
            })


        })
        //Users
        $(function () {
            $(".tabelki").css("display","none")
            $(".adminMenu").click(function(){
                if($(this).attr("id")=="listaUsers"){
                    $(".tabelki").css("display","none")
                    $("#datatableUsers_").css("display","block")
                    $("#nazwaListy").html("Lista Użytkowników")
                    var DTabela = $("#datatableUsers").DataTable({
                        "columnDefs": [
                            {"className": "dt-center", "targets": "_all"}
                        ],
                        bLengthChange: !1,
                        searching: false,
                        destroy: !0,
                        info: !1,
                        sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
                        pageLength: 10,
                        processing: false,
                        columns: [
                            { data: 0 },
                            { data: 1 },
                            { data: 2 },
                            { data: 3 },
                            { data: 4 },
                            { data: 5 },
                            { data: 6 },
                            { data: 7 }

                        ],
                        serverSide: true,
                        aaSorting: [
                                        [0, "desc"]
                                    ],
                    "ajax": {
                            "url": "/tabela-users",
                            "data": function ( d ) {
                            }
                        },
                        language: {
                            paginate: {
                                previous: "<",
                                next: ">"
                            }
                        },
                        drawCallback: function() {
                            $($(".dataTables_wrapper .pagination li:first-of-type")).find("a").addClass("prev"), $($(".dataTables_wrapper .pagination li:last-of-type")).find("a").addClass("next"), $(".dataTables_wrapper .pagination").addClass("pagination-sm");
                        }
                    });

                }else if($(this).attr("id")=="listaZamiennikow"){
                    $("#nazwaListy").html("Lista Zamiennikow")
                    $(".tabelki").css("display","none")
                    $("#datatableZamienniki_").css("display","block")
                }else if($(this).attr("id")=="listaWulgaryzmow"){
                    $("#nazwaListy").html("Lista Wulgaryzmow")
                    $(".tabelki").css("display","none")
                    $("#datatableWulgaryzmy_").css("display","block")
                }
            })


        })
        //Wulgaryzmy
        $(function () {
            $("#dodajWulgaryzmBtn").click(function(){
                let url = "/dodaj-wulgaryzm"
                let fd = new FormData();
                let token = "{{ csrf_token() }}"
                fd.append("_token", token)
                fd.append("nazwa",$("#nowyWulgaryzm").val())
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                        $("#nowyWulgaryzm").val("")
                    },
                    error: function (response) {

                        console.log(response)
                    }
                })
            })
            $(".tabelki").css("display","none")
            $(".adminMenu").click(function(){
                if($(this).attr("id")=="listaWulgaryzmow"){
                    $(".tabelki").css("display","none")
                    $("#datatableWulgaryzmy_").css("display","block")
                    $("#nazwaListy").html("Lista Wulgaryzmow")
                    var DTabela = $("#datatableWulgaryzmy").DataTable({
                        "columnDefs": [
                            {"className": "dt-center", "targets": "_all"}
                        ],
                        bLengthChange: !1,
                        searching: false,
                        destroy: !0,
                        info: !1,
                        sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
                        pageLength: 10,
                        processing: false,
                        columns: [
                            { data: 0 },
                            { data: 1 },
                            { data: 2 },
                            { data: 3 },
                            { data: 4 }

                        ],
                        serverSide: true,
                        aaSorting: [
                                        [1, "asc"]
                                    ],
                    "ajax": {
                            "url": "/tabela-wulgaryzmy",
                            "data": function ( d ) {
                            }
                        },
                        language: {
                            paginate: {
                                previous: "<",
                                next: ">"
                            }
                        },
                        drawCallback: function() {
                            $($(".dataTables_wrapper .pagination li:first-of-type")).find("a").addClass("prev"), $($(".dataTables_wrapper .pagination li:last-of-type")).find("a").addClass("next"), $(".dataTables_wrapper .pagination").addClass("pagination-sm");
                        }
                    });

                }else if($(this).attr("id")=="listaZamiennikow"){
                    $("#nazwaListy").html("Lista Zamiennikow")
                    $(".tabelki").css("display","none")
                    $("#datatableZamienniki_").css("display","block")
                }else if($(this).attr("id")=="listaUsers"){
                    $("#nazwaListy").html("Lista Użytkowników")
                    $(".tabelki").css("display","none")
                    $("#datatableUsers_").css("display","block")
                }
            })
            $(document).on("click",".zmianaStatusu",function(){
                let url = "/zmiana-statusu-user"
                let fd = new FormData();
                let token = "{{ csrf_token() }}"
                fd.append("_token", token)
                fd.append("id",$(this).attr("data-id"))
                fd.append("status",$(this).html())
                var that=$(this)
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response)
                        that.html(response.status)
                    },
                    error: function (response) {

                        console.log(response)
                    }
                })
            })

        })
    </script>
@endpush

