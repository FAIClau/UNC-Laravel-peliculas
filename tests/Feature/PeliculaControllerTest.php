<?php

namespace Tests\Feature;

use App\Models\Pelicula;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PeliculaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Pelicula::create([
            'titulo' => 'Volver al futuro',
            'genero' => 'Ciencia ficcion',
            'anio' => 1985,
            'descripcion' => 'Marty McFly viaja accidentalmente al pasado.',
            'imagen' => null,
        ]);

        Pelicula::create([
            'titulo' => 'El gran pez',
            'genero' => 'Drama',
            'anio' => 2003,
            'descripcion' => 'Un hijo intenta conocer la verdadera historia de su padre.',
            'imagen' => null,
        ]);
    }

    public function test_catalogo_muestra_las_peliculas_guardadas(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertSee('Volver al futuro')
            ->assertSee('El gran pez');
    }

    public function test_filtro_muestra_solo_peliculas_de_ciencia_ficcion(): void
    {
        $response = $this->get(route('peliculas.ciencia-ficcion'));

        $response
            ->assertOk()
            ->assertSee('Volver al futuro')
            ->assertDontSee('El gran pez');
    }

    public function test_detalle_muestra_la_pelicula_solicitada(): void
    {
        $response = $this->get(route('peliculas.show', 1));

        $response
            ->assertOk()
            ->assertSee('Volver al futuro')
            ->assertSee('Marty McFly viaja accidentalmente al pasado.');
    }

    public function test_alta_valida_guarda_la_pelicula_y_redirecciona(): void
    {
        Storage::fake('public');

        $response = $this->post(route('peliculas.store'), [
            'titulo' => 'Interestelar',
            'genero' => 'Ciencia ficcion',
            'anio' => 2014,
            'descripcion' => 'Un viaje espacial para salvar a la humanidad.',
            'imagen' => UploadedFile::fake()->image('interestelar.jpg'),
        ]);

        $response->assertRedirect(route('peliculas.index'));

        $this->assertDatabaseHas('peliculas', [
            'titulo' => 'Interestelar',
            'genero' => 'Ciencia ficcion',
            'anio' => 2014,
            'descripcion' => 'Un viaje espacial para salvar a la humanidad.',
        ]);

        $pelicula = Pelicula::where('titulo', 'Interestelar')->firstOrFail();

        Storage::disk('public')->assertExists($pelicula->imagen);
    }
}
