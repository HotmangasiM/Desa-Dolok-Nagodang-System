<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Tidak Mampu</title>
    <style>
        @page {
            margin: 30px 65px 40px 65px;
        }

        body {
            font-family: Arial, sans-serif !important;
            font-size: 13px;
            color: #000;
            line-height: 1.35;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 12px;
            margin-bottom: 18px;
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

        .kop-title .line-1 { font-size: 17px; }
        .kop-title .line-2 { font-size: 16px; }
        .kop-title .line-3 { font-size: 18px; }

        .title {
            text-align: center;
            margin-top: 18px;
            margin-bottom: 18px;
            line-height: 1.2;
        }

        .title .main {
            font-weight: bold;
            text-decoration: underline;
            font-size: 14px;
        }

        .content {
            text-align: justify;
        }

        .data-table {
            margin-left: 42px;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 1px 4px;
            vertical-align: top;
        }

        .label {
            width: 130px;
            white-space: nowrap;
        }

        .colon {
            width: 10px;
        }

        .paragraph {
            margin-top: 18px;
            text-align: justify;
        }

        .signature {
            width: 330px;
            margin-left: auto;
            margin-top: 48px;
            text-align: left;
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

    $familyCardNumber = $sktm['family_card_number']
        ?? $payload['family_card_number']
        ?? $citizen->family_card_number
        ?? '-';

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
                <div class="line-1">{{ $government_name }}</div>
                <div class="line-2">{{ $district_name }}</div>
                <div class="line-3">{{ $village_name }}</div>
            </td>
            <td style="width: 120px;"></td>
        </tr>
    </table>
</div>

<div class="title">
    <div class="main">SURAT KETERANGAN TIDAK MAMPU</div>
    <div>No: {{ $letter->letter_number }}</div>
</div>

<div class="content">
    <p>Yang bertanda tangan dibawah ini:</p>

    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td><strong>{{ $signer_name }}</strong></td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $signer_position ?? 'Kepala Desa' }}</td>
        </tr>
        <tr>
            <td class="label">Desa</td>
            <td class="colon">:</td>
            <td>Dolok Nagodang</td>
        </tr>
        <tr>
            <td class="label">Kecamatan</td>
            <td class="colon">:</td>
            <td>Uluan</td>
        </tr>
        <tr>
            <td class="label">Kabupaten</td>
            <td class="colon">:</td>
            <td>Toba</td>
        </tr>
    </table>

    <p class="paragraph">Menerangkan dengan sebenarnya bahwa:</p>

    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $citizen->full_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">No.KK</td>
            <td class="colon">:</td>
            <td>{{ $familyCardNumber }}</td>
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
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td>{{ $citizen->gender ?? '-' }}</td>
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
        Adalah benar penduduk Desa Dolok Nagodang Kecamatan Uluan Kabupaten Toba
        selanjutnya diterangkan bahwa keluarga tersebut diatas benar
        <strong>Keluarga tidak mampu.</strong>
    </p>

    <p class="paragraph">
        Demikian Surat Keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan
        untuk seperlunya.
    </p>
</div>

<div class="signature">
    <div>Dikeluarkan di : Desa Dolok Nagodang</div>
    <div>Pada Tanggal&nbsp;&nbsp;: {{ $issuedDateIndo }}</div>

    <br>

    <div class="signature-center">Kepala Desa Dolok Nagodang</div>

    <div class="signature-name">
        {{ $signer_name ?? 'BANGKIT MANURUNG' }}
    </div>
</div>

</body>
</html>
