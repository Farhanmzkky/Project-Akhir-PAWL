<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mission;
use App\Models\PointTransaction;
use App\Models\Submission;
use App\Models\User;

class DashboardController
{
    public function index()
    {
        $counts = Submission::selectRaw('status, COUNT(*) AS total')->groupBy('status')->pluck('total', 'status');
        return view('admin.dashboard', [
            'userCount' => User::where('role', 'user')->count(),
            'activeMissions' => Mission::where('is_active', true)->count(),
            'counts' => $counts,
            'xp' => PointTransaction::sum('xp_amount'),
        ]);
    }
}
