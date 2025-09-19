<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Secuencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'activa',
        'ecosistema_id',
    ];

    protected function casts(): array
    {
        return [
            'activa' => 'boolean',
        ];
    }

    public function ecosistema(): BelongsTo
    {
        return $this->belongsTo(Ecosistema::class);
    }

    // Relación con Pasos (futuro)
    // public function pasos(): HasMany
    // {
    //     return $this->hasMany(Paso::class)->orderBy('orden');
    // }

    public function scopeByEcosistema($query, $ecosistemaId)
    {
        return $query->where('ecosistema_id', $ecosistemaId);
    }

    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    public function scopeInactivas($query)
    {
        return $query->where('activa', false);
    }
}
