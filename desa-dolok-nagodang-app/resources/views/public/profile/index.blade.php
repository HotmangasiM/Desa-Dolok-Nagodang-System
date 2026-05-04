@extends('layouts.public')

@section('content')
<section class="bg-emerald-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold">Profil Desa</h1>
        <p class="mt-3 text-emerald-100">
            Informasi umum Desa Dolok Nagodang.
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-800">Tentang Desa Dolok Nagodang</h2>

            <p class="mt-4 text-slate-600 leading-7">
                Desa Dolok Nagodang merupakan salah satu desa di Kecamatan Uluan, Kabupaten Toba.
                Website ini hadir sebagai media informasi publik, pelayanan administrasi, dan transparansi desa.
            </p>

            <h3 class="mt-8 text-xl font-bold text-slate-800">Visi</h3>
            <p class="mt-3 text-slate-600 leading-7">
                Mewujudkan desa yang informatif, tertib administrasi, dan melayani masyarakat dengan baik.
            </p>

            <h3 class="mt-8 text-xl font-bold text-slate-800">Misi</h3>
            <ul class="mt-3 space-y-2 text-slate-600 list-disc list-inside">
                <li>Meningkatkan pelayanan administrasi desa.</li>
                <li>Menyediakan informasi desa yang mudah diakses masyarakat.</li>
                <li>Mendorong transparansi dan partisipasi warga.</li>
            </ul>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <h2 class="text-xl font-bold text-slate-800">Informasi Wilayah</h2>

            <div class="mt-5 space-y-4 text-sm">
                <div>
                    <p class="text-slate-500">Desa</p>
                    <p class="font-semibold">Dolok Nagodang</p>
                </div>

                <div>
                    <p class="text-slate-500">Kecamatan</p>
                    <p class="font-semibold">Uluan</p>
                </div>

                <div>
                    <p class="text-slate-500">Kabupaten</p>
                    <p class="font-semibold">Toba</p>
                </div>

                <div>
                    <p class="text-slate-500">Provinsi</p>
                    <p class="font-semibold">Sumatera Utara</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection