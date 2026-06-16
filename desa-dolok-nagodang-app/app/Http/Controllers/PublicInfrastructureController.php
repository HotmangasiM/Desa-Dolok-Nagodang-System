<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInfrastructureRequest;
use App\Http\Requests\UpdateInfrastructureRequest;
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
            $search = $request->search;

            $query->where(function ($builder) use ($search) {
                $builder->where('nama_barang', 'like', '%' . $search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $search . '%')
                    ->orWhere('jenis_barang', 'like', '%' . $search . '%')
                    ->orWhere('content', 'like', '%' . $search . '%');
            });
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
        $search = $request->search;

        $query->where(function ($builder) use ($search) {
            $builder->where('nama_barang', 'like', '%' . $search . '%')
                ->orWhere('kode_barang', 'like', '%' . $search . '%')
                ->orWhere('jenis_barang', 'like', '%' . $search . '%');
        });
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

   public function store(StoreInfrastructureRequest $request)
{
    $data = $request->validated();

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')
            ->store('infrastructure', 'public');
    }

    Infrastructure::create([
        ...$data,
        'slug' => $this->generateUniqueSlug($data['nama_barang']),
        'image' => $imagePath,
    ]);

    return redirect()
        ->route('admin.infrastructure.index')
        ->with('success', 'Data infrastruktur berhasil ditambahkan.');
}

    public function edit($id)
    {
        $item = Infrastructure::findOrFail($id);

        return view(
            'admin.infrastructure.edit',
            compact('item')
        );
    }

  public function update(UpdateInfrastructureRequest $request, $id)
{
    $item = Infrastructure::findOrFail($id);
    $data = $request->validated();

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
        ...$data,
        'slug' => $this->generateUniqueSlug($data['nama_barang'], $item->id),
        'image' => $imagePath,
    ]);

    return redirect()
        ->route('admin.infrastructure.index')
        ->with('success', 'Data infrastruktur berhasil diperbarui.');
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

    protected function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 2;

        while (Infrastructure::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
