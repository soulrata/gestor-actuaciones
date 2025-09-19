<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estado extends Model
{
    protected $fillable = [
        'nombre',
        'tipo',
        'ecosistema_id',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => 'string',
        ];
    }

    public function ecosistema(): BelongsTo
    {
        return $this->belongsTo(Ecosistema::class);
    }

    public static function getTipos(): array
    {
        return ['Inicio', 'En Proceso', 'Fin'];
    }

    public function scopeByEcosistema($query, $ecosistemaId)
    {
        return $query->where('ecosistema_id', $ecosistemaId);
    }

    public function scopeByTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}
