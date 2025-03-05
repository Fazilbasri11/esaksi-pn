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


    public function agendaBiasaAdd(Request $request) {
        $body = $request->all();
        $jenisPerkara = $body["jenis_pidana"];
        try {
            if($jenisPerkara == 'pidana') {
                switch ($body["pihak_menghadirkan"]) {
                    case 'jaksa':
                        $affectedRows = Perkara::where("status", true)
                        ->where("jenis", $jenisPerkara)
                        ->where("no", $body["no_perkara"])
                        ->update(["jaksa_hadir" => true]);
                        return redirect()->back()->with('success', 'Data berhasil diubah!');            
                        break;
                    case 'terdakwa':
                        $affectedRows = Perkara::where("status", true)
                        ->where("jenis", $jenisPerkara)
                        ->where("no", $body["no_perkara"])
                        ->update(['terdakwa_hadir' => true]);
                        return redirect()->back()->with('success', 'Data berhasil diubah!');                
                        break;
                    case 'jaksa_dan_terdakwa':
                        $affectedRows = Perkara::where("status", true)
                        ->where("jenis", $jenisPerkara)
                        ->where("no", $body["no_perkara"])
                        ->update(["jaksa_hadir" => true, 'terdakwa_hadir' => true]);
                        return redirect()->back()->with('success', 'Data berhasil diubah!');   
                        break;
                }
            } else {
                PihakMenghadirkan::where("pihak", $body["pihak_menghadirkan"])
                ->where("no_perkara", $body["no_perkara"])
                ->where("id", intval($body["pihak_hadir"] ?? "0"))
                ->update(["hadir" => true]);
                return redirect()->back()->with('success', 'Data berhasil diubah!');  
            }
        }  catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function createSaksiPerdata(Request $request): JsonResponse {
        try {
            $body = $request->all();
            $form = [];
    
            foreach ($body["rows"] as $row) {
                $form[] = [
                    "pihak_id" => intval($body["pihak_dari"] ?? "0"),
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


    public function addSaksi(Request $request): RedirectResponse {
        $body = $request->all();
        $form = collect();
        // Loop melalui data dengan prefix 'row_nama_' dan 'row_telepon_'
        foreach ($body as $key => $value) {
            if (preg_match('/row_nama_(\d+)/', $key, $matches)) {
                $index = $matches[1];
                $form->push([
                    "agenda" => $body["agenda"],
                    "jenis_pidana" => $body["jenis"],
                    "no_perkara" => $body["no_perkara"],
                    "pihak_menghadirkan" => $body["pihak_menghadirkan"],
                    "pihak_id" => isset($body["pihak_dari"]) && is_numeric($body["pihak_dari"]) ? (int) $body["pihak_dari"] : 0,
                    "pihak" => $body["pihak"],
                    "tanggal" => $body["tanggal"],
                    "nama" => $value,
                    "nomor_telepon" => $body["row_telepon_$index"] ?? null,
                ]);
            }
        }
        try {
            Saksi::insert($form->toArray());
            return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
        } catch (ValidationException $e) {
            return redirect()->back()->with('error', $e->errors());
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
        $noPerkara = $request->query('no_perkara');
        $pihak = $request->query('pihak');
    
        $pihaks = PihakMenghadirkan::query()
            ->when($noPerkara, fn($query) => $query->where('no_perkara', $noPerkara))
            ->when($pihak, fn($query) => $query->where('pihak', $pihak))
            ->get();
    
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

