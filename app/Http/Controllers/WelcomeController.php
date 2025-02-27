<?php


namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\Perkara;
use App\Models\PihakMenghadirkan;
use App\Models\Saksi;

class WelcomeController extends Controller {

    public function index(Request $request) {
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

       
        $jenisPidana = $request->query('jenis_pidana') ?? "";
        $perkaras = Perkara::where("status", true)->get();
    
        if ($jenisPidana == "perdata" || $jenisPidana == "pidana") {
            session()->put('agenda', $jenisPidana);
            $perkaras = Perkara::where("status", true)->where("jenis", $jenisPidana)->get();
        }
    
        $data = [
            "perkaras" => $perkaras,
        ];
        return view('welcome', $data);
    }

    public function createSaksiPerdata(Request $request): RedirectResponse {
        $body = $request->all();
        try {
            Saksi::create($body);
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function saksiDestroy($id): RedirectResponse {
        $perkara = Saksi::findOrFail($id);
        $perkara->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function findPerkara(Request $request) : JsonResponse {
        $jenisPidana = $request->query('jenis_pidana') ?? "";
      
        if ($jenisPidana == "perdata" || $jenisPidana == "pidana") {
            $perkaras = Perkara::where("status", true)->where("jenis", $jenisPidana)->get();
            return response()->json($perkaras);
        }

        $perkaras = Perkara::where("status", true)->get();
        return response()->json($perkaras);
    }

}

