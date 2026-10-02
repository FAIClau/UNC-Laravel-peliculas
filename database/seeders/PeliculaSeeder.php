<?php

namespace Database\Seeders;

use App\Models\Pelicula;
use Illuminate\Database\Seeder;

class PeliculaSeeder extends Seeder
{
    /**
     * Carga peliculas usando el modelo Eloquent directamente.
     */
    public function run(): void
    {
        Pelicula::updateOrCreate(
            ['titulo' => 'El gran pez'],
            [
                'genero' => 'Drama',
                'anio' => 2003,
                'descripcion' => 'Un hijo intenta conocer la verdadera historia de su padre.',
                'imagen' => 'peliculas/fMgc3SM3zyjwVN7xQ07LKgQ05k8ENaQknn1UWSMq.jpg',
            ],
        );

        Pelicula::updateOrCreate(
            ['titulo' => 'Charlie y la fabrica de chocolate'],
            [
                'genero' => 'Musical',
                'anio' => 2005,
                'descripcion' => 'Charlie visita una fabrica fantastica dirigida por Willy Wonka.',
                'imagen' => 'peliculas/oLJ4s90FTgYPauO21xr99yKqz4Owd2m0YpDeuOvu.jpg',
            ],
        );

        Pelicula::updateOrCreate(
            ['titulo' => 'Volver al futuro'],
            [
                'genero' => 'Ciencia ficcion',
                'anio' => 1985,
                'descripcion' => 'Marty McFly viaja accidentalmente al pasado en un DeLorean.',
                'imagen' => null,
            ],
        );
    }
}
