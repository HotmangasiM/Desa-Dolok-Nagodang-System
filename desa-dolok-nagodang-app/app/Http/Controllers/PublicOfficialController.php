<?php

namespace App\Http\Controllers;

use App\Models\Official;
use Illuminate\View\View;

class PublicOfficialController extends Controller
{
    public function index(): View
    {
        $officials = Official::latest()->get();

        return view('public.officials.index', [
            'title' => 'Aparat Desa',
            'officials' => $officials,
        ]);
    }
}