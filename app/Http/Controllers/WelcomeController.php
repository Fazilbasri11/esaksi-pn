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

    // public function createSaksiPerdata(Request $request): RedirectResponse {
    //     $body = $request->all();
    //     try {
    //         Saksi::create($body);
    //         return redirect()->back()->with('success', 'Data berhasil disimpan.');
    //     } catch (ValidationException $e) {
    //         return redirect()->back()->withErrors($e->errors())->withInput();
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function createSaksiPerdata(Request $request): JsonResponse {
        try {
            $body = $request->all();
            $form = [];
    
            foreach ($body["rows"] as $row) {
                $form[] = [
                    'jenis_pidana' => $body["jenis_pidana"],
                    'no_perkara'=> $body["no_perkara"],
                    'pihak_menghadirkan'=> $body["pihak_menghadirkan"],
                    'pihak'=> $body["pihak"],
                    "tanggal"=> $body["tanggal"],
                    'nama' => $row["nama"],
                    'nomor_telepon' => $row["telepon"],
                ];
            }
            Saksi::insert($form); // insert untuk multiple records
            return response()->json($form, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
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

    public function findPihak(Request $request) : JsonResponse {
        $jenisPerkara = $request->query('jenis_perkara') ?? "";
        $noPerkara = $request->query('no_perkara') ?? "";
      
        if ($jenisPerkara != "" && $noPerkara != "") {
            $pihaks = PihakMenghadirkan::where("no_perkara", $noPerkara)->where("hadir", false)->get();
            // return response()->json([ "data:" => PihakMenghadirkan::all(),"pihaks" => $pihaks, "jenis_perkara" => $jenisPerkara, "no_perkara" => $noPerkara ]);
            return response()->json($pihaks);
        }

        $pihaks = PihakMenghadirkan::all();
        return response()->json($pihaks);
    }

    public function agendaBiasPihakHadir($id) {
        try {
            $pihak = PihakMenghadirkan::where("id", $id)->findOrFail($id);
            $pihak->update(["hadir"=> true]);
            return response()->json($pihak);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

}

