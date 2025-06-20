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

{{--Si hay un error en el json aparece un mensaje con el error en la parte superior del contenido --}}

<div id="error" class="alert alert-danger" style = "display: none;">
    @if($error)
        {{$error}}
    @endif
</div>


<div id= "success" class="alert alert-success" style="display:none;">
    @if($success_msg)
        {{$success_msg}}
    @endif
</div>



{{--Formulario para introducir los datos de usuario --}}


<form id="loginForm" action="validate_login.php" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
    </div>

    <div class="mb-4">
        <label for="password" class="form-label">Contraseña</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
    </div>

    <div class="d-grid gap-1 mb-4">
        <button type="submit" class="btn btn-primary col-8 mx-auto">Iniciar Sesión</button>
        <a href="{{$url}}" class="btn btn-danger col-8 mx-auto"><i class="fa-brands fa-google me-2"></i>Login Google</a>
    </div>
</form>


<div class="card-footer text-center py-3 bg-white">
    <p class="mb-0">¿No tienes una cuenta? <a href="register.php" class="text-primary">Regístrate</a></p>
</div>
@endsection('contenido')

@section('ruta_js')
{{$ruta_js}}
@endsection('ruta_js')
