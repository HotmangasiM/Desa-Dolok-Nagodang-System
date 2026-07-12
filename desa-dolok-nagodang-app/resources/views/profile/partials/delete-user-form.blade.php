<section>
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-700">
                <i data-lucide="triangle-alert" class="h-5 w-5"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    Hapus Akun
                </h2>
                <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                    Setelah akun dihapus, seluruh akses dan data terkait akun ini akan dihapus permanen. Pastikan tindakan ini benar-benar diperlukan.
                </p>
            </div>
        </div>

        <button
            type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex w-fit items-center justify-center gap-2 rounded-xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-rose-700">
            <i data-lucide="trash-2" class="h-4 w-4"></i>
            Hapus Akun
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-700">
                    <i data-lucide="triangle-alert" class="h-5 w-5"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">
                        Konfirmasi Hapus Akun
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Masukkan password untuk mengonfirmasi penghapusan akun secara permanen.
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Masukkan password"
                    class="mt-2 block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-rose-500 focus:outline-none focus:ring-2 focus:ring-rose-500"
                >

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-700">
                    Ya, Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</section>
