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


class WelcomeController extends Controller {

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
        return view('welcome', $data);
    }

    public function createSaksiPerdata(Request $request): JsonResponse {
        // $validated = $request->validate([
        //     'jenis' => 'required|string',
        //     'no' => ['required', 'regex:/^[\pL\pN\s\-\/().]+$/u', 'unique:perkaras,no'],
        // ]);

        $body = $request->all();

        $data = [
            "jenis_pidana" => $body["jenis_pidana"],
        ];

        return response()->json([
            'message' => 'Berhasil Menambahkan Data',
            "data" => $body,
        ]);
    }

}
