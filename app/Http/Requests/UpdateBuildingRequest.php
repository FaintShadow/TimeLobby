<?php

namespace App\Http\Requests;

use App\Models\Building;
use App\Models\Institute;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateBuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Request $request): bool
    {
        return Auth::user()->can('update', $request->route('building'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:24',
                Rule::unique('buildings')->where(function ($query) {
                    return $query->where('institute_id', Auth::user()->institute_id);
                })->ignore($this->route('building')),
            ],
        ];
    }
}
