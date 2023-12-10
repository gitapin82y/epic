@extends('layouts.main-chat')

@section('title','Petugas')

@section('soloStyle')
{{-- sweetalert2 --}} 
<script src="{{asset('assets\js\sweetalert2.all.min.js')}}"></script>

{{-- data table + ui design --}}
<link rel="stylesheet" href="{{asset('assets\DataTables-1.10.21\css\dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets\DataTables-1.10.21\css\jquery.dataTables.min.css')}}">
{{-- end data table --}}
@endsection
@section('content')

@include('surat-jenis.tambah')
<style type="text/css">
    .content {
      height: 90%;
      flex: 1;
      display: flex;
      flex-direction: column;
      }
      .content header {
      height: 76px;
      /* background: #fff; */
      background-color: #FFD18D;
      border-bottom: 1px solid #ccc;
      display: flex;
      padding: 10px;
      align-items: center;
      }
      .content header img {
      border-radius: 50%;
      width: 50px;
      height: 50px;
      object-fit: cover;
      margin-right: 10px;
      box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.5);
      }
      .content header .info {
      flex: 1;
      }
      .content header .info .user {
      font-weight: 700;
      color: #F0C441;
      }
      .content header .info .time {
      display: flex;
      margin-top: 3px;
      font-size: 0.85em;
      color: #F0C441;
      }
      .content header .open {
      display: none;
      }
      .content header .open a {
      color: #000;
      letter-spacing: 3px;
      }

      .message-wrap {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 15px;
      overflow: auto;
      }
      .message-wrap::before {
      content: "";
      margin-bottom: auto;
      }
      .message-wrap .message-list {
      align-self: flex-start;
      max-width: 70%;
      margin-bottom: 20px;
      }
      .message-wrap .message-list.me {
      align-self: flex-end;
      }
      .message-wrap .message-list.me .msg {
      text-align: center;
      background: #C4EAF3;
      color: black;
      box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.1);
      padding: 5px;
      margin-bottom: 10px;
      border-radius: 10px;
      }
      .message-wrap .message-list .msg {
      text-align: center;
      background: #F3F9FA;
      color: black;
      box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.1);
      padding: 5px;
      margin-bottom: 10px;
      border-radius: 10px;
      }
      .message-wrap .message-list .time {
      text-align: center;
      color: #999;
      font-size: 0.75em;
      }

      .message-footer {
      background: white;
      padding: 10px;
      display: flex;
      height: 60px;
      border: 1px solid #499DB1;
      }
      .message-footer input {
      border: 0;
      background: transparent;
      flex: 1;
      padding: 0 20px;
      border-radius: 5px;
      }

      ul.no-bullets {
        list-style-type: none; /* Remove bullets */
        padding: 0; /* Remove padding */
        margin: 0; /* Remove margins */
      }

      .card-body {
        height: 500px;
      }

      .chatkuning {
        background-Color: #FFFBF5;
      }

      .container input {
        position: relative !important;
        opacity: 1 !important;
        cursor: text;
       }

       .container {
        font-size: inherit !important;
       }

       sidebar .list-wrap {
      width: 100%;
      overflow: auto;
      height: 100%;
      }
      sidebar .list-wrap .list {
      border-bottom: 1px solid #ccc;
      background: white;
      display: flex;
      align-items: center;
      padding: 5px;
      height: 70px;
      cursor: pointer;
      /* border-radius: 10px */
      }
      sidebar .list-wrap .list:hover, sidebar .list-wrap .list.active {
      background: #F3F9FA;
      }
      sidebar .list-wrap .list img {
      border-radius: 50%;
      width: 50px;
      height: 50px;
      object-fit: cover;
      margin-right: 10px;
      box-shadow: 1px 2px 3px rgba(0, 0, 0, 0.5);
      }
      sidebar .list-wrap .list .info {
      flex: 1;
      }
      sidebar .list-wrap .list .info .user {
      font-weight: 700;
      }
      sidebar .list-wrap .list .info .text {
      display: flex;
      margin-top: 3px;
      font-size: 0.85em;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      line-clamp: 2;
      -webkit-box-orient: vertical;
      }
      sidebar .list-wrap .list .time {
      margin-right: 5px;
      margin-left: 5px;
      font-size: 0.75em;
      color: #a9a9a9;
      }
      sidebar .list-wrap .list .count {
      font-size: 0.75em;
      background: #bde2f7;
      box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.7);
      padding: 3px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      text-align: center;
      color: #000;
      }

      @media only screen and (max-width: 480px), only screen and (max-width: 767px) {
      sidebar {
        position: absolute;
        width: 100%;
        min-width: 100%;
        height: 0vh;
        bottom: 0;
        box-shadow: 0 5px 25px -5px black;
      }
      sidebar.opened {
        height: 70vh !important;
      }
      sidebar .logo {
        display: none;
      }
      sidebar .list-wrap .list .count {
        font-size: 0.75em;
      }

      header .open {
        display: block !important;
      }
      }
