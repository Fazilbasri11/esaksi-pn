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


class DashboardController extends Controller {

    /**
     * 
     */
    public function index() {
        $data = [
            'title' => 'Dashboard',
            'perkaras' => Perkara::where("status", true)->get(),
        ];
    
        return view('dashboard', $data);
    }

    /**
     * Create Perkara
    */
    public function createPerkara(Request $request): RedirectResponse
    {
        
        // return response()->json([
        //     'message' => 'Perkara berhasil dibuat',
        //     'data' => Perkara::all(),
        // ]);
        $jenis = $request->input('jenis'); // Ambil data dari input form
        $no = $request->input('no');
        $status = $request->input('status') == "1";

        $perkara = [
            "jenis" => $jenis,
            "no" => $no,
            "status" => $status,
        ];

        

        $perkara = Perkara::create([
            "jenis" => $jenis,
            "no" => $no,
            "status" => $status,
        ]); 

        return redirect('/dashboard');
        // return response()->json([
        //     'message' => 'Perkara berhasil dibuat',
        //     'data' => $perkara,
        // ]);
    
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
            'status' => 'required|boolean',
        ]);

        $perkara = Perkara::findOrFail($id);
        $perkara->update([
            'jenis' => $request->jenis,
            'no' => $request->no,
            'status' => $request->status,
        ]);

        return redirect()->route('perkara.edit', $id)->with('success', 'Perkara berhasil diperbarui!');
    }


}



