<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Yatim</title>
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
            border-bottom: 1.8px solid #000;
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
            line-height: 1.35;
        }

        .kop-title .line-1 {
            font-size: 14px;
        }

        .kop-title .line-2 {
            font-size: 14px;
            color: #1d4ed8;
        }

        .kop-title .line-3 {
            font-size: 18px;
            font-weight: bold;
        }

        .title {
            text-align: center;
            margin-top: 16px;
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
            text-indent: 36px;
        }

        .data-table {
            margin-top: 16px;
            margin-left: 72px;
            border-collapse: collapse;
        }

        .data-table td {
            padding: 2px 4px;
            vertical-align: top;
        }

        .label {
            width: 145px;
        }

        .colon {
            width: 10px;
        }

        .paragraph {
            margin-top: 18px;
            text-align: justify;
        }

        .signature {
            width: 270px;
            margin-left: auto;
            margin-top: 42px;
            text-align: left;
        }

        .signature-name {
            margin-top: 58px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

@php
    $birthDate = $citizen->birth_date
        ? \Carbon\Carbon::parse($citizen->birth_date)->format('d-m-Y')
        : '-';

    $fatherName = $orphan['father_name'] ?? '-';
    $motherName = $orphan['mother_name'] ?? '-';
    $guardianName = $orphan['guardian_name'] ?? '-';
    $guardianAddress = $orphan['guardian_address'] ?? '-';
@endphp

<div class="kop">
    <table class="kop-table">
        <tr>
            <td class="logo-cell">
                <img src="{{ public_path('images/logo-kab-toba.jpg') }}" class="logo">
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
    <div class="main">SURAT KETERANGAN YATIM</div>
    <div>No: {{ $letter->letter_number }}</div>
</div>

<div class="content">
    <p class="indent">
        Yang bertanda tangan dibawah Kepala Desa Dolok Nagodang kecamatan
        Uluan kabupaten Toba menerangkan dengan sebenarnya bahwa :
    </p>

    <table class="data-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td>{{ $citizen->full_name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Jenis kelamin</td>
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
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $citizen->address ?? '-' }}</td>
        </tr>
    </table>

    <p class="paragraph indent">
        Selanjutnya diterangkan bahwa nama tersebut di atas benar anak Yatim
        dari pasangan:
    </p>

    <table class="data-table">
        <tr>
            <td class="label">Nama Ayah Kandung</td>
            <td class="colon">:</td>
            <td>{{ $fatherName }}</td>
        </tr>
        <tr>
            <td class="label">Nama Ibu Kandung</td>
            <td class="colon">:</td>
            <td>{{ $motherName }}</td>
        </tr>
    </table>

    <p class="paragraph indent">
        Dan pada saat keterangan ini dibuat masih berstatus pelajar dan tinggal
        bersama orang tua :
    </p>

    <table class="data-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td>{{ $guardianName }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $guardianAddress }}</td>
        </tr>
    </table>

    <p class="paragraph indent">
        Demikianlah Surat Keterangan ini dibuat untuk dapat dipergunakan
        sebagaimana mestinya.
    </p>
</div>

<div class="signature">
    <div>Dolok Nagodang, &nbsp;&nbsp; {{ $issued_month_year }}</div>
    <div>Kepala Desa Dolok Nagodang</div>

    <div class="signature-name">
        BANGKIT MANURUNG
    </div>
</div>

</body>
</html>