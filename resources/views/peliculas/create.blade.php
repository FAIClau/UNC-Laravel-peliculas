@extends('layouts.peliculas', ['title' => 'Nueva pelicula'])

@section('content')
    <h1>Nueva pelicula</h1>

    @if ($errors->any())
        <div class="errores">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('peliculas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="titulo">Titulo</label>
        <input id="titulo" name="titulo" value="{{ old('titulo') }}" required>

        <label for="genero">Genero</label>
        <input id="genero" name="genero" value="{{ old('genero') }}" required>

        <label for="anio">Anio</label>
        <input
            id="anio"
            type="number"
            name="anio"
            min="1895"
            max="{{ $maxYear }}"
            value="{{ old('anio') }}"
            required
        >

        <label for="descripcion">Descripcion</label>
        <textarea id="descripcion" name="descripcion" required>{{ old('descripcion') }}</textarea>

        <label for="imagen">Imagen</label>
        <input id="imagen" type="file" name="imagen" accept="image/jpeg,image/png,image/webp" required>
        <small>JPG, PNG o WEBP. Maximo 2 MB.</small>

        <button type="submit">Guardar pelicula</button>
    </form>

    <p><a href="{{ route('peliculas.index') }}"><- Cancelar</a></p>
@endsection
