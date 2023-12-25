@extends('layouts.public')
@section('title','Layanan Digital Perizinan')
@push('extra_style')
  <style>
       /* Container untuk gambar */
       .image-container {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        /* Gambar */
        .image-container img {
          border-radius: 8px;
            width: 100%;
            height: auto;
            transition: transform 0.3s ease-in-out;
        }

        /* Teks yang muncul di tengah gambar saat dihover */
        .image-container .overlay-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            opacity: 0;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 2px;
            padding: 20px;
            transition: opacity 0.3s ease-in-out;
        }

        /* Efek muncul saat hover */
        .image-container:hover img {
          border-radius: 8px;
            transform: scale(1.03);
        }

        .image-container:hover .overlay-text {
            opacity: 1;
        }
        #videoPanduan a{
          color: #499db1 ;
          text-decoration: none;
        }
        #videoPanduan .card{
          min-height: 300px;
          height: auto;
          margin-top: 20px;
        }
        #videoPanduan .card h4{
          margin-top: 10px;
        }
        #videoPanduan .owl-next,
        #videoPanduan .owl-prev{
          background-color: rgba(73, 156, 177, 0.116);
          height: 50px;
          width: 50px;
          border-radius: 10px;
          padding-bottom: 30px;
          position: relative;
        }
        #videoPanduan .owl-nav {
          position: absolute !important;
          right: 0 !important;
          top: 0;
          margin-top: -60px;
          width: auto;
        }
        #videoPanduan .owl-prev {
  margin-right: 20px;
}
#videoPanduan .owl-next span,
#videoPanduan .owl-prev span {
  color: var(--main-collor);
  font-size: 54px;
  position: absolute;
  height: 0;
  top: -20px;
  left: 16px;
}

  </style>
@endpush
@section('content')
<section id="header">
  <div class="container">
    <div class="row col-12">
      <div class="col-12 col-md-6 align-self-center" data-aos="fade-right">
        <h1 class="fw-bold">
          Layanan Digital Pengurus Perizinan Sekolah
          <span class="text-main">Terpercaya</span>
        </h1>
        <p>
          Dengan epic mengurus surat perizinan lebih instan, buruan buat
          surat permohonan kamu sekarang!
        </p>
        <a href="buat-permohonan" class="btn btn-main">Buat Permohonan</a>
      </div>
      <div class="col-12 col-md-6" data-aos="fade-left">
        <img
          src="{{asset('assets/public/img/home-illustration.png')}}"
          class="w-100 mt-5 mt-md-0"
          alt=""
        />
      </div>
    </div>
  </div>
</section>

<div id="fitur-unggulan">
  <div class="container pb-5 my-5">
    <h2 class="text-center fw-bold mt-5"    data-aos-offset="200"
    data-aos="fade-up">Fitur Unggulan</h1>
    <img
      src="{{asset('assets/public/img/fitur-unggulan-bg-left.png')}}"
      class="komponenFiturLine"
      alt=""
    />
    <div class="row col-12 mx-0 px-0">
      <div
        class="col-12 col-md-3 justify-content-center d-flex"
        data-aos-offset="200"
        data-aos="fade-up"
      >
        <div class="card mt-4">
          <div class="row justify-content-center">
            <img src="{{asset('assets/public/icon/perizinan.png')}}" alt="" />
          </div>

          <h5 class="fw-bold">Perbaikan Data Perizinan</h5>
        </div>
      </div>
      <div
        class="col-12 col-md-3 justify-content-center d-flex"
        data-aos-offset="200"
        data-aos="fade-up"
      >
        <div class="card mt-4">
          <div class="row justify-content-center">
            <img src="{{asset('assets/public/icon/pelacakan.png')}}" alt="" />
          </div>

          <h5 class="fw-bold">Pelacakan Perizinan Real Time</h5>
        </div>
      </div>
      <div
        class="col-12 col-md-3 justify-content-center d-flex"
        data-aos-offset="200"
        data-aos="fade-up"
      >
        <div class="card mt-4">
          <div class="row justify-content-center">
            <img src="{{asset('assets/public/icon/unduh.png')}}" alt="" />
          </div>
          <h5 class="fw-bold">Unduh dan Cetak Perizinan</h5>
        </div>
      </div>
      <div
        class="col-12 col-md-3 justify-content-center d-flex"
        data-aos-offset="200"
        data-aos="fade-up"
      >
        <div class="card mt-4">
          <div class="row justify-content-center">
            <img src="{{asset('assets/public/icon/realtime.png')}}" alt="" />
          </div>

          <h5 class="fw-bold">Real Time Chat Dengan Petugas</h5>
        </div>
      </div>
    </div>
    <img
      src="{{asset('assets/public/img/fitur-unggulan-bg-right.png')}}"
      class="komponenFiturDots"
      alt=""
    />
  </div>
</div>

