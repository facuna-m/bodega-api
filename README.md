# 📦 Guía de Instalación y Configuración

Sigue estos pasos para levantar el proyecto localmente después de clonarlo desde GitHub.

## Requisitos Previos

Asegúrate de tener instalado en tu computador:
* [PHP](https://www.php.net/) (versión 8.1 o superior)
* [Composer](https://getcomposer.org/)
* [Node.js & NPM](https://nodejs.org/)
* [PostgreSQL](https://www.postgresql.org/)

---

## 🚀 Pasos de Instalación

### 1. Clonar el repositorio
Si aún no lo has hecho, descarga el proyecto desde GitHub:

```bash
git clone <URL_DEL_REPOSITORIO>
cd <NOMBRE_DE_LA_CARPETA>
```

### 2. Instalar dependencias de Backend (PHP)
Este comando descarga el framework de Laravel y sus librerias en la carpeta vendor:

```bash
composer install
```

### 3. Configurar variables de entorno
El archivo .env no se sube a GitHub por seguridad. Debes crear una copia del archivo de ejemplo:

```bash
cp .env.example .env
```

### 4. Generar llave de aplicación
Genera una clave única para encriptar sesiones y datos sensibles:

```bash
php artisan key:generate
```

### 5. Configurar la Base de Datos
1. Abre tu gestor de base de datos (phpMyAdmin, HeidiSQL, TablePlus, etc.).

2. Crea una base de datos vacía llamada "bodega_manager"

3. Abre el archivo .env que creaste en el paso 3 y configura tus credenciales:

```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=bodega_manager
DB_USERNAME=root
DB_PASSWORD=tu_password
```
4. Restaura el backup (bd_dump_bodega-api) que se encuentra en la carpeta 'postgresql' en la base de datos vacía creada anteriormente.

### 6. Instalar dependencias de Frontend (JS/CSS)
Esto descargar Tailwind, Alpine.js y compila los activos visuales.

```bash
npm install
npm run build
```

### 7. Iniciar el servidor

```bash
php artisan serve
```
