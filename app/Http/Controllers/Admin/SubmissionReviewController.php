<?php

namespace App\Http\Controllers\Admin;

use App\Models\MissionParticipant;
use App\Models\Submission;
use App\Models\User;
use App\Services\GamificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubmissionReviewController
{
    public function index()
    {
        $submissions = Submission::with('participant.user', 'participant.mission')
            ->where('status', 'pending')->oldest('submitted_at')->orderBy('id')->paginate(20);
        return view('admin.submissions.index', ['submissions' => $submissions, 'history' => false]);
    }

    public function history()
    {
        $submissions = Submission::with('participant.user', 'participant.mission')
            ->whereNotNull('reviewed_at')->latest('reviewed_at')->orderByDesc('id')->paginate(20);
        return view('admin.submissions.index', ['submissions' => $submissions, 'history' => true]);
    }

    public function show(Submission $submission)
    {
        $submission->load('photos', 'participant.user', 'participant.mission', 'reviewer');
        return view('admin.submissions.show', compact('submission'));
    }

    public function approve(Request $request, Submission $submission, GamificationService $rewards)
    {
        return $this->decide($request, $submission, $rewards, 'approved', null);
    }

    public function reject(Request $request, Submission $submission, GamificationService $rewards)
    {
        $data = $request->validate(['reason' => ['required', 'string', 'max:1500']]);
        return $this->decide($request, $submission, $rewards, 'rejected', $data['reason']);
    }

    private function decide(Request $request, Submission $submission, GamificationService $rewards, string $decision, ?string $reason)
    {
        $ownerId = $submission->participant->user_id;
        DB::transaction(function () use ($request, $submission, $rewards, $decision, $reason, $ownerId) {
            $user = User::lockForUpdate()->findOrFail($ownerId);
            $participant = MissionParticipant::lockForUpdate()->findOrFail($submission->participant_id);
            $entry = Submission::lockForUpdate()->findOrFail($submission->id);
            if ($entry->status !== 'pending' || $participant->status !== 'pending_review') {
                throw ValidationException::withMessages(['decision' => 'Pengiriman ini sudah ditinjau.']);
            }

            $entry->update([
                'status' => $decision, 'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(), 'rejection_reason' => $reason,
            ]);
            if ($decision === 'approved') {
                $participant->update(['status' => 'completed', 'completed_at' => now()]);
                $rewards->award($user, $participant);
            } else {
                $participant->update(['status' => 'rejected']);
            }
        }, 3);

        return to_route('admin.submissions.index')->with('notice', 'Keputusan verifikasi disimpan.');
    }
}
