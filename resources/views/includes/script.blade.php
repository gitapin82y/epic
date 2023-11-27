
 <!-- General JS Scripts -->
<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/popper/dist/umd/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.nicescroll.min.js')}}"></script>
 <script
      src="{{asset('assets/js/moment.min.js')}}">
  </script>
  <script src="{{asset('assets/js/stisla.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
  <!-- Template JS File -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <script src="{{asset('assets/js/custom.js')}}"></script>

  <script>
     var baseUrl = '{{ url('/') }}';

     $('.input-daterange').datepicker({
      format:'dd-mm-yyyy'
  });

  iziToast.settings({
  timeout: 3000,
  icon: 'material-icons',
  transitionIn: 'flipInX',
  transitionOut: 'flipOutX',
  closeOnClick: true,
  position:'topRight'
  });

  </script>
