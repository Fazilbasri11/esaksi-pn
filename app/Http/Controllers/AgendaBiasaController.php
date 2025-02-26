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


class AgendaBiasaController extends Controller  {

    public function index() {
        $perkaras = Perkara::all();
        $data = [
            'title' => 'Agenda Biasa',
            "perkaras" => $perkaras,
        ];
        return view('agenda-biasa.index', $data);
    }


}