<!-- total -->
<section id="total">
  <div class="container text-center">
    <div class="row justify-content-center text-center text-white">
      <div class="col-md-2 col-6 my-4">
        <h1>
          <span
            data-purecounter-start="0"
            data-purecounter-end="823"
            data-purecounter-duration="2"
            class="purecounter"
          ></span>
        </h1>

        <h6>Pengguna</h6>
      </div>
      <div class="col-md-2 col-6 my-4">
        <h1>
          <span
            data-purecounter-start="0"
            data-purecounter-end="852"
            data-purecounter-duration="2"
            class="purecounter"
          ></span>
        </h1>

        <h6>Perizinan Masuk</h6>
      </div>
      <div class="col-md-2 col-6 my-4">
        <h1>
          <span
            data-purecounter-start="0"
            data-purecounter-end="983"
            data-purecounter-duration="2"
            class="purecounter"
          ></span>
        </h1>

        <h6>Perizinan Selesai</h6>
      </div>
    </div>
  </div>
</section>
<!-- end total -->

<section id="videoPanduan">
  <div class="container">
    <div class="row">
      <div class="text-left text-md-start">
        <h2 class="mt-1 fw-bold">Video Panduan</h2>
      </div>
    </div>
      <div class="row owl-carousel owl-theme">
        @foreach ($videos as $video)
          <a href="{{$video->url}}" class="item w-100 p-2 mx-2" target="_blank">
            <div class="card p-2 text-center w-100">
              @php
              $segments = explode('/', trim(parse_url($video->url, PHP_URL_PATH), '/'));
            @endphp
            <div class="image-container">
            <img src="https://img.youtube.com/vi/{{isset($segments[0]) ? $segments[0] : null}}/maxresdefault.jpg" class="w-100 mb-2" alt="Video Cover">
            <div class="overlay-text">Lihat Video</div>
            </div>
            <h4>{{$video->nama}}</h4>
            </div>
          </a>
        @endforeach
      </div>
  </div>
</section>


<section id="testimoni">
  <div class="container bg-color">
    <div class="row">
      <div class="text-left text-md-start mb-5">
        <h2 class="mt-1 fw-bold">Apa Kata Mereka?</h2>
      </div>
    </div>
    <div class="row owl-carousel owl-theme">
      <div class="card-item item">
        <div class="row">
          <div class="col-3">
            <img
              src="{{asset('assets/public/avatar/avatar1.png')}}"
              width="100"
              height="100"
              class="avatar"
              alt="profile testimoni"
            />
          </div>
          <div class="col-9 pl-2">
            <h3>Aditya</h3>
            <small>Surabaya, Indonesia</small>
          </div>
        </div>
        <div class="row pt-4">
          <p>
            Lorem ipsum is placeholder text commonly used in the graphic,
            print, and publishing industries
          </p>
          <img
            src="{{asset('assets/public/icon/stars.svg')}}"
            width="300"
            height="100"
            class="star"
            alt="review testimoni wipin"
          />
        </div>
      </div>
      <div class="card-item item">
        <div class="row">
          <div class="col-3">
            <img
              src="{{asset('assets/public/avatar/avatar1.png')}}"
              width="100"
              height="100"
              class="avatar"
              alt="profile testimoni"
            />
          </div>
          <div class="col-9 pl-2">
            <h3>Daffa Darma</h3>
            <small>Surabaya, Indonesia</small>
          </div>
        </div>
        <div class="row pt-4">
          <p>
            Lorem ipsum is placeholder text commonly used in the graphic,
            print, and publishing industries
          </p>
          <img
            src="{{asset('assets/public/icon/stars.svg')}}"
            width="300"
            height="100"
            class="star"
            alt="review testimoni wipin"
          />
        </div>
      </div>
      <div class="card-item item">
        <div class="row">
          <div class="col-3">
            <img
              src="{{asset('assets/public/avatar/avatar1.png')}}"
              width="100"
              height="100"
              class="avatar"
              alt="profile testimoni"
            />
          </div>
          <div class="col-9 pl-2">
            <h3>Salsabila</h3>
            <small>Surabaya, Indonesia</small>
          </div>
        </div>
        <div class="row pt-4">
          <p>
            Lorem ipsum is placeholder text commonly used in the graphic,
            print, and publishing industries
          </p>
          <img
            src="{{asset('assets/public/icon/stars.svg')}}"
            width="300"
            height="100"
            class="star"
            alt="review testimoni wipin"
          />
        </div>
      </div>
      <div class="card-item item">
        <div class="row">
          <div class="col-3">
            <img
              src="{{asset('assets/public/avatar/avatar1.png')}}"
              width="100"
              height="100"
              class="avatar"
              alt="profile testimoni"
            />
          </div>
          <div class="col-9 pl-2">
            <h3>Andre</h3>
            <small>Surabaya, Indonesia</small>
          </div>
        </div>
        <div class="row pt-4">
          <p>
            Lorem ipsum is placeholder text commonly used in the graphic,
            print, and publishing industries
          </p>
          <img
            src="{{asset('assets/public/icon/stars.svg')}}"
            width="300"
            height="100"
            class="star"
            alt="review testimoni wipin"
          />
        </div>
      </div>
    </div>
    <img
      src="{{asset('assets/public/img/testimoni-bg-left.png')}}"
      class="design1"
      alt="desain testimoni"
    />
    <img
      src="{{asset('assets/public/img/testimoni-bg-right.png')}}"
      class="design2"
      alt="desain testimoni"
    />
  </div>
