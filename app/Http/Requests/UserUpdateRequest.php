<?php

namespace App\Http\Requests;

use App\Models\Role;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role->name == 'admin' ||
            Auth::id() == $this->input('id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => [
                'email',
                Rule::unique('users', 'email')->ignore($this->input('id')),
                'max:255'
            ],
            'role_id' => [
                Rule::prohibitedIf(Auth::user()->role->name != 'admin')
            ]
        ];
    }
}
