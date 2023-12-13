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

class SurveyController extends Controller
{
    public function index() {
    $surveyors = DB::table("user")->where('role_id', '7')->get();

      return view('survey-jadwal.index', compact('surveyors'));
    }

    public function datatable() {
      // if (Auth::user()->role_id == 7) {
      //    $data = DB::table('survey')->join('surat', 'surat.id', '=', "survey.surat_id")->select('surat.*', 'survey.id as survey_id', 'survey.user_id as surveyor_id')
      //   ->where("surat.status",'Penjadwalan Survey')->where('survey.user_id', Auth::user()->id)
      //   ->get();

      // } else {
        $data = DB::table('surat')
        ->where("status",'Penjadwalan Survey')
        ->get();

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
          // if(Auth::user()->role_id === 1){
  
            if($data->jadwal_survey !== null){
              return Carbon::parse($data->jadwal_survey)->format('d F Y');
  
            }else{
              return '<div><i>Belum Tersedia</i></div>';
            }
          // }else{
          //   return null;
          // }
          })
        ->addColumn('status', function ($data) {
          $color = '<div><strong class="text-success">Acc Jadwal Survey</strong></div>';
      
          if ( $data->jadwal_survey == NULL) {
              // Tombol "Approve" hanya muncul jika is_active == 1
              $color =  '<div><strong class="text-warning"> Menunggu Jadwal</strong></div>';
          }else if ($data->jadwal_survey != NULL){
            $color;
          }
          return $color;
      })
      ->addColumn('tanggal_pengajuan', function ($data) {
        return Carbon::parse($data->created_at)->format('d F Y');

      })
          ->addColumn('aksi', function ($data) {
            $aksi = '<div class="btn-group">'.
            '<button type="button" onclick="detail('.$data->id.')" class="btn btn-warning btn-lg pt-2" title="penjadwalan survey">'.
            '<label class="fa fa-calendar-check-o w-100" style="padding:0 2px"></label></button>'.
         '</div>';
         if ($data->jadwal_survey == NULL) {
          $aksi = '<div class="btn-group">'.
          '<button type="button" onclick="edit('.$data->id.')" class="btn btn-success btn-lg pt-2" title="penjadwalan survey">'.
          '<label class="far fa-calendar w-100" style="padding:0 2px"></label></button>'.
       '</div>';
                 } else if ($data->jadwal_survey != NULL) {
          $aksi = '<div class="btn-group">'.
            '<button type="button" onclick="detail('.$data->id.')" class="btn btn-info btn-lg pt-2" title="lihat detail penugasan">'.
            '<label class="fa fa-eye w-100" ></label></button>'.
         '</div>';
         }
         
            return $aksi;
          })
          ->rawColumns(['aksi','status','surat_jenis','jadwal_survey','tanggal_pengajuan'])
          ->addIndexColumn()
          ->make(true);
    }

    
    public function simpan(Request $req) {
     
      // if ($req->is_acc_penjadwalan == "N" && $req->is_reschedule == "N") {
        DB::beginTransaction();
        try {

        DB::table("surat")
        ->where("id", $req->id)
              ->update([
              "jadwal_survey" => $req->jadwal_survey,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

        DB::table("survey")
        ->insertGetId([
          'surat_id' => $req->id,
          'user_id' => $req->user_id,
          'status' => 'Belum Disurvey',
          "created_at" => Carbon::now("Asia/Jakarta"),
          "updated_at" => Carbon::now("Asia/Jakarta")
        ]);

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2, "message" =>$e->getMessage()]);
        }
      
      }

      //  else {
      //   DB::beginTransaction();
      //   try {

      //     DB::table("user")
      //       ->where("id", $req->id)
      //       ->update([
      //         "nama_lengkap" => $req->nama_lengkap,
      //         "username" => $req->username,
      //         "password" => Crypt::encryptString($req->password),
      //         "role_id" => $req->role,
      //         "updated_at" => Carbon::now("Asia/Jakarta")
      //       ]);

         
      //     DB::commit();
      //     return response()->json(["status" => 3]);
      //   } catch (\Exception $e) {
      //     DB::rollback();
      //     return response()->json(["status" => 4, "message" =>$e->getMessage()]);
      //   }
      // }


    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("user")
            ->where("id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 3]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 4]);
      }

    }

    public function tolak(Request $req) {
      $data = DB::table("user")
              ->where("id", $req->id)
              ->first();

      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }

    public function tolakprocess(Request $req) {
      DB::beginTransaction();
      try {
        $data = DB::table("user")
        ->where("id", $req->id)
        ->first();
        SendemailController::Send($data->nama_lengkap,"Alasan : ".$req->alasan_ditolak." . Silahkan lakukan Registrasi Kembali dengan data yang sesuai", "Akun Anda Gagal Diaktifkan",  $data->email);

        DB::table("user")
            ->where("id", $req->id)
            ->delete();

        DB::commit();
        return response()->json(["status" => 1]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(["status" => 2, 'error' => $e->getMessage()]);
      }

    }

    public function approve(Request $req) {
      DB::beginTransaction();
      try {
        $data = DB::table("user")
        ->where("id", $req->id)
        ->first();

        DB::table("user")
            ->where("id", $req->id)
            ->update([
              "is_active" => "Y"
            ]);
            
            SendemailController::Send($data->nama_lengkap, "Silahkan Login ke akun anda","Selamat Akun Anda Sudah di Aktivasi", $data->email);
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
      
      $survey = DB::table("survey")->where('surat_id', $req->id)->first();


      $data = [
        "surat" => $surat,
        "survey" => $survey,
      ];
      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }

    public function getData(Request $req){
      try{
        $data = DB::table('survey')->join('surat', 'surat.id' ,'=' ,'survey.surat_id')->join('user', 'user.id' ,'=' ,'survey.user_id')->select('surat.*', 'survey.status as status_survey', 'user.nama_lengkap as surveyor')
        ->where("surat.status",'Penjadwalan Survey')->where("survey.status", "not like", 'null')
        ->get();
  
        return response()->json(["status" => 1, "data" => $data]);
      }catch(\Exception $e){
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }

    public function getDataBySurveyorId($id){
      try {
        $data = DB::table('survey')->join('surat', 'surat.id', '=', "survey.surat_id")->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*', 'survey.id as survey_id', 'survey.user_id as surveyor_id', 'surat_jenis.nama as surat_jenis_nama')
        ->where("surat.status",'Penjadwalan Survey')->where('survey.status','Belum Disurvey')->where('survey.user_id', $id)
        ->get();
        return response()->json(["status" => 1, "data" => $data]);

      } catch (\Exception $e) {
        //throw $th;
        return response()->json(["status" => 2, "message" => $e->getMessage()]);

      }
    }

    public function getDetailDataPenugasan($id){
      try {
        $data = DB::table('survey')->join('surat', 'surat.id', '=', "survey.surat_id")->select('surat.*', 'survey.id as survey_id', 'survey.user_id as surveyor_id')
        ->where('survey.id', $id)
        ->get();
        return response()->json(["status" => 1, "data" => $data]);

      } catch (\Exception $e) {
        //throw $th;
        return response()->json(["status" => 2, "message" => $e->getMessage()]);

      }
    }

    // get detail data survey untuk pengisian hasil survey
    public function getDetailLaporanSurvey($id){
      try{
        $data = DB::table('survey')->join('surat', 'surat.id', '=', "survey.surat_id")->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('survey.*', 'surat_jenis.id as surat_jenis_id')
        ->where('surat_id', $id)
        ->first();
  
        return response()->json(["status" => 1, "data" => $data]);
      }catch(\Exception $e){
        return response()->json(["status" => 2, "message" => $e->getMessage()]);
      }
    }
    public function submitFormLaporanPertama(Request $request)
    {
      // DB::beginTransaction();

       try {
        //code...
        $imgPath = null;
        $tgl = Carbon::now('Asia/Jakarta');
        $folder = $tgl->year . $tgl->month . $tgl->timestamp;
        $childPath ='file/uploads/laporan-survey/foto-survey/';
        $childPathHasilSurvey ='file/uploads/laporan-survey/dokumen-survey/';
        $path = $childPath;

        $file = $request->file('foto_survey');
        $fileDokumen = $request->file('dokumen_survey');
        $name = null;
        if ($file != null) {
          $name = $folder . '.' . $file->getClientOriginalExtension();
          $file->move($path, $name);
          $imgPath = $childPath . $name;
        }else if ($fileDokumen != null) {
          $name = $folder . '.' . $fileDokumen->getClientOriginalExtension();
          $fileDokumen->move($path, $name);
          $imgPath = $childPathHasilSurvey . $name;
        }
         else {
          return response()->json(["status" => 2, "message" => 'Foto Survey Belum Di upload']);

        }

        // DB::table('survey')->where('surat_id', $request->surat_id)->update([
        //   'jadwal_survey' => $request->input('jadwal_survey'),
        //   'status' => 'Sudah Disurvey',
        //   'foto_survey' => $request
        // ]);
        // if($request->longitude == ''){
        // return response()->json(["status" => 2, "message" => 'longitude']);

        // }else  if($request->latitude == ''){
        //   return response()->json(["status" => 2, "message" => 'latitude']);
  
        //   }else{
        DB::table('survey')->where('id', $request->id)->update([
          'jadwal_survey' => $request->jadwal_survey,
          'status' => 'Sudah Disurvey',
          "foto_survey"=>$imgPath,
          "alamat_survey"=>$request->alamat_survey,
          "longitude"=>$request->longitude,
          "latitude"=>$request->latitude,
          "dokumen_survey"=>$request->dokumen_survey,
          "alasan_ditolak"=> null,
          "updated_at" => $tgl
      ]);
      $getIdSurat = DB::table('survey')->where('id', $request->id)->first();

        DB::table('surat')->where('id', $getIdSurat->surat_id)->update([
          'status' => 'Verifikasi Hasil Survey',
          "updated_at" => Carbon::now("Asia/Jakarta")
        ]);
    // }
    // $getIdSurat = DB::table('survey')->where('id', $request->id)->first();

      DB::commit();

        return response()->json(["status" => 1,'message' => 'Sukses memperbarui laporan','id' => $getIdSurat->surat_id]);
       } catch (\Exception $e) {
        return response()->json(["status" => 2, "message" => $e]);

       }
       
    }
   
    
}
