# 📋 Guía de Instalación Rápida

Una guía paso a paso para instalar y ejecutar ContactsWeb.

## 🚀 Inicio Rápido (5 minutos)

### 1. Verificar Requisitos

```bash
# PHP 8.1+
php -v

# Composer
composer -v
```

### 2. Clonar/Descargar Proyecto

```bash
cd /media/rdsdev/01DC2CC588FC7C60/practica-api/contacts-web
```

### 3. Instalar Dependencias

```bash
composer install
```

### 4. Configurar Entorno

```bash
cp .env.example .env
php artisan key:generate
```

**Editar `.env`:**

```env
API_BASE_URL=http://localhost:8001
API_TIMEOUT=10
```

### 5. Iniciar Servidor

```bash
php artisan serve
```

### 6. Acceder a la Aplicación

```
http://localhost:8000
```

---

## 🔧 Configuración Completa

### Variables de .env

```env
APP_NAME=ContactsWeb              # Nombre de la app
APP_ENV=local                      # Entorno
APP_DEBUG=true                     # Debug mode
APP_URL=http://localhost:8000      # URL de la app

API_BASE_URL=http://localhost:8001 # URL de la API
API_TIMEOUT=10                     # Timeout en segundos

SESSION_DRIVER=database            # Almacenamiento de sesiones
```

### Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear

# Ver rutas disponibles
php artisan route:list

# Ver versión de Laravel
php artisan --version

# Entrar a consola interactiva
php artisan tinker
```

---

## 📝 Archivos Importantes

| Archivo                                      | Propósito                  |
| -------------------------------------------- | -------------------------- |
| `.env`                                       | Variables de entorno       |
| `config/services.php`                        | Configuración de servicios |
| `app/Services/ApiContactService.php`         | Consumo de API             |
| `app/Http/Controllers/AuthController.php`    | Autenticación              |
| `app/Http/Controllers/ContactController.php` | Gestión de contactos       |
| `routes/web.php`                             | Definición de rutas        |
| `resources/views/`                           | Vistas (templates)         |

---

## 🐛 Solucionar Problemas

### Error: "Could not find driver"

**Causa:** SQLite no está disponible

**Solución:** Cambiar en `.env`

```env
DB_CONNECTION=sqlite
# O instalar paquete SQLite
sudo apt-get install php-sqlite3
```

### Error: "API no está disponible"

**Causa:** API REST no está corriendo

**Solución:**

```bash
# En otra terminal, iniciar API
cd ../contacts-api
php artisan serve --port=8001
```

### Error: "Página en blanco"

**Causa:** Error en la aplicación

**Solución:**

```bash
# Ver logs
tail -f storage/logs/laravel.log

# O limpiar caché
php artisan cache:clear
```

### Error: "CORS"

**Causa:** Problema de políticas de origen cruzado

**Solución:** Verificar que API está en localhost:8001 correctamente

---

## 📊 Estructura de Carpetas

```
contacts-web/
├── app/                      # Código de aplicación
│   ├── Http/
│   │   └── Controllers/      # Controladores
│   └── Services/             # Servicios (API, etc)
├── config/                   # Archivos de configuración
├── resources/                # Recursos (vistas, CSS)
│   └── views/                # Plantillas Blade
├── routes/                   # Definición de rutas
├── storage/                  # Archivos generados
│   └── logs/                 # Logs de la aplicación
├── vendor/                   # Librerías externas
├── .env                      # Variables de entorno
├── .env.example              # Ejemplo de variables
├── artisan                   # CLI de Laravel
├── composer.json             # Dependencias PHP
└── composer.lock             # Versiones bloqueadas
```

---

## 🔐 Seguridad

-   🔒 Cambia `APP_DEBUG=false` en producción
-   🔑 Usa contraseñas fuertes
-   🌐 Configura CORS si necesitas APIs externas
-   📝 Revisa logs regularmente
-   🔐 No expongas `API_BASE_URL` en frontend

---

**¿Necesitas ayuda?** Revisa `docs/USO.md` o `docs/DESARROLLO.md`
