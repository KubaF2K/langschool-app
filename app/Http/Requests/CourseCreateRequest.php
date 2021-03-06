<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('create', Course::class) &&
            (Auth::user()->role->name == 'admin' || Auth::user()->language_id == $this->input('language_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:courses|max:255',
            'hours' => 'required|numeric|integer|min:0|max:2147483647',
            'price' => 'required|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'description' => 'required|string|max:32767',
            'language_id' => 'required|exists:languages,id',
            'teacher_id' => [
                'required',
                Rule::exists('users', 'id')
                    ->where('role_id', Role::where('name', '=', 'teacher')->first()->id),
                Rule::exists('users', 'id')
                    ->where('language_id', $this->input('language_id'))
            ]
        ];
    }
}
