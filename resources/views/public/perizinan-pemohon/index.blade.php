@extends('layouts.public')
@section('title','Permohonan Saya')

@push('extra_style')
<link rel="stylesheet" href="{{asset('assets/node_modules/izitoast/dist/css/iziToast.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css')}}">
<style>
body {
    background-color: #f3f8fb;
  }

  .content .active a {
    color: white !important;
  }
  .page-item.active .page-link {
    background-color: #499db1;
    border-color: #499db1;
  }
</style>
@endpush

@section('content')

@include('public.perizinan-pemohon.detail')
@include('public.perizinan-pemohon.tolak')
@include('public.perizinan-pemohon.acc-jadwal')

<div
class="row col-12 justify-content-center mt-5 pt-5"
id="buat-perizinan"
>
<div class="col-md-10 col-12">
  <div class="content">
    <div class="row justify-content-between">
      <div class="col-6 align-self-center">
        <h4 class="align-self-center">List Permohonan Perizinan ( <span id="filter_status">Semua</span> )</h4>
      </div>
      <div class="col-6 justify-content-end d-flex">
        <div class="btn-group">
          <button type="button" class="btn text-white btn-main dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              Filter Status
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
               <a class="dropdown-item" href="#" onclick="handleFilter('Semua')">Semua</a>
              <a class="dropdown-item" href="#" onclick="handleFilter('Pengisian Dokumen')">Pengisian Dokumen</a>
              <a class="dropdown-item" href="#" onclick="handleFilter('Validasi Operator')">Validasi Operator</a>
              <a class="dropdown-item" href="#" onclick="handleFilter('Verifikasi Verifikator')">Verifikasi Verifikator</a>
              <a class="dropdown-item" href="#" onclick="handleFilter('Penjadwalan Survey')">Penjadwalan Survey</a>
              <a class="dropdown-item" href="#" onclick="handleFilter('Verifikasi Hasil Survey')">Verifikasi Hasil Survey</a>
              <a class="dropdown-item" href="#" onclick="handleFilter('Verifikasi Kepala Dinas')">Verifikasi Kepala Dinas</a>
          </div>
      </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="table-responsive">
        <table class="table table_status table-hover w-100" id="table-data" cellspacing="0">
            <thead class="bg-main text-white">
              <tr>
                <th>No. Surat</th>
                <th>Jenis Surat</th>
                <th>Jadwal Survey</th>
                <th>Status</th>
                <th>Tanggal Pengajuan</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody>

            </tbody>
        </table>
    </div>
    </div>
  </div>
</div>
</div>
@endsection

@push('extra_script')
<script type="text/javascript" src="{{asset('assets/datatables/datatables.min.js')}}"></script>
<script src="{{asset('assets/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js')}}"></script>

<script>
    var selectedStatus = 'Semua'; 
  function handleFilter(status) {
      selectedStatus = status ;  // update selectedStatus
      document.getElementById("filter_status").innerHTML = status
  
      // Update DataTable's Ajax URL
      table.ajax.url("{{ url('/perizinantable') }}/" + selectedStatus).load();
  };
  var table = $('#table-data').DataTable({
          processing: true,
          serverSide: true,
          searching: true,
          paging: true,
          // dom: 'Bfrtip',
          title: '',
          buttons: [
              // 'pdf'
                // 'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength',
              
          ],
          ajax: {
            url: "{{ url('/perizinantable') }}/" + selectedStatus ,
          },
          columnDefs: [
  
                {
                   targets: 0 ,
                   className: 'center id'
                },
                {
                   targets: 1,
                   className: 'center'
                },
                {
                   targets: 2,
                   className: 'type center'
                },
                {
                   targets: 3,
                   className: 'w-25 center'
                },
                {
                   targets: 4,
                   className: 'type center'
                },
                {
                   targets: 5,
                   className: 'type center'
                },
               
              ],
          "columns": [
            {data: 'id', name: 'id'},
            {data: 'surat_jenis', name: 'surat_jenis'},
            {data:'jadwal_survey', name: 'jadwal_survey'},
            {data:'status', name: 'status'},
            {data:'tanggal_pengajuan', name: 'tanggal_pengajuan'},
            {data: 'aksi', name: 'aksi'},
  
          ],
          "language": {
                      "sProcessing": "Sedang memproses...",
                      "sLengthMenu": "Tampilkan _MENU_ data",
                      "sZeroRecords": "Tidak ditemukan data yang sesuai",
                      "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                      "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                      "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                      "sInfoPostFix": "",
                      "sSearch": "Cari:",
                      "sUrl": "",
                      "oPaginate": {
                          "sFirst": "Pertama",
                          "sPrevious": "Sebelumnya",
                          "sNext": "Selanjutnya",
                          "sLast": "Terakhir"
                      }
                  }
});

