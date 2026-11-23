<?php

namespace App\Http\Controllers\User;

use App\Models\Mission;
use App\Services\MissionService;
use Illuminate\Http\Request;

class MissionParticipationController
{
    public function store(Request $request, Mission $mission, MissionService $service)
    {
        $service->join($request->user(), $mission);
        return to_route('user.my-missions')->with('notice', 'Misi tersimpan di Misi Saya.');
    }
}
