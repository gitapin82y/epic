
 <!-- General JS Scripts -->
<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
{{-- <script src="{{asset('assets/popper/dist/umd/popper.min.js')}}"></script> --}}
  {{-- <script src="{{asset('assets/js/bootstrap.min.js')}}"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="{{asset('assets/js/jquery.nicescroll.min.js')}}"></script>
 <script
      src="{{asset('assets/js/moment.min.js')}}">
  </script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
  <!-- Template JS File -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>

  <script>
     var baseUrl = '{{ url('/') }}';

     $('.input-daterange').datepicker({
      format:'dd-mm-yyyy'
  });


  $('.select2').select2({
      width: '100%'
    });


  iziToast.settings({
  timeout: 3000,
  icon: 'material-icons',
  transitionIn: 'flipInX',
  transitionOut: 'flipOutX',
  closeOnClick: true,
  position:'topRight'
  });

  $(document).ready(function () {
        $('.notifikasi .dropdown-toggle-notifikasi').click(function () {
            // Toggle class 'show' pada dropdown notifikasi
            $('.dropdown-menu-notifikasi').toggleClass('show');
        });
    });

    @if (session('sendSurvey'))
iziToast.success({
 icon: 'fa fa-save',
 message: 'Survey Berhasil Dikirim',
});
@endif

// $(document).ready(function() {
//     // Menghentikan event klik agar tidak menyebar ke dropdown profil
//     $('.head-dropdown-notif').on('click', function(e) {
//         e.stopPropagation();
//     });

//     // ... (kode lainnya)

//     // Selengkapnya, jika diperlukan
// });

  </script>
