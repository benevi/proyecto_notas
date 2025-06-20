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
<div id="error" class="alert alert-danger" style = "display: none;"></div>
<div id= "success" class="alert alert-success" style="display:none;"></div>
 <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Sistema de Notas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fa fa-person me-2"></i>{{$usuario}}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="../src/logout.php"><i class="fa fa-right-from-bracket me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container py-4">
    <!-- Cabecera con botón de nueva nota -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa fa-book me-2"></i>Mis Notas</h2>
        <button id="addNoteBtn" class="btn btn-primary">
            <i class="fa fa-plus me-2"></i>Nueva Nota
        </button>
    </div>

    <!-- Formulario para agregar/editar notas (oculto por defecto) -->
    <div id="noteFormContainer" class="card mb-4 shadow-sm" style="display: none;">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0" id="formTitle">Nueva Nota</h5>
        </div>
        <div class="card-body">
            <form id="noteForm">
                <input type="hidden" id="noteId" name="noteId">
                
                <div class="mb-3">
                    <label for="noteTitle" class="form-label">Título</label>
                    <input type="text" class="form-control" id="noteTitle" name="noteTitle" required>
                </div>
                
                <div class="mb-3">
                    <label for="noteContent" class="form-label">Contenido</label>
                    <textarea class="form-control" id="noteContent" name="noteContent" rows="4"></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="noteImage" class="form-label">Imagen (opcional)</label>
                    <div class="file-drop-area">
                        <span class="file-msg">Arrastra una imagen aquí o haz clic para seleccionar</span>
                        <input type="file" class="form-control" id="noteImage" name="noteImage" accept="image/*" style="display: none;">
                        <button type="button" class="btn btn-outline-primary mt-2" id="browseBtn">
                            <i class="bi bi-image me-2"></i>Seleccionar imagen
                        </button>
                    </div>
                    <div class="image-preview-container mt-3" style="display:none;">
                        <img id="imagePreview" src="" alt="Vista previa" class="image-preview mb-2">
                        <button type="button" id="removeImageBtn" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>Eliminar imagen
                        </button>
                    </div>
                </div>
                
                <div id="currentImage" class="mb-3" style="display: none;">
                    <label class="form-label">Imagen actual</label>
                    <div class="card">
                        <div class="card-body text-center">
                            <img id="currentImagePreview" src="" alt="Imagen actual" class="image-preview mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="deleteImage" name="deleteImage">
                                <label class="form-check-label" for="deleteImage">
                                    Eliminar imagen actual
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" id="cancelNoteBtn" class="btn btn-outline-secondary">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Contenedor para mostrar las notas -->
    <div id="notesContainer" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <!-- Las notas se cargarán aquí dinámicamente -->
        <div class="col-12 no-notes">
            <div class="text-center text-muted">
                <i class="bi bi-journal-x display-4"></i>
                <p class="mt-3">No tienes notas. ¡Crea una nueva!</p>
            </div>
        </div>
    </div>
</div>

<!-- Plantilla para cada nota (se usará con JavaScript) -->
<template id="noteTemplate">
    <div class="col">
        <div class="card note-card h-100 shadow-sm position-relative">
            <div class="note-actions">
                <button class="btn btn-sm btn-outline-primary btn-edit me-1" onclick="showHideNoteMode(this.getAttribute('data-note-id'))">
                    <i class="fa fa-pencil"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger btn-delete">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            <div class="note-image-container">
                <!-- La imagen se insertará aquí si existe -->
            </div>
            <div class="card-body container-display-mode">
                <h5 class="card-title note-title"></h5>
                <p class="card-text note-content"></p>
            </div>
            <div class="card-body container-edit-mode" style="display:none">
                <form>
                    <div class="row">
                        <input type="text" class="txtNoteTitle form-control">
                    </div>
                    <div class="row">
                        <textarea class="txtNoteDescr form-control"></textarea>
                    </div>
                    <button type="button" class="btn btn-sm btn-success btn-save-note">Guardar</button>
                </form>
            </div>
            <div class="card-footer text-muted small bg-white">
                <i class="fa fa-clock me-1"></i><span class="note-date"></span>
            </div>
            
        </div>
    </div>
</template>

@endsection('contenido')

@section('ruta_js')
{{$ruta_js}}
@endsection('ruta_js')
