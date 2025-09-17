<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcosistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        return $user && $user->can('Gestor de ecosistemas');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:ecosistemas,nombre',
            'descripcion' => 'nullable|string',
        ];
    }
}
