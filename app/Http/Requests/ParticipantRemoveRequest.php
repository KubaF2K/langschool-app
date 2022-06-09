<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ParticipantRemoveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::id() == $this->input('user_id') ||
            Auth::id() == Course::findOrFail($this->input('course_id'))->teacher_id ||
            Auth::user()->role->name == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('course_participant', 'user_id')->where('course_id', $this->input('course_id'))
            ],
            'course_id' => [
                'required',
                Rule::exists('course_participant', 'course_id')->where('user_id', $this->input('user_id'))
            ]
        ];
    }
}
