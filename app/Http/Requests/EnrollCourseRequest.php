<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EnrollCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role->name == 'admin' || Auth::id() == $this->input('user_id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('course_user', 'course_id')->where('user_id', $this->input('user_id')),
                Rule::unique('course_participant', 'course_id')->where('user_id', $this->input('user_id'))
            ]
        ];
    }
}
