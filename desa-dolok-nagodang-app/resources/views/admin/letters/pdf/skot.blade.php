<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Penghasilan Orang Tua</title>
    <style>
        @page { margin: 30px 65px; }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.4;
        }

        .kop {
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-table {
            width: 100%;
        }

        .logo {
            width: 80px;
        }

        .center { text-align: center; }

        .title {
            text-align: center;
            margin-top: 10px;
        }

        .title h3 {
            text-decoration: underline;
        }

        table {
            margin-left: 40px;
            border-collapse: collapse;
        }

        td {
            padding: 2px 5px;
        }

        .section {
            margin-top: 20px;
        }

        .signature {
            margin-top: 50px;
            width: 300px;
            margin-left: auto;
            text-align: center;
        }
    </style>
</head>
<body>

@php
    $formatDate = function ($date) {
        return $date ? \Carbon\Carbon::parse($date)->format('d-m-Y') : '-';
    };
@endphp

{{-- KOP --}}
<div class="kop">
    <table class="kop-table">
        <tr>
            <td style="width:100px;">
                <img src="{{ public_path('images/logo-kab-toba.jpg') }}" class="logo">
            </td>
            <td class="center">
                <div>{{ $government_name }}</div>
                <div>{{ $district_name }}</div>
                <div><strong>{{ $village_name }}</strong></div>
            </td>
            <td style="width:100px;"></td>
        </tr>
    </table>
</div>

{{-- TITLE --}}
<div class="title">
    <h3>SURAT KETERANGAN PENGHASILAN ORANG TUA</h3>
    <p>No: {{ $letter->letter_number }}</p>
</div>

{{-- PEMBUKA --}}
<p>Yang bertanda tangan dibawah ini:</p>

<table>
    <tr><td>Nama</td><td>: {{ $signer_name }}</td></tr>
    <tr><td>Jabatan</td><td>: {{ $signer_position }}</td></tr>
    <tr><td>Alamat</td><td>: {{ $signer_address }}</td></tr>
</table>

<p class="section">Menerangkan dengan sebenarnya bahwa:</p>

{{-- AYAH --}}
<table>
    <tr><td>Nama</td><td>: {{ $father['name'] }}</td></tr>
    <tr><td>Tempat/Tgl Lahir</td><td>: {{ $father['birth'] }}</td></tr>
    <tr><td>Agama</td><td>: {{ $father['religion'] }}</td></tr>
    <tr><td>Pekerjaan</td><td>: {{ $father['job'] }}</td></tr>
    <tr><td>Alamat</td><td>: {{ $father['address'] }}</td></tr>
    <tr><td>Besar Penghasilan</td><td>: {{ $father['income'] }}</td></tr>
</table>

<br>

{{-- IBU --}}
<table>
    <tr><td>Nama</td><td>: {{ $mother['name'] }}</td></tr>
    <tr><td>Tempat/Tgl Lahir</td><td>: {{ $mother['birth'] }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>: {{ $mother['gender'] }}</td></tr>
    <tr><td>Pekerjaan</td><td>: {{ $mother['job'] }}</td></tr>
    <tr><td>Besar Penghasilan</td><td>: {{ $mother['income'] }}</td></tr>
</table>

<p class="section">
Adalah benar penduduk Desa Dolok Nagodang Kecamatan Uluan Kabupaten Toba,
selanjutnya diterangkan bahwa kedua orang tersebut adalah orang tua dari:
</p>

{{-- ANAK --}}
<table>
    <tr><td>Nama Lengkap</td><td>: {{ $child['name'] }}</td></tr>
    <tr><td>Tempat/Tanggal Lahir</td><td>: {{ $child['birth'] }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>: {{ $child['gender'] }}</td></tr>
    <tr><td>Pekerjaan</td><td>: {{ $child['job'] }}</td></tr>
    <tr><td>Agama</td><td>: {{ $child['religion'] }}</td></tr>
    <tr><td>Alamat</td><td>: {{ $child['address'] }}</td></tr>
</table>

<p class="section">
Demikian Surat Keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
</p>

{{-- SIGN --}}
<div class="signature">
    <p>{{ $issued_location }}, {{ $issued_date }}</p>
    <p>Kepala Desa Dolok Nagodang</p>

    <br><br>

    <strong>{{ $signer_name }}</strong>
</div>

</body>
</html>