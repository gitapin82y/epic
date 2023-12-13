@extends('main')

@section('extra_style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
body {
    background-color: #f3f8fb;
}
#map {
    height: 50vh;
    width: 100%;
    z-index: 1;
}
</style>
@endsection

@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb bg-warning">
                    <li class="breadcrumb-item active" aria-current="page">Laporan Survey</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="form1" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row">
                            <input type="hidden" class="form-control" id="survey_id" name="survey_id" value="{{ $suratId->id }}">

                            @foreach ($dataSurveyPertanyaan as $index => $list)
                            <div class="form-group col-6">
                                <label for="jawaban{{ $index }}"  >{{ $index + 1 }}) {{ $list->pertanyaan }}</label>
                                <input type="hidden" class="form-control" name="survey_pertanyaan_id[]" value="{{ $list->id }}">
                                <textarea class="form-control mt-2" name="jawaban[]" id="jawaban{{ $index }}"></textarea>
                            </div>
                            @endforeach
                        </div>
                        <div class="row btn-update-profile mt-4">
                            <button type="button" class="btn btn-main text-light" id="kirim">Kirim Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_script')

<script>
$('#kirim').click(function() {
    var formData = new FormData($('#form1')[0]);

    // Ajax request untuk mengirim data ke backend
    $.ajax({
        url: baseUrl + '/isi-survey',
        type: 'POST',
        contentType: false,
        processData: false,
        data: formData,
        success: function(data) {
            if (data.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Disimpan!',
                });
                window.location.href = baseUrl + '/survey/penugasan';
            } else if (data.status == 2) {
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: data.message,
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
        error: function(error) {
            console.log(error);
        }
    });
});
</script>
@endsection
