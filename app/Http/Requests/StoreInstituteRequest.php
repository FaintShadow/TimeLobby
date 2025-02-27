<?php

namespace App\Http\Requests;

use App\Models\Institute;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreInstituteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        Debugbar::info('StoreInstituteRequest::authorize');
        return Auth::user()->can('create', Institute::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        Debugbar::info('StoreInstituteRequest::rules');
        return [
            'name' => ['required', 'string', 'unique:institutes,name', 'min:4', 'max:64'],
            'description' => ['nullable', 'string', 'min:24', 'max:255'],
            'established_at' => ['required', 'date', 'before_or_equal:today'],
        ];
    }
}
