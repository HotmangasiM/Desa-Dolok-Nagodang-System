@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.letters.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Surat Elektronik
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Edit Surat Elektronik</h1>
            <p class="text-sm text-slate-500 mt-2">
                Perbarui informasi surat elektronik yang sudah tersimpan.
            </p>
        </div>
    </div>

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
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor Surat</label>
                    <input type="text"
                        value="{{ $letter->letter_number }}"
                        readonly
                        class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Surat</label>
                    <select id="letter_type_id" name="letter_type_id"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih</option>
                        @foreach ($letterTypes as $type)
                            <option value="{{ $type->id }}"
                                data-code="{{ strtoupper($type->code ?? '') }}"
                                {{ (string)old('letter_type_id', $letter->letter_type_id) === (string)$type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pemohon</label>
                    <select
                        id="citizen_id"
                        name="citizen_id"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih</option>
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
                                {{ (string) old('citizen_id', optional($letter->citizen)->id) === (string) $citizen->id ? 'selected' : '' }}
                            >
                                {{ $citizen->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Subjek</label>
                    <input type="text" name="subject"
                        value="{{ old('subject', $letter->subject) }}"
                        class="w-full rounded-xl border px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label>Status</label>
                    <select name="status"
                        class="w-full rounded-xl border px-4 py-3 text-sm">
                        <option value="submitted" {{ old('status',$letter->status)=='SUBMITTED'?'selected':'' }}>submitted</option>
                        <option value="processed" {{ old('status',$letter->status)=='PROCESSING'?'selected':'' }}>processed</option>
                        <option value="approved" {{ old('status',$letter->status)=='COMPLETED'?'selected':'' }}>approved</option>
                        <option value="rejected" {{ old('status',$letter->status)=='REJECTED'?'selected':'' }}>rejected</option>
                    </select>
                </div>

                <div>
                    <label>Tanggal Pengajuan</label>
                    <input type="date" name="submission_date"
                        value="{{ old('submission_date', optional($letter->submission_date)->format('Y-m-d')) }}"
                        class="w-full rounded-xl border px-4 py-3 text-sm">
                </div>

                <div>
                    <label>Tanggal Persetujuan</label>
                    <input type="date" name="approval_date"
                        value="{{ old('approval_date', optional($letter->approval_date)->format('Y-m-d')) }}"
                        class="w-full rounded-xl border px-4 py-3 text-sm">
                </div>

            </div>
        </div>

        {{-- PAYLOAD --}}
        <div id="payloadSection" class="rounded-2xl bg-white border shadow-sm overflow-hidden hidden">
            <div class="px-6 py-4 border-b">
                <h2 class="font-bold text-lg">Data Tambahan Surat</h2>
                <p id="payloadDescription" class="text-sm text-slate-500"></p>
            </div>

            <div class="p-6 space-y-8">

                {{-- AYAH --}}
                <div>
                    <h3 class="font-bold mb-3">Data Ayah</h3>
                    <input name="payload[father_name]" value="{{ old('payload.father_name', $letter->payload['father_name'] ?? '') }}" class="input">
                    <input name="payload[father_birth]" value="{{ old('payload.father_birth', $letter->payload['father_birth'] ?? '') }}" class="input">
                    <input name="payload[father_religion]" value="{{ old('payload.father_religion', $letter->payload['father_religion'] ?? '') }}" class="input">
                    <input name="payload[father_job]" value="{{ old('payload.father_job', $letter->payload['father_job'] ?? '') }}" class="input">
                    <input name="payload[father_address]" value="{{ old('payload.father_address', $letter->payload['father_address'] ?? '') }}" class="input">
                    <input name="payload[father_income]" value="{{ old('payload.father_income', $letter->payload['father_income'] ?? '') }}" class="input">
                </div>

                {{-- IBU --}}
                <div>
                    <h3 class="font-bold mb-3">Data Ibu</h3>
                    <input name="payload[mother_name]" value="{{ old('payload.mother_name', $letter->payload['mother_name'] ?? '') }}" class="input">
                    <input name="payload[mother_birth]" value="{{ old('payload.mother_birth', $letter->payload['mother_birth'] ?? '') }}" class="input">
                    <input name="payload[mother_gender]" value="{{ old('payload.mother_gender', $letter->payload['mother_gender'] ?? '') }}" class="input">
                    <input name="payload[mother_job]" value="{{ old('payload.mother_job', $letter->payload['mother_job'] ?? '') }}" class="input">
                    <input name="payload[mother_income]" value="{{ old('payload.mother_income', $letter->payload['mother_income'] ?? '') }}" class="input">
                </div>

                {{-- ANAK --}}
                <div>
                    <h3 class="font-bold mb-3">Data Anak</h3>
                    <input id="payload_child_name"name="payload[child_name]" value="{{ old('payload.child_name', $letter->payload['child_name'] ?? '') }}" class="input">
                    <input id="payload_child_birth"name="payload[child_birth]" value="{{ old('payload.child_birth', $letter->payload['child_birth'] ?? '') }}" class="input">
                    <input id="payload_child_gender"name="payload[child_gender]" value="{{ old('payload.child_gender', $letter->payload['child_gender'] ?? '') }}" class="input">
                    <input id="payload_child_job"name="payload[child_job]" value="{{ old('payload.child_job', $letter->payload['child_job'] ?? '') }}" class="input">
                    <input id="payload_child_religion"name="payload[child_religion]" value="{{ old('payload.child_religion', $letter->payload['child_religion'] ?? '') }}" class="input">
                    <input id="payload_child_address"name="payload[child_address]" value="{{ old('payload.child_address', $letter->payload['child_address'] ?? '') }}" class="input">
                </div>

            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.letters.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Update</button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('letter_type_id');
    const citizenSelect = document.getElementById('citizen_id');
    const payload = document.getElementById('payloadSection');
    const payloadDescription = document.getElementById('payloadDescription');

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

    function toggle() {
        const selectedOption = select.options[select.selectedIndex];
        const code = selectedOption ? (selectedOption.dataset.code || '').toUpperCase() : '';
        const allowed = ['SKPO', 'SKPOT', 'SKTM', 'SKD', 'SKU'];

        if (allowed.includes(code)) {
            payload.classList.remove('hidden');

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
            payload.classList.add('hidden');
            payloadDescription.textContent = 'Lengkapi data khusus untuk template surat.';
        }
    }

    toggle();
    autoFillFromCitizen();

    select.addEventListener('change', toggle);
    citizenSelect.addEventListener('change', autoFillFromCitizen);
});
</script>
@endpush