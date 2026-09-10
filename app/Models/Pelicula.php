<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class Pelicula
{
    private string $archivo;

    public function __construct(
        ?string $archivo = null,
        private readonly string $disk = 'public',
    ) {
        $this->archivo = $archivo ?? storage_path('app/peliculas/peliculas.json');
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>
     */
    public function obtenerTodas(): array
    {
        return $this->obtenerDatos();
    }

    /**
     * @return array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}|null
     */
    public function obtenerPorId(int $id): ?array
    {
        foreach ($this->obtenerDatos() as $pelicula) {
            if ((int) $pelicula['id'] === $id) {
                return $pelicula;
            }
        }

        return null;
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>
     */
    public function obtenerPorGenero(string $genero): array
    {
        return array_values(array_filter(
            $this->obtenerDatos(),
            fn (array $pelicula): bool => $pelicula['genero'] === $genero,
        ));
    }

    /**
     * @param  array{titulo: string, genero: string, anio: int, descripcion: string}  $datos
     */
    public function agregar(array $datos, UploadedFile $imagen): void
    {
        $peliculas = $this->obtenerDatos();
        $ids = array_column($peliculas, 'id');

        $peliculas[] = [
            'id' => empty($ids) ? 1 : max($ids) + 1,
            'titulo' => $datos['titulo'],
            'genero' => $datos['genero'],
            'anio' => $datos['anio'],
            'descripcion' => $datos['descripcion'],
            'imagen' => $imagen->store('peliculas', $this->disk),
        ];

        $this->guardarDatos($peliculas);
    }

    public function urlImagen(?string $ruta): ?string
    {
        if ($ruta === null || $ruta === '') {
            return null;
        }

        return Storage::disk($this->disk)->url($ruta);
    }

    /**
     * @return array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>
     */
    private function obtenerDatos(): array
    {
        if (! file_exists($this->archivo)) {
            return [];
        }

        $contenido = file_get_contents($this->archivo);
        $datos = json_decode($contenido ?: '[]', true);

        return is_array($datos) ? $datos : [];
    }

    /**
     * @param  array<int, array{id: int, titulo: string, genero: string, anio: int, descripcion: string, imagen: ?string}>  $peliculas
     */
    private function guardarDatos(array $peliculas): void
    {
        $directorio = dirname($this->archivo);

        if (! is_dir($directorio) && ! mkdir($directorio, 0755, true)) {
            throw new RuntimeException('No se pudo crear el directorio de datos.');
        }

        file_put_contents(
            $this->archivo,
            json_encode($peliculas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX,
        );
    }
}
