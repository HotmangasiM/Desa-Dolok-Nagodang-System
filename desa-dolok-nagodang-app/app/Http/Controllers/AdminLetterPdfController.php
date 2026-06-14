<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Letter;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdminLetterPdfController extends Controller
{
    public function preview(int $letter)
    {
        $letter = Letter::with(['letterType', 'citizen'])->findOrFail($letter);

        $template = $this->resolveTemplate($letter);
        $data = $this->buildTemplateData($letter);

        $pdf = Pdf::loadView($template, $data)
            ->setOption('defaultFont', 'Arial')
            ->setPaper('a4', 'portrait');

        return $pdf->stream($this->fileName($letter));
    }

    public function download(int $letter)
    {
        $letter = Letter::with(['letterType', 'citizen'])->findOrFail($letter);

        $template = $this->resolveTemplate($letter);
        $data = $this->buildTemplateData($letter);

        $pdf = Pdf::loadView($template, $data)
            ->setOption('defaultFont', 'Arial')
            ->setPaper('a4', 'portrait');

        $filename = 'letters/' . $this->fileName($letter);

        Storage::disk('public')->put($filename, $pdf->output());

        $letter->update([
            'result_file' => $filename,
            'status' => 'COMPLETED',
        ]);

        return response()->download(storage_path('app/public/' . $filename));
    }

    protected function resolveTemplate(Letter $letter): string
    {
        $template = $letter->letterType?->template_file;

        if (!$template) {
            abort(404, 'Template surat belum diatur pada jenis surat.');
        }

        if (!view()->exists($template)) {
            abort(404, "File template PDF tidak ditemukan: {$template}");
        }

        return $template;
    }

    protected function fileName(Letter $letter): string
    {
        $number = $letter->letter_number ?: 'surat';
        $safeNumber = str_replace(['/', '\\'], '-', $number);

        return $safeNumber . '.pdf';
    }

    protected function buildTemplateData(Letter $letter): array
    {
        $payload = $letter->payload ?? [];
        $citizen = $letter->citizen;

        $fatherCitizen = !empty($payload['father_citizen_id'])
            ? Citizen::find($payload['father_citizen_id'])
            : null;

        $motherCitizen = !empty($payload['mother_citizen_id'])
            ? Citizen::find($payload['mother_citizen_id'])
            : null;

        return [
            'letter' => $letter,
            'letter_type' => $letter->letterType,
            'citizen' => $citizen,
            'payload' => $payload,

            // Kop surat
            'government_name' => 'PEMERINTAH KABUPATEN TOBA',
            'district_name' => 'KECAMATAN ULUAN',
            'village_name' => 'DESA DOLOK NAGODANG',

            // Penanda tangan
            'signer_name' => 'BANGKIT MANURUNG',
            'signer_position' => 'Kepala Desa',
            'signer_village' => 'Dolok Nagodang',
            'signer_district' => 'Uluan',
            'signer_regency' => 'Toba',
            'signer_address' => 'Desa Dolok Nagodang, Kec. Uluan, Kab. Toba',

            // Tempat dan tanggal surat
            'issued_location' => 'Dolok Nagodang',
            'issued_place_full' => 'Desa Dolok Nagodang',
            'issued_date' => now()->translatedFormat('d F Y'),
            'issued_month_year' => now()->translatedFormat('F Y'),

            // Data ayah
            'father' => [
                'name' => $fatherCitizen?->full_name ?? $payload['father_name'] ?? '-',
                'birth' => $fatherCitizen ? $this->formatBirth($fatherCitizen) : ($payload['father_birth'] ?? '-'),
                'religion' => $fatherCitizen?->religion ?? $payload['father_religion'] ?? '-',
                'job' => $fatherCitizen?->occupation ?? $payload['father_job'] ?? '-',
                'address' => $fatherCitizen ? $this->formatAddress($fatherCitizen) : ($payload['father_address'] ?? '-'),
                'income' => $payload['father_income'] ?? '-',
            ],

            // Data ibu
            'mother' => [
                'name' => $motherCitizen?->full_name ?? $payload['mother_name'] ?? '-',
                'birth' => $motherCitizen ? $this->formatBirth($motherCitizen) : ($payload['mother_birth'] ?? '-'),
                'gender' => $motherCitizen?->gender ?? $payload['mother_gender'] ?? 'Perempuan',
                'job' => $motherCitizen?->occupation ?? $payload['mother_job'] ?? '-',
                'address' => $motherCitizen ? $this->formatAddress($motherCitizen) : ($payload['mother_address'] ?? '-'),
                'income' => $payload['mother_income'] ?? '-',
            ],

            // Data anak/pemohon
            'child' => [
                'name' => $payload['child_name'] ?? optional($citizen)->full_name ?? '-',
                'birth' => $payload['child_birth'] ?? $this->formatBirth($citizen),
                'gender' => $payload['child_gender'] ?? optional($citizen)->gender ?? '-',
                'job' => $payload['child_job'] ?? optional($citizen)->occupation ?? '-',
                'religion' => $payload['child_religion'] ?? optional($citizen)->religion ?? '-',
                'address' => $payload['child_address'] ?? $this->formatAddress($citizen),
            ],

            // Data usaha
            'business' => [
                'name' => $payload['business_name'] ?? '-',
                'type' => $payload['business_type'] ?? '-',
                'address' => $payload['business_address'] ?? '-',
                'purpose' => $payload['business_purpose'] ?? 'persyaratan administrasi',
            ],

            // Data SKTM
            'sktm' => [
                'family_card_number' => $payload['family_card_number']
                    ?? optional($citizen)->family_card_number
                    ?? '-',
                'purpose' => $payload['purpose'] ?? null,
                'additional_notes' => $payload['additional_notes'] ?? null,
            ],

            // Data yatim
            'orphan' => [
                'father_name' => $payload['father_name'] ?? '-',
                'mother_name' => $payload['mother_name'] ?? '-',
                'status' => $payload['orphan_status'] ?? '-',
                'parent_death_date' => $payload['parent_death_date'] ?? '-',
                'notes' => $payload['orphan_notes'] ?? null,
                'guardian_name' => $payload['guardian_name'] ?? '-',
                'guardian_address' => $payload['guardian_address'] ?? '-',
            ],
        ];
    }

    protected function formatBirth($citizen): string
    {
        if (!$citizen) {
            return '-';
        }

        $birthPlace = $citizen->birth_place ?? null;
        $birthDate = null;

        if (!empty($citizen->birth_date)) {
            $birthDate = Carbon::parse($citizen->birth_date)->format('d-m-Y');
        }

        if ($birthPlace && $birthDate) {
            return $birthPlace . ', ' . $birthDate;
        }

        return $birthPlace ?? $birthDate ?? '-';
    }

    protected function formatAddress($citizen): string
    {
        if (!$citizen) {
            return '-';
        }

        $parts = array_filter([
            $citizen->address ?? null,
            $citizen->village ?? null,
            $citizen->district ?? null,
            $citizen->regency ?? null,
            $citizen->province ?? null,
        ]);

        return count($parts) ? implode(', ', $parts) : '-';
    }
}
