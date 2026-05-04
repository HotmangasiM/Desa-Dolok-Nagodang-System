@extends('layouts.public')

@section('content')
<section class="bg-emerald-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold">Layanan Surat Desa</h1>
        <p class="mt-3 text-emerald-100">
            Informasi jenis surat yang dapat diproses melalui kantor desa.
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($letterTypes as $type)
            <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-sm">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center text-3xl">
                    📄
                </div>

                <h2 class="mt-4 text-lg font-bold text-slate-800">
                    {{ $type->name }}
                </h2>

                <p class="mt-2 text-sm text-slate-500 leading-6">
                    Silakan menghubungi kantor desa untuk proses pengajuan dan kelengkapan dokumen.
                </p>
            </div>
        @endforeach
    </div>
</section>
@endsection