function edit(id) {
      // body...
      $.ajax({
        url:baseUrl + '/editperizinan',
        data:{id},
        dataType:'json',
        success:function(data){
          console.log({data})
          $('.id').val(data.surat.id);
          document.getElementById("jenis_perizinan").innerHTML = data.surat_jenis.nama;
          document.getElementById("surat_id").innerHTML = data.surat.id;
          document.getElementById("status_surat").innerHTML = data.surat.status;
          data.surat.status === "Selesai" ? document.getElementById("status_surat").style.color = "green" : data.surat.status === "Ditolak" ? document.getElementById("status_surat").style.color = "red" : document.getElementById("status_surat").style.color = "#F3B137";
          document.getElementById("tanggal_pengajuan").innerHTML = data.tanggal_pengajuan;
          document.getElementById("jadwal_survey").innerHTML = data.jadwal_survey;
          document.getElementById("alamat_lokasi").innerHTML = data.surat.alamat_lokasi;
          document.getElementById('cetakNoRegis').setAttribute('href','generate-pdf?noSurat='+data.surat.id);
          // data.surat_dokumen.forEach(function(surat_syarat) {
          // document.getElementsByClassName("nama_surat_syarat").innerHTML = surat_syarat.nama;
          // });
  
          data.surat_dokumen.forEach(myFunction);
  
          // document.getElementById("nama_surat_syarat").innerHTML = text;
          function myFunction(item, index) {
            const container = document.getElementById("nama_surat_syarat");
  
            // Create paragraph element
            const para = document.createElement("p");
            const node = document.createTextNode((index + 1) + ".) " + item.nama);
            para.appendChild(node);
        
            // Create link element
            const link = document.createElement("a");
            link.setAttribute("href", item.dokumen_upload);  // Set the link's href attribute as needed
            link.setAttribute("target", '_blank');  // Set the link's href attribute as needed
            const text = document.createTextNode("Lihat Dokumen");
            link.appendChild(text);
        
            // Apply CSS styles to reduce the margin between para and link
            para.style.marginBottom = "1px";  // Adjust the value as needed
            link.style.color = "#F3B137"
            // Append paragraph and link to the container
            container.appendChild(para);
            container.appendChild(link);
        
            // Add a line break for better separation
            const lineBreak = document.createElement("br");
            container.appendChild(lineBreak);
            const lineBreak2 = document.createElement("br");
            container.appendChild(lineBreak2);
        
        
        };
        
          // $('.datepicker').val(data.created_at)
          $('#detail').modal('show');
        }
      });
  
    }
  
    $('#simpan').click(function(){
      $.ajax({
        url: baseUrl + '/simpansurat',
        data:$('.table_modal :input').serialize(),
        dataType:'json',
        success:function(data){
          if (data.status == 1) {
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Berhasil Disimpan!',
            });
            reloadall();
          }else if(data.status == 2){
            iziToast.warning({
                icon: 'fa fa-info',
                message: 'Data Gagal disimpan!',
            });
          }else if (data.status == 3){
            iziToast.success({
                icon: 'fa fa-save',
                message: 'Data Berhasil Diubah!',
            });
            reloadall();
          }else if (data.status == 4){
            iziToast.warning({
                icon: 'fa fa-info',
                message: 'Data Gagal Diubah!',
            });
          }
  
        }
      });
    })
  
    $('#showModalTolak').click(function(){
     var tes = document.getElementById("id").value ;
     $('.id').val(tes);
     $('.alasan_dikembalikan').val("");
     $('#detail').modal('hide'); 
     $('#showTolak').modal('show');
      
    })
  
    function accJadwal(id){
      $.ajax({
        url:baseUrl + '/editperizinan',
        data:{id},
        dataType:'json',
        success:function(data){
          console.log({data})
          $('.id').val(data.surat.id);
        
          $('#showAccJadwal').modal('show');
        }
      });
  
    }

    


    function alasanDikembalikan(text, suratJenis, idSurat){
      $('.alasan_dikembalikan').html(text);
      $('.kirimUlang').attr('href',baseUrl+'/ajukan-perizinan?jenis='+suratJenis);
      $('#showTolak').modal('show');
    }
  
    $('#accJadwalSurvey').click(function(){
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        title:
        'Konfirmasi Ketersediaan Jadwal Survey',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              url:baseUrl + '/pemohonaccjadwalperizinan',
              data:$('.table_modal :input').serialize(),
              dataType:'json',
              success:function(data){
                if (data.status == 1) {
            iziToast.success({
                icon: 'fa fa-save',
                message:
                'Jadwal Survey Berhasil Dikonfirmasi',
            });
            reloadall();
          }else if(data.status == 2){
            iziToast.warning({
                icon: 'fa fa-info',
                message: 'Jadwal Survey Gagal Dikonfirmasi',
            });
          }
  
                reloadall();
              }
            });
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    })

    $('#jadwalUlang').click(function(){
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        title:
        'Konfirmasi Penjadwalan Ulang',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              url:baseUrl + '/jadwalulang',
              data:$('.table_modal :input').serialize(),
              dataType:'json',
              success:function(data){
                if (data.status == 1) {
            iziToast.success({
                icon: 'fa fa-save',
                message:
                'Tunggu Jadwal Survey Terbaru',
            });
            reloadall();
          }else if(data.status == 2){
            iziToast.warning({
                icon: 'fa fa-info',
                message: 'Penjadwalan Ulang Survey Gagal',
            });
          }
  
                reloadall();
              }
            });
          }, true],
          ['<button>Tidak</button>', function (instance, toast) {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
          }],
        ]
      });
    })
  
  
    function reloadall() {
      $('.table_modal :input').val("");
      $('#tambah').modal('hide');
      $('#detail').modal('hide');
      $('#showTolak').modal('hide');
      $('#showAccJadwal').modal('hide');
      
      // $('#table_modal :input').val('');
     
      // $(".inputtext").val("");
      // var table1 = $('#table_modal').DataTable();
      // table1.ajax.reload();
      table.ajax.reload();
    }
    </script>
@endpush
