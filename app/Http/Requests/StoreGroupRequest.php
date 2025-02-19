<?php

namespace App\Http\Requests;

use App\Models\Group;
use Date;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('create', Group::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
        $validationRules = [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:25',
            ],
            'academic_year' => [
                'required',
                'integer',
                'min:' . $this->academicYearValidator()['min'],
                'max:' . $this->academicYearValidator()['max'],
            ],
            'minCapacity' => [
                'nullable',
                'numeric',
                'min:1',
                'exclude_if:minCapacity,null',
                'max:' . ($request->maxCapacity ?: 30)
            ],
            'maxCapacity' => [
                'nullable',
                'numeric',
                'min:1',
                'exclude_if:maxCapacity,null',
                'gte:minCapacity',
            ],
            'year_id' => [
                'required',
                'exclude_if:groupType,subgroup',
                'integer',
                'exists:years,id',
            ],
            'groupType' => 'required'
        ];

        if ($request->groupType == 'subgroup') {
            $validationRules['main_group_id'] = [
                'required',
                'integer',
                'exists:groups,id',
            ];
        }

        return $validationRules;
    }

    public function messages()
    {
        return [
            'main_group_id.required' => 'Group is required.',
            'year_id.required' => 'Year is required.',
        ];
    }

    function academicYearValidator()
    {
        $currentYear = Date::now()->year;
        $minYear = $currentYear + (Date::now()->month > 8 ? 1 : 0);
        return [
            'min' =>  $minYear,
            'max' => $minYear + 1,
        ];
    }
}
