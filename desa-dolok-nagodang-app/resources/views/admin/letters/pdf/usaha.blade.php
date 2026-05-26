<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Usaha</title>

    <style>
        @page {
            margin: 30px 65px 40px 65px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #000;
            line-height: 1.45;
        }

        .kop {
            width: 100%;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 22px;
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
            line-height: 1.25;
        }

        .kop-title .line-1 {
            font-size: 16px;
            text-decoration: underline;
        }

        .kop-title .line-2 {
            font-size: 15px;
            text-decoration: underline;
        }

        .kop-title .line-3 {
            font-size: 18px;
        }

        .title {
            text-align: center;
            margin-top: 18px;
            margin-bottom: 22px;
            line-height: 1.3;
        }

        .title .main {
            text-decoration: underline;
            font-size: 13px;
            font-weight: bold;
        }

        .content {
            text-align: justify;
        }

        .data-table,
        .official-table,
        .business-table {
            margin-left: 86px;
            border-collapse: collapse;
        }

        .official-table {
            margin-top: 8px;
            margin-bottom: 20px;
        }

        .business-table {
            margin-top: 16px;
        }

        .data-table td,
        .official-table td,
        .business-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .label {
            width: 160px;
            white-space: nowrap;
        }

        .colon {
            width: 10px;
        }

        .paragraph {
            margin-top: 22px;
            text-align: justify;
        }

        .signature {
            width: 260px;
            margin-left: auto;
            margin-top: 70px;
            text-align: left;
            line-height: 1.4;
        }

        .signature-center {
            text-align: center;
        }

        .signature-name {
            margin-top: 65px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

@php
    \Carbon\Carbon::setLocale('id');

    $birthDate = $citizen->birth_date
        ? \Carbon\Carbon::parse($citizen->birth_date)->format('d-m-Y')
        : '-';

    $businessName = $payload['business_name'] ?? '-';
    $businessType = $payload['business_type'] ?? '-';
    $businessAddress = $payload['business_address'] ?? '-';
    $businessPurpose = $payload['business_purpose'] ?? 'persyaratan administrasi';

    $issuedDateIndo = now()->translatedFormat('d F Y');

    if (!empty($issued_date)) {
        try {
            $issuedDateIndo = \Carbon\Carbon::parse($issued_date)->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            $issuedDateIndo = $issued_date;
        }
    } elseif (!empty($letter->submission_date)) {
        $issuedDateIndo = \Carbon\Carbon::parse($letter->submission_date)->translatedFormat('d F Y');
    }
@endphp

<div class="kop">
    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            </td>

            <td class="kop-title">
                <div class="line-1">PEMERINTAH KABUPATEN TOBA</div>
                <div class="line-2">KECAMATAN ULUAN</div>
                <div class="line-3">DESA DOLOK NAGODANG</div>
            </td>

            <td style="width:120px;"></td>
        </tr>
    </table>
</div>

<div class="title">
    <div class="main">SURAT KETERANGAN USAHA</div>
    <div>No: {{ $letter->letter_number }}</div>
</div>

<div class="content">

    <p>Yang bertanda tangan dibawah ini :</p>

    <table class="official-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $signer_name ?? 'BANGKIT MANURUNG' }}</td>
        </tr>

        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $signer_position ?? 'Kepala Desa' }}</td>
        </tr>

        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>Desa Dolok Nagodang, Kec. Uluan, Kab. Toba</td>
        </tr>
    </table>

    <p>Menerangkan dengan sebenarnya bahwa :</p>

    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $citizen->full_name ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">NIK</td>
            <td class="colon">:</td>
            <td>{{ $citizen->nik ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Tempat/Tgl Lahir</td>
            <td class="colon">:</td>
            <td>{{ $citizen->birth_place ?? '-' }}, {{ $birthDate }}</td>
        </tr>

        <tr>
            <td class="label">Warga Negara/Agama</td>
            <td class="colon">:</td>
            <td>Indonesia / {{ $citizen->religion ?? '-' }}</td>
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

    <p class="paragraph">
        Selanjutnya diterangkan bahwa nama tersebut diatas benar Penduduk Desa
        Dolok Nagodang, Kecamatan Uluan, Kabupaten Toba dan benar mempunyai
        usaha sebagai berikut:
    </p>

    <table class="business-table">
        <tr>
            <td class="label">Usaha Pokok</td>
            <td class="colon">:</td>
            <td>{{ $businessName }}</td>
        </tr>

        <tr>
            <td class="label">Usaha Tambahan</td>
            <td class="colon">:</td>
            <td>{{ $businessType }}</td>
        </tr>

        {{-- OPTIONAL --}}
        {{-- 
        <tr>
            <td class="label">Alamat Usaha</td>
            <td class="colon">:</td>
            <td>{{ $businessAddress }}</td>
        </tr>
        --}}
    </table>

    <p class="paragraph">
        Demikian Surat Keterangan ini dibuat sebagai
        {{ $businessPurpose }}, dan dapat dipergunakan
        sebagaimana mestinya.
    </p>

</div>

<div class="signature">
    <div>Dolok Nagodang, {{ $issuedDateIndo }}</div>

    <div class="signature-center">
        Kepala Desa Dolok Nagodang
    </div>

    <div class="signature-name">
        {{ $signer_name ?? 'BANGKIT MANURUNG' }}
    </div>
</div>

</body>
</html>