# Sistema de Notas

Una aplicación web para gestionar notas personales con autenticación de usuarios y integración con Google Auth.

## Características

- ✅ Registro e inicio de sesión de usuarios
- ✅ Autenticación con Google OAuth
- ✅ Crear, editar y eliminar notas
- ✅ Interfaz responsive con Bootstrap
- ✅ Validación de formularios
- ✅ Gestión de sesiones
- ✅ Base de datos MySQL

## Tecnologías Utilizadas

- **Backend:** PHP 7.4+
- **Frontend:** HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS:** Bootstrap 5.3
- **Base de datos:** MySQL
- **Template Engine:** Blade (Laravel Blade Standalone)
- **Autenticación:** Google OAuth 2.0
- **Dependencias:** Composer

## Estructura del Proyecto

```
proyecto_notas/
├── public/           # Archivos públicos (dashboard.php, login.php, register.php)
├── src/             # Lógica del backend (Conexion.php, Helper.php, validaciones)
├── js/              # Archivos JavaScript
├── css/             # Estilos CSS
├── views/           # Plantillas Blade
├── cache/           # Cache de plantillas (no incluir en Git)
├── vendor/          # Dependencias de Composer (no incluir en Git)
├── include/         # Archivos de inclusión
└── composer.json    # Configuración de dependencias
```

## Instalación

### Prerrequisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Composer
- Servidor web (Apache/Nginx) o XAMPP/WAMP

### Pasos de instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/tu-usuario/proyecto-notas.git
   cd proyecto-notas
   ```

2. **Instalar dependencias**
   ```bash
   composer install
   ```

3. **Configurar la base de datos**
   - Crear una base de datos MySQL llamada `sistema_notas`
   - Importar el archivo `sistema_notas.sql`:
   ```bash
   mysql -u tu_usuario -p sistema_notas < sistema_notas.sql
   ```

4. **Configurar credenciales de base de datos**
   - Editar el archivo `src/Conexion.php`
   - Actualizar las credenciales de conexión:
   ```php
   $this->host = "localhost";
   $this->db = "sistema_notas";
   $this->user = "tu_usuario";
   $this->pass = "tu_contraseña";
   ```

5. **Configurar Google OAuth (opcional)**
   - Obtener credenciales en [Google Console](https://console.developers.google.com/)
   - Actualizar `Client ID` y `Client Secret` en los archivos de login y registro
   - Configurar URL de redirección: `http://localhost/tu-ruta/src/validate_login.php`

6. **Configurar servidor web**
   - Apuntar el document root a la carpeta `public/`
   - O usar el servidor integrado de PHP:
   ```bash
   php -S localhost:8000 -t public/
   ```

## Uso

1. Acceder a `http://localhost/proyecto-notas/public/login.php`
2. Registrarse como nuevo usuario o iniciar sesión
3. Crear, editar y gestionar notas desde el dashboard

## Estructura de la Base de Datos

### Tabla `usuarios`
- `id` (PK, AUTO_INCREMENT)
- `nombre` (VARCHAR 50)
- `email` (VARCHAR 100, UNIQUE)
- `password` (VARCHAR 255)
- `fecha_registro` (DATETIME)

### Tabla `notas`
- `id` (PK, AUTO_INCREMENT)
- `id_usuario` (FK)
- `titulo` (VARCHAR 100)
- `contenido` (TEXT)
- `fecha_creacion` (DATETIME)
- `fecha_modificacion` (DATETIME)

## Funcionalidades

### Autenticación
- Registro de usuarios con validación
- Inicio de sesión tradicional
- Integración con Google OAuth
- Gestión segura de sesiones

### Gestión de Notas
- Crear notas con título y contenido
- Editar notas existentes
- Eliminar notas con confirmación
- Visualización en formato de tarjetas

### Interfaz de Usuario
- Diseño responsive
- Mensajes de error y éxito
- Navegación intuitiva

## Contribuir

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## Seguridad

- Contraseñas hasheadas con `password_hash()`
- Validación de entrada en frontend y backend
- Protección contra SQL injection con prepared statements
- Gestión segura de sesiones
- Sanitización de datos de entrada

## Licencia

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## Autor

**Victor Franco** - [victor_franco@hotmail.es](mailto:victor_franco@hotmail.es)

## Problemas Conocidos

- [ ] Funcionalidad de imágenes en notas no implementada completamente
- [ ] Falta validación adicional en algunos formularios

## Próximas Funcionalidades

- [ ] Subida de imágenes en notas
- [ ] Búsqueda de notas
- [ ] Categorías de notas
- [ ] Exportación de notas
