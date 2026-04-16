<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class AdminLetterPdfController extends Controller
{
    public function preview(int $letter)
    {
        $letter = Letter::with(['letterType', 'citizen'])->findOrFail($letter);

        $data = $this->buildTemplateData($letter);

        $pdf = Pdf::loadView('admin.letters.pdf.parent-income-certificate', $data);

        return $pdf->stream('surat-keterangan-penghasilan-orang-tua.pdf');
    }

    public function download(int $letter)
    {
        $letter = Letter::with(['letterType', 'citizen'])->findOrFail($letter);

        $data = $this->buildTemplateData($letter);

        $pdf = Pdf::loadView('admin.letters.pdf.parent-income-certificate', $data);

        return $pdf->download('surat-keterangan-penghasilan-orang-tua.pdf');
    }

    protected function buildTemplateData(Letter $letter): array
    {
        return [
            'letter' => $letter,

            // Header instansi
            'government_name' => 'PEMERINTAH KABUPATEN TOBA',
            'district_name' => 'KECAMATAN ULUAN',
            'village_name' => 'DESA DOLOK NAGODANG',

            // Pejabat penandatangan
            'signer_name' => 'BANGKIT MANURUNG',
            'signer_position' => 'Kepala Desa',
            'signer_address' => 'Desa Dolok Nagodang, Kec. Uluan, Kab. Toba',

            // Data dummy sementara untuk template awal
            'father' => [
                'name' => 'PAHOTAN SITORUS',
                'birth' => 'Lumban Gala-Gala, 08-08-1961',
                'religion' => 'Kristen',
                'job' => 'Petani',
                'address' => 'Desa Dolok Nagodang, Kec. Uluan, Kab. Toba, Prov. Sumut',
                'income' => 'Rp.1.000.000/Bulan',
            ],

            'mother' => [
                'name' => 'DERITA MANURUNG',
                'birth' => 'Dolok Nagodang, 03-09-1970',
                'gender' => 'Perempuan',
                'job' => 'Petani',
                'income' => 'Rp.500.000/Bulan',
            ],

            'child' => [
                'name' => optional($letter->citizen)->full_name ?? 'NAMA PEMOHON',
                'birth' => 'Dolok Nagodang, 09-10-2006',
                'gender' => 'Perempuan',
                'job' => 'Mahasiswa Poli Teknik Negeri Lampung',
                'religion' => 'Kristen',
                'address' => 'Desa Dolok Nagodang, Kec. Uluan, Kab. Toba, Prov. Sumut',
            ],

            'issued_location' => 'Dolok Nagodang',
            'issued_date' => now()->translatedFormat('d F Y'),
        ];
    }
}