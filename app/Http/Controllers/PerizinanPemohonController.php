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
      
            return view('public.perizinan-pemohon.index');
          }
      
          public function datatable($status) {
            if(Auth::user()->role_id == 9){
            if($status !== 'Semua'){
                $data = DB::table('surat')->where('status', $status)->where('user_id', Auth::user()->id)->get();
            }else{
                if($status !== 'Semua'){
                $data = DB::table('surat')->where('status', $status)->where('user_id', Auth::user()->id)->get();
                }else{
                $data = DB::table('surat')->where('user_id', Auth::user()->id)->where('status' ,'not like', 'Selesai')->where('status' ,'not like', 'Ditolak')->get();
                }
            }
            }else{
                $data = null;
            }
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
              })
              ->addColumn('status', function ($data) {
                $color = '<div><strong class="text-warning">' . $data->status . '</strong></div>';
            
                if ($data->status == "Selesai") {
                    // Tombol "Approve" hanya muncul jika is_active == 1
                    $color =  '<div><strong class="text-success">' . $data->status . '</strong></div>';
                } else if ($data->status == "Ditolak"){
                  $color = '<div><strong class="text-danger">' . $data->status . '</strong></div>';
                }else{
                  if(Auth::user()->role_id == 9){
                    if ($data->status == "Penjadwalan Survey" && $data->is_acc_penjadwalan == "N" && $data->is_reschedule == "N" && $data->jadwal_survey != NULL) {
                        $color = '<div><strong class="text-warning">' . $data->status . '<br><br> <span class="text-primary"> ( Butuh Konfirmasi Ketersediaan ) </span> </strong></div>';
                     } if ($data->status == "Penjadwalan Survey" && $data->is_acc_penjadwalan == "Y" && $data->is_reschedule == "N" && $data->jadwal_survey != NULL) {
                      $color = '<div><strong class="text-warning">' . $data->status . '<br><br> <span class="text-success"> ( Sudah Konfirmasi ) </span>  </strong></div>';
                     }if ($data->status == "Penjadwalan Survey" && $data->is_acc_penjadwalan == "N" && $data->is_reschedule == "Y" && $data->jadwal_survey != NULL) {
                        $color = '<div><strong class="text-warning">' . $data->status . '<br><br> <span class="text-primary"> ( Menunggu Jadwal Terbaru ) </span>  </strong></div>';
                       }
                       if ($data->is_dikembalikan == "Y" && $data->alasan_dikembalikan !== NULL) {
                        $color = '<div><strong class="text-warning">' . $data->status . '<br><br> <span class="text-danger"> ( Berkas Dikembalikan ) </span>  </strong></div>';
                       }
                  }else{
                    $color;
                  }
                }
                return $color;
            })
            ->addColumn('tanggal_pengajuan', function ($data) {
              return Carbon::parse($data->created_at)->format('d F Y');
      
            })
                ->addColumn('aksi', function ($data) {
                  $aksi = '<div class="btn-group">'.
                  '<button type="button" onclick="edit('.$data->id.')" class="btn btn-success btn-lg pt-2" title="edit">'.
                  '<label class="fa fa-eye w-100"></label></button>';
                  if ($data->is_acc_penjadwalan == "N" && $data->is_reschedule == "N" && $data->jadwal_survey != NULL) {
                    $aksi .= '<button type="button" onclick="accJadwal('.$data->id.')" class="btn btn-info btn-lg pt-2 ml-2" title="edit">'.
                    '<label class="fa fa-calendar w-100"></label></button>';
                  }
                  if ($data->is_dikembalikan == "Y" && $data->alasan_dikembalikan !== NULL) {
                    $aksi .= '<button type="button" onclick="alasanDikembalikan(\'' . $data->alasan_dikembalikan . '\', \'' . $data->surat_jenis_id . '\')" class="btn btn-danger btn-lg pt-2 ml-2" title="dikembalikan">'.
                    '<label class="fa-solid fa-circle-info"></label></button>';
                  }
                  $aksi .= '</div>';
                  return $aksi;
                })
                ->rawColumns(['aksi','jadwal_survey','status', 'tanggal_pengajuan'])
                ->addIndexColumn()
                // ->setTotalRecords(2)
                ->make(true);
          }
      
    
          public function pemohonAccJadwalSurvey(Request $req){
            DB::beginTransaction();
            try {
              DB::table('surat')->where('id', $req->id)->update(['is_acc_penjadwalan' => 'Y']);
              DB::commit();
              return response()->json(["status" => "1"]);
            } catch (\Exception $e) {
              return response()->json(["status" => 2, 'message' => $e->getMessage()]);
      
            }
          }

          public function jadwalulang(Request $req){
            DB::beginTransaction();
            try {
              DB::table('surat')->where('id', $req->id)->update(['is_reschedule' => "Y",'is_acc_penjadwalan' => 'N']);
              DB::commit();
              return response()->json(["status" => "1"]);
            } catch (\Exception $e) {
              return response()->json(["status" => 2, 'message' => $e->getMessage()]);
      
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
}
