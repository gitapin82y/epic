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

class SuratSyaratController extends Controller
{
    public function index() {
    $suratJenis = DB::table("surat_jenis")->get();


      return view('surat-syarat.index', compact('suratJenis'));
    }

    public function datatable($surat_jenis_id) {
      // $data = DB::table('surat_syarat')
      //   ->get();

      if($surat_jenis_id){
        $data = DB::table('surat_syarat')->where('surat_jenis_id', $surat_jenis_id)->get();
      }


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          // ->addColumn("nominal", function($data) {
          //   return FormatRupiah($data->uangkeluar_nominal);
          // })
         
          ->addColumn("surat_jenis", function($data) {
            $surat_jenis = DB::table('surat_jenis')->where('id', $data->surat_jenis_id)->first();
            return $surat_jenis->nama;
          })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
          })
          ->rawColumns(['aksi'])
          ->addIndexColumn()
          // ->setTotalRecords(2)
          ->make(true);
    }

    public function datatableNoFilter() {
      $data = DB::table('surat_syarat')
        ->get();

      // if($surat_jenis_id !== null){
      //   $data = DB::table('surat_syarat')->where('surat_jenis_id', $surat_jenis_id)->get();
      // }else{
      //   // $data;
      //   $data = DB::table('surat_syarat')->get();
  
      // }


        // return $data;
        // $xyzab = collect($data);
        // return $xyzab;
        // return $xyzab->i_price;
        return Datatables::of($data)
          // ->addColumn("nominal", function($data) {
          //   return FormatRupiah($data->uangkeluar_nominal);
          // })
         
          ->addColumn("surat_jenis", function($data) {
            $surat_jenis = DB::table('surat_jenis')->where('id', $data->surat_jenis_id)->first();
            return $surat_jenis->nama;
          })
          ->addColumn('aksi', function ($data) {
            return  '<div class="btn-group">'.
                     '<button type="button" onclick="edit('.$data->id.')" class="btn btn-info btn-lg" title="edit">'.
                     '<label class="fa fa-pencil-alt"></label></button>'.
                     '<button type="button" onclick="hapus('.$data->id.')" class="btn btn-danger btn-lg" title="hapus">'.
                     '<label class="fa fa-trash"></label></button>'.
                  '</div>';
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
          $imgPath = null;
          $tgl = Carbon::now('Asia/Jakarta');
          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $childPath ='file/uploads/dokumen-syarat-template/';
          $path = $childPath;
         
          $file = $req->file('syarat_template');
          $name = null;
          if ($file != null) {
            $name = $folder . '.' . $file->getClientOriginalExtension();
            $file->move($path, $name);
            $imgPath = $childPath . $name;
          } else {
              return 'error';
          }

        DB::table("surat_syarat")
              ->insertGetId([
              "nama" => $req->nama,
              "surat_jenis_id" => $req->surat_jenis_id,
              "syarat_template" => $imgPath,
              "created_at" => Carbon::now("Asia/Jakarta"),
              "updated_at" => Carbon::now("Asia/Jakarta")
            ]);

          DB::commit();
          return response()->json(["status" => 1]);
          // return response()->json(["status" => 1, 'data' => $file->getClientOriginalName()]);

        } catch (\Exception $e) {
          DB::rollback();
          return response()->json(["status" => 2, "message" =>$e->getMessage()]);
        }
      } else {
        DB::beginTransaction();
        try {
          $imgPath = null;
          $tgl = Carbon::now('Asia/Jakarta');
          $folder = $tgl->year . $tgl->month . $tgl->timestamp;
          $childPath ='file/uploads/dokumen-syarat-template/';
          $path = $childPath;
         
          $file = $req->file('syarat_template');
          $name = null;
          if ($file != null) {
            $name = $folder . '.' . $file->getClientOriginalExtension();
            $file->move($path, $name);
            $imgPath = $childPath . $name;
          } else {
              return 'error';
          }

          DB::table("surat_syarat")
            ->where("id", $req->id)
            ->update([
              "nama" => $req->nama,
              "surat_jenis_id" => $req->surat_jenis_id,
              "syarat_template" => $req->syarat_template,
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

        DB::table("surat_syarat")
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
      $data = DB::table("surat_syarat")
              ->where("id", $req->id)
              ->first();

     
      // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");

      return response()->json($data);
    }

    public function getData(Request $req){
      try {
        if($req->surat_jenis_id){
        $data = DB::table("surat_syarat")->where('surat_jenis_id', $req->surat_jenis_id)->get();
        }else{
          $data = DB::table("surat_syarat")->get();
        }
        return response()->json(['status' => 1, 'data' => $data]);
        
      } catch (\Exception $e) {
        //throw $th;
        return response()->json(['status' => 2, "message" => $e->getMessage()]);
      }
    }
}
