@extends('layouts.app')
@section('title','Beranda')
@section('soloStyle')
<style id="clock-animations"></style>
@endsection
@section('content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h4 class="text-blue">Beranda (  @php
              echo 'Role : '. Auth::user()->role_id;
              
            @endphp )</h4>
          </div>
          <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
              <div class="card card-statistic-1 semua-perizinan">
                <div class="card-icon bg-white">
                  <img src="{{asset('assets/dashboard/semua-perizinan.png')}}" class="icon-card-dashboard" alt="">
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Semua Perizinan</h4>
                  </div>
                  <div class="card-body">
                    12312
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="card card-statistic-1 perizinan-masuk">
                <div class="card-icon bg-white">
                  <img src="{{asset('assets/dashboard/perizinan-masuk.png')}}" class="icon-card-dashboard" alt="">
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Perizinan Masuk</h4>
                  </div>
                  <div class="card-body">
                    12312
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="card card-statistic-1 perizinan-terlambat">
                <div class="card-icon bg-white">
                  <img src="{{asset('assets/dashboard/perizinan-terlambat.png')}}" class="icon-card-dashboard" alt="">
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Perizinan Terlambat</h4>
                  </div>
                  {{-- data laporan ada di dashboard controller method index --}}
                  <div class="card-body">
                    12312
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="card card-statistic-1 perizinan-dikembalikan">
                <div class="card-icon bg-white">
                  <img src="{{asset('assets/dashboard/perizinan-dikembalikan.png')}}" class="icon-card-dashboard" alt="">
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Perizinan Dikembalikan</h4>
                  </div>
                  <div class="card-body">
                    12312
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12">
              <div class="card card-statistic-1 perizinan-diterbitkan">
                <div class="card-icon bg-white">
                  <img src="{{asset('assets/dashboard/perizinan-diterbitkan.png')}}" class="icon-card-dashboard" alt="">
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Perizinan Diterbitkan</h4>
                  </div>
                  <div class="card-body">
                    12312
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h4>Statistics Tahun {{ now()->year }}</h4>
                </div>
                <div class="card-body">
                    <div id="line-chart-container"></div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
@endsection
@section('soloScript')
<script src="{{ asset('assets\highcharts\highcharts.js') }}"></script>

 <script>
   $(document).ready(function () {
     var linechart = @json($linechart);

     linechart.forEach(function(item) {
        item.total_diterbitkan = Number(item.total_diterbitkan);
        item.total_ditolak = Number(item.total_ditolak);
        item.total_masuk = Number(item.total_masuk);
    });

     Highcharts.chart('line-chart-container', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Total Perizinan Masuk, Diterbitkan dan Ditolak'
            },
            xAxis: {
                categories: linechart.map(item => monthName(item.month)),
                title: {
                    text: 'Bulan'
                }
            },
            yAxis: {
                title: {
                    text: 'Jumlah Perizinan'
                }
            },
            series: [{
                name: 'Diterbitkan',
                data: linechart.map(item => item.total_diterbitkan),
                color: '#93D7FE'
            },{
                name: 'Masuk',
                data: linechart.map(item => item.total_masuk),
                color: '#A2FF99'
            }, {
                name: 'Ditolak',
                data: linechart.map(item => item.total_ditolak),
                color: '#FFCE95'
            }]
          });

              // Fungsi untuk mendapatkan nama bulan berdasarkan angka bulan
    function monthName(monthNumber) {
        var monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        return monthNames[monthNumber - 1];
    }


        });
        
</script>   
@endsection