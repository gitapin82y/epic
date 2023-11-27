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

@include('petugas.tambah')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header p-0 col-12 justify-content-between px-4">
                        <div class="col-md-6 col-lg-6 text-left col-12">
                            <h5 class="text-blue">Kelola Petugas</h5>
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
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Nama Lengkap</th>
                                            <th>Role</th>
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

    var table = $('#table-data').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            searching: true,
            paging: true,
            
            // dom: 'Bfrtip',
            title: '',
            buttons: [
                // 'pdf'
            ],
            ajax: {
                url:'{{ url('/petugastable') }}',
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
                     className: 'type center'
                  },
                  {
                     targets: 3,
                     className: 'center'
                  },
                  {
                     targets: 4,
                     className: 'center'
                  }
                ],
            "columns": [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'username', name: 'username'},
              {data: 'password', name: 'password'},
              {data: 'nama_lengkap', name: 'Nama Lengkap'},
              {data: 'role', name: 'role'},
              {data: 'aksi', name: 'aksi'},
    
            ]
      });
    
    
    
      function edit(id) {
        // body...
        $.ajax({
          url:baseUrl + '/editpetugas',
          data:{id},
          dataType:'json',
          success:function(data){
            // console.log
            $('.id').val(data.id);
            $('.nama_lengkap').val(data.nama_lengkap);
            $('.username').val(data.username);
            $('.password').val(data.password);
            $('#role_id').val(data.role_id);
            $('#role_id').select2();
    
            
            
            // $('.datepicker').val(data.created_at)
            $('#tambah').modal('show');
          }
        });
    
      }
    
      $('#simpan').click(function(){
        $.ajax({
          url: baseUrl + '/simpanpetugas',
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
                url:baseUrl + '/hapuspetugas',
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
        $('#role_id').val('');
        $('#role_id').select2();
        // var table1 = $('#table_modal').DataTable();
        // table1.ajax.reload();
        table.ajax.reload();
      }
    </script>

@endsection
{{-- end script khusus pada pages kode rekening --}}