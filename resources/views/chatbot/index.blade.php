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

<style>
    /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cacfcc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #499DB1;
}

input:focus + .slider {
  box-shadow: 0 0 1px #499DB1;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

<!-- partial -->
<div class="main-content">
  <section class="section mt-4">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Chatbot</h4>

                    <form method="POST" class="form-horizontal" action="{{ url('chatbot/save') }}" accept-charset="UTF-8" id="tambahpekerja" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="row">

                             <div class="col-md-12 col-sm-12 col-xs-12" style="height: 1%;">
                             <label class="switch">
                                @if(isset($data))
                                    @if($data->is_active == "Y")
                                    <input type="checkbox" name="is_active" checked>
                                    @else 
                                    <input type="checkbox" name="is_active">
                                    @endif
                                @else
                                <input type="checkbox" name="is_active">
                                @endif
                                <span class="slider round"></span>
                            </label>

                            <div class="col-md-4 col-sm-6 col-xs-12" style="padding:0px;">
                                <label>Jam Aktif</label>
                            </div>
                            <div class="col-md-8 col-sm-6 col-xs-12" style="padding:0px;">
                                <div class="form-group">
                                @if(isset($data))
                                <input type="text" class="form-control form-control-sm inputtext clockpicker" name="date" value="{{$data->jam_active}}">
                                @else 
                                <input type="text" class="form-control form-control-sm inputtext clockpicker" name="date" value="{{Carbon\Carbon::now()->format('H:i')}}">
                                @endif
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12" style="padding:0px;">
                                <label>Jam Selesai</label>
                            </div>
                            <div class="col-md-8 col-sm-6 col-xs-12" style="padding:0px;">
                                <div class="form-group">
                                @if(isset($data))
                                <input type="text" class="form-control form-control-sm inputtext clockpicker" name="enddate" value="{{$data->jam_selesai}}">
                                @else 
                                <input type="text" class="form-control form-control-sm inputtext clockpicker" name="enddate" value="{{Carbon\Carbon::now()->format('H:i')}}">
                                @endif
                                </div>
                            </div>
                            </div>

                      </div>

                    <div class="text-left w-100">
                      <button class="btn btn save" style="background: #499DB1; color:white; width: 150px;" type="submit">Simpan</button>
                    </div>
                  </div>
                </div>
                </form>
              </div>
            </div>
        </div>
        </section>
        </div>
<!-- content-wrapper ends -->
@endsection
@section('extra_script')
<script>
  @if (session('sukses'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Data Berhasil Disimpan!',
  });
  @endif

  @if (session('gagal'))
  iziToast.warning({
      icon: 'fa fa-info',
      message: 'Data Gagal disimpan!',
  });
  @endif
</script>
@endsection
