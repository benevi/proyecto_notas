{{--Plantilla principal que van a heredar el resto de las vistas--}}
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- css para usar Bootstrap -->
    <link rel="stylesheet" href="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="../css/estilos.css">

    <title>@yield('titulo')</title>
</head>
<body>

<div class="container mt-4 col-md-6 col-lg-4 mx-auto">
    <div class="form-container">
         <div class="card">
            <div class="card-header text-center pt-4">
                <h3 class="text-center mb-2">@yield('encabezado')</h3>
            </div>

    @yield('contenido')
        </div>
    </div>
</div>
<script src= "@yield('ruta_js')"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
