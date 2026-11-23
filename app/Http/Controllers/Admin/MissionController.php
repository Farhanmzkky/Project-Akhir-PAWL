<?php

namespace App\Http\Controllers\Admin;

use App\Models\Mission;
use App\Http\Requests\StoreMissionRequest;

class MissionController
{
    public function index()
    {
        return view('admin.missions.index', ['missions' => Mission::orderBy('required_level')->orderBy('id')->get()]);
    }

    public function create()
    {
        return view('admin.missions.form', ['mission' => new Mission(['is_active' => true])]);
    }

    public function store(StoreMissionRequest $request)
    {
        Mission::create($request->validated());
        return to_route('admin.missions.index')->with('notice', 'Misi baru disimpan.');
    }

    public function edit(Mission $mission)
    {
        return view('admin.missions.form', compact('mission'));
    }

    public function update(StoreMissionRequest $request, Mission $mission)
    {
        $mission->update($request->validated());
        return to_route('admin.missions.index')->with('notice', 'Perubahan misi disimpan.');
    }
}
