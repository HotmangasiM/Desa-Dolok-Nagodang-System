@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.letters.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Surat Elektronik
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Tambah Surat Elektronik</h1>
            <p class="text-sm text-slate-500 mt-2">
                Lengkapi form berikut untuk menambahkan data surat baru.
            </p>
        </div>
    </div> -->

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

        {{-- Informasi Surat --}}
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Informasi Surat</h2>
                <p class="text-sm text-slate-500 mt-1">Masukkan informasi utama surat elektronik.</p>
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

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Subjek <span class="text-rose-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="subject"
                        value="{{ old('subject') }}"
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
                        <option value="submitted" {{ old('status') === 'submitted' ? 'selected' : '' }}>submitted</option>
                        <option value="processed" {{ old('status') === 'processed' ? 'selected' : '' }}>processed</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>completed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Pengajuan</label>
                    <input
                        type="date"
                        name="submission_date"
                        value="{{ old('submission_date') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                </div>

                <div class="md:col-span-2 xl:col-span-1">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">File Hasil</label>
                    <input
                        type="text"
                        name="result_file"
                        value="{{ old('result_file') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Contoh: letters/surat-001.pdf"
                    >
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Deskripsi surat..."
                    >{{ old('description') }}</textarea>
                </div>

                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan</label>
                    <textarea
                        name="notes"
                        rows="4"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        placeholder="Catatan tambahan..."
                    >{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Data Tambahan Surat --}}
        <div id="payloadSection" class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Data Tambahan Surat</h2>
                <p id="payloadDescription" class="text-sm text-slate-500 mt-1">
                    Lengkapi data khusus untuk template surat.
                </p>
            </div>

            <div class="p-6 space-y-8">
                {{-- Data Ayah --}}
                <div>
                    <h3 class="text-base font-bold text-slate-800 mb-4">Data Ayah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
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
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat/Tgl Lahir Ayah</label>
                            <input
                                type="text"
                                name="payload[father_birth]"
                                value="{{ old('payload.father_birth') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Agama Ayah</label>
                            <input
                                type="text"
                                name="payload[father_religion]"
                                value="{{ old('payload.father_religion') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan Ayah</label>
                            <input
                                type="text"
                                name="payload[father_job]"
                                value="{{ old('payload.father_job') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Ayah</label>
                            <input
                                type="text"
                                name="payload[father_address]"
                                value="{{ old('payload.father_address') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Penghasilan Ayah</label>
                            <input
                                type="text"
                                name="payload[father_income]"
                                value="{{ old('payload.father_income') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>
                    </div>
                </div>

                {{-- Data Ibu --}}
                <div>
                    <h3 class="text-base font-bold text-slate-800 mb-4">Data Ibu</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
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
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat/Tgl Lahir Ibu</label>
                            <input
                                type="text"
                                name="payload[mother_birth]"
                                value="{{ old('payload.mother_birth') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin Ibu</label>
                            <input
                                type="text"
                                name="payload[mother_gender]"
                                value="{{ old('payload.mother_gender') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan Ibu</label>
                            <input
                                type="text"
                                name="payload[mother_job]"
                                value="{{ old('payload.mother_job') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Penghasilan Ibu</label>
                            <input
                                type="text"
                                name="payload[mother_income]"
                                value="{{ old('payload.mother_income') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>
                    </div>
                </div>

                {{-- Data Anak --}}
                <div>
                    <h3 class="text-base font-bold text-slate-800 mb-4">Data Anak</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Anak</label>
                            <input
                                id="payload_child_name"
                                type="text"
                                name="payload[child_name]"
                                value="{{ old('payload.child_name') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat/Tgl Lahir Anak</label>
                            <input
                                id="payload_child_birth"
                                type="text"
                                name="payload[child_birth]"
                                value="{{ old('payload.child_birth') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin Anak</label>
                            <input
                                id="payload_child_gender"
                                type="text"
                                name="payload[child_gender]"
                                value="{{ old('payload.child_gender') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan Anak</label>
                            <input
                                id="payload_child_job"
                                type="text"
                                name="payload[child_job]"
                                value="{{ old('payload.child_job') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Agama Anak</label>
                            <input
                                id="payload_child_religion"
                                type="text"
                                name="payload[child_religion]"
                                value="{{ old('payload.child_religion') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>

                        <div class="md:col-span-2 xl:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Anak</label>
                            <input
                                id="payload_child_address"
                                type="text"
                                name="payload[child_address]"
                                value="{{ old('payload.child_address') }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                            >
                        </div>
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
                Simpan Surat
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const letterTypeSelect = document.getElementById('letter_type_id');
        const payloadSection = document.getElementById('payloadSection');
        const payloadDescription = document.getElementById('payloadDescription');
        const citizenSelect = document.getElementById('citizen_id');

        const childNameInput = document.getElementById('payload_child_name');
        const childBirthInput = document.getElementById('payload_child_birth');
        const childGenderInput = document.getElementById('payload_child_gender');
        const childJobInput = document.getElementById('payload_child_job');
        const childReligionInput = document.getElementById('payload_child_religion');
        const childAddressInput = document.getElementById('payload_child_address');

        function formatGender(gender) {
            if (gender === 'L') return 'Laki-laki';
            if (gender === 'P') return 'Perempuan';
            return gender || '';
        }

        function formatBirth(place, date) {
            if (place && date) return `${place}, ${date}`;
            if (place) return place;
            if (date) return date;
            return '';
        }

        function formatAddress(address, village, district, regency, province) {
            const parts = [address, village, district, regency, province].filter(Boolean);
            return parts.join(', ');
        }

        function autoFillFromCitizen() {
            const selectedOption = citizenSelect.options[citizenSelect.selectedIndex];

            if (!selectedOption || !selectedOption.value) {
                return;
            }

            const fullName = selectedOption.dataset.fullName || '';
            const birthPlace = selectedOption.dataset.birthPlace || '';
            const birthDate = selectedOption.dataset.birthDate || '';
            const gender = selectedOption.dataset.gender || '';
            const religion = selectedOption.dataset.religion || '';
            const occupation = selectedOption.dataset.occupation || '';
            const address = selectedOption.dataset.address || '';
            const village = selectedOption.dataset.village || '';
            const district = selectedOption.dataset.district || '';
            const regency = selectedOption.dataset.regency || '';
            const province = selectedOption.dataset.province || '';

            if (childNameInput && !childNameInput.value.trim()) {
                childNameInput.value = fullName;
            }

            if (childBirthInput && !childBirthInput.value.trim()) {
                childBirthInput.value = formatBirth(birthPlace, birthDate);
            }

            if (childGenderInput && !childGenderInput.value.trim()) {
                childGenderInput.value = formatGender(gender);
            }

            if (childJobInput && !childJobInput.value.trim()) {
                childJobInput.value = occupation;
            }

            if (childReligionInput && !childReligionInput.value.trim()) {
                childReligionInput.value = religion;
            }

            if (childAddressInput && !childAddressInput.value.trim()) {
                childAddressInput.value = formatAddress(address, village, district, regency, province);
            }
        }

        function togglePayloadSection() {
            const selectedOption = letterTypeSelect.options[letterTypeSelect.selectedIndex];
            const code = selectedOption ? (selectedOption.dataset.code || '').toUpperCase() : '';

            const supportedCodes = ['SKPO', 'SKPOT', 'SKTM', 'SKD', 'SKU'];

            if (code && supportedCodes.includes(code)) {
                payloadSection.classList.remove('hidden');

                if (code === 'SKPO' || code === 'SKPOT') {
                    payloadDescription.textContent = 'Lengkapi data penghasilan orang tua untuk kebutuhan template surat.';
                } else if (code === 'SKTM') {
                    payloadDescription.textContent = 'Lengkapi data tambahan untuk surat keterangan tidak mampu.';
                } else if (code === 'SKD') {
                    payloadDescription.textContent = 'Lengkapi data tambahan untuk surat domisili jika diperlukan.';
                } else if (code === 'SKU') {
                    payloadDescription.textContent = 'Lengkapi data tambahan untuk surat keterangan usaha jika diperlukan.';
                } else {
                    payloadDescription.textContent = 'Lengkapi data khusus untuk template surat.';
                }
            } else {
                payloadSection.classList.add('hidden');
                payloadDescription.textContent = 'Lengkapi data khusus untuk template surat.';
            }
        }

        togglePayloadSection();
        autoFillFromCitizen();

        letterTypeSelect.addEventListener('change', togglePayloadSection);
        citizenSelect.addEventListener('change', autoFillFromCitizen);
    });
</script>
@endpush