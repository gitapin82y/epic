@extends('layouts.app')

@section('title','Surat Syarat')

@section('soloStyle')
{{-- sweetalert2 --}} 
<script src="{{asset('assets\js\sweetalert2.all.min.js')}}"></script>

{{-- data table + ui design --}}
<link rel="stylesheet" href="{{asset('assets\DataTables-1.10.21\css\dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets\DataTables-1.10.21\css\jquery.dataTables.min.css')}}">
{{-- end data table --}}
@endsection
@section('content')

@include('surat-syarat.tambah')
<style type="text/css">

</style>

<!-- partial -->
<div class="main-content">
  <section class="section mt-4">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header p-0 col-12 justify-content-between px-4">
                      <div class="col-md-6 col-lg-6 text-left col-12">
                          <h5 class="text-blue" id="filter_surat_jenis">Surat Syarat</h5>
                    {{-- <h4 class="card-title" id="filter_surat_jenis"></h4> --}}

                      </div>
                      <div class="col-md-6 col-lg-6 d-flex col-12 justify-content-end">
                          <div class="card-header-action mx-1">
                              <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambah">Tambah
                                  Data <i class="fas fa-plus"></i></a>
                          </div>
                      </div>
                  </div>

                  <div class="card-body  pb-5 pt-2">

                          <div class="table-responsive overflow-hidden table-invoice">
                              <table id="table-data" class="table w-100 table-hover">
                                  <thead>
                              <tr>
                                <th>No</th>
                                <th>Syarat Perizinan</th>
                                <th>Surat Jenis</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                {{-- data table ajax --}}
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
</div>
</section>
</div>

@endsection

{{-- script khusus pada pages kode rekening --}}
@section('soloScript')

{{-- data table --}}
<script src="{{ asset('assets\DataTables-1.10.21\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets\DataTables-1.10.21\js\dataTables.bootstrap4.js') }}"></script>
{{-- end data table --}}
<script>
// var baseUrlChange += "/simpansuratsyarat";

const searchParams = new URLSearchParams(window.location.search);
const surat_jenis_id = searchParams ? searchParams.get('id') : null;
@php
$getId = $_GET ? $_GET['id'] : null;
  $surat_jenis = DB::table("surat_jenis")->where("id", $getId !== null ? $getId : '' )->first()
@endphp
var surat_jenis_nama = <?php echo json_encode($surat_jenis ? $surat_jenis->nama : '') ?>;
document.getElementById("filter_surat_jenis").innerHTML = surat_jenis_id ? 'Syarat Perizinan ( ' + surat_jenis_nama + ' )' : 'Syarat Perizinan';

// console.log({surat_jenis_id});
var table = $('#table-data').DataTable({
        processing: true,
        // responsive:true,
        // pageLength : 2,
        // lengthMenu: [ 2, 4 ],
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
            url:  surat_jenis_id !== null ? "{{ url('/suratsyarattable') }}/" + surat_jenis_id : "{{ url('/suratsyarattableall') }}" ,
        },
        columnDefs: [

              {
                 targets: 0 ,
                 className: 'center id '
              },
              {
                 targets: 1,
                 className: ' w-50'
              },
              {
                 targets: 2,
                 className: 'type center'
              },
             
            ],
        "columns": [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'nama', name: 'nama'},
          {data: 'surat_jenis', name: 'surat_jenis'},
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
      url:baseUrl + '/editsuratsyarat',
      data:{id},
      dataType:'json',
      success:function(data){
        $('#tambah').modal('show');

        $('.id').val(data.id);
        $('.nama').val(data.nama);
        $('#surat_jenis_id').val(data.surat_jenis_id);
        $('#surat_jenis_id').select2();
        $('.syarat_template').val(data.syarat_template);

      
        // $('.datepicker').val(data.created_at)
      }
    });

  }

  $('#simpan').click(function () {
    var formdata = new FormData();
    formdata.append('nama', $('.nama').val()); 
    formdata.append('id', $('.id').val()); 
    formdata.append('surat_jenis_id', $('#surat_jenis_id').val()); 
    formdata.append('syarat_template', $('.syarat_template')[0].files[0]); // Sesuaikan nama properti dengan nama yang diharapkan oleh server
    // var csrfToken = $('meta[name="csrf-token"]').attr('content');
    // Menampilkan isi data menggunakan console log

    $.ajax({
        url: baseUrl + '/simpansuratsyarat',
        type: 'POST', // Perlu ditentukan method POST
        data: formdata,
        contentType: false, // Penting: Jangan mengatur contentType dan processData menjadi true saat mengirim FormData
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'// Sertakan token CSRF dalam header permintaan
        },
        success: function (data) {
    console.log(data);

            if (data.status == 1) {
              console.log({data})
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Disimpan!',
                });
                reloadall();
            } else if (data.status == 2) {
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Gagal disimpan!',
                });
            } else if (data.status == 3) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Diubah!',
                });
                reloadall();
            } else if (data.status == 4) {
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Gagal Diubah!',
                });
            }
        },
        error: function (error) {
            console.error('Error:', error);
            iziToast.error({
                icon: 'fa fa-times',
                message: 'Terjadi kesalahan saat mengirim data!',
            });
        },
    });
});



  function hapus(id) {
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Hapus data',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url:baseUrl + '/hapussuratsyarat',
            data:{id},
            dataType:'json',
            success:function(data){
              iziToast.success({
                  icon: 'fa fa-trash',
                  message: 'Data Berhasil Dihapus!',
              });

              reloadall();
            }
          });
  			}, true],
  			['<button>Tidak</button>', function (instance, toast) {
  				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
  			}],
  		]
  	});
  }

  function reloadall() {
    $('.table_modal :input').val("");
    $('#tambah').modal('hide');
    // $('#table_modal :input').val('');
   
    // $(".inputtext").val("");
    $('#surat_jenis_id').val('');
    $('#surat_jenis_id').select2();
    // var table1 = $('#table_modal').DataTable();
    // table1.ajax.reload();
    table.ajax.reload();
  }
</script>
@endsection