</section>

<section id="faq">
  <div class="container my-5 pt-5">
    <div class="row col-12">
      <div
        class="col-12 col-md-6 text-center"
        data-aos-offset="200"
        data-aos="fade-right"
      >
        <img
          src="{{asset('assets/public/img/email-illustration.png')}}"
          class="w-75 mb-3"
          alt=""
        />
        <h2 class="fw-bold">Frequently Asked Questions</h2>
        <p>Berikut beberapa informasi yang mungkin kamu butuhkan</p>
      </div>
      <div
        class="col-12 col-md-6"
        data-aos-offset="200"
        data-aos="fade-left"
      >
        <div
          class="accordion accordion-flush row"
          id="accordionFlushExample"
        >
          <div class="col-12">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseOne"
                  aria-expanded="true"
                  aria-controls="flush-collapseOne"
                >
                  Bagaimana cara menggunakan aplikasi perizinan online?
                </button>
              </h2>
              <div
                id="flush-collapseOne"
                class="accordion-collapse collapse"
                aria-labelledby="flush-headingOne"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body">
                  <p>
                    - Pemohon dapat melihat panduan penggunaan aplikasi di menu panduan
                  </p>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button
                  class="accordion-button collapsed"
                  type="button"
                  data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseTwo"
                  aria-expanded="true"
                  aria-controls="flush-collapseTwo"
                >
                  Jenis perizinan apa yang dapat diajukan melalui aplikasi
                  ini?
                </button>
              </h2>
              <div
                id="flush-collapseTwo"
                class="accordion-collapse collapse"
                aria-labelledby="flush-headingTwo"
                data-bs-parent="#accordionFlushExample"
              >
                <div class="accordion-body">
                  <p>
                    Perizinan yang terdapat pada aplikasi ini, yaitu: <br>
- Izin Pendirian Sekolah<br>
- Izin Operasional <br>
- Perpanjangan Surat Izin Operasional
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseThree"
                aria-expanded="true"
                aria-controls="flush-collapseThree"
              >
                Bagaimana cara memantau status perizinan saya?
              </button>
            </h2>
            <div
              id="flush-collapseThree"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingThree"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <p>
                  Setelah mengajukan perizinan, Anda dapat masuk ke akun Anda dan melihat status perizinan Anda. Anda juga dapat mengakses menu tracking dan menginputkan ID Surat atau melakukan scan QR Code untuk melihat status perizinan.
                </p>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingFour">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseFour"
                aria-expanded="true"
                aria-controls="flush-collapseFour"
              >
                Apakah ada biaya untuk menggunakan aplikasi ini?
              </button>
            </h2>
            <div
              id="flush-collapseFour"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingFour"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <p>
                  Aplikasi ini tidak ada biaya dalam penggunaannya
                </p>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingFive">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#flush-collapseFive"
                aria-expanded="true"
                aria-controls="flush-collapseFive"
              >
                Apakah Aplikasi ini dapat diakses dari perangkat seluler?
              </button>
            </h2>
            <div
              id="flush-collapseFive"
              class="accordion-collapse collapse"
              aria-labelledby="flush-headingFive"
              data-bs-parent="#accordionFlushExample"
            >
              <div class="accordion-body">
                <p>
                  Ya, aplikasi ini dirancang untuk diakses dari perangkat seluler, memudahkan pengguna untuk mengajukan perizinan kapan pun dan di mana pun. Anda dapat mengunduh aplikasi mobile untuk kenyamanan penggunaan yang lebih baik.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="download-app">
  <div class="container py-5">
    <div class="row col-12 justify-content-center text-left text-md-left">
      <div
        class="col-12 col-md-4 align-self-center"
        data-aos-offset="200"
        data-aos="fade-right"
      >
        <h1 class="fw-bold">Epic tersedia di mobile app</h1>
        <p>Download epic di mobile apps sekarang</p>
        <a href="" class="btn btn-main">Play Store</a>
      </div>
      <div
        class="col-12 col-md-5 justify-content-end row"
        data-aos-offset="200"
        data-aos="fade-left"
      >
        <img src="{{asset('assets/public/img/mockup.png')}}" class="w-75" alt="" />
      </div>
    </div>
  </div>
</div>
@endsection
