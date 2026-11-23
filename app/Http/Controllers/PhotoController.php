<?php

namespace App\Http\Controllers;

use App\Models\SubmissionPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController
{
    public function show(Request $request, SubmissionPhoto $photo)
    {
        $user = $request->user();
        abort_unless($user->role === 'admin' || $photo->submission->participant->user_id === $user->id, 403);
        return Storage::disk('local')->response($photo->file_path, null, [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
