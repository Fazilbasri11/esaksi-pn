<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\PihakMenghadirkan;
use App\Models\Perkara;



class PihakMenghadirkanController extends Controller {

    // API Method

    public function index() {
        $perkaras = Perkara::where("status", true)->get();


        // foreach ($perkaras as $key => $perkara) {
        //     $maxIndex = PihakMenghadirkan::where("no_perkara", $perkara->no)->max('index');
        //     $pihakMenghadirkanArray = collect();

        //     for ($i = 1; $i <= $maxIndex; $i++) {
        //         $pihakTergugat = PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "tergugat")->where("index", $i)->first();
        //         $pihakPenggugat = PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "penggugat")->where("index", $i)->first();
        //         $pihakTurutTergugat = PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "turut_tergugat")->where("index", $i)->first();
        //         $pihakPemohon = PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "pemohon")->where("index", $i)->first();
        //         $pihakTermohon = PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "termohon")->where("index", $i)->first();

        //         $pihakMenghadirkan = [
        //             "tergugat"=> $pihakTergugat,
        //             "penggugat"=> $pihakPenggugat,
        //             "turut_tergugat"=> $pihakTurutTergugat,
        //             "pemohon"=> $pihakPemohon,
        //             "termohon"=> $pihakTermohon,
        //             "maxIndex"=> $maxIndex,
        //         ];

        //         $pihakMenghadirkanArray->push($pihakMenghadirkan);
        //     }
         

        //     $perkaras[$key]->pihak_menghadirkan = $pihakMenghadirkanArray->toArray(); // Tambahkan ke objek
        // }

        $data = [
            "perkaras" => $perkaras,
        ];

        return view('pihak-menghadirkan.index', $data);
    }


    public function form(Request $request) {
        $no_perkara = $request->query('perkara'); 
    
        // Cari berdasarkan kolom `no`
        $perkara = $no_perkara ? Perkara::where('no', $no_perkara)->first() : null; 

        $data = [
            "perkara" => $perkara,
            "perkara_options" => Perkara::all(), // Mengambil semua data dari model Perkara
            "pihak_menghadirkan" => PihakMenghadirkan::where("no_perkara", $no_perkara)->get(),
        ];
    
        return view('pihak-menghadirkan.form', $data);
    }


    public function add(Request $request): JsonResponse {
        $body = $request->all();


        $data = [
            "data"=> $body,
        ];

        // "jenis_perdata": "gugatan_sederhana",
        // "pihak": "turut_tergugat",
        // "nama": "Lela",
        // "nomor_telepon": "08123456789",
        // "jumlah_saksi": "1"

        return response()->json($data, 200);
        // $no_perkara = $request->query('perkara') ?? ""; 
    

        // $jenis_perdata = $request->input('jenis_perdata'); 
        // $pihak = $request->input('pihak'); 
        // $nama = $request->input('name'); 
        // $no_telp = $request->input('phone'); 
        // $jumlah_saksi = $request->input('jumlah_saksi') ?? 0; 
        // $index = $request->input('index') ?? 1; 
        
        // // Cek apakah kombinasi jenis_perdata, pihak, dan index sudah ada
        // $exists = PihakMenghadirkan::where([
        //     'jenis_perdata' => $jenis_perdata,
        //     'pihak' => $pihak,
        //     'index' => $index
        // ])->exists();

        // if ($exists) {
        //     return redirect()->back()->withErrors('Data sudah ada!');
        // }

        // $data = [
        //     "no_perkara" => $no_perkara,
        //     "jenis_perdata" => $jenis_perdata,
        //     "pihak" => $pihak,
        //     "nama" => $nama,
        //     "no_telp" => $no_telp,
        //     "jumlah_saksi" => $jumlah_saksi,
        //     "index"=> $index,
        // ];

        // $pihak = PihakMenghadirkan::create($data);
    
        // return response()->json($data, 200);

        // return redirect("/pihak-menghadirkan/form" . ($no_perkara !== "" ? "?perkara={$no_perkara}" : ""));

    }

    public function destroy(Request $request) {
        $id = $request->input('id');
        PihakMenghadirkan::destroy($id); // Hapus berdasarkan ID
        return redirect()->back()->with('success', 'Data deleted successfully.');
    }
    

}


/**
 * 
 * jenis perdata
 */