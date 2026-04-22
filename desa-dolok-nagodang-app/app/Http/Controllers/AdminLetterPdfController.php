<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class AdminLetterPdfController extends Controller
{
    public function preview(int $letter)
    {
        $letter = Letter::with(['letterType', 'citizen'])->findOrFail($letter);

        $data = $this->buildTemplateData($letter);

        $pdf = Pdf::loadView('admin.letters.pdf.parent-income-certificate', $data);

        return $pdf->stream('surat-keterangan-penghasilan-orang-tua.pdf');
    }

    // public function download(int $letter)
    // {
    //     $letter = Letter::with(['letterType', 'citizen'])->findOrFail($letter);

    //     $data = $this->buildTemplateData($letter);

    //     $pdf = Pdf::loadView('admin.letters.pdf.parent-income-certificate', $data);

    //     return $pdf->download('surat-keterangan-penghasilan-orang-tua.pdf');
    // }
    public function download(int $letter)
    {
        $letter = Letter::with(['letterType', 'citizen'])->findOrFail($letter);

        $data = $this->buildTemplateData($letter);

        $pdf = Pdf::loadView('admin.letters.pdf.parent-income-certificate', $data);

        $filename = 'letters/' . str_replace('/', '-', $letter->letter_number) . '.pdf';

        // Simpan file
        Storage::disk('public')->put($filename, $pdf->output());

        // Update database
        $letter->update([
            'result_file' => $filename
        ]);

        return response()->download(storage_path('app/public/' . $filename));
    }

    protected function buildTemplateData(Letter $letter): array
    {
        $payload = $letter->payload ?? [];

        return [
            'letter' => $letter,

            'government_name' => 'PEMERINTAH KABUPATEN TOBA',
            'district_name' => 'KECAMATAN ULUAN',
            'village_name' => 'DESA DOLOK NAGODANG',

            'signer_name' => 'BANGKIT MANURUNG',
            'signer_position' => 'Kepala Desa',
            'signer_address' => 'Desa Dolok Nagodang, Kec. Uluan, Kab. Toba',

            'father' => [
                'name' => $payload['father_name'] ?? '-',
                'birth' => $payload['father_birth'] ?? '-',
                'religion' => $payload['father_religion'] ?? '-',
                'job' => $payload['father_job'] ?? '-',
                'address' => $payload['father_address'] ?? '-',
                'income' => $payload['father_income'] ?? '-',
            ],

            'mother' => [
                'name' => $payload['mother_name'] ?? '-',
                'birth' => $payload['mother_birth'] ?? '-',
                'gender' => $payload['mother_gender'] ?? '-',
                'job' => $payload['mother_job'] ?? '-',
                'income' => $payload['mother_income'] ?? '-',
            ],

            'child' => [
                'name' => $payload['child_name'] ?? optional($letter->citizen)->full_name ?? '-',
                'birth' => $payload['child_birth'] ?? '-',
                'gender' => $payload['child_gender'] ?? '-',
                'job' => $payload['child_job'] ?? '-',
                'religion' => $payload['child_religion'] ?? '-',
                'address' => $payload['child_address'] ?? '-',
            ],

            'issued_location' => 'Dolok Nagodang',
            'issued_date' => $letter->approval_date
                ? $letter->approval_date->translatedFormat('d F Y')
                : now()->translatedFormat('d F Y'),
        ];
    }
}