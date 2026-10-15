<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Problema temporal</title>
    <style>
        body{font-family:system-ui,sans-serif;background:#f3f4f6;display:flex;min-height:100vh;align-items:center;justify-content:center;margin:0}
        .caja{background:#fff;border-radius:8px;padding:2rem;max-width:28rem;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.1)}
        a{display:inline-block;margin-top:1rem;background:#1f2937;color:#fff;padding:.6rem 1.2rem;border-radius:6px;text-decoration:none}
    </style>
</head>
<body>
    <div class="caja">
        <h1>Tenemos un problema con los datos</h1>
        <p>No pudimos conectarnos con la base de datos en este momento. Por favor, inténtalo de nuevo en unos minutos. Si el problema continúa, avisa al encargado del laboratorio.</p>
        <a href="{{ url('/') }}">Volver al inicio</a>
    </div>
</body>
</html>
