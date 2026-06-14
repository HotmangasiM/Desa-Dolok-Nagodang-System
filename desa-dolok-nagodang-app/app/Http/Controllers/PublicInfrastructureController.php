<?php

namespace App\Http\Controllers;

use App\Models\Infrastructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicInfrastructureController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PUBLIC
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Infrastructure::query()
            ->where('status', 'publish');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $infrastructures = $query
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view(
            'public.infrastruktur.index',
            compact('infrastructures')
        );
    }

    public function show($slug)
    {
        $infrastructure = Infrastructure::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        $relatedInfrastructures = Infrastructure::where('status', 'publish')
            ->where('id', '!=', $infrastructure->id)
            ->latest()
            ->take(5)
            ->get();

        return view(
            'public.infrastruktur.show',
            compact(
                'infrastructure',
                'relatedInfrastructures'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $request)
{
    $query = Infrastructure::query();

    if ($request->filled('search')) {
        $query->where(
            'title',
            'like',
            '%' . $request->search . '%'
        );
    }

    $data = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $allInfrastructure = Infrastructure::count();

    $publishedInfrastructure = Infrastructure::where(
        'status',
        'publish'
    )->count();

    $draftInfrastructure = Infrastructure::where(
        'status',
        'draft'
    )->count();

    return view(
        'admin.infrastructure.index',
        compact(
            'data',
            'allInfrastructure',
            'publishedInfrastructure',
            'draftInfrastructure'
        )
    );
}

    public function create()
    {
        return view('admin.infrastructure.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'nama_barang'     => 'required|string|max:255',
        'kode_barang'     => 'nullable|string|max:255',
        'jenis_barang'    => 'nullable|string|max:255',
        'jumlah_luas'     => 'nullable|string|max:255',
        'nilai_harga'     => 'nullable|numeric',
        'tahun_pengadaan' => 'nullable',
        'kondisi'         => 'required',
        'keterangan'      => 'nullable|string',
        'status'          => 'required|in:draft,publish',
        'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')
            ->store('infrastructure', 'public');
    }

    Infrastructure::create([
    'slug' => Str::slug($request->nama_barang),

    'nama_barang' => $request->nama_barang,
    'kode_barang' => $request->kode_barang,
    'jenis_barang' => $request->jenis_barang,
    'jumlah_luas' => $request->jumlah_luas,
    'nilai_harga' => $request->nilai_harga,
    'tahun_pengadaan' => $request->tahun_pengadaan,
    'kondisi' => $request->kondisi,
    'keterangan' => $request->keterangan,

    'content' => $request->content,

    'status' => $request->status,
    'image' => $imagePath,
]);

    return redirect()
        ->route('admin.infrastructure.index')
        ->with('success', 'Data aset berhasil ditambahkan.');
}

    public function edit($id)
    {
        $item = Infrastructure::findOrFail($id);

        return view(
            'admin.infrastructure.edit',
            compact('item')
        );
    }

  public function update(Request $request, $id)
{
    $item = Infrastructure::findOrFail($id);

    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'kondisi'     => 'required',
        'status'      => 'required|in:draft,publish',
        'content'     => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = $item->image;

    if ($request->hasFile('image')) {

        if (
            $item->image &&
            Storage::disk('public')->exists($item->image)
        ) {
            Storage::disk('public')->delete($item->image);
        }

        $imagePath = $request->file('image')
            ->store('infrastructure', 'public');
    }

    $item->update([
        'slug'            => Str::slug($request->nama_barang . '-' . time()),
        'nama_barang'     => $request->nama_barang,
        'kode_barang'     => $request->kode_barang,
        'jenis_barang'    => $request->jenis_barang,
        'jumlah_luas'     => $request->jumlah_luas,
        'nilai_harga'     => $request->nilai_harga,
        'tahun_pengadaan' => $request->tahun_pengadaan,
        'kondisi'         => $request->kondisi,
        'keterangan'      => $request->keterangan,
        'content'         => $request->content,
        'status'          => $request->status,
        'image'           => $imagePath,
    ]);

    return redirect()
        ->route('admin.infrastructure.index')
        ->with('success', 'Data aset berhasil diperbarui.');
}
    public function destroy($id)
    {
        $item = Infrastructure::findOrFail($id);

        if (
            $item->image &&
            Storage::disk('public')->exists($item->image)
        ) {
            Storage::disk('public')
                ->delete($item->image);
        }

        $item->delete();

        return redirect()
            ->route('admin.infrastructure.index')
            ->with(
                'success',
                'Data infrastruktur berhasil dihapus.'
            );
    }
}