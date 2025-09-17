<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcosistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        return $user && $user->can('Gestor de ecosistemas');
    }

    public function rules(): array
    {
        $ecosistemaId = $this->route('ecosistema')->id ?? null;

        return [
            'nombre' => 'required|string|max:255|unique:ecosistemas,nombre,'.$ecosistemaId,
            'descripcion' => 'nullable|string',
        ];
    }
}
