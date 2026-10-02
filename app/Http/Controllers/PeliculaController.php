<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PeliculaController extends Controller
{
    public function index(): View
    {
        return view('peliculas.index', [
            'peliculas' => Pelicula::orderBy('titulo')->get(),
            'titulo' => 'Catalogo de peliculas',
            'activeFilter' => 'todas',
            'modelo' => new Pelicula(),
        ]);
    }

    public function cienciaFiccion(): View
    {
        return view('peliculas.index', [
            'peliculas' => Pelicula::where('genero', 'Ciencia ficcion')
                ->orderBy('titulo')
                ->get(),
            'titulo' => 'Peliculas de ciencia ficcion',
            'activeFilter' => 'ciencia-ficcion',
            'modelo' => new Pelicula(),
        ]);
    }

    public function show(int $id): View
    {
        $pelicula=Pelicula::find($id);
        return view('peliculas.show', [
            'pelicula' =>  $pelicula ,
            'modelo' => new Pelicula(),
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

        Pelicula::create([
            'titulo' => $validated['titulo'],
            'genero' => $validated['genero'],
            'anio' => (int) $validated['anio'],
            'descripcion' => $validated['descripcion'],
            'imagen' => $request->file('imagen')->store('peliculas', 'public'),
        ]);

        return redirect()->route('peliculas.index');
    }
}
