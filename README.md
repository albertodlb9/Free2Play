# Free2Play

Este es un proyecto de desarrollo web que tiene como objetivo crear una plataforma donde los usuarios puedan calificar y opinar sobre videojuegos. Los usuarios podrán dejar reseñas, comentarios sobre las reseñas y ver las calificaciones generales de los videojuegos en la plataforma.

## Descripción

El proyecto consiste en una página web en la que los usuarios pueden:
- **Registrar una cuenta** con roles de usuario (administrador o normal).
- **Buscar videojuegos** y ver sus detalles, incluidas las reseñas y la calificación media.
- **Dejar reseñas** y **calificar videojuegos**.
- **Comentar** en las reseñas de otros usuarios.
- **Administrar** el contenido como administrador (CRUD de videojuegos, reseñas, comentarios, etc.).

El backend de la aplicación está desarrollado en **PHP puro**, mientras que el frontend está realizado con **JavaScript**

## Tecnologías Utilizadas

- **Backend**:
  - PHP (puro, sin frameworks)
  - MySQL para la base de datos
- **Frontend**:
  - JavaScript
- **Herramientas adicionales**:
  - Docker (para contenedores)
  - Composer (gestión de dependencias en PHP)

## Base de Datos

La base de datos está basada en **MySQL** y tiene las siguientes entidades principales:

1. **Usuarios**: Almacena la información de los usuarios, incluidos los roles (admin, normal).
2. **Videojuegos**: Contiene los detalles de los videojuegos, incluyendo su nombre, y la calificación media basada en las reseñas de los usuarios.
3. **Reviews**: Relacionadas con los videojuegos, cada reseña tiene una puntuación y un texto.
4. **Comentarios de Reviews**: Permite a los usuarios comentar sobre las reviews de otros usuarios.
5. **Plataformas**: Relacionadas con los videojuegos (por ejemplo, PlayStation, Xbox, PC).
6. **Desarrolladores**: Relacionados con los videojuegos.

Las relaciones entre las entidades son las siguientes:

- Un **usuario** puede tener muchas **reviews**.
- Un **usuario** puede tener muchos **comentarios**.
- Un **videojuego** puede tener muchas **reviews**.
- Una **reseña** puede tener muchos **comentarios**.
- Un **videojuego** puede tener una **plataforma**.
- Un **videojuego** puede tener un **desarrollador**.

## Funcionalidades Principales

1. **Registro y autenticación de usuarios**:
   - Los usuarios pueden registrarse y autenticarse para dejar reviews y comentarios.
   - Los administradores tienen acceso a funcionalidades adicionales de gestión de contenidos.
   
2. **CRUD de Videojuegos**:
   - Los administradores pueden agregar, editar y eliminar videojuegos en la plataforma.

3. **CRUD de Reseñas**:
   - Los usuarios pueden crear, editar y eliminar reseñas de videojuegos.

4. **Comentarios**:
   - Los usuarios pueden comentar en las reseñas de otros usuarios para discutir sobre los videojuegos.
