@extends('layouts.app')

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

@include('pertanyaan-survey-kepuasan.tambah')
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
                          <h5 class="text-blue">Pertanyaan Survey Kepuasan</h5>
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
                                <th>Judul</th>
                                <th>Status</th>
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
<!-- content-wrapper ends -->
@endsection

{{-- script khusus pada pages kode rekening --}}
@section('soloScript')

{{-- data table --}}
<script src="{{ asset('assets\DataTables-1.10.21\js\jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets\DataTables-1.10.21\js\dataTables.bootstrap4.js') }}"></script>
{{-- end data table --}}
<script>

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
            url:'{{ url('/pertanyaansurveykepuasantable') }}',
        },
        columnDefs: [

              {
                 targets: 0 ,
                 className: 'center id'
              },
              {
                 targets: 1,
                 className: 'nominal center'
              },
              {
                 targets: 2,
                 className: 'nominal center'
              },
              {
                 targets: 3,
                 className: 'type center'
              },
             
            ],
        "columns": [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'nama', name: 'nama'},
          {data: 'is_active', name: 'is_active',
              render: function(data){
                return (data == 'Y') ? 'Aktif' : 'Non-Aktif';
              }
        },
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
      url:baseUrl + '/editpertanyaansurveykepuasan',
      data:{id},
      dataType:'json',
      success:function(data){
        // console.log
        $('.id').val(data.id);
        $('.nama').val(data.nama);
      
        // $('.datepicker').val(data.created_at)
        $('#tambah').modal('show');
      }
    });

  }

  $('#simpan').click(function(){
    $.ajax({
      url: baseUrl + '/simpanpertanyaansurveykepuasan',
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
            url:baseUrl + '/hapuspertanyaansurveykepuasan',
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
    // var table1 = $('#table_modal').DataTable();
    // table1.ajax.reload();
    table.ajax.reload();
  }
</script>
@endsection
