<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEcosistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->can('Gestor de ecosistemas');
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:ecosistemas,nombre',
            'descripcion' => 'nullable|string',
        ];
    }
}
