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
      background: #FFD18D;
      color: black;
      box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.1);
      padding: 5px;
      margin-bottom: 10px;
      border-radius: 10px;
      }
      .message-wrap .message-list .msg {
      text-align: center;
      background: #FFD18D;
      color: black;
      box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.1);
      padding: 5px;
      margin-bottom: 10px;
      border-radius: 10px;
      }
      .message-wrap .message-list .time {
      text-align: right;
      color: #999;
      font-size: 0.75em;
      }

      .message-footer {
      background: #FFF6E8;
      padding: 10px;
      display: flex;
      height: 60px;
      }
      .message-footer input {
      border: 0;
      background: transparent;
      flex: 1;
      padding: 0 20px;
      border-radius: 5px;
      }

      .card-body {
        height: 500px;
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
    <div class="row">
    <div class="col-3 grid-margin stretch-card" style="padding-left:0px; border-radius: 10px;">
            <div class="card">
                <div class="card-body" style="padding: 0px;">
                <sidebar>
                    <div class="list-wrap" id="listroom">
                    </div>
                </sidebar>
                </div>
            </div>
    </div>
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Live Chat</h4>
                    
                    <div class="content">
                        <div class="message-wrap" id="listchat" onscroll="detectScroll()">

                        </div>
                        <div class="message-footer">
                        <input type="text" data-placeholder="Send a message to {0}" id="placeholder" placeholder="Pesan" onkeydown="entermessage()" />
                        &nbsp
                        <button type="button" name="button" onclick="sendmessage()" style="background-color: transparent; width:40px; color:black; border:0;"> <span class="fa fa-send"></span> </button>
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
@section('extra_script')
<script>
        var idselect = 0;
        var selectedroom = false;
        var penerima = "";
        var scrolled = false

        if ({{Auth::user()->role_id == 9}}) {
            listchat()
        }

        function entermessage() {
         if(event.key === 'Enter') {
             sendmessage()     
         }
        }
        
        function listchat() {
          var html = "";

          $.ajax({
    				url: "{{url('/')}}" + "/listchat",
            data: {id: idselect},
    				success: function(data) {

              for (var i = 0; i < data.length; i++) {
                let res = data[i]
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

        function clicked() {
            scrolled = false;
        }

</script>
@endsection
