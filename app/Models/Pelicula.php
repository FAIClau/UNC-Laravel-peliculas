<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pelicula extends Model
{
    protected $fillable = [
        'titulo',
        'genero',
        'anio',
        'descripcion',
        'imagen',
    ];

    protected function casts(): array
    {
        return [
            'anio' => 'integer',
        ];
    }

    public function urlImagen(?string $ruta): ?string
    {
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::disk('public')->url($ruta);
    }
}
