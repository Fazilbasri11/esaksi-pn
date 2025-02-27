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

class RiwayatPerkaraController extends Controller {
    public function index() {
        $perkaras = Perkara::where("status", false)->get();

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
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_menghadirkan", "tergugat")->get()->all();
                    $child["tergugat"] = $data["tergugat"][$i];
                    $child["tergugat"]["saksi"] = $saksi;
                }
                if (isset($data["penggugat"][$i]) && $data["penggugat"][$i] !== null) {
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_menghadirkan", "penggugat")->get()->all();
                    $child["penggugat"] = $data["penggugat"][$i];
                    $child["penggugat"]["saksi"] = $saksi;
                }
                if (isset($data["turut_tergugat"][$i]) && $data["turut_tergugat"][$i] !== null) {
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_menghadirkan", "turut_tergugat")->get()->all();
                    $child["turut_tergugat"] = $data["turut_tergugat"][$i];
                    $child["turut_tergugat"]["saksi"] = $saksi;
                }
                if (isset($data["pemohon"][$i]) && $data["pemohon"][$i] !== null) {
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_menghadirkan", "pemohon")->get()->all();
                    $child["pemohon"] = $data["pemohon"][$i];
                    $child["turut_tergugat"]["saksi"] = $saksi;
                }
                if (isset($data["termohon"][$i]) && $data["termohon"][$i] !== null) {
                    $saksi = Saksi::where("no_perkara", $perkara->no)->where("pihak_menghadirkan", "termohon")->get()->all();
                    $child["termohon"] = $data["termohon"][$i];
                    $child["termohon"]["saksi"] = $saksi;
                }
                $pihak->push($child);
            }

            $perkaras[$key]->pihak = $pihak;
        }

        $data = [
            "perkaras" => $perkaras,
        ];
    
        return view('riwayat-perkara.index', $data);
    }


}