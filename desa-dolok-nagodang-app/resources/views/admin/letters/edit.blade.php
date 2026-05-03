@extends('layouts.admin')

@section('content')
@php
    $payload = old('payload', $letter->payload ?? []);

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

    <form action="{{ route('admin.letters.update', $letter->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Informasi Surat --}}
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Surat</h2>
                <p class="text-sm text-slate-500 mt-1">Perbarui informasi utama surat elektronik.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor Surat
                    </label>
                    <input
                        type="text"
                        name="letter_number"
                        value="{{ old('letter_number', $letter->letter_number) }}"
                        readonly
                        class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Jenis Surat <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="letter_type_id"
                        name="letter_type_id"
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
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Pemohon <span class="text-rose-500">*</span>
                    </label>
                    <select
                        id="citizen_id"
                        name="citizen_id"
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
                </div>

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Subjek <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="subject"
                        value="{{ old('subject', $letter->subject) }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Masukkan subjek surat"
                    >
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Status <span class="text-rose-500">*</span>
                    </label>
                    <select
                        name="status"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Status</option>
                        <option value="submitted" {{ $statusFormValue === 'submitted' ? 'selected' : '' }}>submitted</option>
                        <option value="processed" {{ $statusFormValue === 'processed' ? 'selected' : '' }}>processed</option>
                        <option value="completed" {{ $statusFormValue === 'completed' ? 'selected' : '' }}>completed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pengajuan</label>
                    <input
                        type="date"
                        name="submission_date"
                        value="{{ old('submission_date', $letter->submission_date ? $letter->submission_date->format('Y-m-d') : '') }}"
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
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Ibu</label>
                                <input
                                    type="text"
                                    name="payload[mother_name]"
                                    value="{{ $payload['mother_name'] ?? '' }}"
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
                                    value="{{ old('payload.guardian_name') }}"
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
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Penghasilan Ayah <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="payload[father_income]"
                                    value="{{ $payload['father_income'] ?? '' }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Rp. 1.000.000/Bulan"
                                >
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
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Penghasilan Ibu <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="payload[mother_income]"
                                    value="{{ $payload['mother_income'] ?? '' }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Rp. 500.000/Bulan"
                                >
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
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SKU --}}
                <div data-letter-fields="SKU" class="letter-fields hidden grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Usaha</label>
                        <input
                            type="text"
                            name="payload[business_name]"
                            value="{{ $payload['business_name'] ?? '' }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Warung Sembako"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Usaha</label>
                        <input
                            type="text"
                            name="payload[business_type]"
                            value="{{ $payload['business_type'] ?? '' }}"
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

                form.submit();
            }

        });

    });

});
</script>
@endpush