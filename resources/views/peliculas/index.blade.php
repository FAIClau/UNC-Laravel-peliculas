@extends('layouts.peliculas', ['title' => $titulo])

@section('content')
    <h1>{{ $titulo }}</h1>

    <nav>
        <a class="boton {{ $activeFilter === 'todas' ? 'activo' : '' }}" href="{{ route('peliculas.index') }}">Todas</a>
        <a class="boton {{ $activeFilter === 'ciencia-ficcion' ? 'activo' : '' }}" href="{{ route('peliculas.ciencia-ficcion') }}">Ciencia ficcion</a>
        <a class="boton" href="{{ route('peliculas.create') }}">+ Agregar pelicula</a>
    </nav>

    @forelse ($peliculas as $pelicula)
        <article class="pelicula">
            @if ($url = $modelo->urlImagen($pelicula['imagen']))
                <img
                    class="poster"
                    src="{{ $url }}"
                    alt="Poster de {{ $pelicula['titulo'] }}"
                >
            @else
                <div class="sin-imagen">Sin imagen</div>
            @endif

            <div>
                <h2>{{ $pelicula['titulo'] }}</h2>
                <p>{{ $pelicula['genero'] }} - {{ (int) $pelicula['anio'] }}</p>
                <a href="{{ route('peliculas.show', $pelicula['id']) }}">Ver detalle</a>
            </div>
        </article>
    @empty
        <p>No hay peliculas para mostrar.</p>
    @endforelse
@endsection
