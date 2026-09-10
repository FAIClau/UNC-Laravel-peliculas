<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Peliculas' }}</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; padding: 0 20px; color: #222; }
        nav { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 25px; }
        a { color: #2457a6; }
        .boton { padding: 9px 14px; border: 1px solid #bbb; border-radius: 6px; text-decoration: none; background: #fff; }
        .boton.activo { border-color: #2457a6; background: #eef4ff; }
        .pelicula { border: 1px solid #ddd; border-radius: 8px; padding: 16px; margin: 15px 0; display: flex; gap: 20px; align-items: center; }
        .poster, .sin-imagen { width: 120px; height: 170px; border-radius: 6px; flex: 0 0 120px; }
        .poster { object-fit: cover; }
        .sin-imagen { background: #eee; display: flex; align-items: center; justify-content: center; color: #777; text-align: center; }
        .detalle-poster { max-width: 250px; max-height: 360px; object-fit: cover; border-radius: 8px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input, textarea { width: 100%; box-sizing: border-box; padding: 8px; margin-top: 5px; }
        textarea { min-height: 100px; }
        .errores { background: #fee; border: 1px solid #d88; padding: 12px 18px; border-radius: 6px; }
        button { margin-top: 20px; padding: 10px 18px; cursor: pointer; }
        small { display: block; margin-top: 6px; color: #555; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
