<?php

namespace App\Http\Controllers;

use App\Models\LetterType;
use Illuminate\View\View;

class PublicLetterServiceController extends Controller
{
    public function index(): View
    {
        $letterTypes = LetterType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('public.letters.index', [
            'title' => 'Layanan Surat Desa',
            'letterTypes' => $letterTypes,
        ]);
    }
}