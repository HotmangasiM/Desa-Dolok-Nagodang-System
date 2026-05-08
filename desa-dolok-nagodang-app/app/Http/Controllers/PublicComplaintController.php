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

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'category' => ['required', 'string', 'in:' . implode(',', $categories)],
            'message' => ['required', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
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