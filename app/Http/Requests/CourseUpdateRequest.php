<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update', Course::findOrFail($this->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'hours' => 'required|numeric|integer|min:0',
            'price' => 'required|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'description' => 'required',
            'teacher_id' => 'required|exists:users,id'
        ];
    }
}
