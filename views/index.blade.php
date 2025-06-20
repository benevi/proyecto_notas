{{--Herencia de la plantilla1 --}}
@extends('plantillas.plantilla1')

{{--Seccion de titulo--}}
@section('titulo')
{{$titulo}}
@endsection

{{--Seccion para el encabezado--}}
@section('encabezado')
{{$encabezado}}
@endsection

{{--Seccion para el contenido de la pagina --}}
@section('contenido')

<!-- Contenido principal -->
<div class="text-center">
    <h1 class="mb-4">¡Bienvenido al Sistema de Notas!</h1>
    
    <p class="lead mb-4">
        Organiza tus ideas y pensamientos de manera fácil y rápida.
    </p>
    
    <!-- Botones principales -->
    <div class="d-grid gap-2 col-6 mx-auto">
        <a href="public/login.php" class="btn btn-primary btn-lg">
            Iniciar Sesión
        </a>
        <a href="public/register.php" class="btn btn-outline-primary btn-lg">
            Crear Cuenta
        </a>
    </div>
    
    <p class="text-muted mt-4">
        ¿Ya tienes cuenta? Solo inicia sesión para ver tus notas.
    </p>
</div>

@endsection('contenido')

@section('ruta_js')
{{$ruta_js}}
@endsection('ruta_js')