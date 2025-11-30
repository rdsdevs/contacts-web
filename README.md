# 📱 ContactsWeb

Una aplicación web elegante y moderna para gestionar tus contactos, consumiendo una API REST desarrollada con Laravel.

## 🎯 Características

- ✅ **Autenticación segura** con tokens API (Laravel Sanctum)
- 📇 **Gestión completa de contactos** (crear, ver, listar)
- 🔐 **Sesiones de usuario** almacenadas localmente
- 💎 **Interfaz moderna y responsiva** sin frameworks CSS
- 🚀 **Integración con API REST** mediante Guzzle
- 📱 **Totalmente responsivo** en dispositivos móviles

## 🛠️ Requisitos Previos

- PHP 8.1 o superior
- Composer
- Un servidor web (Apache, Nginx, etc.)

## 📦 Instalación

### 1. Clonar o descargar los archivos

```bash
cd /ruta/a/tu/proyecto
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar variables de entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` y configura:

```env
APP_NAME=ContactsWeb
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# API Configuration
API_BASE_URL=http://localhost:8001
API_TIMEOUT=10
```

### 4. Iniciar el servidor

```bash
php artisan serve
```

La aplicación estará en `http://localhost:8000`

## 🚀 Uso

### Registro
1. Haz clic en "Registrarse"
2. Completa: Nombre, Apellido, Email, Contraseña
3. Acceso automático al panel de contactos

### Iniciar Sesión
1. Ingresa Email y Contraseña
2. Acceso a tu panel de contactos

### Gestionar Contactos

**Crear Contacto**
- En panel de contactos, clic en "+ Nuevo Contacto"
- Completa: Nombre, Apellido, Email, Teléfono, Dirección (opcional)
- Clic en "Guardar Contacto"

**Ver Contactos**
- Panel principal muestra todas tus tarjetas de contacto
- Clic en "Ver" para ver detalles completos

### Perfil
- Clic en "Perfil" en menú superior para ver tus datos

### Cerrar Sesión
- Clic en "Salir" en esquina superior derecha

## 🏗️ Estructura

```
contacts-web/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php
│   │   └── ContactController.php
│   └── Services/
│       └── ApiContactService.php
├── config/services.php
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── auth/
│   ├── contacts/
├── routes/web.php
└── README.md
```

## 🔌 API Service

`ApiContactService` consume la API REST con Guzzle:

```php
$api->register($data)        // POST /api/auth/register
$api->login($credentials)    // POST /api/auth/login
$api->logout()               // POST /api/auth/logout
$api->getMe()                // GET /api/auth/me
$api->listContacts($page)    // GET /api/contacts
$api->createContact($data)   // POST /api/contacts
$api->getContact($id)        // GET /api/contacts/{id}
```

## 🎨 Diseño

- **Colores**: Gradiente morado (#667eea a #764ba2)
- **Tipografía**: Fuentes nativas del sistema
- **Responsive**: Adaptable a todos los dispositivos
- **Sin frameworks CSS**: Diseño personalizado puro

## 🔒 Seguridad

✅ Tokens en sesión  
✅ CSRF protection  
✅ Validación server-side  
✅ Timeouts configurados  
✅ Manejo de errores

## 📝 Documentación

- [Documentación de Uso](docs/USO.md)
- [Documentación de Desarrollo](docs/DESARROLLO.md)

## 📄 Licencia

MIT License

## 👨‍💻 Autor

Desarrollado como aplicación web moderna para APIs REST con Laravel.

---

**Versión**: 1.0.0  
**Última actualización**: Noviembre 2025
