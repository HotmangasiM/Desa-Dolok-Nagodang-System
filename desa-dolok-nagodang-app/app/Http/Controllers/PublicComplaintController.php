<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicComplaintController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $categories = [
            'Umum',
            'Sosial',
            'Keamanan',
            'Kesehatan',
            'Kebersihan',
            'Permintaan',
        ];

        $validated = $request->validateWithBag('complaint', [
            'name' => ['required', 'string', 'max:255', "regex:/^[A-Za-z\\s'.-]+$/"],
            'phone' => ['required', 'regex:/^\d{10,15}$/'],
            'category' => ['required', 'string', 'in:' . implode(',', $categories)],
            'message' => ['required', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'name.regex' => 'Nama hanya boleh berisi huruf, spasi, titik, apostrof, dan tanda hubung.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon harus terdiri dari 10 sampai 15 digit angka.',
            'category.required' => 'Kategori wajib dipilih.',
            'category.in' => 'Kategori pengaduan yang dipilih tidak valid.',
            'message.required' => 'Isi pengaduan wajib diisi.',
            'message.max' => 'Isi pengaduan maksimal 2000 karakter.',
            'attachment.mimes' => 'Lampiran hanya boleh berupa file JPG, JPEG, PNG, atau PDF.',
            'attachment.max' => 'Ukuran lampiran maksimal 2 MB.',
        ]);

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
        }

        Complaint::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'category' => $validated['category'],
            'message' => $validated['message'],
            'attachment' => $attachmentPath,
            'status' => 'SUBMITTED',
            'ip_address' => $request->ip(),
        ]);

        return back()->with('complaint_success', 'Pengaduan berhasil dikirim. Terima kasih atas laporan Anda.');
    }
}
