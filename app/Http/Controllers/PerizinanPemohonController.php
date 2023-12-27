<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\mMember;

use App\Authentication;


use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Session;


use Yajra\Datatables\Datatables;


class PerizinanPemohonController extends Controller
{
    public function index() {
      $data = DB::table("user")->where("role_id", "5")->first();

      return view('public.perizinan-pemohon.index', compact("data"));
    }
      
          public function datatable($status) {
            // $data = DB::table('surat')->get();
            if(Auth::user()->role_id == 9){
      
            if($status != 'Semua'){
            $data = DB::table('surat')->where('status', $status)->orderBy("created_at", "asc")->where('user_id', Auth::user()->id)
            ->get();
          }else{
            // $data;
            $data = DB::table('surat')->whereNotIn('status', ['Ditolak','Selesai','Pengisian Dokumen'])->orderBy("created_at", "asc")->where('user_id', Auth::user()->id)->get();
      
          }
        }
      //   else if(Auth::user()->role_id == 5){
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
                $color = '<div><strong class="text-warning">' . $data->status  .'</strong></div>';
            
                if ($data->status == "Selesai") {
                    // Tombol "Approve" hanya muncul jika is_active == 1
                    $color =  '<div><strong class="text-success">' . $data->status . '</strong></div>';
                } else if ($data->status == "Ditolak"){
                  $color = '<div><strong class="text-danger">' . $data->status . '</strong></div>';
                }else if($data->status == "Penjadwalan Survey"){
                $statusSurvey = DB::table('survey')->where('surat_id', $data->id)->first();
                // $color = '<div><strong class="text-warning">' . $data->id  .'</strong></div>';
                if($statusSurvey){
                  $color = '<div><strong class="text-warning">' . $data->status .'<br>( '. $statusSurvey->status .' )</strong></div>';
                }else{
                  $color = '<div><strong class="text-warning">' . $data->status .'<br>( Menunggu Jadwal )</strong></div>';

                }
                }
                else{
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
      
            if($surat->status == "Penjadwalan Survey"){
              $surveyor = DB::table('survey')->join('user', 'user.id', '=', "survey.user_id")->select('user.id as surveyor_id')->where('surat_id', $surat->id)->first();
            }else{
              $surveyor = null;
            }
      
            $data = [
             'surat' => $surat,
             'user' => $user,
             'surat_jenis' => $surat_jenis,
             'tanggal_pengajuan' => Carbon::parse($surat->created_at)->format('d F Y'),
             'jadwal_survey' => $surat->jadwal_survey ? Carbon::parse($surat->jadwal_survey)->format('d F Y') : 'Belum Tersedia',
             'surat_dokumen' => $surat_dokumen,
       'surveyor_id' => $surveyor ? $surveyor->surveyor_id : null

            ];
            // $data->created_at = Carbon::parse($data->created_at)->format("d-m-Y");
      
            return response()->json($data);
          }
      
          public function getData(Request $req){
            try{
              if($req->user_id){
                $data = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*', 'surat_jenis.nama as surat_jenis_nama')->where('user_id',$req->user_id)->where(function ($query) {
                  $query->where('status','not like', 'Ditolak')
                        ->orWhere('status','not like', 'Selesai');
              })->get();
              }else{
                $data = DB::table('surat')->join('surat_jenis', 'surat_jenis.id', '=', "surat.surat_jenis_id")->select('surat.*', 'surat_jenis.nama as surat_jenis_nama')->where(function ($query) {
                  $query->where('status','not like', 'Ditolak')
                        ->orWhere('status','not like', 'Selesai');
              })->get();
              }
              return response()->json(['status' => 1, 'data' => $data]);
            }catch(\Exception $e){
              return response()->json(["status" => 2, "message" => $e->getMessage()]);
            }
          }

          public function cetakPerizinan(Request $req)
          {
            $data = DB::table('surat')
            ->join('surat_jenis','surat_jenis.id','=','surat.surat_jenis_id')
            ->join('user','user.id','=','surat.user_id')
            ->select('surat.*','user.nama_lengkap as nama_lengkap','user.email as email','surat_jenis.nama as namaPerizinan')
            ->where('surat.id',$req->dataId)->first();
            $survey = DB::table('survey')
            ->join('user','user.id','=','survey.user_id')
            ->select('survey.*','user.*')
            ->where('survey.surat_id',$req->dataId)->first();

            $syarats = DB::table('surat_syarat')
            ->where('surat_jenis_id',$data->surat_jenis_id)->get();

              $pdf = \PDF::loadView('public.perizinan.cetak-perizinan', compact('data','syarats','survey'));
              return $pdf->stream('cetak-sk-perizinan.pdf');
          }
}
