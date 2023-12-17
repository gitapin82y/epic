@extends('layouts.app')

@section('title','Semua Notifikasi')

@section('soloStyle')

@endsection

@section('content')
<!-- partial -->
<div class="main-content">
<section class="section mt-4">
  <div class="row">
  	<div class="col-lg-12 grid-margin stretch-card">
        @php
        use Carbon\Carbon;
        @endphp
          <div class="card">
            <div class="row justify-content-between p-4 ">
                <div class="col-4 pt-2">
                    <h5 class="text-blue">Semua Notifikasi</h5>
                </div>
                <div class="col-2 pt-2 text-right">
                    <a href="{{ route('semuaNotifikasi', ['is_seen' => true]) }}" class="text-decoration-none text-main"><strong>Sudah Dibaca</strong></a>
                </div>
            </div>
        </div>
                <div class="card px-5 py-3">
                  @forelse($notifications as $notification)
                  <div class="my-3">
                      <strong>{{ $notification->judul }}</strong>
                      <p class="my-2">
                        {{$notification->deskripsi}}
                      </p>
                      <small class="m-0 p-0 d-block text-muted">{{ Carbon::parse($notification->created_at)->format('d F Y')}}</small>
                  </div>
                  <hr>

                @empty
                <strong class="text-center">Belum ada notifikasi</strong>
                @endforelse
                </div>
    </div>
</section>

  </div>
</div>
@endsection