</style>
<!-- partial -->
<div class="main-content">
  <section class="section mt-4">
    @if(Auth::user()->role_id == 9)
    <div id="warningSpan">
    <br>
    <center>
    <span style="margin-bottom: -30px; font-size: 15px; margin-top: 10px; " class="badge badge-warning">Peringatan : Saat ini live chat berada di luar jam kerja, mohon maaf jika slow respon, terima kasih!</span>
    </center>
    </div>
    @endif
    <div class="row">
    <div class="col-3 grid-margin stretch-card  mt-5" style="padding-left:0px; border-radius: 10px; ">
            <div class="card">
                <div class="card-body" style="padding: 0px;">
                <sidebar>
                    <div class="list-wrap" id="listroom">
                    </div>
                </sidebar>
                </div>
            </div>
    </div>
    <div class="col-9 grid-margin stretch-card mt-5">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Live Chat</h4>
                <div class="open">
                    <a style="display:none;" href="javascript:;">UP</a>
                </div>
                <div class="content">
                    <div class="message-wrap" id="listchat" onscroll="detectScroll()">

                    </div>
                    <div class="message-footer">
                    @if(Auth::user()->role_id == 9)
                    <input type="text" data-placeholder="Send a message to {0}" id="placeholder" placeholder="Ketik /topik untuk pertanyaan umum" onkeydown="entermessage()" />
                    @else 
                    <input type="text" data-placeholder="Send a message to {0}" id="placeholder" placeholder="Pesan" onkeydown="entermessage()" />
                    @endif
                    &nbsp
                    <button type="button" name="button" onclick="sendmessage()" style="background-color: #499DB1; width:40px; color:white; border-radius: 4px; border:0px;"> <span class="fas fa-paper-plane"></span> </button>
                    </div>
                </div>
                </div>
            </div>
    </div>
   </div>
  </section>
   </div>
  
<!-- content-wrapper ends -->
@endsection
@section('soloScript')

{{-- data table --}}
<script src="{{ asset('assets\DataTables-1.10.21\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets\DataTables-1.10.21\js\dataTables.bootstrap4.js') }}"></script>

