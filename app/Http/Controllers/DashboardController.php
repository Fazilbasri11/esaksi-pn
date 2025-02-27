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



