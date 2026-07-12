<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PublicVillageProfileController extends Controller
{
    public function index(): View
    {
        return view('public.profile.index', [
            'title' => 'Profil Desa Dolok Nagodang',
        ]);
    }
}