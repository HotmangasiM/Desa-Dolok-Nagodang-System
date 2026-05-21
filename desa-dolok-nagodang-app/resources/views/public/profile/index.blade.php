@extends('layouts.public')

@section('content')
{{-- HERO --}}
<section class="bg-emerald-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <p class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 border border-white/10">
            Profil Desa
        </p>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight">
            Desa Dolok Nagodang
        </h1>

        <p class="mt-5 max-w-3xl text-emerald-100 leading-7">
            Informasi umum mengenai Desa Dolok Nagodang, Kecamatan Uluan, Kabupaten Toba,
            meliputi sejarah, visi misi, wilayah, dan potensi desa.
        </p>
    </div>
</section>

{{-- RINGKASAN WILAYAH --}}
<section class="max-w-7xl mx-auto px-4 -mt-8 relative z-10">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500">Desa</p>
            <h3 class="mt-2 text-xl font-bold text-slate-800">Dolok Nagodang</h3>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500">Kecamatan</p>
            <h3 class="mt-2 text-xl font-bold text-slate-800">Uluan</h3>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500">Kabupaten</p>
            <h3 class="mt-2 text-xl font-bold text-slate-800">Toba</h3>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <p class="text-sm text-slate-500">Provinsi</p>
            <h3 class="mt-2 text-xl font-bold text-slate-800">Sumatera Utara</h3>
        </div>
    </div>
</section>

{{-- TENTANG DESA --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 rounded-3xl bg-white border border-slate-200 p-8 shadow-sm">
            <p class="text-sm font-semibold text-emerald-700">Tentang Desa</p>
            <h2 class="mt-1 text-3xl font-bold text-slate-800">
                Sekilas Desa Dolok Nagodang
            </h2>

            <div class="mt-6 space-y-5 text-slate-600 leading-7">
                <p>
                    Desa Dolok Nagodang merupakan salah satu desa yang berada di Kecamatan Uluan,
                    Kabupaten Toba, Provinsi Sumatera Utara.
                </p>

                <p>
                    Website ini hadir sebagai media informasi resmi desa untuk membantu masyarakat
                    mendapatkan informasi terkait pemerintahan desa, pelayanan administrasi,
                    berita kegiatan, dan data publik desa.
                </p>

                <p>
                    Melalui sistem informasi desa ini, Pemerintah Desa Dolok Nagodang berupaya
                    meningkatkan keterbukaan informasi dan kualitas pelayanan kepada masyarakat.
                </p>
            </div>
        </div>

        <div class="rounded-3xl bg-emerald-950 text-white p-8 shadow-sm">
            <p class="text-sm font-semibold text-emerald-200">Informasi Layanan</p>
            <h2 class="mt-1 text-2xl font-bold">
                Kantor Desa
            </h2>

            <div class="mt-6 space-y-4 text-sm text-emerald-100">
                <div>
                    <p class="font-semibold text-white">Alamat</p>
                    <p class="mt-1">Desa Dolok Nagodang, Kecamatan Uluan, Kabupaten Toba</p>
                </div>

                <div>
                    <p class="font-semibold text-white">Jam Layanan</p>
                    <p class="mt-1">Senin - Jumat, 08.00 - 15.00</p>
                </div>

                <div>
                    <p class="font-semibold text-white">Layanan</p>
                    <p class="mt-1">Administrasi kependudukan dan surat keterangan desa.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- VISI MISI --}}
