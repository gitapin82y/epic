
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
 
   
  <script type="text/javascript">
    $('.input-daterange').datepicker({
        format:'dd-mm-yyyy'
    });
  </script>

  <script type="text/javascript">
  iziToast.settings({
    timeout: 3000,
    icon: 'material-icons',
    transitionIn: 'flipInX',
    transitionOut: 'flipOutX',
    closeOnClick: true,
    position:'topRight'
  });
  $(document).ready(function(){


    $("input[type='number'] .number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    var datepicker = $('.datepicker').datepicker({
      format:"dd-mm-yyyy",
      autoclose:true
    });

    var datepicker_today = $('.datepicker_today').datepicker({
      format:"dd-mm-yyyy",
      autoclose:true
    }).datepicker("setDate", "0");

    var datepicker_today1 = $('.datepicker_today1').datepicker({
      format:"dd-mm-yyyy",
      autoclose:true
    });

    $('select').select2({
      width: '100%'
    });


    $('.data-table').dataTable({
          //"responsive":true,
          dom: 'Bfrtip',
          title: '',
          buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
          ],
          "pageLength": 10,
        "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
        "language": {
            "searchPlaceholder": "Search",
            // "emptyTable": "Tidak ada data",
            // "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
            "sSearch": '<i class="fa fa-search"></i>'
            // "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
            // "infoEmpty": "",
            // "paginate": {
            //         "previous": "Sebelumnya",
            //         "next": "Selanjutnya",
            //      }
          }

        });

        $('.datatbl').dataTable({
              //"responsive":true,

              "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            "paging": false,
            "language": {
                "searchPlaceholder": "Search",
                // "emptyTable": "Tidak ada data",
                // "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                "sSearch": '<i class="fa fa-search"></i>'
                // "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                // "infoEmpty": "",
                // "paginate": {
                //         "previous": "Sebelumnya",
                //         "next": "Selanjutnya",
                //      }
              }

            });
    $(".hanya_angka").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && e.which != 46 && (e.which < 48 || e.which > 57)) {
        //display error message
        return false;
    }
   });

  });
  var t ;
  var baseUrl = '{{ url('/') }}';
  // var regex_huruf = replace(/[A-Za-z$. ,-]/g, "");
  // var regex_angka = replace(/[^0-9\-]+/g,"");

  //function
  $('.format_money').mask('000.000.000.000.000', {reverse: true});
  // $('.format_money_kosongan').maskMoney({prefix:' ', allowNegative: false, thousands:'', decimal:'',precision:false, affixesStay: false});
  $('.right').css('text-align','right')
  $('.sembuyikan').css('display','none')
  $('.tampilkan').css('display','block')
  $('.bintang_merah').css('color','red')
  $('.red').css('color','red')
  $('.readonly').attr('readonly',true)




</script>
<!-- sidebar -->
<script>
    // Get Cookie
    var sidebar = Cookies.get('sidebar');

    // Cookie Sidebar Exists
    if (sidebar){
        $('body').addClass(sidebar);

        if (sidebar=='sidebar-light')
        {
          $('#sidebar-light-theme').addClass('selected');
          $('#sidebar-default-theme').removeClass('selected');

        }
        if (sidebar=='sidebar-default')
        {
          $('#sidebar-default-theme').addClass('selected');
          $('#sidebar-light-theme').removeClass('selected');

        }
    }
    // Cookie Sidebar Doesn't Exist
    else {
        $('body').addClass();
    }

    // Sidebar Option Cookie
    $('#sidebar-light-theme').on('click', function(){
        $('body').addClass('sidebar-light');
        $('#sidebar-light-theme').addClass('sidebar-light selected');
        Cookies.set('sidebar', 'sidebar-light',{ expires : 365});

    });

    $('#sidebar-default-theme').on('click', function(){
        $('body').removeClass('sidebar-light');
        Cookies.set('sidebar', 'sidebar-default',{ expires : 365});
    });

    // Get Cookie
    var navbar  = Cookies.get('navbar');
    // Cookie Navbar Exists
    if (navbar){
        $('.navbar').addClass(navbar);
        if(navbar=='navbar-primary')
        {
          $('div.tiles.primary').addClass('selected');
        }
        if(navbar=='navbar-success')
        {
          $('div.tiles.success').addClass('selected');
        }
        if(navbar=='navbar-warning')
        {
          $('div.tiles.warning').addClass('selected');
        }
        if(navbar=='navbar-danger')
        {
          $('div.tiles.danger').addClass('selected');
        }
        if(navbar=='navbar-pink')
        {
          $('div.tiles.pink').addClass('selected');
        }
        if(navbar=='navbar-dark')
        {
          $('div.tiles.dark').addClass('selected');
        }
        if(navbar=='navbar-light')
        {
          $('div.tiles.light').addClass('selected');
        }
    }
    // Cookie Navbar Doesn't Exist
    else {
        $('.navbar').addClass('navbar-light');
        $('div.tiles.light').addClass('selected');
    }
    // Navbar Option Cookie
    $('div.tiles.primary').on('click', function(){
        $('.navbar').addClass('navbar-primary');
        Cookies.set('navbar', 'navbar-primary', {expires : 365});
    });
    $('div.tiles.success').on('click', function(){
        $('.navbar').addClass('navbar-success');
        Cookies.set('navbar', 'navbar-success', {expires : 365});
    });
    $('div.tiles.warning').on('click', function(){
        $('.navbar').addClass('navbar-warning');
        Cookies.set('navbar', 'navbar-warning', {expires : 365});
    });
    $('div.tiles.danger').on('click', function(){
        $('.navbar').addClass('navbar-danger');
        Cookies.set('navbar', 'navbar-danger', {expires : 365});
    });
    $('div.tiles.pink').on('click', function(){
        $('.navbar').addClass('navbar-pink');
        Cookies.set('navbar', 'navbar-pink', {expires : 365});
    });
    $('div.tiles.info').on('click', function(){
        $('.navbar').addClass('navbar-info');
        Cookies.set('navbar', 'navbar-info', {expires : 365});
    });
    $('div.tiles.dark').on('click', function(){
        $('.navbar').addClass('navbar-dark');
        Cookies.set('navbar', 'navbar-dark', {expires : 365});
    });
    $('div.tiles.light').on('click', function(){
        $('.navbar').addClass('navbar-light');
        Cookies.set('navbar', 'navbar-light', {expires : 365});
    });
