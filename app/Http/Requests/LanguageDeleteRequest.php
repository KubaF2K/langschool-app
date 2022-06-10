<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LanguageDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->can('delete', Language::findOrFail($this->input('id')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => [
                'required',
                'exists:languages,id',
                Rule::prohibitedIf(Language::findOrFail($this->input('id'))->courses->count() != 0)
            ]
        ];
    }
}
