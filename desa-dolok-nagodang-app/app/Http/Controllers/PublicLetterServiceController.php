<?php

namespace App\Http\Controllers;

use App\Models\LetterType;
use Illuminate\View\View;
use App\Models\Citizen;
use App\Models\Letter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function show(string $code): View
    {
        $letterType = LetterType::where('is_active', true)
            ->where('code', strtoupper($code))
            ->firstOrFail();

        $requirements = $this->requirementsByCode($letterType->code);
        $flowSteps = $this->flowSteps();

        return view('public.letters.show', [
            'title' => $letterType->name,
            'letterType' => $letterType,
            'requirements' => $requirements,
            'flowSteps' => $flowSteps,
        ]);
    }

    private function requirementsByCode(string $code): array
    {
        return match (strtoupper($code)) {
            'DOM' => [
                'Fotokopi KTP pemohon',
                'Fotokopi Kartu Keluarga',
                'Alamat domisili yang jelas',
            ],
            'SKTM' => [
                'Fotokopi KTP pemohon',
                'Fotokopi Kartu Keluarga',
                'Keterangan keperluan surat',
                'Dokumen pendukung jika diperlukan',
            ],
            'YTM' => [
                'Fotokopi KTP atau identitas anak',
                'Fotokopi Kartu Keluarga',
                'Nama ayah dan ibu kandung',
                'Keterangan wali/orang tua yang tinggal bersama',
            ],
            'SKOT' => [
                'Fotokopi KTP anak/pemohon',
                'Fotokopi Kartu Keluarga',
                'Data ayah dan ibu',
                'Informasi penghasilan ayah dan ibu',
            ],
            'SKU' => [
                'Fotokopi KTP pemohon',
                'Fotokopi Kartu Keluarga',
                'Nama usaha',
                'Jenis usaha',
                'Alamat usaha',
            ],
            default => [
                'Fotokopi KTP pemohon',
                'Fotokopi Kartu Keluarga',
                'Dokumen pendukung sesuai kebutuhan surat',
            ],
        };
    }

    private function flowSteps(): array
    {
        return [
            'Pilih jenis surat yang dibutuhkan.',
            'Siapkan dokumen persyaratan.',
            'Datang ke kantor desa pada jam pelayanan.',
            'Petugas melakukan verifikasi data.',
            'Surat diproses dan dapat diambil setelah selesai.',
        ];
    }

    public function apply(string $code): View
    {
        $letterType = LetterType::where('is_active', true)
            ->where('code', strtoupper($code))
            ->firstOrFail();

        return view('public.letters.apply', [
            'title' => 'Ajukan ' . $letterType->name,
            'letterType' => $letterType,
        ]);
    }

    public function storeApplication(Request $request, string $code): RedirectResponse
    {
        $letterType = LetterType::where('is_active', true)
            ->where('code', strtoupper($code))
            ->firstOrFail();

        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'purpose' => ['nullable', 'string', 'max:1000'],
        ]);

        $citizen = Citizen::where('nik', $validated['nik'])->first();

        if (!$citizen) {
            return back()
                ->withInput()
                ->withErrors([
                    'nik' => 'NIK tidak ditemukan pada data penduduk desa.',
                ]);
        }

        if (Str::lower(trim($citizen->full_name)) !== Str::lower(trim($validated['full_name']))) {
            return back()
                ->withInput()
                ->withErrors([
                    'full_name' => 'Nama lengkap tidak sesuai dengan data NIK yang terdaftar.',
                ]);
        }

        Letter::create([
            'letter_number' => null,
            'letter_type_id' => $letterType->id,
            'applicant_national_id' => $citizen->nik,
            'subject' => 'Pengajuan Online - ' . $letterType->name,
            'description' => $validated['purpose'] ?? null,
            'payload' => [
                'source' => 'public_online',
                'phone' => $validated['phone'] ?? null,
                'purpose' => $validated['purpose'] ?? null,
            ],
            'submission_date' => now(),
            'status' => 'SUBMITTED',

            // sementara pakai admin/system user id
            // pastikan user id 1 ada di tabel users
            'created_by' => 3,
        ]);

        return redirect()
            ->route('public.letters.apply', $letterType->code)
            ->with('success', 'Pengajuan surat berhasil dikirim. Silakan menunggu proses verifikasi dari petugas desa.');
    }
}