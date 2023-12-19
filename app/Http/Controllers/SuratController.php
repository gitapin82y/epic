<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;

use Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;


use Yajra\Datatables\Datatables;

class SuratController extends Controller
{
    public function index() {
      return view('surat.index');
    }

    public function datatable($status) {
      // $data = DB::table('surat')->get();
      if(Auth::user()->role_id == 1 || Auth::user()->role_id == 9 || Auth::user()->role_id == 2){

      if($status != 'Semua'){
      $data = DB::table('surat')->where('status', $status)->orderby("created_at", "DESC")->get();
    }else{
      // $data;
      $data = DB::table('surat')->whereNotIn('status' , ['Selesai','Ditolak','Pengisian Dokumen'])->orderby("created_at", "DESC")->get();

    }
  }else if(Auth::user()->role_id == 3){
    $data = DB::table('surat')->where('status', 'Verifikasi Kepala Dinas')->get();
  
  }
  else if(Auth::user()->role_id == 5){
    $data = DB::table('surat')->where('status', 'Validasi Operator')->get();
  
}
else if(Auth::user()->role_id == 6){
  $data = DB::table('surat')->where('status', 'Verifikasi Verifikator')->get();

}


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
        ->addColumn("surat_jenis", function($data) {
          $surat_jenis = DB::table('surat_jenis')->where('id', $data->surat_jenis_id)->first();
          return $surat_jenis->nama;
        })
        ->addColumn('jadwal_survey', function ($data) {
          if($data->jadwal_survey !== null){
            return Carbon::parse($data->jadwal_survey)->format('d F Y');

          }else{
            return '<div><i>Belum Tersedia</i></div>';
          }
        })
        ->addColumn('status', function ($data) {
          $color = '<div><strong class="text-warning">' . $data->status . '</strong></div>';
      
          if ($data->status == "Selesai") {
              // Tombol "Approve" hanya muncul jika is_active == 1
              $color =  '<div><strong class="text-success">' . $data->status . '</strong></div>';
          } else if ($data->status == "Ditolak"){
            $color = '<div><strong class="text-danger">' . $data->status . '</strong></div>';
          }else{
            $color;
          }
          return $color;
      })
      ->addColumn('tanggal_pengajuan', function ($data) {
        return Carbon::parse($data->created_at)->format('d F Y');

      })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id.')" class="btn btn-success btn-lg pt-2" title="edit">'.
                     '<label class="fa fa-eye w-100"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi','jadwal_survey','status', 'tanggal_pengajuan'])
          ->addIndexColumn()
          // ->setTotalRecords(2)
          ->make(true);
    }

    public function indexsuratterlambat() {
      return view('surat-terlambat.index');
    }

    public function suratterlambatdatatable() {
      // $data = DB::table('surat')->get();
      if(Auth::user()->role_id == 1 || Auth::user()->role_id == 9 || Auth::user()->role_id == 2){

    //   if($status != 'Semua'){
    //   $data = DB::table('surat')->where('status', $status)->orderby("created_at", "DESC")->get();
    // }else{
      // $data;
      $data = DB::table('surat')->where('is_terlambat' , 'Y')->orderby("created_at", "DESC")->get();

    }
//   }else if(Auth::user()->role_id == 5){
//     $data = DB::table('surat')->where('status', 'Validasi Operator')->get();
  
// }
// else if(Auth::user()->role_id == 6){
//   $data = DB::table('surat')->where('status', 'Verifikasi Verifikator')->get();

// }


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
        ->addColumn("surat_jenis", function($data) {
          $surat_jenis = DB::table('surat_jenis')->where('id', $data->surat_jenis_id)->first();
          return $surat_jenis->nama;
        })
        ->addColumn('jadwal_survey', function ($data) {
          if($data->jadwal_survey !== null){
            return Carbon::parse($data->jadwal_survey)->format('d F Y');

          }else{
            return '<div><i>Belum Tersedia</i></div>';
          }
        })
        ->addColumn('status', function ($data) {
          $color = '<div><strong class="text-warning">' . $data->status . '</strong></div>';
      
          if ($data->status == "Selesai") {
              // Tombol "Approve" hanya muncul jika is_active == 1
              $color =  '<div><strong class="text-success">' . $data->status . '</strong></div>';
          } else if ($data->status == "Ditolak"){
            $color = '<div><strong class="text-danger">' . $data->status . '</strong></div>';
          }else{
            $color;
          }
          return $color;
      })
      ->addColumn('tanggal_pengajuan', function ($data) {
        return Carbon::parse($data->created_at)->format('d F Y');

      })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id.')" class="btn btn-success btn-lg pt-2" title="edit">'.
                     '<label class="fa fa-eye w-100"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi','jadwal_survey','status', 'tanggal_pengajuan'])
          ->addIndexColumn()
          // ->setTotalRecords(2)
          ->make(true);
    }

    public function simpan(Request $req) {
     
      if ($req->id == null) {
        DB::beginTransaction();
        try {

        DB::table("surat")
              ->insert([
              "nama" => $req->nama,
              "user_id" => $req->user_id,
              "surat_jenis_id" => $req->surat_jenis_id,
              "status" => 'Pengisian Dokumen',
              "kategori" => $req->kategori,
              "alamat_lokasi" => $req->alamat_lokasi,
              "longitude" => $req->longitude,
              "latitude" => $req->latitude,
              "created_at" => Carbon::now("Asia/Jakarta"),
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

          DB::commit();
          $dataBaru = DB::table("surat")->orderBy("id", "DESC")->first();
          return response()->json(["status" => 1,'message' => 'success', 'data' => $dataBaru]);
          return response()->json(["status" => 1,'message' => 'success']);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2, "message" =>$e->getMessage()]);
        }
      } else {
        DB::beginTransaction();
        try {

          DB::table("surat_jenis")
            ->where("id", $req->id)
            ->update([
              "nama" => $req->nama,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

         
          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2, "message" =>$e->getMessage()]);
        }
      }

    }

    public function uploadDokumenSyarat(Request $req)
    {
      try {
        $imgPath = null;
        $tgl = Carbon::now('Asia/Jakarta');
        $folder = $tgl->year . $tgl->month . $tgl->timestamp;
        $childPath ='file/uploads/dokumen-syarat-pemohon/';
        $path = $childPath;
        $cekDataSurat = DB::table("surat")->where("id", $req->surat_id)->first();
        $cekDataSuratDokumen = DB::table("surat_dokumen")->where("surat_syarat_id", $req->surat_syarat_id)->where("surat_id", $req->surat_id)->first();
        if ($cekDataSurat == null ) {
        return response()->json(["status" => 2, "message" => 'Data Surat Tidak Ditemukan']);

        }
        else if($cekDataSuratDokumen != null){
        // return response()->json(["status" => 2, "message" => 'Data Dokumen Sudah Ada']);
        $file = $req->file('dokumen_syarat_pemohon');
        $name = null;
        if ($file != null) {
          $name = $folder . '.' . $file->getClientOriginalExtension();
          $file->move($path, $name);
          $imgPath = $childPath . $name;
        } else {
            return 'error';
        }

       
        DB::table("surat_dokumen")
        ->where("surat_syarat_id", $req->surat_syarat_id)->where("surat_id", $req->surat_id)
        ->update([
          // "id" => $max,
          "surat_id" => $req->surat_id,
          "surat_syarat_id" => $req->surat_syarat_id,
          "dokumen_upload"=>$imgPath,
          // "created_at" => $tgl,
          "updated_at" => $tgl
        ]);
          
          DB::commit();
      
          return response()->json(["status" => 1, "message" => "Sukses Upload Dokumen Syarat Baru"]);
        }
        else{
        $file = $req->file('dokumen_syarat_pemohon');
        $name = null;
        if ($file != null) {
          $name = $folder . '.' . $file->getClientOriginalExtension();
          $file->move($path, $name);
          $imgPath = $childPath . $name;
        } else {
            return 'error';
        }

       
        DB::table("surat_dokumen")
        ->insertGetId([
          // "id" => $max,
          "surat_id" => $req->surat_id,
          "surat_syarat_id" => $req->surat_syarat_id,
          "dokumen_upload"=>$imgPath,
          "created_at" => $tgl,
          "updated_at" => $tgl
        ]);
          
          DB::commit();
      }

        return response()->json(["status" => 1, "message" => "Sukses Upload Dokumen Syarat"]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e]);
      }
  }

  public function kirimSuratPengajuan(Request $req) {
    $cekJumlahSuratSyarat = DB::table("surat_syarat")->where("surat_jenis_id", $req->surat_jenis_id)->count();
    $cekJumlahSuratDokumen = DB::table("surat_dokumen")->where("surat_id", $req->surat_id)->count();
    $cekDataUser = DB::table("surat")->join('user', 'user.id', '=', 'surat.user_id')
    ->where('surat.id', $req->surat_id)->first();
    $operator = DB::table('user')->where('role_id', '5')->first(); 

   //  if($cekDataUser){
   //   return $cekDataUser->user_id;
   //  }
   if($req->surat_jenis_id && $req->surat_id){
    if($cekJumlahSuratDokumen < $cekJumlahSuratSyarat){
     return response()->json(["status" => 2, "message" => "Dokumen Syarat Mohon Dilengkapi Terlebih Dahulu"]);

    }else{
       DB::beginTransaction();
    try {

       DB::table("surat")
             ->where("id", $req->surat_id)
             ->update([
               "status" => 'Validasi Operator',
               "updated_at" => Carbon::now("Asia/Jakarta")
             ]);

         DB::commit();
         SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Pengajuan surat Anda telah sukses diajukan. Kami akan melakukan Validasi Operator.<br><br> Mohon tunggu pemberitahuan selanjutnya yaa","Permohonan Perizinan Berhasil Diajukan", $cekDataUser->email);
         PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Perizinan Berhasil Diajukan','Selamat! Pengajuan surat Anda telah sukses diajukan. Kami akan melakukan Validasi Operator, mohon tunggu pemberitahuan selanjutnya yaa' );

         PushNotifController::sendMessage($operator->id,'Hai Operator, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->surat_id.' !','Ada surat dari pemohon yang perlu segera divalidasi. Silakan akses tugas Anda sekarang dan lakukan validasi. Terima kasih!' );
         
         return response()->json(["status" => 1,'message' => 'Surat Berhasil Diajukan']);
       } catch (\Exception $e) {
         DB::rollback();
         return response()->json(["status" => 2, "message" =>$e->getMessage()]);
       }
    }
   }else{
     return response()->json(["status" => 2, "message" => "Surat Jenis belum dipilih"]);
   }

   }

    public function validasi(Request $req) {
      DB::beginTransaction();
      // if(Auth::user()->role_id ===5){
        $cekDataUser = DB::table("surat")->join('user', 'user.id', '=', 'surat.user_id')
     ->where('surat.id', $req->input('id'))->first();
     $verifikator = DB::table('user')->where('role_id', '6')->first(); 
     $admin_dinas = DB::table('user')->where('role_id', '3')->first(); 

    //  if($cekDataUser){
    //   // return $cekDataUser->nama_lengkap;
    //   return response()->json(["data" => $cekDataUser->nama_lengkap]);
    //  }
    if (Auth::check()) {
    if( Auth::user()->role_id == 5 ){
      try {

        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Verifikasi Verifikator',
              "is_dikembalikan" => "N",
              "alasan_dikembalikan" => null, 
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

        DB::commit();
        SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Pengajuan surat Anda telah sukses divalidasi. Kami akan melakukan Verifikasi Verifikator,<br><br> mohon tunggu pemberitahuan selanjutnya yaa","Permohonan Perizinan Berhasil Divalidasi", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Perizinan Berhasil Divalidasi','Selamat! Pengajuan surat Anda telah sukses divalidasi. Kami akan melakukan Verifikasi Verifikator, mohon tunggu pemberitahuan selanjutnya yaa' );

        PushNotifController::sendMessage($verifikator->id,'Hai Verifikator, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->id.' !','Ada surat dari pemohon yang perlu segera diverifikasi. Silakan akses tugas Anda sekarang dan lakukan verifikasi. Terima kasih!' );
        return response()->json(["status" => 1, "message" => "Permohonan Perizinan Berhasil Divalidasi"]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }else if(  Auth::user()->role_id == 6 )
    {
      try {

        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Penjadwalan Survey',
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

        DB::commit();
        SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Pengajuan surat Anda telah sukses diverifikasi. Kami akan melakukan Penjadwalan Survey,<br><br> mohon tunggu pemberitahuan selanjutnya yaa","Permohonan Perizinan Berhasil Diverifikasi", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Perizinan Berhasil Diverifikasi','Selamat! Pengajuan surat Anda telah sukses diverifikasi. Kami akan melakukan Penjadwalan Survey, mohon tunggu pemberitahuan selanjutnya yaa' );

        PushNotifController::sendMessage($admin_dinas->id,'Hai Admin Dinas, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->id.' !','Ada surat dari pemohon yang perlu segera dilakukan Penjadwalan Survey. Silakan akses tugas Anda sekarang dan lakukan Penjadwalan Survey. Terima kasih!' );
        return response()->json(["status" => 1]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }
  }
  // response api
  else {
    if( $req->input('role_id') == 5  ){
      try {

        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Verifikasi Verifikator',
              "is_dikembalikan" => "N",
              "alasan_dikembalikan" => null, 
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

        DB::commit();
        SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Pengajuan surat Anda telah sukses divalidasi. Kami akan melakukan Verifikasi Verifikator,<br><br> mohon tunggu pemberitahuan selanjutnya yaa","Permohonan Perizinan Berhasil Divalidasi", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Perizinan Berhasil Divalidasi','Selamat! Pengajuan surat Anda telah sukses divalidasi. Kami akan melakukan Verifikasi Verifikator, mohon tunggu pemberitahuan selanjutnya yaa' );

        PushNotifController::sendMessage($verifikator->id,'Hai Verifikator, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->id.' !','Ada surat dari pemohon yang perlu segera diverifikasi. Silakan akses tugas Anda sekarang dan lakukan verifikasi. Terima kasih!' );
        return response()->json(["status" => 1, "message" => "Permohonan Perizinan Berhasil Divalidasi"]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }else if( $req->input('role_id') == 6 )
    {
      try {

        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Penjadwalan Survey',
              "is_dikembalikan" => "N",
              "alasan_dikembalikan" => null, 
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

        DB::commit();
        SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Pengajuan surat Anda telah sukses diverifikasi. Kami akan melakukan Penjadwalan Survey,<br><br> mohon tunggu pemberitahuan selanjutnya yaa","Permohonan Perizinan Berhasil Diverifikasi", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Perizinan Berhasil Diverifikasi','Selamat! Pengajuan surat Anda telah sukses diverifikasi. Kami akan melakukan Penjadwalan Survey, mohon tunggu pemberitahuan selanjutnya yaa' );

        PushNotifController::sendMessage($admin_dinas->id,'Hai Admin Dinas, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->id.' !','Ada surat dari pemohon yang perlu segera dilakukan Penjadwalan Survey. Silakan akses tugas Anda sekarang dan lakukan Penjadwalan Survey. Terima kasih!' );
        return response()->json(["status" => 1,  "message" => "Permohonan Perizinan Berhasil Diverifikasi"]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }
}

    }

    public function kembalikan(Request $req) {
      DB::beginTransaction();
      // if(Auth::user()->role_id ===5){
        $cekDataUser = DB::table("surat")->join('user', 'user.id', '=', 'surat.user_id')
     ->where('surat.id', $req->id)->first();
     $verifikator = DB::table('user')->where('role_id', '6')->first(); 

    //  if($cekDataUser){
    //   return $cekDataUser->nama_lengkap;
    //  }
    if (Auth::check()) {

    if( Auth::user()->role_id == 5 ){

      try {

        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Pengisian Dokumen',
              "is_dikembalikan" => 'Y',
              "alasan_dikembalikan" => $req->alasan_dikembalikan,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

        DB::commit();
        SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh operator. Silakan periksa pesan alasan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali.<br><br> Alasan Dikembalikan :<br>".$req->alasan_dikembalikan."<br><br> Terima kasih atas pemahaman Anda.","Mohon Maaf, Surat No. ".$req->id." Dikembalikan !", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,"Mohon Maaf, Surat No. ".$req->id." Dikembalikan !","Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh operator. Silakan periksa email anda untuk melihat alasan dikembalikan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali." );

       
        return response()->json(["status" => 3, 'message' => 'dikembalikan']);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4, "message" => $e->getMessage()]);
      }
    }else if(  Auth::user()->role_id == 6 )
    {
      try {

        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Pengisian Dokumen',
              "is_dikembalikan" => 'Y',
              "alasan_dikembalikan" => $req->alasan_dikembalikan,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

        DB::commit();
        SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh verifikator. Silakan periksa pesan alasan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali.<br><br> Alasan Dikembalikan :<br>".$req->alasan_dikembalikan."<br><br> Terima kasih atas pemahaman Anda.","Mohon Maaf, Surat No. ".$req->id." Dikembalikan !", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,"Mohon Maaf, Surat No. ".$req->id." Dikembalikan !","Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh verifikator. Silakan periksa email anda untuk melihat alasan dikembalikan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali." );

       
        return response()->json(["status" => 3, 'message' => 'dikembalikan']);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4, "message" => $e->getMessage()]);
      }
    }
  }else{
    if( $req->input('role_id') == 5 ){
      $cekStatus = DB::table('surat')->where('id', $req->input('id'))->first();
      
      try {
        if($cekStatus->status == 'Validasi Operator'){
        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Pengisian Dokumen',
              "is_dikembalikan" => 'Y',
              "alasan_dikembalikan" => $req->alasan_dikembalikan,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

      DB::commit();

        SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh operator. Silakan periksa pesan alasan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali.<br><br> Alasan Dikembalikan :<br>".$req->alasan_dikembalikan."<br><br> Terima kasih atas pemahaman Anda.","Mohon Maaf, Surat No. ".$req->id." Dikembalikan !", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,"Mohon Maaf, Surat No. ".$req->id." Dikembalikan !","Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh operator. Silakan periksa email anda untuk melihat alasan dikembalikan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali." );

       
        return response()->json(["status" => 1, 'message' => 'dikembalikan operator']);
          }else{
        return response()->json(["status" => 2, "message" => "Status Surat bukan Validasi Operator"]);

          }
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }

    }else if(  $req->input('role_id') == 6 )
    {
      $cekStatus = DB::table('surat')->where('id', $req->input('id'))->first();
      
      try {
        if($cekStatus->status == 'Verifikasi Verifikator'){

        DB::table("surat")
            ->where("id", $req->id)
            ->update([
              "status" => 'Pengisian Dokumen',
              "is_dikembalikan" => 'Y',
              "alasan_dikembalikan" => $req->alasan_dikembalikan,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

      DB::commit();

        SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh verifikator. Silakan periksa pesan alasan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali.<br><br> Alasan Dikembalikan :<br>".$req->alasan_dikembalikan."<br><br> Terima kasih atas pemahaman Anda.","Mohon Maaf, Surat No. ".$req->id." Dikembalikan !", $cekDataUser->email);
        PushNotifController::sendMessage($cekDataUser->user_id,"Mohon Maaf, Surat No. ".$req->id." Dikembalikan !","Sayangnya, surat dengan nomor No. ".$req->id."  Anda ditolak oleh verifikator. Silakan periksa email anda untuk melihat alasan dikembalikan dan lakukan koreksi sesuai petunjuk yang diberikan untuk mengajukan kembali." );

       
        return response()->json(["status" => 1, 'message' => 'dikembalikan verifikator']);
          }else{
        return response()->json(["status" => 2, "message" => "Status Surat bukan Verifikasi Verifikator"]);

          }
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }

    }
  }

    }
    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("surat_jenis")
            ->where("id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function edit(Request $req) {
      $surat = DB::table("surat")
              ->where("id", $req->id)
              ->first();

      $user = DB::table("user")
              ->where("id", $surat->user_id)
              ->first();
      $surat_jenis = DB::table("surat_jenis")
              ->where("id", $surat->surat_jenis_id)
              ->first();

      $surat_dokumen = DB::table("surat_dokumen")->join('surat_syarat', 'surat_syarat.id', '=', 'surat_dokumen.surat_syarat_id')
      ->where('surat_dokumen.surat_id', $surat->id)->get();

      

      $data = [
       'surat' => $surat,
       'user' => $user,
       'surat_jenis' => $surat_jenis,
       'tanggal_pengajuan' => Carbon::parse($surat->created_at)->format('d F Y'),
       'jadwal_survey' => $surat->jadwal_survey ? Carbon::parse($surat->jadwal_survey)->format('d F Y') : 'Belum Tersedia',
       'surat_dokumen' => $surat_dokumen
      ];
      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }

    public function tes()
  {
    DB::beginTransaction();

    // Carbon::setTimeZone('Asia/Jakarta');

    // $surat = Surat::where(['status' => 'Verifikasi Operator'])->first();
    $surat = DB::table('surat')->where('status', 'Validasi Operator')->first();

    $updated_at = Carbon::parse($surat->updated_at)->tz('Asia/Jakarta');
    $tenggat = $updated_at->copy()->addDays(1);

    $origin = date_create($tenggat->tz('Asia/Jakarta')->toDateString());
    $target = date_create(Carbon::now()->tz('Asia/Jakarta')->toDateString());
    $interval = date_diff($origin, $target);

    // if ($tenggat->tz('Asia/Jakarta')->toDateString()>Carbon::now()->tz('Asia/Jakarta')->toDateString()) {
    //   // $surat->is_terlambat = 'Y';
    //   // $surat->save();
    //   DB::table("surat")
    //   ->where("id", $surat->id)
    //   ->update([
    //     "is_terlambat" => 'Y',
    //   ]);

    //   DB::commit();

    //   return response()->json([
    //     'data' => $surat
    //   ]);
    // }
    return response()->json([
      'tgl skrng' => Carbon::now()->tz('Asia/Jakarta')->toDateString(),
      'tenggat' => $tenggat->tz('Asia/Jakarta')->toDateString(),
      'interval' => $interval->format('%R%a'),
      'hasil' => Carbon::now()->tz('Asia/Jakarta')->toDateString()>$tenggat->tz('Asia/Jakarta')->toDateString()
      // 'surat' => $surat->updated_at->tz('Asia/Jakarta')->toDateString(),
    ]);
  }
  public function getData(Request $req){
    try{
      if($req->input('user_id') ){
        $data = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*', 'surat_jenis.nama as surat_jenis_nama')->where('user_id', $req->input('user_id'))->whereNotIn('status' , ['Selesai','Ditolak','Pengisian Dokumen'])->get();
      }else{
        if($req->input('status')){
        $data = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*', 'surat_jenis.nama as surat_jenis_nama')->where('status', $req->input('status'))->where(function ($query) {
          $query->whereNotIn('status' , ['Selesai','Ditolak','Pengisian Dokumen']);
      })->get();
    }else{
      $data = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*', 'surat_jenis.nama as surat_jenis_nama')->where(function ($query) {
        $query->whereNotIn('status' , ['Selesai','Ditolak','Pengisian Dokumen']);
    })->get();
    }
      }
      return response()->json(['status' => 1, 'data' => $data]);
    }catch(\Exception $e){
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }

  public function listSemuaPerizinan() {
    try{

    $surat = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*','surat.id as id_surat', 'surat_jenis.nama as surat_jenis_nama')->whereNotIn('surat.status', ['Selesai', 'Ditolak'])->get();

    $data = [];

    foreach ($surat as $item) {
        $data[] = [
            'id'               => $item->id_surat,
            'jenis_perizinan' => $item->surat_jenis_nama,
            'nomor_surat'      => $item->id_surat,
            'tanggal'          => $item->created_at,
            'perizinan'        => $item->is_terlambat == 'Y' ? 'Terlambat' : 'Masuk',
        ];
    }

    return response()->json(['status' => 1, 'data' => $data]);
  }catch(\Exception $e){
    return response()->json(["status" => 2, "message" => $e->getMessage()]);
  }
  }

  public function listPerizinanMasuk() {
    try{

    $surat = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*','surat.id as id_surat', 'surat_jenis.nama as surat_jenis_nama')->where('surat.is_terlambat','N')->whereNotIn('surat.status', ['Selesai', 'Ditolak'])->get();

    $data = [];

    foreach ($surat as $item) {
        $data[] = [
            'id'               => $item->id_surat,
            'jenis_perizinan' => $item->surat_jenis_nama,
            'nomor_surat'      => $item->id_surat,
            'tanggal'          => $item->created_at,
            'perizinan'        => 'Masuk',
        ];
    }

    return response()->json(['status' => 1, 'data' => $data]);
  }catch(\Exception $e){
    return response()->json(["status" => 2, "message" => $e->getMessage()]);
  }
  }
  
  public function listPerizinanTerlambat() {
    try{

    $surat = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*','surat.id as id_surat', 'surat_jenis.nama as surat_jenis_nama')->where('surat.is_terlambat','Y')->whereNotIn('surat.status', ['Selesai', 'Ditolak'])->get();

    $data = [];

    foreach ($surat as $item) {
        $data[] = [
            'id'               => $item->id_surat,
            'jenis_perizinan' => $item->surat_jenis_nama,
            'nomor_surat'      => $item->id_surat,
            'tanggal'          => $item->created_at,
            'perizinan'        => 'Terlambat',
        ];
    }

    return response()->json(['status' => 1, 'data' => $data]);
  }catch(\Exception $e){
    return response()->json(["status" => 2, "message" => $e->getMessage()]);
  }
  }

  public function approveHasilSurvey(Request $req) {
    DB::beginTransaction();
    // if(Auth::user()->role_id ===5){
      $cekDataUser = DB::table("surat")->join('user', 'user.id', '=', 'surat.user_id')
   ->where('surat.id', $req->id)->first();
   $verifikator = DB::table('user')->where('role_id', '6')->first(); 
   $kepala_dinas = DB::table('user')->where('role_id', '3')->first(); 

  //  if($cekDataUser){
  //   // return $cekDataUser->nama_lengkap;
  //   return response()->json(["data" => $cekDataUser->nama_lengkap]);
  //  }
  if (Auth::check()) {
  if(  Auth::user()->role_id == 6 )
  {
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Verifikasi Kepala Dinas',
            "is_dikembalikan" => "N",
            "alasan_dikembalikan" => null, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

          DB::table("survey")
          ->where("surat_id", $req->id)
          ->update([
            "status" => 'Survey Disetujui',
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Hasil Survey dari surat pengajuan anda sukses disetujui . Kami akan melakukan Verifikasi Kepala Dinas,<br><br> mohon tunggu pemberitahuan selanjutnya yaa","Hasil Survey Permohonan Anda Disetujui", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Hasil Survey Permohonan Anda Disetujui','Selamat! Hasil Survey Pengajuan surat Anda telah sukses disetujui. Kami akan melakukan Verifikasi Kepala Dinas, mohon tunggu pemberitahuan selanjutnya yaa' );

      PushNotifController::sendMessage($kepala_dinas->id,'Hai Kepala Dinas, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->id.' !','Ada surat dari pemohon yang perlu segera dilakukan Verifikasi. Silakan akses tugas Anda sekarang dan lakukan Verifikasi. Terima kasih!' );
      return response()->json(["status" => 1]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}
// response api
else {
  if( $req->input('role_id') == 6 )
  {
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Verifikasi Kepala Dinas',
            "is_dikembalikan" => "N",
            "alasan_dikembalikan" => null, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

          DB::table("survey")
          ->where("surat_id", $req->id)
          ->update([
            "status" => 'Survey Disetujui',
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Hasil Survey dari surat pengajuan anda sukses disetujui . Kami akan melakukan Verifikasi Kepala Dinas,<br><br> mohon tunggu pemberitahuan selanjutnya yaa","Hasil Survey Permohonan Anda Disetujui", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Hasil Survey Permohonan Anda Disetujui','Selamat! Hasil Survey Pengajuan surat Anda telah sukses disetujui. Kami akan melakukan Verifikasi Kepala Dinas, mohon tunggu pemberitahuan selanjutnya yaa' );

      PushNotifController::sendMessage($kepala_dinas->id,'Hai Kepala Dinas, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->id.' !','Ada surat dari pemohon yang perlu segera dilakukan Verifikasi. Silakan akses tugas Anda sekarang dan lakukan Verifikasi. Terima kasih!' );
      return response()->json(["status" => 1,  "message" => "Hasil Survey Berhasil di Approve dan Akan Diproses Kepala Dinas"]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}

  }

  public function tolakHasilSurvey(Request $req) {
    DB::beginTransaction();
    // if(Auth::user()->role_id ===5){
      $cekDataUser = DB::table("surat")->join('user', 'user.id', '=', 'surat.user_id')
   ->where('surat.id', $req->input('id'))->first();

  //  if($cekDataUser){
  //   // return $cekDataUser->nama_lengkap;
  //   return response()->json(["data" => $cekDataUser->nama_lengkap]);
  //  }
  if (Auth::check()) {
  if(  Auth::user()->role_id == 6 )
  {
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Ditolak',
            "is_dikembalikan" => "N",
            "alasan_dikembalikan" => null, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

          DB::table("survey")
          ->where("surat_id", $req->id)
          ->update([
            "status" => 'Survey Ditolak',
            'alasan_ditolak' => $req->alasan_dikembalikan,
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, Hasil Survey dari surat pengajuan anda dengan nomor No. ".$req->id." ditolak oleh verifikator.<br><br> Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda","Hasil Survey Permohonan Anda Ditolak", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Hasil Survey Permohonan Anda Ditolak','Sayangnya, Hasil Survey dari surat pengajuan anda dengan nomor No. '.$req->id.'  Anda ditolak oleh verifikator. Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda' );

      return response()->json(["status" => 1]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}
// response api
else {
  if( $req->input('role_id') == 6 )
  {
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Ditolak',
            "is_dikembalikan" => "N",
            "alasan_dikembalikan" => null, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

          DB::table("survey")
          ->where("surat_id", $req->id)
          ->update([
            "status" => 'Survey Ditolak',
            'alasan_ditolak' => $req->alasan_dikembalikan,
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);
      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, Hasil Survey dari surat pengajuan anda dengan nomor No. ".$req->id." ditolak oleh verifikator.<br><br> Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda","Hasil Survey Permohonan Anda Ditolak", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Hasil Survey Permohonan Anda Ditolak','Sayangnya, Hasil Survey dari surat pengajuan anda dengan nomor No. '.$req->id.' ditolak oleh verifikator. Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda' );

      return response()->json(["status" => 1,  "message" => "Hasil Survey Permohonan Perizinan Ditolak"]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}

  }

  public function terbitkanSurat(Request $req) {
    DB::beginTransaction();
    // if(Auth::user()->role_id ===5){
      $cekDataUser = DB::table("surat")->join('user', 'user.id', '=', 'surat.user_id')
   ->where('surat.id', $req->input('id'))->first();
   $generateSuratPenerbitan = DB::table("surat")->join('surat_jenis', 'surat_jenis.id', '=', 'surat.surat_jenis_id')
   ->where('surat.id', $req->input('id'))->select('surat.*')->first();
   $verifikator = DB::table('user')->where('role_id', '6')->first(); 
   $admin_dinas = DB::table('user')->where('role_id', '2')->first(); 

  //  if($cekDataUser){
  //   // return $cekDataUser->nama_lengkap;
  //   // return response()->json(["data" => $cekDataUser->nama_lengkap]);
  //   return response()->json([ "nomor_penerbitan" => $generateSuratPenerbitan->id.'/0'.$generateSuratPenerbitan->surat_jenis_id.'/'.Carbon::parse($generateSuratPenerbitan->created_at)->format('Y')]);
  //  }
  if (Auth::check()) {
  if( Auth::user()->role_id == 3 ){
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Selesai',
            "nomor_penerbitan" => $generateSuratPenerbitan->id.'/0'.$generateSuratPenerbitan->surat_jenis_id.'/'.Carbon::parse($generateSuratPenerbitan->created_at)->format('Y'),
            "is_dikembalikan" => "N",
            "alasan_dikembalikan" => null, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Pengajuan surat Anda telah sukses diterbitkan. Selanjutnya silahkan cetak surat anda dan datang ke kantor dinas dengan membawa bukti registrasi dan surat pengajuan anda","Permohonan Perizinan Berhasil Diterbitkan", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Perizinan Berhasil Diterbitkan','Selamat! Pengajuan surat Anda telah sukses diterbitkan. Selanjutnya silahkan cetak surat anda dan datang ke kantor dinas dengan membawa bukti registrasi dan surat pengajuan anda' );

      // PushNotifController::sendMessage($verifikator->id,'Hai Verifikator, Anda memiliki tugas baru menanti dengan nomor surat #'.$req->id.' !','Ada surat dari pemohon yang perlu segera diverifikasi. Silakan akses tugas Anda sekarang dan lakukan verifikasi. Terima kasih!' );
      return response()->json(["status" => 1, "message" => "Permohonan Perizinan Berhasil Diterbitkan"]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}
// response api
else {
  if( $req->input('role_id') == 3  ){
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Selesai',
            "nomor_penerbitan" => $generateSuratPenerbitan->id.'/0'.$generateSuratPenerbitan->surat_jenis_id.'/'.Carbon::parse($generateSuratPenerbitan->created_at)->format('Y'),
            "is_dikembalikan" => "N",
            "alasan_dikembalikan" => null, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Selamat! Pengajuan surat Anda telah sukses diterbitkan. Selanjutnya silahkan cetak surat anda dan datang ke kantor dinas dengan membawa bukti registrasi dan surat pengajuan anda","Permohonan Perizinan Berhasil Diterbitkan", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Perizinan Berhasil Diterbitkan','Selamat! Pengajuan surat Anda telah sukses diterbitkan. Selanjutnya silahkan cetak surat anda dan datang ke kantor dinas dengan membawa bukti registrasi dan surat pengajuan anda' );
      return response()->json(["status" => 1, "message" => "Permohonan Perizinan Berhasil Diterbitkan"]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}

  }

  public function tolakSuratKepalaDinas(Request $req) {
    DB::beginTransaction();
    // if(Auth::user()->role_id ===5){
      $cekDataUser = DB::table("surat")->join('user', 'user.id', '=', 'surat.user_id')
   ->where('surat.id', $req->id)->first();
   $generateSuratPenerbitan = DB::table("surat")->join('surat_jenis', 'surat_jenis.id', '=', 'surat.surat_jenis_id')
   ->where('surat.id', $req->id)->select('surat.*')->first();
   $verifikator = DB::table('user')->where('role_id', '6')->first(); 
   $admin_dinas = DB::table('user')->where('role_id', '2')->first(); 

  //  return response()->json(["data" => $req->id]);

  //  if($cekDataUser){
  //   // return $cekDataUser->nama_lengkap;
  //   return response()->json(["data" => $cekDataUser->nama_lengkap]);
  //   // return response()->json([ "nomor_penerbitan" => $generateSuratPenerbitan->id.'/0'.$generateSuratPenerbitan->surat_jenis_id.'/'.Carbon::parse($generateSuratPenerbitan->created_at)->format('Y')]);
  //  }
  if (Auth::check()) {
  if( Auth::user()->role_id == 3 ){
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Ditolak',
            "is_ditolak" => "Y",
            "alasan_ditolak" => $req->alasan_ditolak, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, surat pengajuan anda dengan nomor No. ".$req->id." ditolak oleh kepala dinas.<br><br> Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda","Permohonan Anda Ditolak Kepala Dinas", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Anda Ditolak Kepala Dinas','Sayangnya, surat pengajuan anda dengan nomor No. '.$req->id.'  ditolak oleh Kepala Dinas. Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda' );

      return response()->json(["status" => 1, "message" => "Permohonan Perizinan Berhasil Ditolak"]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}
// response api
else {
  if( $req->role_id == 3  ){
    try {

      DB::table("surat")
          ->where("id", $req->id)
          ->update([
            "status" => 'Ditolak',
            "is_ditolak" => "Y",
            "alasan_ditolak" => $req->alasan_ditolak, 
            "updated_at" => Carbon::now("Asia/Jakarta")
          ]);

      DB::commit();
      SendemailController::Send($cekDataUser->nama_lengkap, "Sayangnya, surat pengajuan anda dengan nomor No. ".$req->id." ditolak oleh kepala dinas.<br><br> Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda","Permohonan Anda Ditolak Kepala Dinas", $cekDataUser->email);
      PushNotifController::sendMessage($cekDataUser->user_id,'Permohonan Anda Ditolak Kepala Dinas','Sayangnya, surat pengajuan anda dengan nomor No. '.$req->id.'  ditolak oleh Kepala Dinas. Dengan ini surat anda tidak dapat diproses lagi dan tersimpan di Arsip surat anda' );

      return response()->json(["status" => 1, "message" => "Permohonan Perizinan Berhasil Ditolak"]);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(["status" => 2, "message" => $e->getMessage()]);
    }
  }
}

  }

  public function getListHasilSurvey(){
    return view('hasil-survey.index');
  }

  public function datatableHasilSurvey() {
    // $data = DB::table('surat')->get();
    if(Auth::user()->role_id == 6){
      $data = DB::table('surat')->where('status', 'Verifikasi Hasil Survey')->get();
      }else if(Auth::user()->role_id == 7){
      $data = DB::table('survey')->join('surat', 'surat.id' ,'=' ,'survey.surat_id')->select('surat.*','survey.*', 'survey.status as status_survey', 'survey.user_id as survey_user_id')->whereNotIn('survey.status', ['Belum Disurvey'])->where('survey.user_id', Auth::user()->id)->get();

      }

      // return $data;
      // $xyzab = collect($data);
      // return $xyzab;
      // return $xyzab->i_price;
      return Datatables::of($data)
      ->addColumn("surat_jenis", function($data) {
        $surat_jenis = DB::table('surat_jenis')->where('id', $data->surat_jenis_id)->first();
        return $surat_jenis->nama;
      })
      ->addColumn('jadwal_survey', function ($data) {
        if($data->jadwal_survey !== null){
          return Carbon::parse($data->jadwal_survey)->format('d F Y');

        }else{
          return '<div><i>Belum Tersedia</i></div>';
        }
      })
      ->addColumn('nama_surveyor', function ($data) {
        if(Auth::user()->role_id == 6){
  
            $survey = DB::table('survey')->join('user', 'user.id' ,'=' ,'survey.user_id')->select('user.nama_lengkap as nama_surveyor')->where('survey.surat_id', $data->id)->first();
    
            return $survey ? $survey->nama_surveyor : '';
        }else{
          return null;
        }
        })
    
        ->addColumn('aksi', function ($data) {
          return  '<div class="btn-group">'.
                   '<a  href="penugasan/laporan/'.$data->id.'" class="btn btn-success btn-lg pt-2" title="edit">'.
                   '<label class="fa fa-eye w-100"></label></a>'.
                '</div>';
        })
        ->rawColumns(['aksi','jadwal_survey','status', 'tanggal_pengajuan','nama_surveyor'])
        ->addIndexColumn()
        // ->setTotalRecords(2)
        ->make(true);
  }

  public function getDataArsip(Request $req) {
    try{
    if($req->user_id != ""){
    if ($req->jenis != "") {
      $surat = DB::table('surat')
      ->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")
      ->select('surat.*','surat.id as id_surat', 'surat_jenis.nama as surat_jenis_nama')
      ->where('user_id',  $req->user_id)
      ->where("surat.surat_jenis_id", $req->jenis)
      ->whereIn('surat.status', ['Selesai', 'Ditolak'])
      ->get();
    } else {
      $surat = DB::table('surat')
      ->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")
      ->select('surat.*','surat.id as id_surat', 'surat_jenis.nama as surat_jenis_nama')
      ->where('user_id',  $req->user_id)
      ->whereIn('surat.status', ['Selesai', 'Ditolak'])
      ->get();
    }
  }else{
    if ($req->jenis != "") {
      $surat = DB::table('surat')
      ->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")
      ->select('surat.*','surat.id as id_surat', 'surat_jenis.nama as surat_jenis_nama')
      // ->where('user_id',  $req->user_id)
      ->where("surat.surat_jenis_id", $req->jenis)
      ->whereIn('surat.status', ['Selesai', 'Ditolak'])
      ->get();
    } else {
      $surat = DB::table('surat')
      ->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")
      ->select('surat.*','surat.id as id_surat', 'surat_jenis.nama as surat_jenis_nama')
      ->whereIn('surat.status', ['Selesai', 'Ditolak'])
      ->get();
    }
  }


    $data = [];

    foreach ($surat as $item) {
        $data[] = [
            'id'               => $item->id_surat,
            'jenis_perizinan' => $item->surat_jenis_nama,
            'nomor_surat'      => $item->id_surat,
            'tanggal'          => $item->created_at,
            'nama'          => $item->nama,
            'status'        => $item->status,

        ];
    }

    return response()->json(['status' => 1, 'data' => $data]);
  }catch(\Exception $e){
    return response()->json(["status" => 2, "message" => $e->getMessage()]);
  }
  }


}
