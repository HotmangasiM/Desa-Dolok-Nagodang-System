@php
    $title = 'Admin Desa - Profil';
    $pageTitle = 'Profil Pengguna';
    $pageDescription = 'Kelola informasi akun dan keamanan akses CMS.';
    $breadcrumbs = [
        ['label' => 'Profil Pengguna', 'url' => null],
    ];
@endphp

@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-2xl font-bold text-emerald-700">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">{{ $user->name }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ $user->email }}</p>
                </div>
            </div>

            <div class="inline-flex w-fit items-center gap-2 rounded-xl bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700">
                <i data-lucide="shield-check" class="h-4 w-4"></i>
                Akun Administrator
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="rounded-2xl border border-rose-200 bg-white p-5 shadow-sm">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
