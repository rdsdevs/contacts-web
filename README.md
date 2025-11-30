# 📱 ContactsWeb

Una aplicación web elegante y moderna para gestionar tus contactos, consumiendo una API REST desarrollada con Laravel. Con diseño personalizado, paleta de colores profesional, iconos Font Awesome y autenticación basada en tokens.

## 🎯 Características

-   ✅ **Autenticación segura** con tokens API (bearers)
-   📇 **Gestión completa de contactos** (crear, ver, listar)
-   🔐 **Sesiones de usuario** almacenadas en archivo (sin base de datos)
-   💎 **Interfaz moderna y responsiva** sin frameworks CSS (CSS personalizado)
-   🎨 **Paleta de colores profesional**: Azul (#4A90E2), Amarillo (#FFD700), Verde (#1ABC9C), Rojo (#FF6B6B)
-   🚀 **Integración con API REST** mediante Guzzle 7.\*
-   📱 **Totalmente responsivo** en dispositivos móviles
-   🏷️ **Iconos Font Awesome** en todas las interfaces
-   🌐 **Localización en español** con validaciones personalizadas

## 🛠️ Requisitos Previos

-   **PHP** 8.1 o superior
-   **Composer** 2.0+
-   **Un servidor web** (Apache, Nginx) o servidor artisan de Laravel

## 📦 Instalación

### 1. Clonar o descargar los archivos

```bash
git clone https://github.com/rdsdevs/contacts-web.git
cd contacts-web
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

# Localización
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES

# API Configuration - Apunta a la API REST
API_BASE_URL=http://localhost:8001
API_TIMEOUT=10

# Session Driver - Usamos archivo, no base de datos
SESSION_DRIVER=file
```

### 4. Iniciar el servidor

**Opción A: Con artisan**

```bash
php artisan serve
```

**Opción B: Con servidor web local**

```bash
# Nginx, Apache, etc.
# Apuntar document root a: /ruta/al/proyecto/public
```

La aplicación estará en `http://localhost:8000`

> ⚠️ **Nota importante**: La API REST debe estar corriendo en `http://localhost:8001` antes de usar la aplicación web

## 🚀 Uso

### 📝 Registro

1. Haz clic en **"Registrarse"** en la página de inicio
2. Completa los campos:
    - Nombre (requerido)
    - Apellido (requerido)
    - Email (requerido, único)
    - Contraseña (mín. 6 caracteres, confirmación requerida)
3. Clic en **"Crear Cuenta"**
4. Acceso automático al panel de contactos

### 🔑 Iniciar Sesión

1. Ingresa **Email** y **Contraseña**
2. Clic en **"Iniciar Sesión"**
3. Acceso a tu panel de contactos

### 📇 Gestionar Contactos

**Crear Contacto**

-   En el panel de contactos, clic en **"+ Nuevo Contacto"**
-   Completa los campos:
    -   Nombre (requerido)
    -   Apellido (requerido)
    -   Email (requerido, válido)
    -   Teléfono (requerido, 10-15 dígitos)
    -   Dirección (opcional)
-   Clic en **"Guardar Contacto"**

**Ver Contactos**

-   Panel principal muestra todas tus tarjetas de contacto
-   Cada tarjeta muestra: Nombre completo, Email, Teléfono
-   Clic en **"Ver"** para ver detalles completos

**Detalles del Contacto**

-   Página con información completa del contacto
-   Volver al panel con botón "Volver"

### 👤 Perfil

-   Clic en **"Perfil"** en menú superior
-   Visualiza: Nombre, Apellido, Email
-   Botón **"Volver"** para regresar

### 🚪 Cerrar Sesión

-   Clic en **"Salir"** en esquina superior derecha
-   Redirección automática a página de login

## 🏗️ Estructura del Proyecto

```
contacts-web/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php        # Autenticación y perfil
│   │   └── ContactController.php     # CRUD de contactos
│   └── Services/
│       └── ApiContactService.php     # Integración con API (Guzzle)
├── config/
│   └── services.php                  # Configuración de API
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php            # Layout base con estilos
│   ├── auth/
│   │   ├── register.blade.php       # Formulario de registro
│   │   ├── login.blade.php          # Formulario de login
│   │   └── profile.blade.php        # Vista de perfil
│   └── contacts/
│       ├── index.blade.php          # Listado de contactos
│       ├── create.blade.php         # Formulario crear contacto
│       └── show.blade.php           # Detalle de contacto
├── resources/lang/es/
│   └── validation.php               # Mensajes de validación en español
├── routes/
│   └── web.php                      # Rutas de la aplicación
├── docs/
│   ├── DESARROLLO.md                # Guía paso a paso de desarrollo
│   ├── USO.md                       # Manual de uso
│   └── VALIDACION.md                # Mensajes de validación
├── .env.example                     # Variables de entorno (template)
├── composer.json                    # Dependencias PHP
└── README.md                        # Este archivo
```

## 🔧 Rutas Principales

| Ruta               | Método | Descripción               | Acceso    |
| ------------------ | ------ | ------------------------- | --------- |
| `/`                | GET    | Redireccionamiento        | Público   |
| `/register`        | GET    | Formulario de registro    | Público   |
| `/register`        | POST   | Procesar registro         | Público   |
| `/login`           | GET    | Formulario de login       | Público   |
| `/login`           | POST   | Procesar login            | Público   |
| `/profile`         | GET    | Ver perfil de usuario     | Protegido |
| `/logout`          | POST   | Cerrar sesión             | Protegido |
| `/contacts`        | GET    | Listar contactos          | Protegido |
| `/contacts/create` | GET    | Formulario crear contacto | Protegido |
| `/contacts`        | POST   | Guardar contacto          | Protegido |
| `/contacts/{id}`   | GET    | Ver detalle de contacto   | Protegido |

## 🔒 Seguridad

✅ **Tokens en sesión** - Almacenados de forma segura en archivos  
✅ **CSRF protection** - Token CSRF en todos los formularios  
✅ **Validación server-side** - Validación completa en controladores  
✅ **Timeouts configurados** - 10 segundos para requests a API  
✅ **Manejo de errores** - Captura y logging de excepciones  
✅ **Middleware de autenticación** - Protección en rutas protegidas  
✅ **Headers de seguridad** - Content-Type y Accept configurados  
✅ **Localización de errores** - Mensajes claros en español

## 🔌 API Service - Métodos

`ApiContactService` en `app/Services/ApiContactService.php` proporciona:

```php
// Métodos de Autenticación
register(array $data)        // Registrar nuevo usuario
login(array $credentials)    // Iniciar sesión
logout()                     // Cerrar sesión
getMe()                      // Obtener datos del usuario actual

// Métodos de Contactos
listContacts(int $page)      // Listar contactos paginados
createContact(array $data)   // Crear nuevo contacto
getContact(int $id)          // Obtener detalle de contacto

// Métodos de Configuración
setToken(?string $token)     // Establecer token para requests
```

## 🎨 Diseño Visual

### Paleta de Colores

| Color                  | Código  | Uso                                      |
| ---------------------- | ------- | ---------------------------------------- |
| **Azul Primario**      | #4A90E2 | Títulos, encabezados, iconos principales |
| **Azul Oscuro**        | #2E5C8A | Estados hover, gradientes                |
| **Amarillo Acentuado** | #FFD700 | Bordes, divisores, acentos secundarios   |
| **Verde Éxito**        | #1ABC9C | Alertas de éxito                         |
| **Rojo Error**         | #FF6B6B | Alertas de error                         |

### Características de Diseño

-   **Responsive**: Móviles (320px), tablets (768px), escritorio (1024px+)
-   **Sin frameworks CSS**: CSS personalizado puro (sin Bootstrap, Tailwind)
-   **Tipografía**: Fuentes nativas del sistema para máximo rendimiento
-   **Iconos**: Font Awesome 6.4.0 desde CDN
-   **Gradientes**: Efectos visuales modernos en headers
-   **Grid CSS3**: Layouts flexibles para tarjetas de contactos
-   **Animaciones**: Efectos hover suaves y transiciones

## 📚 Documentación Adicional

-   **[Documentación de Uso](docs/USO.md)** - Manual completo de usuario
-   **[Documentación de Desarrollo](docs/DESARROLLO.md)** - Guía paso a paso para desarrolladores
-   **[Validaciones](docs/VALIDACION.md)** - Referencia de mensajes de validación en español
-   **[Instalación](INSTALL.md)** - Guía de instalación detallada
-   **[Resumen de Desarrollo](RESUMEN_DESARROLLO.md)** - Resumen técnico del proyecto

## 📄 Licencia

MIT License - Libre para uso comercial y personal

## 👨‍💻 Autor

**ContactsWeb** - Desarrollado como aplicación web moderna para APIs REST con Laravel 10 y Guzzle.

**Versión**: 1.0.0  
**Estado**: ✅ Producción  
**Última actualización**: Noviembre 2025

---

## 🤝 Soporte

Para reportar bugs o sugerencias, por favor crea un issue en el repositorio de GitHub.
