<?php

namespace App\Http\Controllers;

use App\Models\Infrastructure;

class PublicInfrastructureController extends Controller
{
    public function index()
    {
        $infrastructures = Infrastructure::latest()->paginate(9);

        return view('public.infrastruktur.index', compact('infrastructures'));
    }

    public function show($slug)
    {
        $infrastructure = Infrastructure::where('slug', $slug)->firstOrFail();

        return view('public.infrastruktur.show', compact('infrastructure'));
    }
}