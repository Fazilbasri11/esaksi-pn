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
use App\Models\Saksi;
use App\Models\PihakMenghadirkan;


class DashboardController extends Controller {

    /**
     * 
     */
    public function index(Request $request) {
        $jsonRespone = $request->query('json') == "true"; // Ambil nil

        $perkaras = Perkara::where("status", true)->get();

        foreach ($perkaras as $key => $perkara) {
            $pihak = collect();
            $data = [
                "tergugat" => PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "tergugat")->get()->all(),
                "penggugat" => PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "penggugat")->get()->all(),
                "turut_tergugat" => PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "turut_tergugat")->get()->all(),
                "pemohon" => PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "pemohon")->get()->all(),
                "termohon" => PihakMenghadirkan::where("no_perkara", $perkara->no)->where("pihak", "termohon")->get()->all(),
            ];
            $maxLength = max(array_map('count', $data));


            for ($i = 0; $i < $maxLength; $i++) {
                $child = [
                    "tergugat" => null,
                    "penggugat" =>  null,
                    "turut_tergugat" => null,
                    "pemohon" => null,
                    "termohon" => null,
                ];
                if (isset($data["tergugat"][$i]) && $data["tergugat"][$i] !== null) {
                    $dataChild = $data["tergugat"][$i];
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_id", $dataChild["id"])->where("pihak_menghadirkan", "tergugat")->get()->all();
                    $child["tergugat"] = $dataChild;
                    $child["tergugat"]["saksi"] = $saksi;
                }
                if (isset($data["penggugat"][$i]) && $data["penggugat"][$i] !== null) {
                    $dataChild = $data["penggugat"][$i];
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_id", $dataChild["id"])->where("pihak_menghadirkan", "penggugat")->get()->all();
                    $child["penggugat"] = $dataChild;
                    $child["penggugat"]["saksi"] = $saksi;

                    
                }
                if (isset($data["turut_tergugat"][$i]) && $data["turut_tergugat"][$i] !== null) {
                    $dataChild = $data["turut_tergugat"][$i];
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_id", $dataChild["id"])->where("pihak_menghadirkan", "turut_tergugat")->get()->all();
                    $child["turut_tergugat"] = $dataChild;
                    $child["turut_tergugat"]["saksi"] = $saksi;
                }
                if (isset($data["pemohon"][$i]) && $data["pemohon"][$i] !== null) {
                    $dataChild = $data["turut_tergugat"][$i];
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_id", $dataChild["id"])->where("pihak_menghadirkan", "pemohon")->get()->all();
                    $child["pemohon"] = $dataChild;
                    $child["turut_tergugat"]["saksi"] = $saksi;
                }
                if (isset($data["termohon"][$i]) && $data["termohon"][$i] !== null) {
                    $dataChild = $data["turut_tergugat"][$i];
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_id", $dataChild["id"])->where("pihak_menghadirkan", "termohon")->get()->all();
                    $child["termohon"] = $dataChild;
                    $child["termohon"]["saksi"] = $saksi;
                }
                $pihak->push($child);
            }

            $perkaras[$key]->pihak = $pihak;
        }

        // return response()->json(["perkaras"=> $perkaras]);

        $respon = [
            "perkaras"=> $perkaras,
            // "saksi" => Saksi::all(),
        ];

        if($jsonRespone) {
            return response()->json($respon, 200);
        }
        return view('dashboard', $respon);
    }

    /**
     * Create Perkara
    */
    public function createPerkara(Request $request): RedirectResponse
    {
        
        $validated = $request->validate([
            'jenis' => 'required|string',
            'no' => ['required', 'regex:/^[\pL\pN\s\-\/().]+$/u', 'unique:perkaras,no'],
        ]);
    
        try {
            Perkara::create([
                "jenis" => $validated['jenis'],
                "no" => $validated['no'],
                "status" => true,
            ]);
    
            return redirect()->back()->with('success', 'Perkara berhasil disimpan.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        // return response()->json([
        //     'message' => 'Perkara berhasil dibuat',
        //     'data' => $perkara,
        // ]);
    }

    public function disable($id)
    {
        $perkara = Perkara::findOrFail($id);
        $perkara->update(['status' => false]); // Ubah status menjadi nonaktif

        return redirect()->back()->with('success', 'Perkara berhasil dinonaktifkan.');
    }
    

    /**
     * Remove Perkara
     */
    public function removePerkara($id)
    {
        $perkara = Perkara::findOrFail($id);
        $perkara->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function editPerkara($id): RedirectResponse
    {
        return redirect('/dashboard');
    }

    public function updatePerkara(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required|string',
            'no' => 'required|string',
        ]);

        $perkara = Perkara::findOrFail($id);
        $perkara->update([
            'jenis' => $request->jenis,
            'no' => $request->no,
        ]);

        return redirect()->route('perkara.edit', $id)->with('success', 'Perkara berhasil diperbarui!');
    }


}



