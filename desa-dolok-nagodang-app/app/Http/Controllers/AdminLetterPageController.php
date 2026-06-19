<?php

namespace App\Http\Controllers;

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
            'search' => trim((string) $request->query('search')),
            'status' => $request->query('status'),
            'letter_type_id' => $request->query('letter_type_id'),
            'submission_date_from' => trim((string) $request->query('submission_date_from')),
            'submission_date_to' => trim((string) $request->query('submission_date_to')),
        ];

        if (
            $filters['submission_date_from'] &&
            $filters['submission_date_to'] &&
            $filters['submission_date_from'] > $filters['submission_date_to']
        ) {
            [$filters['submission_date_from'], $filters['submission_date_to']] = [
                $filters['submission_date_to'],
                $filters['submission_date_from'],
            ];
        }

        $perPage = (int) $request->query('per_page', 10);

        $letters = $this->letterService->getAll($filters, $perPage);

        $allLetters = Letter::count();
        $submittedLetters = Letter::where('status', 'SUBMITTED')->count();
        $completedLetters = Letter::where('status', 'COMPLETED')->count();

        $letterTypes = LetterType::orderBy('name')->get();

        return view('admin.letters.index', [
            'title' => 'Admin Desa - Surat Elektronik',
            'pageTitle' => 'Surat Elektronik',
            'pageDescription' => 'Kelola pengajuan dan administrasi surat elektronik desa secara terpusat.',
            'breadcrumbs' => [
                ['label' => 'Surat Elektronik', 'url' => null],
            ],
            'letters' => $letters,
            'allLetters' => $allLetters,
            'submittedLetters' => $submittedLetters,
            'completedLetters' => $completedLetters,
            'letterTypes' => $letterTypes,
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('admin.letters.create', [
            'title' => 'Admin Desa - Tambah Surat',
            'pageTitle' => 'Tambah Surat Elektronik',
            'pageDescription' => 'Lengkapi form untuk menambahkan surat elektronik baru.',
            'breadcrumbs' => [
                ['label' => 'Surat Elektronik', 'url' => route('admin.letters.index')],
                ['label' => 'Tambah Surat', 'url' => null],
            ],
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
            'pageDescription' => 'Perbarui data surat elektronik yang sudah tersimpan.',
            'breadcrumbs' => [
                ['label' => 'Surat Elektronik', 'url' => route('admin.letters.index')],
                ['label' => 'Edit Surat', 'url' => null],
            ],
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
