<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // only users who can manage users may create
        return $this->user() && $this->user()->can('system.users.manage');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['nullable', 'string', 'min:8'],
            'ecosistema_id' => ['nullable', 'integer', 'exists:ecosistemas,id'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string'],
        ];
    }
}
