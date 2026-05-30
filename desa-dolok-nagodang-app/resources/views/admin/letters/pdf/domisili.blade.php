<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Domisili</title>
    <style>
        @page {
            margin: 30px 65px 40px 65px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            line-height: 1.45;
        }

        .kop {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .logo-cell {
            width: 120px;
            text-align: center;
            vertical-align: middle;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .kop-title {
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            line-height: 1.3;
        }

        .kop-title .line-1 {
            font-size: 16px;
        }

        .kop-title .line-2 {
            font-size: 15px;
            color: #1d4ed8;
        }

        .kop-title .line-3 {
            font-size: 18px;
        }

        .title {
            text-align: center;
            margin-top: 18px;
            margin-bottom: 18px;
            line-height: 1.2;
        }

        .title .main {
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 5px;
        }

        .content {
            text-align: justify;
        }

        .indent {
            text-indent: 42px;
        }

        .data-table {
            margin-top: 18px;
            margin-left: 42px;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .label {
            width: 135px;
        }

        .colon {
            width: 10px;
        }

        .paragraph {
            margin-top: 30px;
            text-align: justify;
        }

        .signature {
            width: 260px;
            margin-left: auto;
            margin-top: 48px;
            text-align: left;
        }

        .signature-name {
            margin-top: 65px;
            text-align: center;
            font-weight: bold;
        }

        .signature-center {
            text-align: center;
        }
    </style>
</head>
<body>

@php
    \Carbon\Carbon::setLocale('id');

    $birthDate = $citizen->birth_date
        ? \Carbon\Carbon::parse($citizen->birth_date)->format('d-m-Y')
        : '-';

    $maritalStatusMap = [
        'belum_kawin' => 'Belum Kawin',
        'kawin' => 'Kawin',
        'cerai_hidup' => 'Cerai Hidup',
        'cerai_mati' => 'Cerai Mati',
    ];

    $maritalStatus = $maritalStatusMap[$citizen->marital_status]
        ?? ($citizen->marital_status ?? '-');

    $domicileAddress = $payload['domicile_address']
        ?? '........................................';

    $issuedDateIndo = now()->translatedFormat('d F Y');

    if (!empty($issued_date)) {
        try {
            $issuedDateIndo = \Carbon\Carbon::parse($issued_date)
                ->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            $issuedDateIndo = $issued_date;
        }
    } elseif (!empty($letter->submission_date)) {
        $issuedDateIndo = \Carbon\Carbon::parse($letter->submission_date)
            ->translatedFormat('d F Y');
    }
@endphp

<div class="kop">
    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                {{-- Simpan logo di public/images/logo-toba.png --}}
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            </td>
            <td class="kop-title">
                <div class="line-1">PEMERINTAH KABUPATEN TOBA</div>
                <div class="line-2">KECAMATAN ULUAN</div>
                <div class="line-3">DESA DOLOK NAGODANG</div>
            </td>
            <td style="width: 120px;"></td>
        </tr>
    </table>
</div>

<div class="title">
    <div class="main">SURAT KETERANGAN DOMISILI</div>
    <div>No: {{ $letter->letter_number }}</div>
</div>

<div class="content">
    <p class="indent">
        Yang bertanda tangan dibawah Kepala Desa Dolok Nagodang, kecamatan
        Uluan kabupaten Toba menerangkan dengan sebenarnya bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td>{{ $citizen->nik ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $citizen->full_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td>{{ $citizen->gender ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tempat/Tgl lahir</td>
            <td class="colon">:</td>
            <td>{{ $citizen->birth_place ?? '-' }}, {{ $birthDate }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $citizen->religion ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Status Perkawinan</td>
            <td class="colon">:</td>
            <td>{{ $maritalStatus }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>{{ $citizen->occupation ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $citizen->address ?? '-' }}</td>
        </tr>
    </table>

    <p class="paragraph indent">
        Selanjutnya diterangkan bahwa nama tersebut di atas benar berdomisili
        di {{ $citizen->address }}, Desa Dolok Nagodang, Kec. Uluan, Kab. Toba.
    </p>

    <p class="indent">
        Demikianlah Surat Keterangan ini dibuat untuk dapat dipergunakan
        sebagaimana mestinya.
    </p>
</div>

<div class="signature">
    <div class="signature-center">Dolok Nagodang, {{ $issuedDateIndo }}</div>
    <div class="signature-center">Kepala Desa Dolok Nagodang</div>
    <br>
    <div class="signature-name">
        BANGKIT MANURUNG
    </div>
</div>

</body>
</html>