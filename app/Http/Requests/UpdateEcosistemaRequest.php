<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEcosistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('Gestor de ecosistemas');
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
