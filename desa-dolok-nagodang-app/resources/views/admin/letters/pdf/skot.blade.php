<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Penghasilan Orang Tua</title>
    <style>
        @page { margin: 28px 58px; }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.38;
            color: #000;
        }

        .kop {
            border-bottom: 2px solid black;
            padding-bottom: 8px;
            margin-bottom: 14px;
        }

        .kop-table {
            width: 100%;
            margin-left: 0;
        }

        .logo {
            width: 72px;
        }

        .center { text-align: center; }

        .kop-title {
            font-size: 12px;
            line-height: 1.25;
        }

        .village-title {
            font-size: 15px;
        }

        .title {
            text-align: center;
            margin-top: 8px;
            margin-bottom: 14px;
        }

        .title h3 {
            margin: 0;
            text-decoration: underline;
            font-size: 15px;
        }

        .title p {
            margin: 4px 0 0 0;
        }

        p {
            margin: 9px 0;
        }

        .section {
            margin-top: 13px;
        }

        .data-table {
            margin-left: 46px;
            border-collapse: collapse;
            width: 88%;
            line-height: 1.35;
        }

        .data-table td {
            padding: 1.5px 3px;
            vertical-align: top;
        }

        .label {
            width: 140px;
            white-space: nowrap;
        }

        .colon {
            width: 8px;
            text-align: center;
        }

        .value {
            width: auto;
        }

        .spacer {
            height: 10px;
        }

        .signature {
            margin-top: 34px;
            width: 285px;
            margin-left: auto;
            text-align: center;
            line-height: 1.35;
        }

        .signature p {
            margin: 4px 0;
        }

        .sign-space {
            height: 58px;
        }
    </style>
</head>
<body>

@php
    \Carbon\Carbon::setLocale('id');

    $issuedDateIndo = now()->translatedFormat('d F Y');

    if (!empty($issued_date)) {
        try {
            $issuedDateIndo = \Carbon\Carbon::parse($issued_date)->translatedFormat('d F Y');
        } catch (\Throwable $e) {
            $issuedDateIndo = $issued_date;
        }
    }
@endphp

<div class="kop">
    <table class="kop-table">
        <tr>
            <td style="width:95px;">
                <img src="{{ public_path('images/logo.png') }}" class="logo">
            </td>
            <td class="center kop-title">
                <div>{{ $government_name }}</div>
                <div>{{ $district_name }}</div>
                <div class="village-title"><strong>{{ $village_name }}</strong></div>
            </td>
            <td style="width:95px;"></td>
        </tr>
    </table>
</div>

<div class="title">
    <h3>SURAT KETERANGAN PENGHASILAN ORANG TUA</h3>
    <p>No: {{ $letter->letter_number }}</p>
</div>

<p>Yang bertanda tangan dibawah ini:</p>

<table class="data-table">
    <tr><td class="label">Nama</td><td class="colon">:</td><td class="value">{{ $signer_name }}</td></tr>
    <tr><td class="label">Jabatan</td><td class="colon">:</td><td class="value">{{ $signer_position }}</td></tr>
    <tr><td class="label">Alamat</td><td class="colon">:</td><td class="value">{{ $signer_address }}</td></tr>
</table>

<p class="section">Menerangkan dengan sebenarnya bahwa:</p>

<table class="data-table">
    <tr><td class="label">Nama</td><td class="colon">:</td><td class="value">{{ $father['name'] }}</td></tr>
    <tr><td class="label">Tempat/Tgl Lahir</td><td class="colon">:</td><td class="value">{{ $father['birth'] }}</td></tr>
    <tr><td class="label">Agama</td><td class="colon">:</td><td class="value">{{ $father['religion'] }}</td></tr>
    <tr><td class="label">Pekerjaan</td><td class="colon">:</td><td class="value">{{ $father['job'] }}</td></tr>
    <tr><td class="label">Alamat</td><td class="colon">:</td><td class="value">{{ $father['address'] }}</td></tr>
    <tr><td class="label">Besar Penghasilan</td><td class="colon">:</td><td class="value">{{ $father['income'] }}</td></tr>
</table>

<div class="spacer"></div>

<table class="data-table">
    <tr><td class="label">Nama</td><td class="colon">:</td><td class="value">{{ $mother['name'] }}</td></tr>
    <tr><td class="label">Tempat/Tgl Lahir</td><td class="colon">:</td><td class="value">{{ $mother['birth'] }}</td></tr>
    <tr><td class="label">Jenis Kelamin</td><td class="colon">:</td><td class="value">{{ $mother['gender'] }}</td></tr>
    <tr><td class="label">Pekerjaan</td><td class="colon">:</td><td class="value">{{ $mother['job'] }}</td></tr>
    <tr><td class="label">Besar Penghasilan</td><td class="colon">:</td><td class="value">{{ $mother['income'] }}</td></tr>
</table>

<p class="section">
    Adalah benar penduduk Desa Dolok Nagodang Kecamatan Uluan Kabupaten Toba,
    selanjutnya diterangkan bahwa kedua orang tersebut adalah orang tua dari:
</p>

<table class="data-table">
    <tr><td class="label">Nama Lengkap</td><td class="colon">:</td><td class="value">{{ $child['name'] }}</td></tr>
    <tr><td class="label">Tempat/Tanggal Lahir</td><td class="colon">:</td><td class="value">{{ $child['birth'] }}</td></tr>
    <tr><td class="label">Jenis Kelamin</td><td class="colon">:</td><td class="value">{{ $child['gender'] }}</td></tr>
    <tr><td class="label">Pekerjaan</td><td class="colon">:</td><td class="value">{{ $child['job'] }}</td></tr>
    <tr><td class="label">Agama</td><td class="colon">:</td><td class="value">{{ $child['religion'] }}</td></tr>
    <tr><td class="label">Alamat</td><td class="colon">:</td><td class="value">{{ $child['address'] }}</td></tr>
</table>

<p class="section">
    Demikian Surat Keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
</p>

<div class="signature">
    <p>{{ $issued_location }}, {{ $issuedDateIndo }}</p>
    <p>Kepala Desa Dolok Nagodang</p>

    <div class="sign-space"></div>

    <strong>{{ $signer_name }}</strong>
</div>

</body>
</html>