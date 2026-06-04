@extends('layouts.admin')

@section('content')
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

    <form action="{{ route('admin.letters.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Field sistem --}}
        <input type="hidden" id="subjectInput" name="subject" value="{{ old('subject', 'Surat Elektronik') }}">
        <input type="hidden" name="status" value="{{ old('status', 'submitted') }}">

        {{-- Informasi Surat --}}
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Surat</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pilih jenis surat dan pemohon. Data lain akan menyesuaikan template surat.
                </p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor Surat
                    </label>
                    <input
                        type="text"
                        value="Otomatis dibuat setelah data disimpan"
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
                                data-name="{{ $type->name }}"
                                {{ (string) old('letter_type_id') === (string) $type->id ? 'selected' : '' }}
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
                                {{ (string) old('citizen_id') === (string) $citizen->id ? 'selected' : '' }}
                            >
                                {{ $citizen->full_name }} - {{ $citizen->nik }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Tanggal Pengajuan
                    </label>
                    <input
                        type="date"
                        name="submission_date"
                        value="{{ old('submission_date') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                    <p class="mt-1 text-xs text-slate-400">
                        Jika dikosongkan, sistem dapat menggunakan tanggal hari ini.
                    </p>
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
                {{-- DOM / Surat Domisili --}}
                <!-- <div data-letter-fields="DOM" class="letter-fields hidden grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-700">
                        Surat Domisili menggunakan data alamat dari data penduduk yang dipilih. Jika alamat domisili berbeda, isi kolom alamat domisili di bawah.
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Keperluan Surat
                        </label>
                        <input
                            type="text"
                            name="payload[purpose]"
                            value="{{ old('payload.purpose') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Persyaratan administrasi"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Alamat Domisili
                        </label>
                        <input
                            id="payload_domicile_address"
                            type="text"
                            name="payload[domicile_address]"
                            value="{{ old('payload.domicile_address') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Otomatis dari alamat penduduk, bisa diubah jika diperlukan"
                        >
                    </div>
                </div> -->

                {{-- SKTM --}}
                <div data-letter-fields="SKTM" class="letter-fields hidden grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            No. KK <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="payload[family_card_number]"
                            value="{{ old('payload.family_card_number') }}"
                            maxlength="16"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Masukkan 16 digit Nomor KK"
                        >
                        <p class="mt-1 text-xs text-slate-400">
                            Nomor KK diisi manual karena belum tersedia di data penduduk.
                        </p>
                    </div>
                </div>

                {{-- YTM --}}
                <div data-letter-fields="YTM" class="letter-fields hidden space-y-8">
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Orang Tua / Wali</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Ayah</label>
                                <input
                                    type="text"
                                    name="payload[father_name]"
                                    value="{{ old('payload.father_name') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Ibu</label>
                                <input
                                    type="text"
                                    name="payload[mother_name]"
                                    value="{{ old('payload.mother_name') }}"
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
                                    <option value="Yatim" {{ old('payload.orphan_status') === 'Yatim' ? 'selected' : '' }}>Yatim</option>
                                    <option value="Piatu" {{ old('payload.orphan_status') === 'Piatu' ? 'selected' : '' }}>Piatu</option>
                                    <option value="Yatim Piatu" {{ old('payload.orphan_status') === 'Yatim Piatu' ? 'selected' : '' }}>Yatim Piatu</option>
                                </select>
                            </div>

                            <!-- <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Meninggal Orang Tua</label>
                                <input
                                    type="date"
                                    name="payload[parent_death_date]"
                                    value="{{ old('payload.parent_death_date') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >
                            </div> -->

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

                            <!-- <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Keterangan</label>
                                <textarea
                                    name="payload[orphan_notes]"
                                    rows="3"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                >{{ old('payload.orphan_notes') }}</textarea>
                            </div> -->
                        </div>
                    </div>
                </div>

                {{-- SKOT --}}
                <div data-letter-fields="SKOT" class="letter-fields hidden space-y-8">
                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Ayah</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Pilih Ayah <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    name="payload[father_citizen_id]"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500"
                                >
                                    <option value="">Pilih Data Ayah</option>
                                    @foreach ($citizens as $citizen)
                                        <option value="{{ $citizen->id }}" {{ (string) old('payload.father_citizen_id') === (string) $citizen->id ? 'selected' : '' }}>
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
                                    value="{{ old('payload.father_income') }}"
                                    inputmode="numeric"
                                    data-rupiah-income
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Rp 1.000.000"
                                >
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Ibu</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Pilih Ibu <span class="text-rose-500">*</span>
                                </label>
                                <select
                                    name="payload[mother_citizen_id]"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500"
                                >
                                    <option value="">Pilih Data Ibu</option>
                                    @foreach ($citizens as $citizen)
                                        <option value="{{ $citizen->id }}" {{ (string) old('payload.mother_citizen_id') === (string) $citizen->id ? 'selected' : '' }}>
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
                                    value="{{ old('payload.mother_income') }}"
                                    inputmode="numeric"
                                    data-rupiah-income
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500"
                                    placeholder="Contoh: Rp 500.000"
                                >
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-4">Data Anak / Pemohon</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Anak</label>
                                <input id="payload_child_name" type="text" name="payload[child_name]"
                                    value="{{ old('payload.child_name') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">TTL Anak</label>
                                <input id="payload_child_birth" type="text" name="payload[child_birth]"
                                    value="{{ old('payload.child_birth') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                                <input id="payload_child_gender" type="text" name="payload[child_gender]"
                                    value="{{ old('payload.child_gender') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan</label>
                                <input id="payload_child_job" type="text" name="payload[child_job]"
                                    value="{{ old('payload.child_job') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Agama</label>
                                <input id="payload_child_religion" type="text" name="payload[child_religion]"
                                    value="{{ old('payload.child_religion') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
                            </div>

                            <div class="md:col-span-2 xl:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                                <input id="payload_child_address" type="text" name="payload[child_address]"
                                    value="{{ old('payload.child_address') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm">
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
                            value="{{ old('payload.business_name') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Warung Sembako"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Usaha Tambahan</label>
                        <input
                            type="text"
                            name="payload[business_type]"
                            value="{{ old('payload.business_type') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Perdagangan"
                        >
                    </div>

                    <!-- <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Usaha</label>
                        <input
                            type="text"
                            name="payload[business_address]"
                            value="{{ old('payload.business_address') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Dusun I Dolok Nagodang"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Keperluan Surat</label>
                        <input
                            type="text"
                            name="payload[business_purpose]"
                            value="{{ old('payload.business_purpose') }}"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            placeholder="Contoh: Persyaratan administrasi"
                        >
                    </div> -->
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
                Simpan Surat
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const letterTypeSelect = document.getElementById('letter_type_id');
    const citizenSelect = document.getElementById('citizen_id');
    const payloadSection = document.getElementById('payloadSection');
    const payloadDescription = document.getElementById('payloadDescription');
    const fieldGroups = document.querySelectorAll('.letter-fields');
    const subjectInput = document.getElementById('subjectInput');

    const descriptionMap = {
        DOM: 'Lengkapi data tambahan untuk Surat Keterangan Domisili.',
        SKTM: 'Lengkapi keperluan atau keterangan untuk Surat Keterangan Tidak Mampu.',
        YTM: 'Lengkapi data pendukung untuk Surat Yatim.',
        SKOT: 'Lengkapi data orang tua dan data anak untuk Surat Keterangan Orang Tua.',
        SKU: 'Lengkapi data usaha untuk Surat Keterangan Usaha.'
    };

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

    function getSelectedLetterOption() {
        if (!letterTypeSelect) return null;
        return letterTypeSelect.options[letterTypeSelect.selectedIndex] || null;
    }

    function getSelectedLetterCode() {
        const selectedOption = getSelectedLetterOption();
        return selectedOption ? (selectedOption.dataset.code || '').toUpperCase() : '';
    }

    function getSelectedLetterName() {
        const selectedOption = getSelectedLetterOption();
        return selectedOption ? (selectedOption.dataset.name || selectedOption.textContent || '').trim() : '';
    }

    function setGroupInputsDisabled(group, disabled) {
        group.querySelectorAll('input, textarea, select').forEach(function (input) {
            input.disabled = disabled;
        });
    }

    function selectedCitizenData() {
        if (!citizenSelect) return null;

        const selectedOption = citizenSelect.options[citizenSelect.selectedIndex];

        if (!selectedOption || !selectedOption.value) {
            return null;
        }

        return {
            fullName: selectedOption.dataset.fullName || '',
            birthPlace: selectedOption.dataset.birthPlace || '',
            birthDate: selectedOption.dataset.birthDate || '',
            gender: selectedOption.dataset.gender || '',
            religion: selectedOption.dataset.religion || '',
            occupation: selectedOption.dataset.occupation || '',
            address: selectedOption.dataset.address || '',
            village: selectedOption.dataset.village || '',
            district: selectedOption.dataset.district || '',
            regency: selectedOption.dataset.regency || '',
            province: selectedOption.dataset.province || '',
        };
    }

    function formatGender(gender) {
        if (gender === 'L') return 'Laki-laki';
        if (gender === 'P') return 'Perempuan';
        return gender || '';
    }

    function formatBirth(data) {
        if (!data) return '';

        const place = data.birthPlace || '';
        const date = data.birthDate ? data.birthDate.substring(0, 10) : '';

        if (place && date) return place + ', ' + date;

        return place || date || '';
    }

    function formatAddress(data) {
        if (!data) return '';

        return [
            data.address,
            data.village,
            data.district,
            data.regency,
            data.province,
        ].filter(Boolean).join(', ');
    }

    function setValueIfEmpty(id, value) {
        const input = document.getElementById(id);

        if (input && !input.value.trim()) {
            input.value = value || '';
        }
    }

    function autofillChildPayload() {
        const data = selectedCitizenData();

        if (!data) return;

        setValueIfEmpty('payload_child_name', data.fullName);
        setValueIfEmpty('payload_child_birth', formatBirth(data));
        setValueIfEmpty('payload_child_gender', formatGender(data.gender));
        setValueIfEmpty('payload_child_job', data.occupation);
        setValueIfEmpty('payload_child_religion', data.religion);
        setValueIfEmpty('payload_child_address', formatAddress(data) || data.address);
    }

    function autofillDomisiliPayload() {
        const data = selectedCitizenData();

        if (!data) return;

        setValueIfEmpty('payload_domicile_address', formatAddress(data) || data.address);
    }

    function updateSubject() {
        const letterName = getSelectedLetterName();
        const data = selectedCitizenData();

        if (!subjectInput) return;

        if (letterName && data && data.fullName) {
            subjectInput.value = letterName + ' - ' + data.fullName;
        } else if (letterName) {
            subjectInput.value = letterName;
        } else {
            subjectInput.value = 'Surat Elektronik';
        }
    }

    function toggleLetterFields() {
        const selectedCode = getSelectedLetterCode();

        fieldGroups.forEach(function (group) {
            group.classList.add('hidden');
            setGroupInputsDisabled(group, true);
        });

        if (!selectedCode) {
            payloadSection.classList.add('hidden');
            if (payloadDescription) {
                payloadDescription.textContent = 'Lengkapi data khusus sesuai jenis surat yang dipilih.';
            }
            updateSubject();
            return;
        }

        const selectedGroup = document.querySelector('[data-letter-fields="' + selectedCode + '"]');

        if (!selectedGroup) {
            payloadSection.classList.add('hidden');
            updateSubject();
            return;
        }

        payloadSection.classList.remove('hidden');
        selectedGroup.classList.remove('hidden');
        setGroupInputsDisabled(selectedGroup, false);

        if (payloadDescription) {
            payloadDescription.textContent = descriptionMap[selectedCode] || 'Lengkapi data tambahan surat.';
        }

        updateSubject();

        if (selectedCode === 'DOM') {
            autofillDomisiliPayload();
        }

        if (selectedCode === 'SKOT') {
            autofillChildPayload();
        }
    }

    if (letterTypeSelect) {
        letterTypeSelect.addEventListener('change', function () {
            toggleLetterFields();
        });
    }

    if (citizenSelect) {
        citizenSelect.addEventListener('change', function () {
            updateSubject();

            if (getSelectedLetterCode() === 'DOM') {
                autofillDomisiliPayload();
            }

            if (getSelectedLetterCode() === 'SKOT') {
                autofillChildPayload();
            }
        });
    }

    toggleLetterFields();

    const form = document.querySelector('form[action*="letters"]');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        if (form.dataset.confirmed === 'true') {
            return;
        }

        if (typeof Swal === 'undefined') {
            return;
        }

        e.preventDefault();

        Swal.fire({
            title: 'Simpan Surat?',
            html: `
                <p class="text-sm text-slate-600">
                    Pastikan data surat sudah lengkap dan benar.
                </p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6b7280',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.dataset.confirmed = 'true';

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
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
