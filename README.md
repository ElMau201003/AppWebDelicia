# 🍽️ AppWebDelicia

Aplicación web desarrollada con **Laravel** para gestionar recetas, menús o productos de un sistema gastronómico. Este proyecto sirve como base para prácticas, desarrollo de funcionalidades CRUD, y despliegue web con PHP y Laravel.

## 🚀 Tecnologías usadas

- ⚙️ [Laravel](https://laravel.com/) 12.x
- 💾 MySQL (vía phpMyAdmin)
- 🌐 HTML/CSS/Blade
- 🔁 Composer
- 🧪 PHPUnit (testing opcional)

## 📦 Requisitos previos

Antes de clonar este proyecto, asegúrate de tener instalado:

- PHP >= 8.1
- Composer
- MySQL o MariaDB
- Git
- Laravel CLI (opcional)
- XAMPP / Laragon / Valet (opcional, para entorno local)

## 🛠️ Instalación del proyecto

```bash
# Clonar el repositorio
git clone https://github.com/ElMau201003/AppWebDelicia.git
```
cd AppWebDelicia

# Instalar dependencias de PHP
composer install

# Crear archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar conexión a base de datos en .env
# (ajusta DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# Ejecutar migraciones (si las hay)
php artisan migrate

# Levantar servidor local
php artisan serve