<script>

        var idselect = 0;
        var selectedroom = false;
        var penerima = "";
        var scrolled = false

        roomchat();

        setInterval(function(){

          roomchat();

        }, 5000);

        function entermessage() {
         if(event.key === 'Enter') {
             sendmessage()     
         }
        }

        function roomchat() {
          var html = "";

          $.ajax({
    				url: "{{url('/')}}" + "/listroom",
    				success: function(data) {

              if(data.peringatan == true) {
                $("#warningSpan").css("display", "")
              } else {
                $("#warningSpan").css("display", "none")
              }

              if (data.data.length != 0) {
                for (var i = 0; i < data.data.length; i++) {
                  let res = data.data[i]

                  if (res.counter_kedua > 0) {
                    if (res.account.profile_toko != null) {
                      html += '<div class="list chatkuning" onclick="clicked('+res.account.id+')">'+
                        '<img src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.nama_lengkap+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="count">'+res.counter_kedua+'</span>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id+'">'+
                        '</div>';
                    } else {
                      html += '<div class="list chatkuning" onclick="clicked('+res.account.id+')">'+
                        '<img src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.nama_lengkap+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="count">'+res.counter_kedua+'</span>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id+'">'+
                        '</div>';
                    }
                  } else {
                    if (res.account.profile_toko != null) {
                      html += '<div class="list" onclick="clicked('+res.account.id+')">'+
                        '<img src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.nama_lengkap+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id+'">'+
                        '</div>';
                    } else {
                      html += '<div class="list" onclick="clicked('+res.account.id+')">'+
                        '<img src="https://st3.depositphotos.com/6672868/13701/v/450/depositphotos_137014128-stock-illustration-user-profile-icon.jpg" />'+
                        '<div class="info">'+
                          '<span class="user">'+res.account.nama_lengkap+'</span>'+
                          '<span class="text">'+res.last_message+'</span>'+
                        '</div>'+
                        '<span class="time">'+res.created_at+'</span>'+
                        '<input type="hidden" class="iduser" name="id" value="'+res.id+'">'+
                        '</div>';
                    }
                  }
                }


                if (selectedroom == false) {
                  idselect = data.data[0].id;
                }

                // listchat();

                $('#listroom').html(html);

                const ls = localStorage.getItem("selected");
                let selected = false;
                var list = document.querySelectorAll(".list"),
                  content = document.querySelector(".content"),
                  input = document.querySelector(".message-footer input"),
                  open = document.querySelector(".open a");

                //init
                function init() {
                //input.focus();
                let now = 2;
                const texts = [""];
                for(var i = 4; i < list.length; i++) {
                  list[i].querySelector(".time").innerText = `${now} day ago`;
                  list[i].querySelector(".text").innerText = texts[(i-4) < texts.length ? (i-4) : Math.floor(Math.random() * texts.length)];
                  now++;
                }
                }
                init();

                //process
                function process() {
                if(ls != null) {
                  selected = true;
                  click(list[ls], ls);
                }
                if(!selected) {
                  click(list[0], 0);
                }

                list.forEach((l,i) => {
                  l.addEventListener("click", function() {
                    click(l, i);
                    // alert("click");
                  });
                });

                try {
                //   document.querySelector(".list.active").scrollIntoView(true);
                }
                catch {}

                }

                process();

                //list click
                // if (scrolled == true) {
                  function click(l, index) {
                  list.forEach(x => { x.classList.remove("active"); });
                  if(l) {
                    l.classList.add("active");
                    document.querySelector("sidebar").classList.remove("opened");
                    open.innerText="UP";
                    const id = l.querySelector(".iduser").value;

                    // const inputPH = $('#placeholder').data('placeholder');
                    // input.placeholder = inputPH.replace("{0}", user.split(' ')[0]);
                    // $('#placeholder').attr('placeholder', inputPH.replace("{0}", user.split(' ')[0]));

                    // document.querySelector(".message-wrap").scrollTop = document.querySelector(".message-wrap").scrollHeight;


                    // alert(prefid);

                    idselect = id;

                    // alert(idselect);

                    selectedroom = true;

                    listchat(idselect);

                    // alert(scrolled);
                    // if (scrolled == true) {
                    //   $('#listchat').scrollTop($('#listchat')[0].scrollHeight);
                      // scrolled = false
                    // }

                    localStorage.setItem("selected", index);

                    // window.location.reload();
                  }
                }
                // }

                open.addEventListener("click", (e) => {
                const sidebar = document.querySelector("sidebar");
                sidebar.classList.toggle("opened");
                if(sidebar.classList.value == 'opened')
                  e.target.innerText = "DOWN";
                else
                  e.target.innerText = "UP";
                });
              }

    				}
    			});
        }

        function listchat() {
          var html = "";

          $.ajax({
    				url: "{{url('/')}}" + "/listchat",
            data: {id: idselect},
    				success: function(data) {

              for (var i = 0; i < data.length; i++) {
                let res = data[i]

                if (res.is_topik == "Y") {
                    html += '<div class="message-list">'+
                    '<ul class="no-bullets msg">'+
                       '<li style="cursor: pointer" onclick="selectTopik(1)">1. Bagaimana cara menggunakan aplikasi perizinan online</li>'+
                       '<li style="cursor: pointer" onclick="selectTopik(2)">2. Jenis perizinan apa yang dapat diajukan melalui aplikasi ini?</li>'+
                       '<li style="cursor: pointer" onclick="selectTopik(3)">3. Bagaimana cara memantau status perizinan saya?</li>'+
                       '<li style="cursor: pointer" onclick="selectTopik(4)">4. Apakah ada biaya untuk aplikasi ini?</li>'+
                       '<li style="cursor: pointer" onclick="selectTopik(5)">5. Apakah aplikasi ini dapat diakses dari seluler?</li>'+
                    '</ul>'+
                    '<span>Note : Silahkan pilih topik yang ingin ditanyakan dengan cara klik text / nomor topik</span>'+
                    '</div>';
                } else {
                  let arraccount = res.account.split("-");

                if (arraccount[0] == "{{Auth::user()->id}}") {
                  penerima = arraccount[1];
                  if (res.photourl != null) {
                    html += '<div class="message-list me">'+
                              '<div class="msg">'+
                                  '<span>'+
                                  '<a href="{{url('/')}}/'+res.photourl+'" target="_blank"> <img src="{{url('/')}}/'+res.photourl+'" style="width:150px; height:150px;"> </a>'+
                                  '</span>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  } else {
                    html += '<div class="message-list me">'+
                              '<div class="msg">'+
                                  '<span>'+
                                  res.message +
                                  '</span>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  }
                } else {
                  penerima = arraccount[0];
                  if (res.photourl != null) {
                    html += '<div class="message-list">'+
                              '<div class="msg">'+
                                  '<span>'+
                                  '<a href="{{url('/')}}/'+res.photourl+'" target="_blank"> <img src="{{url('/')}}/'+res.photourl+'" style="width:150px; height:150px;"> </a>'+
                                  '</span>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  } else {
                    html += '<div class="message-list">'+
                              '<div class="msg">'+
                                  '<span>'+
                                  res.message +
                                  '</span>'+
                              '</div>'+
                              '<div class="time">'+res.created_at+'</div>'+
                            '</div>';
                  }
                }
                }
              }

              $('#listchat').html(html);

              if($('#listchat').scrollTop() + $('#listchat').height() == $('#listchat').height()) {
                if (scrolled == false) {
                  $('#listchat').scrollTop($('#listchat')[0].scrollHeight);
                }
              }

            }
          });
        }

        function sendmessage() {
          let message = $('#placeholder').val();

          $.ajax({
    				url: "{{url('/')}}" + "/sendchat",
            data: {id: idselect, message: message, penerima: penerima},
    				success: function(data) {
              $('#placeholder').val('');
              listchat();
            }
          });
        }

        function detectScroll() {
          // alert('asd')
            scrolled = true;
        }

        function clicked(id) {
            penerima = id
            scrolled = false;
        }

        function selectTopik(id) {
          var message = "";

          if(id == 1) {
            message = "/cara-perizinan";
          } else if(id == 2) {
            message = "/jenis-perizinan";
          } else if(id == 3) {
            message = "/cara-pantau";
          } else if(id == 4) {
            message = "/biaya";
          } else if(id == 5) {
            message = "/akses";
          } 

          $.ajax({
    				url: "{{url('/')}}" + "/sendchat",
            data: {id: idselect, message: message, penerima: penerima},
    				success: function(data) {
              listchat();
            }
          });
        }

</script>
@endsection
