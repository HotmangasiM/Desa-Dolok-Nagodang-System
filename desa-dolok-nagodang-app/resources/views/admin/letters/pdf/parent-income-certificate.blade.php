<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Penghasilan Orang Tua</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 28px 34px;
            color: #000;
        }

        .header-table,
        .info-table,
        .content-table,
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
        }

        .logo-box {
            width: 90px;
        }

        .logo-placeholder {
            width: 72px;
            height: 72px;
            border: 1px solid #999;
            text-align: center;
            font-size: 10px;
            line-height: 72px;
            border-radius: 50%;
        }

        .text-center {
            text-align: center;
        }

        .title-1 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .title-2 {
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .title-3 {
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .line {
            margin-top: 8px;
            border-top: 3px solid #000;
            margin-bottom: 14px;
        }

        .letter-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            margin-bottom: 2px;
        }

        .letter-number {
            text-align: center;
            margin-bottom: 18px;
        }

        .paragraph {
            margin-bottom: 14px;
        }

        .content-table td {
            padding: 1px 0;
            vertical-align: top;
        }

        .label {
            width: 180px;
        }

        .colon {
            width: 12px;
            text-align: center;
        }

        .section-gap {
            height: 14px;
        }

        .signature-wrapper {
            margin-top: 42px;
            width: 100%;
        }

        .signature-box {
            width: 300px;
            margin-left: auto;
            text-align: center;
        }

        .signature-space {
            height: 90px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="logo-box">
                <div class="logo-placeholder">LOGO</div>
            </td>
            <td class="text-center">
                <div class="title-1">{{ $government_name }}</div>
                <div class="title-2">{{ $district_name }}</div>
                <div class="title-3">{{ $village_name }}</div>
            </td>
        </tr>
    </table>

    <div class="line"></div>

    <div class="letter-title">SURAT KETERANGAN PENGHASILAN ORANG TUA</div>
    <div class="letter-number">No: {{ $letter->letter_number }}</div>

    <div class="paragraph">Yang bertanda tangan dibawah ini:</div>

    <table class="content-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="bold">{{ $signer_name }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="colon">:</td>
            <td>{{ $signer_position }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $signer_address }}</td>
        </tr>
    </table>

    <div class="section-gap"></div>

    <div class="paragraph">Menerangkan dengan sebenarnya bahwa:</div>

    <table class="content-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="bold">{{ $father['name'] }}</td>
        </tr>
        <tr>
            <td class="label">Tempat/Tgl Lahir</td>
            <td class="colon">:</td>
            <td>{{ $father['birth'] }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $father['religion'] }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>{{ $father['job'] }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $father['address'] }}</td>
        </tr>
        <tr>
            <td class="label">Besar Penghasilan</td>
            <td class="colon">:</td>
            <td>{{ $father['income'] }}</td>
        </tr>
    </table>

    <div class="section-gap"></div>

    <table class="content-table">
        <tr>
            <td class="label">Nama</td>
            <td class="colon">:</td>
            <td class="bold">{{ $mother['name'] }}</td>
        </tr>
        <tr>
            <td class="label">Tempat/Tgl Lahir</td>
            <td class="colon">:</td>
            <td>{{ $mother['birth'] }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td>{{ $mother['gender'] }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>{{ $mother['job'] }}</td>
        </tr>
        <tr>
            <td class="label">Besar Penghasilan</td>
            <td class="colon">:</td>
            <td>{{ $mother['income'] }}</td>
        </tr>
    </table>

    <div class="section-gap"></div>

    <div class="paragraph">
        Adalah benar Penduduk Desa Dolok Nagodang Kecamatan Uluan Kabupaten Toba,
        selanjutnya diterangkan bahwa kedua orang tersebut adalah orangtua dari:
    </div>

    <table class="content-table">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td class="bold">{{ $child['name'] }}</td>
        </tr>
        <tr>
            <td class="label">Tempat/Tanggal Lahir</td>
            <td class="colon">:</td>
            <td>{{ $child['birth'] }}</td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td>{{ $child['gender'] }}</td>
        </tr>
        <tr>
            <td class="label">Pekerjaan</td>
            <td class="colon">:</td>
            <td>{{ $child['job'] }}</td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td>{{ $child['religion'] }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td>{{ $child['address'] }}</td>
        </tr>
    </table>

    <div class="section-gap"></div>

    <div class="paragraph">
        Demikian Surat Keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    <div class="signature-wrapper">
        <div class="signature-box">
            <div>{{ $issued_location }}, {{ $issued_date }}</div>
            <div>Kepala Desa Dolok Nagodang</div>

            <div class="signature-space"></div>

            <div class="bold">{{ $signer_name }}</div>
        </div>
    </div>

</body>
</html>