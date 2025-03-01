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
use Illuminate\Support\Facades\Validator;
use App\Models\Saksi;
use \Illuminate\Validation\ValidationException;


class PihakMenghadirkanController extends Controller {

    public function index() {
        $perkaras = Perkara::where("status", true)->get();
        $pihaks = PihakMenghadirkan::all();
        $saksis = Saksi::all();

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
            "pihaks" => $pihaks,
            "saksis" => $saksis,
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

    // public function add(Request $request): JsonResponse {
    //     // $body = $request->all();
    //     // $form = [
    //     //     "no_perkara"=> $body["no_perkara"],
    //     //     "jenis_perdata" => $body["jenis_perdata"],
    //     //     "pihak" => $body["pihak"],
    //     //     "nama" => $body["nama"],
    //     //     "no_telp" => $body["nomor_telepon"],
    //     //     "jumlah_saksi" => $body["jumlah_saksi"] ?? 0,
    //     // ];
    //     // try {
    //     //     PihakMenghadirkan::create($form);
    
    //     //     return redirect()->back()->with('success', 'Data berhasil disimpan.');
    //     // } catch (ValidationException $e) {
    //     //     return redirect()->back()->withErrors($e->errors())->withInput();
    //     // } catch (\Exception $e) {
    //     //     return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     // }
    //     $rules = [
    //         'no_perkara' => 'required|string',
    //         'jenis_perdata' => 'required|string',
    //         'pihak' => 'required|string',
    //         'nama' => 'required|string',
    //         'nomor_telepon' => 'required|string',
    //         'rows' => 'nullable|array',
    //         'rows.*.nama' => 'required|string',
    //         'rows.*.telepon' => 'required|string',
    //         'rows.*.saksi' => 'nullable|integer|min:0',
    //     ];
        
    //     $validated = $request->validate($rules);
        
    //     // Ambil nilai utama
    //     $data = collect($validated)->except('rows')->toArray();
        
    //     // Loop untuk memproses `rows` jika ada
    //     $data['rows'] = isset($validated['rows']) ? array_map(function ($row) use ($data) {
    //         return array_merge($data, $row); // Gabungkan nilai utama dengan setiap row
    //     }, $validated['rows']) : [];

        
    //     // try {
    //     //     // Simpan data utama
    //     //     $pihak = PihakMenghadirkan::create([
    //     //         'no_perkara' => $request->no_perkara,
    //     //         'jenis_perdata' => $request->jenis_perdata,
    //     //         'pihak' => $request->pihak,
    //     //         'nama' => $request->nama,
    //     //         'no_telp' => $request->nomor_telepon,
    //     //         'jumlah_saksi' => $request->input('jumlah_saksi', 0),
    //     //     ]);
            
    //     //     // Simpan data saksi jika ada
    //     //     if ($request->has('rows')) {
    //     //         foreach ($request->rows as $row) {
    //     //             $pihak->saksi()->create([
    //     //                 'nama' => $row['nama'],
    //     //                 'telepon' => $row['telepon'],
    //     //                 'jumlah_saksi' => $row['saksi'] ?? 0,
    //     //             ]);
    //     //         }
    //     //     }
            
    //     //     return redirect()->back()->with('success', 'Data berhasil disimpan.');
    //     // } catch (ValidationException $e) {
    //     //     return redirect()->back()->withErrors($e->errors())->withInput();
    //     // } catch (\Exception $e) {
    //     //     return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    //     // }


    //     return response()->json($data, 200);
    // }

    public function add(Request $request): JsonResponse {
        try {
            $body = $request->all();
            $form = [];
    
            foreach ($body["rows"] as $row) {
                $form[] = [
                    "no_perkara" => $body["no_perkara"],
                    'jenis_perdata' => $body["jenis_perdata"],
                    'pihak' => $body["pihak"],
                    'nama' => $row["nama"],
                    'no_telp' => $row["telepon"],
                    'jumlah_saksi' => $row["saksi"],
                ];
            }
    
            PihakMenghadirkan::insert($form); // insert untuk multiple records
    
            return response()->json($form, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }


    public function destroy($id): RedirectResponse {
        $perkara = PihakMenghadirkan::findOrFail($id);
        $perkara->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_perdata' => 'required|string',
            'pihak' => 'required|string',
            'nama' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
            'jumlah_saksi' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $body = $request->all();
        $form = [
            "jenis_perdata" => $body["jenis_perdata"],
            "pihak" => $body["pihak"],
            "nama" => $body["nama"],
            "no_telp" => $body["nomor_telepon"],
            "jumlah_saksi" => $body["jumlah_saksi"] ?? 0,
        ];

        $data = PihakMenghadirkan::findOrFail($id);
        $data->update($form);

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }


}

