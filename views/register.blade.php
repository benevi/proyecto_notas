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



@if($error_google_msg)
<div id="error"class="alert alert-danger" style = "display: block;">
    {{$error_google_msg}}
</div>
@else
<div id="error"class="alert alert-danger" style = "display: none;"></div> 
@endif



@if($success_google_msg)
<div id= "success" class="alert alert-success" style="display:block;">    
    {{$success_google_msg}}
</div>
@else
<div id= "success" class="alert alert-success" style="display:none;"></div>
@endif

{{--Formulario para introducir los datos de usuario --}}

<form id="registerForm" action = "validate_register.php" method ="POST">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-text">La contraseña debe tener al menos 6 caracteres.</div>
    </div>
                        

    <div class="mb-4">
        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-lock-open"></i></span>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
    </div>

    <div class="d-grid gap-1 mb-4">
        <button type="submit" class="btn btn-primary col-8 mx-auto">Registrarse</button>
        <a href="{{$url}}" class="btn btn-danger col-8 mx-auto "><i class="fa-brands fa-google me-2"></i>Registrar con Google</a>
    </div>
</form>


<div class="card-footer text-center py-3 bg-white">
    <p class="mb-0">¿Ya tienes una cuenta? <a href="login.php" class="text-primary">Iniciar Sesión</a></p>
</div>
@endsection('contenido')

@section('ruta_js')
{{$ruta_js}}
@endsection('ruta_js')
