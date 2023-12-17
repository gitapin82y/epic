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

class PertanyaanSurveyKepuasanController extends Controller
{

    public function index() {
      return view('pertanyaan-survey-kepuasan.index');
    }

    public function datatable() {
      $data = DB::table('ulasan_pertanyaan')
        ->get();


        
        return Datatables::of($data)
        // ubahstatus

          ->addColumn('aksi', function ($data) {
            $aksi = '<div class="btn-group">';
            if ($data->is_active == 'Y'){
              $aksi .= '<a href="ubahstatus?is_active=N&id='.$data->id.'" class="btn btn-warning btn-lg" title="check">'.
              '<label class="fas fa-times"></label></a>';
            }else{
              $aksi .= '<a href="ubahstatus?is_active=Y&id='.$data->id.'" class="btn btn-success btn-lg" title="uncheck">'.
              '<label class="fas fa-check"></label></a>';
            }
            $aksi .= '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
            '<label class="fa fa-trash"></label></button>'.
            '</div>';
            return $aksi;
            // return  '<div class="btn-group">'.
            //          '<button type="button" onclick="edit('.$data->id.')" class="btn btn-info btn-lg" title="edit">'.
            //          '<label class="fa fa-pencil-alt"></label></button>'.
            //          '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
            //          '<label class="fa fa-trash"></label></button>'.
            //       '</div>';
          })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          // ->setTotalRecords(2)
          ->make(true);
    }

    public function simpan(Request $req) {
     
      if ($req->id == null) {
        DB::beginTransaction();
        try {

        DB::table("ulasan_pertanyaan")
              ->insertGetId([
              "nama" => $req->nama,
              "created_at" => Carbon::now("Asia/Jakarta"),
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

          DB::commit();
          return response()->json(["status" => 1]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2, "message" =>$e->getMessage()]);
        }
      } else {
        DB::beginTransaction();
        try {

          DB::table("ulasan_pertanyaan")
            ->where("id", $req->id)
            ->update([
              "nama" => $req->nama,
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

         
          DB::commit();
          return response()->json(["status" => 3]);
        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 4, "message" =>$e->getMessage()]);
        }
      }

    }

    public function hapus(Request $req) {
      DB::beginTransaction();
      try {

        DB::table("ulasan_pertanyaan")
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
      $data = DB::table("ulasan_pertanyaan")
              ->where("id", $req->id)
              ->first();

      // $petugas = [
      //   "id" => $data->id,
      //   "nama_lengkap" => $data->nama_lengkap,
      //   "username" => $data->username,
      //   "password" => Crypt::decryptString($data->password),
      //   "role_id" => $data->role_id,
      // ];
      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }

    public function sendSurveyKepuasan(Request $req) {
      $questions = $req->except(['_token']);
      $totalPertanyaan = DB::table('ulasan_pertanyaan')->where('is_active','Y')->get();
      $ulasanId = DB::table('ulasan_hasil')->insertGetId([
          'user_id' => Auth::user()->id,
          'created_at' => Carbon::now("Asia/Jakarta"),
      ]);
      foreach ($totalPertanyaan as $key => $answer) {
        $question_id = intval($key);
        DB::table('ulasan')->insertGetId([
          'ulasan_hasil_id' => $ulasanId,
          'ulasan_pertanyaan_id' => $req->input("question{$question_id}"),
          'isi' => $req->input("answer{$question_id}"),
          'created_at' => Carbon::now("Asia/Jakarta"),
        ]);
      }
      Session::flash('sendSurvey', 'sendSurvey');

      return back();
    }

    public function updateStatus(Request $request){
      DB::table('ulasan_pertanyaan')->where('id',$request->id)->update($request->all());


      Session::flash('updateStatusPertanyaan', 'updateStatusPertanyaan');

      return back();
    }
}
