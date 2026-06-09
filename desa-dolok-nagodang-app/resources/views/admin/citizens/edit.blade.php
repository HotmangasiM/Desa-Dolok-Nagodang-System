@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Back + Header -->
    <!-- <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
        <div>
            <a href="{{ route('admin.citizens.index') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 mb-3">
                ← Kembali ke Data Penduduk
            </a>

            <h1 class="text-3xl font-bold tracking-tight text-slate-800">Edit Penduduk</h1>
            <p class="text-sm text-slate-500 mt-2">
                Perbarui data penduduk yang sudah tersimpan di dalam sistem.
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

    <form action="{{ route('admin.citizens.update', $citizen->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Data Utama -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Data Utama</h2>
                <p class="text-sm text-slate-500 mt-1">Informasi identitas utama penduduk.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">NIK <span class="text-rose-500">*</span></label>
                    <input type="text" name="nik" value="{{ old('nik', $citizen->nik) }}"
                           inputmode="numeric" maxlength="16" pattern="[0-9]{16}"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Masukkan 16 digit NIK">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                    <input type="text" name="full_name" value="{{ old('full_name', $citizen->full_name) }}"
                           maxlength="255" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Jenis Kelamin</label>
                    <select
                        name="gender"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    >
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('gender', $citizen->gender) === 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="Perempuan" {{ old('gender', $citizen->gender) === 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Hidup <span class="text-rose-500">*</span></label>
                    <select name="life_status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Status</option>
                        <option value="alive" {{ old('life_status', $citizen->life_status) === 'alive' ? 'selected' : '' }}>Hidup</option>
                        <option value="deceased" {{ old('life_status', $citizen->life_status) === 'deceased' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. KK</label>
                    <input type="text" name="family_card_number" value="{{ old('family_card_number', $citizen->family_card_number) }}"
                           inputmode="numeric" maxlength="16" pattern="[0-9]{16}"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                           placeholder="Masukkan nomor kartu keluarga">
                </div>
            </div>
        </div>

        <!-- Data Personal -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Data Personal</h2>
                <p class="text-sm text-slate-500 mt-1">Informasi tambahan terkait biodata penduduk.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tempat Lahir</label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $citizen->birth_place) }}"
                           maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $citizen->birth_date) }}"
                           max="{{ now()->toDateString() }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Agama</label>
                        <select 
                            name="religion"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                            <option value="">Pilih Agama</option>
                            @foreach ([
                                'Islam',
                                'Kristen',
                                'Katolik',
                                'Hindu',
                                'Buddha',
                                'Konghucu'
                            ] as $religion)
                                <option value="{{ $religion }}" 
                                    {{ old('religion', $citizen->religion ?? '') == $religion ? 'selected' : '' }}>
                                    {{ $religion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pendidikan</label>
                    <input type="text" name="education" value="{{ old('education', $citizen->education) }}"
                           maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Pekerjaan</label>
                    <input type="text" name="occupation" value="{{ old('occupation', $citizen->occupation) }}"
                           maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status Perkawinan</label>
                        <select 
                            name="marital_status"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >
                            <option value="">Pilih Status</option>

                            @php
                                $statuses = [
                                    'belum_kawin' => 'Belum Kawin',
                                    'kawin' => 'Kawin',
                                    'cerai_hidup' => 'Cerai Hidup',
                                    'cerai_mati' => 'Cerai Mati',
                                ];
                                $current = old('marital_status', $citizen->marital_status ?? '');
                            @endphp

                            {{-- fallback kalau data lama tidak sesuai --}}
                            @if($current && !array_key_exists($current, $statuses))
                                <option value="{{ $current }}" selected hidden>{{ $current }}</option>
                            @endif

                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" {{ $current == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Kontak & Alamat -->
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Kontak & Alamat</h2>
                <p class="text-sm text-slate-500 mt-1">Informasi alamat dan kontak penduduk.</p>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div class="xl:col-span-3">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                    <select name="address"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <option value="">Pilih Dusun</option>
                        @foreach ([
                            'Dusun I Dolok Nagodang',
                            'Dusun II Lumban Lintong',
                            'Dusun III Sosor Silobu',
                        ] as $addressOption)
                            <option value="{{ $addressOption }}" {{ old('address', $citizen->address) === $addressOption ? 'selected' : '' }}>
                                {{ $addressOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">RT</label>
                    <input type="text" name="rt" value="{{ old('rt', $citizen->rt) }}"
                           inputmode="numeric" maxlength="3"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">RW</label>
                    <input type="text" name="rw" value="{{ old('rw', $citizen->rw) }}"
                           inputmode="numeric" maxlength="3"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 3)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Desa</label>
                    <input type="text" name="village" value="{{ old('village', $citizen->village) }}"
                           maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kecamatan</label>
                    <input type="text" name="district" value="{{ old('district', $citizen->district) }}"
                           maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kabupaten</label>
                    <input type="text" name="regency" value="{{ old('regency', $citizen->regency) }}"
                           maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province', $citizen->province) }}"
                           maxlength="100" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Pos</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $citizen->postal_code) }}"
                           inputmode="numeric" maxlength="5" pattern="[0-9]{5}"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 5)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
                    <input type="text" name="phone" value="{{ old('phone', $citizen->phone) }}"
                           inputmode="numeric" maxlength="20"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 20)"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="md:col-span-2 xl:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $citizen->email) }}"
                           maxlength="255" pattern="[^@\s]+@[^@\s]+"
                           title="Email harus mengandung tanda @, contoh: nama@example.com"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
            <a href="{{ route('admin.citizens.index') }}"
               class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                Batal
            </a>

            <button type="button"
                class="btn-submit w-full sm:w-auto inline-flex items-center justify-center rounded-xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition">
             Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ✅ Pastikan SweetAlert aktif
    if (typeof Swal === 'undefined') {
        console.error('SweetAlert tidak ter-load!');
        return;
    }

    // ✅ TOAST SUCCESS (setelah redirect dari controller)
    @if(session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true
        });
    @endif


    // ✅ SUBMIT EDIT (CONFIRMATION)
    document.addEventListener('click', function (e) {

        const button = e.target.closest('.btn-submit');
        if (!button) return;

        e.preventDefault();

        const form = button.closest('form');

        if (!form) {
            console.error('Form tidak ditemukan!');
            return;
        }

        if (!form.reportValidity()) {
            return;
        }

        Swal.fire({
            title: 'Simpan Perubahan?',
            html: `
                <p class="text-sm text-slate-600">
                    Pastikan data yang kamu ubah sudah benar.
                </p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10b981', // emerald sesuai desain
            cancelButtonColor: '#6b7280',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {

            if (result.isConfirmed) {

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

                form.dataset.confirmed = 'true';

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
