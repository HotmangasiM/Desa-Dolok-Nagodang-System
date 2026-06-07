<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Infrastructure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InfrastructureController extends Controller
{
    public function index()
    {
        $data = Infrastructure::latest()->paginate(10);
        return view('admin.infrastructure.index', compact('data'));
    }

    public function create()
    {
        return view('admin.infrastructure.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();

        // slug auto
        $data['slug'] = Str::slug($request->title);

        // upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('infrastructure', 'public');
        }

        Infrastructure::create($data);

        return redirect()
            ->route('admin.infrastructure.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(Infrastructure $infrastructure)
    {
        return view('admin.infrastructure.edit', compact('infrastructure'));
    }

    public function update(Request $request, Infrastructure $infrastructure)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'status' => 'required',
            'image' => 'nullable|image',
        ]);

        $data = $request->all();

        // slug update
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('infrastructure', 'public');
        }

        $infrastructure->update($data);

        return redirect()
            ->route('admin.infrastructure.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy(Infrastructure $infrastructure)
    {
        $infrastructure->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}