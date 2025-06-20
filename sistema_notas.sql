-- ===============================================
-- SISTEMA DE NOTAS - ESTRUCTURA DE BASE DE DATOS
-- ===============================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS `sistema_notas` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;

USE `sistema_notas`;

-- ===============================================
-- TABLA: usuarios
-- Almacena la información de los usuarios del sistema
-- ===============================================
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===============================================
-- TABLA: notas
-- Almacena las notas creadas por los usuarios
-- ===============================================
CREATE TABLE `notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `contenido` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `fecha_modificacion` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  
  -- Relación con tabla usuarios
  CONSTRAINT `notas_ibfk_1` 
    FOREIGN KEY (`id_usuario`) 
    REFERENCES `usuarios` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===============================================
-- TABLA: imagenes_notas
-- Almacena múltiples imágenes por nota (tabla intermedia)
-- ===============================================
CREATE TABLE `imagenes_notas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_nota` int(11) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `nombre_original` varchar(255) NOT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp(),
  
  PRIMARY KEY (`id`),
  KEY `id_nota` (`id_nota`),
  
  -- Relación con tabla notas
  CONSTRAINT `imagenes_notas_ibfk_1` 
    FOREIGN KEY (`id_nota`) 
    REFERENCES `notas` (`id`) 
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ===============================================
-- CONFIGURACIÓN DE AUTO_INCREMENT
-- ===============================================
ALTER TABLE `usuarios` AUTO_INCREMENT = 1;
ALTER TABLE `notas` AUTO_INCREMENT = 1;
ALTER TABLE `imagenes_notas` AUTO_INCREMENT = 1;

-- ===============================================
-- ÍNDICES ADICIONALES RECOMENDADOS
-- ===============================================

-- Índice para búsquedas por email de usuario
-- ALTER TABLE `usuarios` ADD INDEX `idx_email` (`email`);

-- Índice compuesto para búsquedas de notas por usuario y fecha
-- ALTER TABLE `notas` ADD INDEX `idx_usuario_fecha` (`id_usuario`, `fecha_creacion`);

-- Índice para búsquedas por título de nota
-- ALTER TABLE `notas` ADD INDEX `idx_titulo` (`titulo`);

-- ===============================================
-- COMENTARIOS SOBRE LA ESTRUCTURA
-- ===============================================

/*
RELACIONES:
- usuarios (1) -> notas (N): Un usuario puede tener múltiples notas
- notas (1) -> imagenes_notas (N): Una nota puede tener múltiples imágenes

CARACTERÍSTICAS:
- Eliminación en cascada: Al eliminar un usuario se eliminan sus notas
- Al eliminar una nota se eliminan sus imágenes asociadas
- Email único por usuario
- Timestamps automáticos para auditoría
- Soporte para caracteres UTF-8 (emojis, acentos, etc.)

CAMPOS DESTACADOS:
- password: Hash de la contraseña (probablemente bcrypt por el formato $2y$)
- imagen: Campo legacy en tabla notas (reemplazado por tabla imagenes_notas)
- fecha_modificacion: Se actualiza automáticamente al modificar un registro
*/