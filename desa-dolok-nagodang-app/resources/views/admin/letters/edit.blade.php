@extends('layouts.admin')

@section('content')
@php
    $payload = old('payload', $letter->payload ?? []);
    $currentLetterNumber = old('letter_number', $letter->letter_number ?? '');
    $letterNumberPrefix = old('letter_number_prefix');
    $letterNumberSuffix = '';

    if ($letterNumberPrefix === null) {
        if (preg_match('/^(\d+)(\/.*)$/', $currentLetterNumber, $matches)) {
            $letterNumberPrefix = $matches[1];
            $letterNumberSuffix = $matches[2];
        } else {
            $letterNumberPrefix = $currentLetterNumber;
        }
    } else {
        $letterNumberSuffix = preg_replace('/^\d+/', '', $currentLetterNumber);
    }

    $statusFormValue = old('status');

    if (!$statusFormValue) {
        $statusFormValue = match($letter->status) {
            'SUBMITTED' => 'submitted',
            'PROCESSING' => 'processed',
            'COMPLETED' => 'completed',
            default => '',
        };
    }
@endphp

<div class="space-y-6">
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
            <div class="font-semibold mb-2">Terjadi kesalahan pada input:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.letters.update', $letter->id) }}" method="POST" class="space-y-6" data-inline-validate>
        @csrf
        @method('PUT')
        <input type="hidden" id="letter_number" name="letter_number" value="{{ $currentLetterNumber }}">

        {{-- Informasi Surat --}}
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Surat</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi utama surat elektronik.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor Urut Surat <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex overflow-hidden rounded-xl border border-slate-300">
                        <input
                            type="text"
                            id="letter_number_prefix"
                            name="letter_number_prefix"
                            value="{{ $letterNumberPrefix }}"
                            required
                            data-required-label="Nomor Urut Surat"
                            inputmode="numeric"
                            maxlength="20"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-32 border-0 px-4 py-3 text-sm focus:outline-none focus:ring-0"
                            placeholder="Contoh: 002"
                        >
                        <input
                            type="text"
                            id="letter_number_suffix_preview"
                            value="{{ $letterNumberSuffix }}"
                            readonly
                            class="min-w-0 flex-1 border-0 border-l border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-500 focus:outline-none focus:ring-0"
                            placeholder="/KODE/BULAN/TAHUN"
                        >
                    </div>
                    @include('admin.partials.field-error', ['field' => 'letter_number_prefix'])
                    @include('admin.partials.field-error', ['field' => 'letter_number'])
                    <p class="mt-1 text-xs text-slate-400">
                        Ubah nomor urut secara manual. Format surat setelahnya dibuat otomatis oleh sistem.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jenis Surat <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="letter_type_id"
                        name="letter_type_id"
                        required
                        data-required-label="Jenis Surat"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Jenis Surat</option>
                        @foreach ($letterTypes as $type)
                            <option
                                value="{{ $type->id }}"
                                data-code="{{ strtoupper($type->code ?? '') }}"
                                {{ (string) old('letter_type_id', $letter->letter_type_id) === (string) $type->id ? 'selected' : '' }}
                            >
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @include('admin.partials.field-error', ['field' => 'letter_type_id'])
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Pemohon <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="citizen_id"
                        name="citizen_id"
                        required
                        data-required-label="Pemohon"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Penduduk</option>
                        @foreach ($citizens as $citizen)
                            <option
                                value="{{ $citizen->id }}"
                                data-nik="{{ $citizen->nik }}"
                                data-full-name="{{ $citizen->full_name }}"
                                data-birth-place="{{ $citizen->birth_place }}"
                                data-birth-date="{{ $citizen->birth_date }}"
                                data-gender="{{ $citizen->gender }}"
                                data-religion="{{ $citizen->religion }}"
                                data-occupation="{{ $citizen->occupation }}"
                                data-address="{{ $citizen->address }}"
                                data-village="{{ $citizen->village }}"
                                data-district="{{ $citizen->district }}"
                                data-regency="{{ $citizen->regency }}"
                                data-province="{{ $citizen->province }}"
                                {{ (string) old('citizen_id', optional($letter->citizen)->id) === (string) $citizen->id ? 'selected' : '' }}
                            >
                                {{ $citizen->full_name }} - {{ $citizen->nik }}
                            </option>
                        @endforeach
                    </select>
                    @include('admin.partials.field-error', ['field' => 'citizen_id'])
                </div>

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Subjek <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="subject"
                        value="{{ old('subject', $letter->subject) }}"
                        required
                        data-required-label="Subjek"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan subjek surat"
                    >
                    @include('admin.partials.field-error', ['field' => 'subject'])
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Status <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="status"
                        required
                        data-required-label="Status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Status</option>
                        <option value="submitted" {{ $statusFormValue === 'submitted' ? 'selected' : '' }}>submitted</option>
                        <option value="processed" {{ $statusFormValue === 'processed' ? 'selected' : '' }}>processed</option>
                        <option value="completed" {{ $statusFormValue === 'completed' ? 'selected' : '' }}>completed</option>
                    </select>
                    @include('admin.partials.field-error', ['field' => 'status'])
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pengajuan</label>
                    <input
                        type="date"
                        name="submission_date"
                        value="{{ old('submission_date', $letter->submission_date ? $letter->submission_date->toDateString() : now()->toDateString()) }}"
                        min="{{ now()->toDateString() }}"
                        max="{{ now()->toDateString() }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div class="md:col-span-2 xl:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">File Hasil</label>
                    <input
                        type="text"
                        name="result_file"
                        value="{{ old('result_file', $letter->result_file) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Otomatis setelah PDF dibuat"
                    >
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Deskripsi surat..."
                    >{{ old('description', $letter->description) }}</textarea>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                    <textarea
                        name="notes"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Catatan tambahan..."
                    >{{ old('notes', $letter->notes) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Data Tambahan Surat Dinamis --}}
        <div id="payloadSection" class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Data Tambahan Surat</h2>
                <p id="payloadDescription" class="text-sm text-slate-500 mt-1">
                    Lengkapi data khusus sesuai jenis surat yang dipilih.
                </p>
            </div>

            <div class="p-6">
                {{-- DOM --}}
                <div data-letter-fields="DOM" class="letter-fields hidden">
                    <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        Surat Domisili menggunakan data alamat dari data penduduk yang dipilih.
                    </div>
                </div>

                {{-- SKTM --}}
                <div data-letter-fields="SKTM" class="letter-fields hidden grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            No. KK <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="payload[family_card_number]"
                            value="{{ old('payload.family_card_number', $payload['family_card_number'] ?? '') }}"
                            required
                            data-required-label="No. KK"
                            maxlength="16"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Masukkan 16 digit Nomor KK"
                        >
                        @include('admin.partials.field-error', ['field' => 'payload.family_card_number'])
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Keperluan Surat
                        </label>
                        <input
                            type="text"
                            name="payload[purpose]"
                            value="{{ $payload['purpose'] ?? '' }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Permohonan bantuan pendidikan"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Keterangan Tambahan
                        </label>
                        <textarea
                            name="payload[additional_notes]"
                            rows="3"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Opsional"
                        >{{ $payload['additional_notes'] ?? '' }}</textarea>
                    </div>
                </div>

                {{-- YTM --}}
                <div data-letter-fields="YTM" class="letter-fields hidden space-y-8">
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Orang Tua</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Ayah</label>
                                <input
                                    type="text"
                                    name="payload[father_name]"
                                    value="{{ $payload['father_name'] ?? '' }}"
                                    maxlength="255"
                                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Ibu</label>
                                <input
                                    type="text"
                                    name="payload[mother_name]"
                                    value="{{ $payload['mother_name'] ?? '' }}"
                                    maxlength="255"
                                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Status Yatim</label>
                                <select
                                    name="payload[orphan_status]"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                                    <option value="">Pilih Status</option>
                                    <option value="Yatim" {{ ($payload['orphan_status'] ?? '') === 'Yatim' ? 'selected' : '' }}>Yatim</option>
                                    <option value="Piatu" {{ ($payload['orphan_status'] ?? '') === 'Piatu' ? 'selected' : '' }}>Piatu</option>
                                    <option value="Yatim Piatu" {{ ($payload['orphan_status'] ?? '') === 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Meninggal Orang Tua</label>
                                <input
                                    type="date"
                                    name="payload[parent_death_date]"
                                    value="{{ $payload['parent_death_date'] ?? '' }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tinggal Bersama / Nama Orang Tua Wali</label>
                                <input
                                    type="text"
                                    name="payload[guardian_name]"
                                    value="{{ old('payload.guardian_name', $payload['guardian_name'] ?? '') }}"
                                    maxlength="255"
                                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Nama ibu / wali"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Orang Tua / Wali</label>
                                <input
                                    type="text"
                                    name="payload[guardian_address]"
                                    value="{{ old('payload.guardian_address') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Dusun I Dolok Nagodang"
                                >
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
                                <textarea
                                    name="payload[orphan_notes]"
                                    rows="3"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >{{ $payload['orphan_notes'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SKOT --}}
                <div data-letter-fields="SKOT" class="letter-fields hidden space-y-8">

                    {{-- Data Ayah --}}
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Ayah</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Pilih Ayah <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    name="payload[father_citizen_id]"
                                    required
                                    data-required-label="Pilih Ayah"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                                    <option value="">Pilih Data Ayah</option>
                                    @foreach ($citizens as $citizen)
                                        <option
                                            value="{{ $citizen->id }}"
                                            {{ (string)($payload['father_citizen_id'] ?? '') === (string)$citizen->id ? 'selected' : '' }}
                                        >
                                            {{ $citizen->full_name }} - {{ $citizen->nik }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.field-error', ['field' => 'payload.father_citizen_id'])
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Penghasilan Ayah <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="payload[father_income]"
                                    value="{{ $payload['father_income'] ?? '' }}"
                                    required
                                    data-required-label="Penghasilan Ayah"
                                    inputmode="numeric"
                                    data-rupiah-income
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Rp 1.000.000"
                                >
                                @include('admin.partials.field-error', ['field' => 'payload.father_income'])
                            </div>
                        </div>
                    </div>

                    {{-- Data Ibu --}}
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Ibu</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Pilih Ibu <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    name="payload[mother_citizen_id]"
                                    required
                                    data-required-label="Pilih Ibu"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                                    <option value="">Pilih Data Ibu</option>
                                    @foreach ($citizens as $citizen)
                                        <option
                                            value="{{ $citizen->id }}"
                                            {{ (string)($payload['mother_citizen_id'] ?? '') === (string)$citizen->id ? 'selected' : '' }}
                                        >
                                            {{ $citizen->full_name }} - {{ $citizen->nik }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('admin.partials.field-error', ['field' => 'payload.mother_citizen_id'])
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Penghasilan Ibu <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="payload[mother_income]"
                                    value="{{ $payload['mother_income'] ?? '' }}"
                                    required
                                    data-required-label="Penghasilan Ibu"
                                    inputmode="numeric"
                                    data-rupiah-income
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Rp 500.000"
                                >
                                @include('admin.partials.field-error', ['field' => 'payload.mother_income'])
                            </div>
                        </div>
                    </div>

                    {{-- Data Anak / Pemohon --}}
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Anak / Pemohon</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Anak</label>
                                <input
                                    id="payload_child_name"
                                    type="text"
                                    name="payload[child_name]"
                                    value="{{ $payload['child_name'] ?? '' }}"
                                    readonly
                                    maxlength="255" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat/Tgl Lahir Anak</label>
                                <input
                                    id="payload_child_birth"
                                    type="text"
                                    name="payload[child_birth]"
                                    value="{{ $payload['child_birth'] ?? '' }}"
                                    readonly
                                    maxlength="255" oninput="this.value = this.value.replace(/[^A-Za-z0-9\s,.\-\/]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin Anak</label>
                                <input
                                    id="payload_child_gender"
                                    type="text"
                                    name="payload[child_gender]"
                                    value="{{ $payload['child_gender'] ?? '' }}"
                                    readonly
                                    maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan Anak</label>
                                <input
                                    id="payload_child_job"
                                    type="text"
                                    name="payload[child_job]"
                                    value="{{ $payload['child_job'] ?? '' }}"
                                    readonly
                                    maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Agama Anak</label>
                                <input
                                    id="payload_child_religion"
                                    type="text"
                                    name="payload[child_religion]"
                                    value="{{ $payload['child_religion'] ?? '' }}"
                                    readonly
                                    maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div class="md:col-span-2 xl:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Anak</label>
                                <input
                                    id="payload_child_address"
                                    type="text"
                                    name="payload[child_address]"
                                    value="{{ $payload['child_address'] ?? '' }}"
                                    readonly
                                    maxlength="255" oninput="this.value = this.value.replace(/[^A-Za-z0-9\s,.\-\/]/g, '')"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SKU --}}
                <div data-letter-fields="SKU" class="letter-fields hidden grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Usaha Pokok</label>
                        <input
                            type="text"
                            name="payload[business_name]"
                            value="{{ $payload['business_name'] ?? '' }}"
                            maxlength="255"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Warung Sembako"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Usaha Tambahan</label>
                        <input
                            type="text"
                            name="payload[business_type]"
                            value="{{ $payload['business_type'] ?? '' }}"
                            maxlength="255"
                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Perdagangan"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Usaha</label>
                        <input
                            type="text"
                            name="payload[business_address]"
                            value="{{ $payload['business_address'] ?? '' }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Dusun I Dolok Nagodang"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Keperluan Surat</label>
                        <input
                            type="text"
                            name="payload[business_purpose]"
                            value="{{ $payload['business_purpose'] ?? '' }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Persyaratan administrasi"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.letters.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>

            <button
                type="submit"
                class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const letterTypeSelect = document.getElementById('letter_type_id');
    const submissionDateInput = document.querySelector('input[name="submission_date"]');
    const letterNumberInput = document.getElementById('letter_number');
    const letterNumberPrefixInput = document.getElementById('letter_number_prefix');
    const letterNumberSuffixPreview = document.getElementById('letter_number_suffix_preview');

    function toRomanMonth(month) {
        const romans = {
            1: 'I',
            2: 'II',
            3: 'III',
            4: 'IV',
            5: 'V',
            6: 'VI',
            7: 'VII',
            8: 'VIII',
            9: 'IX',
            10: 'X',
            11: 'XI',
            12: 'XII',
        };

        return romans[month] || '-';
    }

    function buildLetterSuffix() {
        const selectedOption = letterTypeSelect
            ? letterTypeSelect.options[letterTypeSelect.selectedIndex]
            : null;
        const code = selectedOption ? (selectedOption.dataset.code || '').toUpperCase() : '';
        const submissionDate = submissionDateInput ? submissionDateInput.value : '';

        if (!code || !submissionDate) {
            return '';
        }

        const parts = submissionDate.split('-');

        if (parts.length !== 3) {
            return '';
        }

        const month = parseInt(parts[1], 10);
        const year = parts[0];

        return '/' + code + '/' + toRomanMonth(month) + '/' + year;
    }

    function syncLetterNumber() {
        if (!letterNumberInput || !letterNumberPrefixInput || !letterNumberSuffixPreview) {
            return;
        }

        const prefix = (letterNumberPrefixInput.value || '').replace(/\D/g, '');
        const suffix = buildLetterSuffix();

        letterNumberPrefixInput.value = prefix;
        letterNumberSuffixPreview.value = suffix;
        letterNumberInput.value = prefix && suffix ? prefix + suffix : '';
    }

    function formatRupiah(value) {
        const digits = (value || '').replace(/\D/g, '');

        if (!digits) {
            return '';
        }

        return 'Rp ' + digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    document.querySelectorAll('[data-rupiah-income]').forEach(function (input) {
        input.value = formatRupiah(input.value);

        input.addEventListener('input', function () {
            input.value = formatRupiah(input.value);
        });
    });

    if (letterTypeSelect) {
        letterTypeSelect.addEventListener('change', syncLetterNumber);
    }

    if (submissionDateInput) {
        submissionDateInput.addEventListener('change', syncLetterNumber);
    }

    if (letterNumberPrefixInput) {
        letterNumberPrefixInput.addEventListener('input', syncLetterNumber);
    }

    syncLetterNumber();

    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    document.addEventListener('submit', function (e) {

        const form = e.target;

        // ✅ Target khusus form update surat
        if (!form.action.includes('letters')) return;

        // ✅ Hindari loop submit
        if (form.dataset.confirmed === 'true') return;

        if (window.AdminInlineValidation && !window.AdminInlineValidation.validateForm(form)) {
            e.preventDefault();
            return;
        }

        e.preventDefault();

        // ambil subject sebagai identitas
        const subject = form.querySelector('input[name="subject"]')?.value || 'surat ini';

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: `Apakah Anda yakin ingin menyimpan perubahan untuk "${subject}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                form.dataset.confirmed = 'true';

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                if (form.requestSubmit) {
                    form.requestSubmit();
                } else {
                    form.submit();
                }
            }

        });

    });

});
</script>
@endpush
