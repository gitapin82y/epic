<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Session;

class PublicController extends Controller
{
    public function index (){
        return view('public.index');
    }

    public function buatPermohonan (){
        $jenisPerizinanOptions = DB::table('surat_jenis')
        ->get();
        return view('public.buat-permohonan',compact('jenisPerizinanOptions'));
    }

    public function getDataByJenis(Request $request)
    {
        $jenisPerizinan = $request->input('jenis_perizinan');
        $dataPerizinan = DB::table('surat_syarat')->where('surat_jenis_id', $jenisPerizinan)->get();
    
        return response()->json($dataPerizinan);
    }

    public function ajukanPerizinan(Request $request){
        $perizinan = DB::table('surat_jenis')->find($request->jenis);
        return view('public.perizinan.form-pengajuan-perizinan',compact('perizinan'));
    }

    public function ajukanSyaratPerizinan(){
        return view('public.perizinan.form-pengajuan-syarat');
    }

    public function createPerizinan(Request $req){
        $tgl = Carbon::now('Asia/Jakarta');

        $surat = DB::table('surat')->insertGetId([
            'user_id' => Auth::user()->id,
            'surat_jenis_id' => $req['surat_jenis_id'],
            'nama' => $req['nama'],
            'kategori' => $req['kategori'],
            'alamat_lokasi' => $req['alamat_lokasi'],
            'longitude' => $req['longitude'],
            'latitude' => $req['latitude'],
            'status' => 'Validasi Operator',
            "created_at" => $tgl,
            "updated_at" => $tgl
        ]);

        $surat = DB::table('surat')->where('id', $surat)->first();

        $syarat = DB::table('surat_syarat')->where('surat_jenis_id', $req['surat_jenis_id'])->get();
        // $path = public_path('uploads/dokumen-syarat-pemohon');
        $childPath ='file/uploads/dokumen-syarat-pemohon/';
        $folder = $tgl->year . $tgl->month . $tgl->timestamp;
        $i = 1;
        foreach ($syarat as $syaratId) {
            
            $file = $req->file('syarat'.$i);
            $name = $folder . '.' . $file->getClientOriginalExtension();
            // $name = time() . '.' . $file->getClientOriginalExtension();
            // $file->move($path, $name);
            $file->move($childPath, $name);
            $imgPath = $childPath . $name;

            DB::table('surat_dokumen')->insert([
                'surat_id' => $surat->id,
                'surat_syarat_id' => $syaratId->id,
                'dokumen_upload' => $imgPath,
                "created_at" => $tgl,
                "updated_at" => $tgl
            ]);   

            $i++;
        }

        return response()->json(['suratId' => $surat->id]);
    }

    public function cetakRegisPdf(Request $req)
    {
        $data = DB::table('surat')->where('id',$req->noSurat)->first();
        $qrcode = base64_encode(QrCode::format('svg')->size(300)->errorCorrection('H')->generate($req->noSurat));
        $namaPerizinan=DB::table('surat_jenis')->where('id',$data->surat_jenis_id)->first()->nama;
        $pdf = \PDF::loadView('public.perizinan.cetak-regis', compact('data','qrcode','namaPerizinan'));
        return $pdf->stream('registrasi-permohonan.pdf');
    }

    public function success(){
        return view('public.perizinan.success');
    }

    public function permohonanSaya(){
        return view('public.perizinan.list-perizinan');
    }

    public function lacakPerizinan(){
        return view('public.lacak-perizinan.form-lacak');
    }

    public function detailPerizinan(Request $req){
        $data = DB::table('surat')
    ->join('surat_jenis', 'surat_jenis.id', '=', 'surat.surat_jenis_id')
    ->select('surat.*', 'surat_jenis.nama as nama_perizinan')
    ->where('surat.id',$req->no_regis)
    ->first();
    if($data){
        $data->created_at = Carbon::parse($data->created_at)->format('d F Y');
        if($data->jadwal_survey){
        $data->jadwal_survey = Carbon::parse($data->jadwal_survey)->format('d F Y');
        }
        return response()->json(['status' => 'success', 'data' => $data]);
    }else{
        return response()->json(['status' => 'error', 'message' => 'Surat Tidak Ditemukan']);
    }


    }
    
}