</script>

  {{-- Filter Menu --}}
    <script type="text/javascript">

      $(document).ready(function(){
        // custom function .ignore()
        $.fn.ignore = function(sel){
          return this.clone().find(sel||">*").remove().end();
        };
        // end custom function

        $cancel_search = $('#btn-reset');
        $btn_search_menu = $('#btn-search-menu');
        $search_fld = $('#filterInput');
        $filter = $search_fld.val().toUpperCase();
        $ul = $('#ayaysir');
        $li = $ul.children('li');

        // $('#wid-id-0 .widget-body').html($('#sidebar ul > li').parents('li').text() + '<br>')
        $('#sidebar ul > li > a').each(function(){
          $(this).prepend('<span class="d-none"> '+ $(this).parents('li').find('.menu-title').text() +'</span>');
        });
        $('#sidebar ul > li:has(ul) > a').each(function(){
          $(this).prepend('<span class="d-none d-sm-none"> '+ $(this).parent('li').children().ignore('span').text() +'</span>');
        });
        $('#sidebar ul > li > ul > li > a').each(function(){
          $(this).prepend('<span class="d-none d-xs-none"> '+ $(this).parent().parent().parent().ignore('span').ignore('ul').text() +'</span>');
        });

        $search_fld.on('keyup focus blur resize', function(){

          if($(this).val().length != 0){
            // alert('a');
            $('#btn-reset').removeClass('d-none');
          } else {
            $('#btn-reset').addClass('d-none');
          }

          var input, filter, ul, li, a, i;
              input = document.getElementById("filterInput");
              filter = input.value.toUpperCase();
              ul = document.getElementById("ayaysir");
              li = ul.getElementsByTagName("li");
              for (i = 0; i < li.length; i++) {
                  a = li[i].getElementsByTagName("a")[0];
                  if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                      li[i].style.display = "";
                  } else {
                      li[i].style.display = "none";

                  }
              if($(this).val() != 0){
                $('#sidebar ul > li > a').find('.menu-title').parents('li').find('div').addClass('show');
                // $('#sidebar ul > li > a').find('.menu-title').parents('li').find('ul').css('display', 'block');

              } else {

                $('#sidebar ul > li > a').find('.menu-title').parents('li').find('div').removeClass('show');
                // $('#sidebar ul > li > a').find('.menu-title').parents('li').find('ul').css('display', 'none');


                if ($('#sidebar ul > li > a').parents('li').hasClass('active') === true ) {

                  $('#sidebar ul > li > a').parents('ul').find('.active').find('div').addClass('show');
                  // $('#sidebar ul > li > a').parents('ul').find('.active').children('ul').css('display', 'block');
                }
              }
              }
        });

        $cancel_search.on('click', function(){
          $search_fld.val(null);
          $search_fld.focus();
        });


        $btn_search_menu.on('click', function(){
          $search_fld.focus();
        });




      });


    </script>
    
<script>
  

         @if (session('sendSurvey'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Survey Berhasil Dikirim',
  });
  @endif

  @if (session('sendSurveyError'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Survey Berhasil Dikirim',
  });
  @endif


  @if (session('updateStatusPertanyaan'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Status pertanyaan berhasil diupdate',
  });
  @endif
</script>

<script type="text/javascript">

      $('.clockpicker').clockpicker({
        donetext: 'OK'
      });   // clockpicker js

</script>

<script type="text/javascript">

  $(function() {
    $('.currency').maskMoney(
      {
        prefix:'Rp. ',
        allowZero: true,
        allowNegative: true,
        thousands:'.',
        decimal:',',
        affixesStay: false
      }
    );
  })

$('.nominal').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

$('.rp').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});

</script>


{{-- Close THeme Setting --}}
<script type="text/javascript">
  $(document).ready(function(){
    $('.container-scroller').click(function(){
      $('#theme-settings').removeClass('open');
    })
  });

  // var lockscreen = '{{Session::get('lockscreen')}}';
  // if (lockscreen == 'yes') {
  //   window.location.href = "{{url('/lockscreen')}}?url={{encrypt(url()->full())}}"
  // } else {
  //   var timeout;
  //   document.onmousemove = function(){
  //     clearTimeout(timeout);
  //     timeout = setTimeout(function(){ window.location.href = "{{url('/lockscreen')}}?url={{encrypt(url()->full())}}" }, 6000000);
  //   }
  // }

  function get_currency(v) {
	if( /^\d([0-9\.]+)$/.test(v) ) {

		var desimal = '';
		if( /\./.test(v) ==  true ) {
			v = parseFloat(v);
			v = v.toFixed(2);
			v = v.toString();
			desimal = v.split('.')[1];
			v = v.split('.')[0];
		}


		v = v.toString();
		var res = v.split('');
		res = res.reverse().join('');
		currStr = v;
		if(res.length > 3) {
			var currPtr = /(\w{3})/g;
			var currStr = res.replace(currPtr, '$1.').split('').reverse().join('').replace(/^\.(.*)/, '$1');
		}


		currStr += desimal != '' ? ',' + desimal : '';
		return currStr;
	}

	return v;
}
</script> 