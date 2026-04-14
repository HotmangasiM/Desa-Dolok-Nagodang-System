<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;
use App\Models\Citizen;
use App\Models\Letter;
use App\Models\LetterType;
use App\Services\LetterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLetterPageController extends Controller
{
    public function __construct(
        protected LetterService $letterService
    ) {
    }

    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'status' => $request->query('status'),
            'letter_type_id' => $request->query('letter_type_id'),
        ];

        $perPage = (int) $request->query('per_page', 10);

        $letters = $this->letterService->getAll($filters, $perPage);

        $allLetters = Letter::count();
        $submittedLetters = Letter::where('status', 'submitted')->count();
        $approvedLetters = Letter::where('status', 'approved')->count();
        $letterTypes = LetterType::orderBy('name')->get();

        return view('admin.letters.index', [
            'title' => 'Admin Desa - Surat Elektronik',
            'pageTitle' => 'Manajemen Surat Elektronik',
            'pageDescription' => 'Kelola surat elektronik desa dan proses administrasinya.',
            'letters' => $letters,
            'allLetters' => $allLetters,
            'submittedLetters' => $submittedLetters,
            'approvedLetters' => $approvedLetters,
            'letterTypes' => $letterTypes,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.letters.create', [
            'title' => 'Admin Desa - Tambah Surat',
            'pageTitle' => 'Tambah Surat Elektronik',
            'pageDescription' => 'Tambahkan data surat elektronik baru.',
            'letterTypes' => LetterType::orderBy('name')->get(),
            'citizens' => Citizen::orderBy('full_name')->get(),
        ]);
    }

    public function store(StoreLetterRequest $request): RedirectResponse
    {
        $this->letterService->create($request->validated());

        return redirect()
            ->route('admin.letters.index')
            ->with('success', 'Data surat berhasil ditambahkan.');
    }

    public function edit(int $letter): View
    {
        return view('admin.letters.edit', [
            'title' => 'Admin Desa - Edit Surat',
            'pageTitle' => 'Edit Surat Elektronik',
            'pageDescription' => 'Perbarui data surat elektronik.',
            'letter' => $this->letterService->getById($letter),
            'letterTypes' => LetterType::orderBy('name')->get(),
            'citizens' => Citizen::orderBy('full_name')->get(),
        ]);
    }

    public function update(UpdateLetterRequest $request, int $letter): RedirectResponse
    {
        $this->letterService->update($letter, $request->validated());

        return redirect()
            ->route('admin.letters.index')
            ->with('success', 'Data surat berhasil diperbarui.');
    }

    public function destroy(int $letter): RedirectResponse
    {
        $this->letterService->delete($letter);

        return redirect()
            ->route('admin.letters.index')
            ->with('success', 'Data surat berhasil dihapus.');
    }
}