<section class="bg-slate-100/80 py-16">

    <div class="max-w-5xl mx-auto px-4">

        {{-- Heading --}}
        <div class="text-center max-w-3xl mx-auto">

            <h2 class="text-3xl md:text-4xl font-bold text-slate-800">
                Visi dan Misi
            </h2>
            <h3 class="text-2xl font-bold text-slate-800">
                            Desa Dolok Nagodang
                        </h3>

            <div class="mt-4 w-24 h-1 bg-emerald-600 rounded-full mx-auto"></div>

        </div>


        <div class="mt-12 space-y-8">

            {{-- VISI --}}
            <div class="rounded-3xl bg-white p-8 md:p-10 shadow-sm">

                <div class="flex items-center gap-4">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wider text-emerald-600">
                            Visi
                        </p>

                        
                    </div>

                </div>


                <div class="mt-6">

                    <p class="text-lg leading-9 text-slate-600">
                        Mewujudkan Desa Dolok Nagodang yang tertib administrasi,
                        informatif, transparan, dan memberikan pelayanan terbaik
                        kepada masyarakat.
                    </p>

                </div>

            </div>



            {{-- MISI --}}
            <div class="rounded-3xl bg-white p-8 md:p-10 shadow-sm">

                <div class="flex items-center gap-4">

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-wider text-emerald-600">
                            Misi
                        </p>

                        <h3 class="text-2xl font-bold text-slate-800">
                            Langkah dan Komitmen Desa
                        </h3>
                    </div>

                </div>


                <div class="mt-6 space-y-5">

                    <div class="flex gap-4">
                        <div class="mt-1 text-emerald-600 font-bold">✓</div>

                        <p class="text-slate-600 leading-7">
                            Meningkatkan kualitas pelayanan administrasi desa.
                        </p>
                    </div>


                    <div class="flex gap-4">
                        <div class="mt-1 text-emerald-600 font-bold">✓</div>

                        <p class="text-slate-600 leading-7">
                            Menyediakan informasi desa yang mudah diakses masyarakat.
                        </p>
                    </div>


                    <div class="flex gap-4">
                        <div class="mt-1 text-emerald-600 font-bold">✓</div>

                        <p class="text-slate-600 leading-7">
                            Mendorong transparansi dalam penyelenggaraan pemerintahan desa.
                        </p>
                    </div>


                    <div class="flex gap-4">
                        <div class="mt-1 text-emerald-600 font-bold">✓</div>

                        <p class="text-slate-600 leading-7">
                            Mendukung partisipasi masyarakat dalam pembangunan desa.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

{{-- WILAYAH ADMINISTRATIF --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Wilayah Desa</p>
            <h2 class="mt-1 text-3xl font-bold text-slate-800">
                Wilayah Administratif
            </h2>
            <p class="mt-3 text-slate-500 leading-7">
                Desa Dolok Nagodang terdiri dari beberapa wilayah dusun yang menjadi bagian
                dari administrasi pelayanan masyarakat.
            </p>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Wilayah</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-800">Dusun I</h3>
                </div>

                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Wilayah</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-800">Dusun II</h3>
                </div>

                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
                    <p class="text-sm text-slate-500">Wilayah</p>
                    <h3 class="mt-2 text-xl font-bold text-slate-800">Dusun III</h3>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
            <h3 class="text-xl font-bold text-slate-800">Peta Lokasi</h3>
            <p class="mt-2 text-sm text-slate-500">
                Lokasi wilayah Desa Dolok Nagodang.
            </p>

            <div class="mt-5 aspect-video rounded-2xl overflow-hidden border border-slate-200">
                <iframe
                    src="https://www.google.com/maps?q=Dolok%20Nagodang&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>

{{-- POTENSI DESA --}}
<section class="bg-emerald-950 text-white py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center max-w-3xl mx-auto">
            <p class="text-sm font-semibold text-emerald-200">Potensi Desa</p>
            <h2 class="mt-1 text-3xl font-bold">
                Potensi dan Keunggulan Desa
            </h2>
            <p class="mt-3 text-emerald-100">
                Beberapa potensi desa yang dapat dikembangkan untuk mendukung kesejahteraan masyarakat.
            </p>
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="rounded-3xl bg-white/10 border border-white/10 p-6">
                <div class="text-4xl">🌾</div>
                <h3 class="mt-4 font-bold">Pertanian</h3>
                <p class="mt-2 text-sm text-emerald-100 leading-6">
                    Potensi hasil pertanian dan perkebunan masyarakat desa.
                </p>
            </div>

            <div class="rounded-3xl bg-white/10 border border-white/10 p-6">
                <div class="text-4xl">🏞️</div>
                <h3 class="mt-4 font-bold">Alam dan Lingkungan</h3>
                <p class="mt-2 text-sm text-emerald-100 leading-6">
                    Lingkungan desa yang dapat dikembangkan sebagai potensi wilayah.
                </p>
            </div>

            <div class="rounded-3xl bg-white/10 border border-white/10 p-6">
                <div class="text-4xl">🤝</div>
                <h3 class="mt-4 font-bold">Gotong Royong</h3>
                <p class="mt-2 text-sm text-emerald-100 leading-6">
                    Kekuatan sosial masyarakat dalam mendukung pembangunan desa.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection