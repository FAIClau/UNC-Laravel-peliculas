<?php

namespace Tests\Feature;

use App\Models\Pelicula;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PeliculaControllerTest extends TestCase
{
    private string $dataFile;

    protected function setUp(): void
    {
        parent::setUp();

        $this->dataFile = storage_path('framework/testing/peliculas.json');

        if (! is_dir(dirname($this->dataFile))) {
            mkdir(dirname($this->dataFile), 0755, true);
        }

        file_put_contents($this->dataFile, json_encode([
            [
                'id' => 1,
                'titulo' => 'Volver al futuro',
                'genero' => 'Ciencia ficcion',
                'anio' => 1985,
                'descripcion' => 'Marty McFly viaja accidentalmente al pasado.',
                'imagen' => null,
            ],
            [
                'id' => 2,
                'titulo' => 'El gran pez',
                'genero' => 'Drama',
                'anio' => 2003,
                'descripcion' => 'Un hijo intenta conocer la verdadera historia de su padre.',
                'imagen' => null,
            ],
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->app->bind(Pelicula::class, fn (): Pelicula => new Pelicula($this->dataFile));
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

        $peliculas = json_decode(file_get_contents($this->dataFile), true);

        $this->assertSame('Interestelar', $peliculas[2]['titulo']);
        $this->assertSame('Ciencia ficcion', $peliculas[2]['genero']);
        $this->assertSame(2014, $peliculas[2]['anio']);
        $this->assertSame('Un viaje espacial para salvar a la humanidad.', $peliculas[2]['descripcion']);

        Storage::disk('public')->assertExists($peliculas[2]['imagen']);
    }
}
