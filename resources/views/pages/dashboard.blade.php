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
            <h4 class="text-blue">Beranda</h4>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Perizinan</h4>
                  </div>
                  <div class="card-body">
                    12312
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="fas fa-user"></i>
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
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="fas fa-comment-dollar"></i>
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
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-comments-dollar"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Perizinan Ditolak</h4>
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
                  <h4>Statistics Tahun 2023</h4>
                </div>
                <div class="card-body">
                    <div id="chartEjjc"></div>
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
    // hight chart
    Highcharts.chart('chartEjjc', {
title: {
    text: 'Grafik Jumlah Transaksi EJJC'
},

subtitle: {
        text: 'Dari Bulan ke 1 sampai 12'
    },

yAxis: {
    title: {
        text: 'Jumlah'
    }
},

xAxis: {
    accessibility: {
        rangeDescription: 'Range: 1 to 12'
    }
},

legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
},

plotOptions: {
    series: {
        label: {
            connectorAllowed: false
        },
        pointStart: 1
    }
},

series: [{
    name: 'Bank In (BI)',
    data: [90908, 29548, 38105]
}, {
    name: 'Bank Out (BO)',
    data: [18908, 25548, 51105]
}, {
    name: 'Kas Kecil (PC)',
    data: [21908, 42548, 61105]
}, {
    name: 'Memorial (MM)',
    data: [11908, 75548, 95105]
}],

responsive: {
    rules: [{
        condition: {
            maxWidth: 500
        },
        chartOptions: {
            legend: {
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom'
            }
        }
    }]
}
});


    //  clock
    var inc = 1000;

clock();

function clock() {
  const date = new Date();

  const hours = ((date.getHours() + 11) % 12 + 1);
  const minutes = date.getMinutes();
  const seconds = date.getSeconds();
  
  const hour = hours * 30;
  const minute = minutes * 6;
  const second = seconds * 6;
  
  document.querySelector('.hour').style.transform = `rotate(${hour}deg)`
  document.querySelector('.minute').style.transform = `rotate(${minute}deg)`
  document.querySelector('.second').style.transform = `rotate(${second}deg)`
}

setInterval(clock, inc);

   });
</script>   
@endsection