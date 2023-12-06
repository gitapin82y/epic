<?php

function FormatRupiah($angka) {
  $number = "Rp. " . number_format($angka,2,',','.');

  return $number;
}

function FormatRupiahFront($angka) {
  $number = "Rp. " . number_format($angka,0,',','.');

  return $number;
}

// if (! function_exists('asset')) {
//   /**
//    * Generate an asset path for the application.
//    *
//    * @param  string  $path
//    * @param  bool    $secure
//    * @return string
//    */
//   function asset($path, $secure = null)
//   {
//       return app('url')->asset("public/".$path, $secure);
//   }
// }
