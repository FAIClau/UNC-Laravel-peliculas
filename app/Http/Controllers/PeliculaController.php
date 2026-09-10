<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PeliculaController extends Controller
{
    public function __construct(private readonly Pelicula $modelo) {}

    public function index(): View
    {
        return view('peliculas.index', [
            'peliculas' => $this->modelo->obtenerTodas(),
            'titulo' => 'Catalogo de peliculas',
            'activeFilter' => 'todas',
            'modelo' => $this->modelo,
        ]);
    }

    public function cienciaFiccion(): View
    {
        return view('peliculas.index', [
            'peliculas' => $this->modelo->obtenerPorGenero('Ciencia ficcion'),
            'titulo' => 'Peliculas de ciencia ficcion',
            'activeFilter' => 'ciencia-ficcion',
            'modelo' => $this->modelo,
        ]);
    }

    public function show(int $id): View
    {
        return view('peliculas.show', [
            'pelicula' => $this->modelo->obtenerPorId($id),
            'modelo' => $this->modelo,
        ]);
    }

    public function create(): View
    {
        return view('peliculas.create', [
            'maxYear' => now()->year + 5,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:120'],
            'genero' => ['required', 'string', 'max:80'],
            'anio' => ['required', 'integer', 'min:1895', 'max:'.(now()->year + 5)],
            'descripcion' => ['required', 'string', 'max:1000'],
            'imagen' => [
                'required',
                'image',
                Rule::file()->types(['jpg', 'jpeg', 'png', 'webp'])->max('2mb'),
            ],
        ]);

        $this->modelo->agregar([
            'titulo' => $validated['titulo'],
            'genero' => $validated['genero'],
            'anio' => (int) $validated['anio'],
            'descripcion' => $validated['descripcion'],
        ], $request->file('imagen'));

        return redirect()->route('peliculas.index');
    }
}
