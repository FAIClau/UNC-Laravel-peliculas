@extends('layouts.peliculas', ['title' => $pelicula ? $pelicula['titulo'] : 'Pelicula no encontrada'])

@section('content')
    @if ($pelicula)
        @if ($url = $modelo->urlImagen($pelicula['imagen']))
            <img
                class="detalle-poster"
                src="{{ $url }}"
                alt="Poster de {{ $pelicula['titulo'] }}"
            >
        @endif

        <h1>{{ $pelicula['titulo'] }}</h1>
        <p><strong>Genero:</strong> {{ $pelicula['genero'] }}</p>
        <p><strong>Anio:</strong> {{ (int) $pelicula['anio'] }}</p>
        <p>{!! nl2br(e($pelicula['descripcion'])) !!}</p>
    @else
        <h1>Pelicula no encontrada</h1>
    @endif

    <p><a href="{{ route('peliculas.index') }}"><- Volver</a></p>
@endsection
