@extends('layouts.public')

@section('content')
<section class="bg-emerald-900 text-white">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl font-bold">Aparat Desa</h1>
        <p class="mt-3 text-emerald-100">
            Struktur perangkat Desa Dolok Nagodang.
        </p>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @forelse ($officials as $official)
            <div class="rounded-3xl bg-white border border-slate-200 p-6 text-center shadow-sm">
                <div class="mx-auto w-28 h-28 rounded-full bg-emerald-100 overflow-hidden flex items-center justify-center text-4xl font-bold text-emerald-700">
                    @if ($official->photo)
                        <img src="{{ asset('storage/' . $official->photo) }}"
                             class="w-full h-full object-cover"
                             alt="{{ $official->name }}">
                    @else
                        {{ strtoupper(substr($official->name, 0, 1)) }}
                    @endif
                </div>

                <h2 class="mt-4 font-bold text-slate-800">
                    {{ $official->name }}
                </h2>

                <p class="mt-1 text-sm text-emerald-700 font-medium">
                    {{ $official->position ?? '-' }}
                </p>

                @if($official->description)
                    <p class="mt-3 text-sm text-slate-500 leading-6">
                        {{ \Illuminate\Support\Str::limit($official->description, 100) }}
                    </p>
                @endif
            </div>
        @empty
            <div class="md:col-span-4 rounded-2xl bg-white border p-10 text-center text-slate-500">
                Data aparat desa belum tersedia.
            </div>
        @endforelse
    </div>
</section>
@endsection