<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120', Rule::unique('missions')->ignore($this->route('mission')?->id)],
            'description' => ['required', 'string', 'max:3000'],
            'category' => ['required', Rule::in(config('gamification.categories'))],
            'required_level' => ['required', 'integer', 'between:1,5'],
            'xp_reward' => ['required', 'integer', 'between:1,10000'],
            'evidence_instructions' => ['required', 'string', 'max:1500'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
