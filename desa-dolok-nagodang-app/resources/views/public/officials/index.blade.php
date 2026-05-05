@extends('layouts.public')

@section('content')
{{-- HERO --}}
<section class="bg-emerald-950 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <p class="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm text-emerald-100 border border-white/10">
            Pemerintahan Desa
        </p>

        <h1 class="mt-6 text-4xl md:text-5xl font-bold leading-tight">
            Aparat Desa Dolok Nagodang
        </h1>

        <p class="mt-5 max-w-3xl text-emerald-100 leading-7">
            Daftar perangkat desa yang bertugas melayani masyarakat dan menjalankan administrasi pemerintahan Desa Dolok Nagodang.
        </p>
    </div>
</section>

{{-- CONTENT --}}
<section class="max-w-7xl mx-auto px-4 py-16">
    @php
        $villageHead = $officials->first(function ($official) {
            return str_contains(strtolower($official->position ?? ''), 'kepala desa');
        });

        $otherOfficials = $officials->reject(function ($official) {
            return str_contains(strtolower($official->position ?? ''), 'kepala desa');
        });
    @endphp

    {{-- KEPALA DESA --}}
    @if ($villageHead)
        <div class="rounded-3xl bg-white border border-slate-200 p-8 shadow-sm mb-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-center">
                <div class="md:col-span-1">
                    <div class="w-40 h-40 rounded-3xl bg-emerald-100 overflow-hidden flex items-center justify-center text-5xl font-bold text-emerald-700 mx-auto md:mx-0">
                        @if ($villageHead->photo)
                            <img src="{{ asset('storage/' . $villageHead->photo) }}"
                                 class="w-full h-full object-cover"
                                 alt="{{ $villageHead->name }}">
                        @else
                            {{ strtoupper(substr($villageHead->name, 0, 1)) }}
                        @endif
                    </div>
                </div>

                <div class="md:col-span-3 text-center md:text-left">
                    <p class="text-sm font-semibold text-emerald-700">Kepala Desa</p>
                    <h2 class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $villageHead->name }}
                    </h2>
                    <p class="mt-2 text-slate-500">
                        {{ $villageHead->position ?? 'Kepala Desa' }}
                    </p>

                    @if ($villageHead->description)
                        <p class="mt-5 text-slate-600 leading-7">
                            {{ $villageHead->description }}
                        </p>
                    @else
                        <p class="mt-5 text-slate-600 leading-7">
                            Bertugas memimpin penyelenggaraan pemerintahan desa, pembangunan desa,
                            pembinaan kemasyarakatan, dan pemberdayaan masyarakat desa.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- LIST APARAT --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
        <div>
            <p class="text-sm font-semibold text-emerald-700">Struktur Perangkat Desa</p>
            <h2 class="mt-1 text-3xl font-bold text-slate-800">
                Perangkat Desa
            </h2>
            <p class="mt-2 text-slate-500">
                Perangkat desa yang membantu pelaksanaan pelayanan dan administrasi desa.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse ($otherOfficials as $official)
            <div class="rounded-3xl bg-white border border-slate-200 p-6 text-center shadow-sm hover:shadow-md hover:-translate-y-1 transition">
                <div class="mx-auto w-28 h-28 rounded-full bg-emerald-100 overflow-hidden flex items-center justify-center text-3xl font-bold text-emerald-700">
                    @if ($official->photo)
                        <img src="{{ asset('storage/' . $official->photo) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $official->name }}">
                    @else
                        {{ strtoupper(substr($official->name, 0, 1)) }}
                    @endif
                </div>

                <h3 class="mt-5 font-bold text-slate-800">
                    {{ $official->name }}
                </h3>

                <p class="mt-1 text-sm font-medium text-emerald-700">
                    {{ $official->position ?? '-' }}
                </p>

                @if ($official->phone)
                    <p class="mt-3 text-sm text-slate-500">
                        📞 {{ $official->phone }}
                    </p>
                @endif

                @if ($official->email)
                    <p class="mt-1 text-sm text-slate-500 break-all">
                        ✉ {{ $official->email }}
                    </p>
                @endif
            </div>
        @empty
            <div class="lg:col-span-4 rounded-3xl bg-white border border-slate-200 p-10 text-center text-slate-500">
                Data aparat desa belum tersedia.
            </div>
        @endforelse
    </div>
</section>
@endsection