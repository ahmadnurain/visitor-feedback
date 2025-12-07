<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FeedbackController extends Controller
{
    public function store(StoreFeedbackRequest $request)
    {
        // 1) Validate via FormRequest (utama)
        $data = $request->validated();

        // 2) Guard tambahan di controller (opsional/lebih ketat)
        //    - batasi jumlah file maks 5
        //    - validasi ulang setiap file (JPG/PNG/WEBP & size <= 2MB)
        //    - clamp rating 1..5
        $request->validate([
            'attachments'    => ['nullable', 'array', 'max:5'],
            'attachments.*'  => ['file', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2 MB/file
            'rating'         => ['nullable', 'integer', 'between:1,5'],
            'feedback_category_id' => ['required', 'exists:feedback_categories,id'],
            'destination_id' => ['required', 'exists:destinations,id'],
        ], [
            // ATTACHMENTS (ramah & jelas)
            'attachments.array'       => 'Attachments must be a list of files.',
            'attachments.max'         => 'You can upload up to 5 files.',
            'attachments.*.file'      => 'One of your files couldn’t be read. Please re-select it.',
            'attachments.*.mimes'     => 'Only images are allowed (JPG, JPEG, PNG, WEBP).',
            'attachments.*.max'       => 'Each file must be 2 MB or smaller.',

            // OTHERS (singkat & to-the-point)
            'rating.between'          => 'Rating must be between 1 and 5.',
            'feedback_category_id.required' => 'Please choose a feedback category.',
            'feedback_category_id.exists'   => 'Invalid category selected.',
            'destination_id.required' => 'Please select a destination.',
            'destination_id.exists'   => 'Selected destination was not found.',
        ]);

        // 3) Normalisasi / sanitasi ringan
        $data['title']   = trim(strip_tags($data['title']));
        $data['content'] = trim(strip_tags($data['content']));
        $data['rating']  = isset($data['rating'])
            ? max(1, min(5, (int) $data['rating']))
            : null;

        // 4) Upload files (aman + cleanup kalau gagal)
        $paths = [];
        $dir   = 'feedbacks/' . now()->format('Y/m');

        try {
            if ($request->hasFile('attachments')) {
                // whitelist tambahan anti-spoofing
                $allowedExt  = ['jpg', 'jpeg', 'png', 'webp'];
                $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];

                foreach ($request->file('attachments') as $file) {
                    if (!$file->isValid()) {
                        throw new \RuntimeException('One of your files is invalid. Please remove it and try again.');
                    }

                    // Validasi MIME sebidang (hindari spoofing konten)
                    $mime = $file->getMimeType();
                    if (!in_array($mime, $allowedMime, true)) {
                        throw new \RuntimeException('This file type isn’t allowed. Please upload JPG, PNG, or WEBP.');
                    }

                    // Cek ekstensi juga (defense in depth)
                    $ext = strtolower($file->getClientOriginalExtension());
                    if (!in_array($ext, $allowedExt, true)) {
                        throw new \RuntimeException('This file extension isn’t allowed. Please upload JPG, PNG, or WEBP.');
                    }

                    // Sanitasi nama file
                    $basename = Str::limit(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), 80, '');
                    $basename = Str::slug($basename) ?: 'file';
                    $filename = $basename . '-' . Str::random(8) . '.' . $ext;

                    $path = $file->storeAs($dir, $filename, 'public');
                    $paths[] = $path;
                }
            }

            // 5) Simpan ke DB (pakai transaksi)
            DB::transaction(function () use ($request, $data, $paths) {
                $payload = [
                    'destination_id' => $data['destination_id'],
                    'user_id'        => Auth::id(),
                    'feedback_category_id' => $data['feedback_category_id'],
                    'visitor_name'   => $data['visitor_name'] ?? null,
                    'channel'        => 'web',
                    'rating'         => $data['rating'] ?? null,
                    'title'          => $data['title'],
                    'content'        => $data['content'],
                    'attachments'    => array_map(fn($p) => Storage::url($p), $paths),
                    'status'         => 'new',
                    'contact_email'  => $data['contact_email'] ?? null,
                    'contact_phone'  => $data['contact_phone'] ?? null,
                    'submitted_ip'   => $request->ip(),
                    'submitted_at'   => now(),
                ];

                Feedback::create($payload);
            });
        } catch (\Throwable $e) {
            // Hapus file yang sudah terlanjur terupload jika ada error
            foreach ($paths as $p) {
                try {
                    Storage::disk('public')->delete($p);
                } catch (\Throwable $ignore) {
                }
            }

            return back()
                ->withErrors([
                    // Ramah & tidak teknis; kalau mau tampilkan detail pakai $e->getMessage()
                    'general' => 'We couldn’t submit your feedback. Please review the highlighted fields and try again.',
                ])
                ->withInput();
        }

        // 6) Flash untuk popup terima kasih
        return back()->with([
            'feedback_submitted' => true,
            'feedback_message'   => 'Umpan balik Anda telah kami terima.',
        ]);
    }
}
