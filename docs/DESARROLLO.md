# 🔨 Documentación de Desarrollo - ContactsWeb

## Guía Paso a Paso de Cómo se Desarrolló ContactsWeb

Esta documentación explica de forma detallada cómo se construyó ContactsWeb, las decisiones de arquitectura y los pasos seguidos.

---

## Tabla de Contenidos

1. [Visión General](#visión-general)
2. [Arquitectura](#arquitectura)
3. [Configuración Inicial](#configuración-inicial)
4. [Paso 1: Crear el Proyecto](#paso-1-crear-el-proyecto)
5. [Paso 2: Configurar Variables de Entorno](#paso-2-configurar-variables-de-entorno)
6. [Paso 3: Crear el Servicio de API](#paso-3-crear-el-servicio-de-api)
7. [Paso 4: Crear Controladores](#paso-4-crear-controladores)
8. [Paso 5: Definir Rutas](#paso-5-definir-rutas)
9. [Paso 6: Crear Vistas](#paso-6-crear-vistas)
10. [Paso 7: Implementar Middleware](#paso-7-implementar-middleware)
11. [Patrones y Decisiones](#patrones-y-decisiones)

---

## Visión General

### Objetivo

Crear una aplicación web que consuma una API REST de gestión de contactos, proporcionando una interfaz elegante y moderna sin utilizar frameworks CSS como Bootstrap o Tailwind.

### Requisitos

-   ✅ Consumir API REST (Laravel 10)
-   ✅ Autenticación con tokens
-   ✅ CRUD básico de contactos (Crear, Ver, Listar)
-   ✅ UI elegante sin frameworks CSS
-   ✅ Responsiva en todos los dispositivos
-   ✅ Integración con Guzzle

### Tecnologías Utilizadas

| Tecnología  | Versión        | Propósito              |
| ----------- | -------------- | ---------------------- |
| **Laravel** | 10.\*          | Framework web          |
| **PHP**     | 8.1+           | Lenguaje backend       |
| **Guzzle**  | 7.\*           | Cliente HTTP           |
| **Blade**   | Nativa         | Template engine        |
| **CSS**     | 3              | Estilos personalizados |
| **Session** | Nativa Laravel | Gestión de sesiones    |

---

## Arquitectura

### Patrón: Arquitectura en Capas

```
┌─────────────────────────────────────────┐
│           Vistas (Blade)                │
│     ├── layouts/app.blade.php           │
│     ├── auth/* (Login, Registro)        │
│     └── contacts/* (CRUD)               │
└────────────────────┬────────────────────┘
                     │
┌────────────────────▼────────────────────┐
│       Controladores (Controllers)       │
│     ├── AuthController                  │
│     └── ContactController               │
└────────────────────┬────────────────────┘
                     │
┌────────────────────▼────────────────────┐
│       Servicios (Services)              │
│     └── ApiContactService (Guzzle)      │
└────────────────────┬────────────────────┘
                     │
┌────────────────────▼────────────────────┐
│    API REST Externa (http://localhost)  │
│     └── Endpoints Auth y Contacts       │
└─────────────────────────────────────────┘
```

### Principios

1. **Separation of Concerns**: Cada capa tiene responsabilidades claras
2. **DRY (Don't Repeat Yourself)**: Lógica centralizada en ServiceClass
3. **MVC**: Modelos View Controller separados
4. **Dependency Injection**: Inyección de dependencias en controladores

---

## Configuración Inicial

### Recomendaciones Antes de Empezar

```bash
# Versión de PHP
php -v
# Debe ser 8.1 o superior

# Composer instalado
composer -v

# Node.js (opcional)
node -v
npm -v
```

### Estructura de Directorios

```
/media/rdsdev/01DC2CC588FC7C60/practica-api/
├── contacts-api/          # API REST (Laravel 10)
│   ├── app/
│   ├── routes/
│   ├── .env
│   └── artisan
└── contacts-web/          # App Web (Laravel 10)
    ├── app/
    ├── config/
    ├── resources/
    ├── routes/
    ├── .env
    └── artisan
```

---

## Paso 1: Crear el Proyecto

### Comando

```bash
cd /media/rdsdev/01DC2CC588FC7C60/practica-api
composer create-project laravel/laravel contacts-web
cd contacts-web
```

### Qué Hace Este Comando

1. **Descarga Laravel 10** desde Packagist
2. **Instala todas las dependencias** (Guzzle, Symfony, etc.)
3. **Genera estructura base** con directorios estándar
4. **Copia .env.example a .env** automáticamente
5. **Crea storage/ y bootstrap/ necesarios**

### Resultado

```
contacts-web/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── .env
├── .env.example
├── artisan
├── composer.json
└── composer.lock
```

### Verificación

```bash
php artisan --version
# Laravel Framework 12.40.2 (o similar)
```

---

## Paso 2: Configurar Variables de Entorno

### Archivo: `.env`

**Cambios necesarios:**

```env
# ANTES (Valores por defecto)
APP_NAME=Laravel
APP_ENV=local
APP_URL=http://localhost
APP_LOCALE=en
LOG_CHANNEL=stack
DB_CONNECTION=sqlite
SESSION_DRIVER=database

# DESPUÉS (Nuestros valores)
APP_NAME=ContactsWeb
APP_ENV=local
APP_KEY=base64:... (se genera automáticamente)
APP_DEBUG=true
APP_URL=http://localhost:8000

APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES

LOG_CHANNEL=stack

# Configuración de la API
API_BASE_URL=http://localhost:8001
API_TIMEOUT=10
```

### Archivo: `config/services.php`

**Agregar configuración de API:**

```php
// ANTES: Solo tiene Postmark, Resend, SES, Slack

// DESPUÉS: Agregar al final
'api' => [
    'base_url' => env('API_BASE_URL', 'http://localhost:8001'),
    'timeout' => env('API_TIMEOUT', 10),
],
```

### Acceso a Configuración

En los controladores:

```php
$baseUrl = config('services.api.base_url');
$timeout = config('services.api.timeout');
```

### Beneficios

✅ Variables sensibles no en el código  
✅ Configuración centralizada  
✅ Fácil cambio de entornos (local, staging, production)  
✅ Seguridad (no commitear .env)

---

## Paso 3: Crear el Servicio de API

### Ubicación

`app/Services/ApiContactService.php`

### Decisión Arquitectónica

Se creó un servicio separado porque:

1. **Reutilización**: Múltiples controladores pueden usar el mismo servicio
2. **Testabilidad**: Fácil de mockear en tests
3. **Mantenibilidad**: Un solo lugar para cambiar la lógica de API
4. **Escalabilidad**: Fácil agregar nuevos métodos

### Estructura del Servicio

```php
class ApiContactService
{
    private Client $client;              // Cliente Guzzle
    private string $baseUrl;             // URL base de la API
    private int $timeout;                // Timeout en segundos
    private ?string $token = null;       // Token de autenticación

    public function __construct()        // Inicialización
    public function setToken($token)     // Establecer token
    private function getHeaders()        // Headers comunes

    // Métodos de Autenticación
    public function register(array $data)
    public function login(array $credentials)
    public function logout()
    public function getMe()

    // Métodos de Contactos
    public function listContacts(int $page)
    public function createContact(array $data)
    public function getContact(int $id)
}
```

### Método Clave: Constructor

```php
public function __construct()
{
    // Lee configuración desde .env via config()
    $this->baseUrl = config('services.api.base_url');
    $this->timeout = config('services.api.timeout');

    // Crea cliente Guzzle con configuración
    $this->client = new Client([
        'base_uri' => $this->baseUrl,
        'timeout'  => $this->timeout,
        'verify'   => false, // Para desarrollo local
    ]);
}
```

### Método Clave: Manejo de Token

```php
public function setToken(?string $token): self
{
    $this->token = $token;
    return $this;  // Retorna $this para encadenamiento
}

private function getHeaders(): array
{
    $headers = [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ];

    if ($this->token) {
        $headers['Authorization'] = "Bearer {$this->token}";
    }

    return $headers;
}
```

### Método Clave: Consumir Endpoint

```php
public function register(array $data): array
{
    try {
        // POST a /api/auth/register
        $response = $this->client->post('/api/auth/register', [
            'json' => $data,
            'headers' => $this->getHeaders(),
        ]);

        // Parsear JSON de respuesta
        return json_decode($response->getBody()->getContents(), true);
    } catch (GuzzleException $e) {
        // Registrar error en logs
        Log::error('Error en registro:', ['error' => $e->getMessage()]);

        // Retornar respuesta de error estructurada
        return [
            'success' => false,
            'message' => 'Error al registrar usuario: ' . $e->getMessage(),
        ];
    }
}
```

### Patrón de Respuesta

Todas las respuestas siguen este patrón:

```php
[
    'success' => true|false,
    'message' => 'Descripción',
    'data' => [...],  // Cuando success es true
]
```

---

## Paso 4: Crear Controladores

### Ubicación

-   `app/Http/Controllers/AuthController.php`
-   `app/Http/Controllers/ContactController.php`

### AuthController

**Responsabilidades:**

```php
class AuthController extends Controller
{
    private ApiContactService $apiService;

    // Inyección de dependencia
    public function __construct(ApiContactService $apiService)

    // Mostrar formulario de registro
    public function showRegister()

    // Procesar registro
    public function register(Request $request)

    // Mostrar formulario de login
    public function showLogin()

    // Procesar login
    public function login(Request $request)

    // Cerrar sesión
    public function logout(Request $request)

    // Ver perfil del usuario
    public function profile()
}
```

**Método: Register**

```php
public function register(Request $request)
{
    // 1. Validar datos del formulario
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // 2. Consumir API de registro
    $result = $this->apiService->register($validated);

    // 3. Verificar éxito
    if ($result['success']) {
        // 4. Guardar en sesión
        session(['token' => $result['data']['token']]);
        session(['user' => $result['data']['user']]);

        // 5. Redirigir
        return redirect()->route('contacts.index')
                        ->with('success', 'Registro exitoso');
    }

    // 6. Si falla, volver con errores
    return back()->withErrors(['error' => $result['message']])
                 ->withInput();
}
```

### ContactController

**Responsabilidades:**

```php
class ContactController extends Controller
{
    private ApiContactService $apiService;

    public function __construct(ApiContactService $apiService)

    // Listar contactos
    public function index(Request $request)

    // Mostrar formulario crear
    public function create()

    // Guardar nuevo contacto
    public function store(Request $request)

    // Ver detalle de contacto
    public function show($id)
}
```

**Middleware en Constructor:**

```php
public function __construct(ApiContactService $apiService)
{
    // Middleware que verifica autenticación
    $this->middleware(function ($request, $next) {
        if (!session('token')) {
            return redirect()->route('login')
                           ->withErrors(['error' => 'Debe iniciar sesión']);
        }
        return $next($request);
    });

    $this->apiService = $apiService;
}
```

**Método: Index (Listar Contactos)**

```php
public function index(Request $request)
{
    $token = session('token');
    $page = $request->get('page', 1);

    // Consumir API
    $result = $this->apiService->setToken($token)->listContacts($page);

    if (!$result['success']) {
        return redirect()->route('login')
                        ->withErrors(['error' => 'Error al cargar contactos']);
    }

    $contacts = $result['data']['data'] ?? [];
    $pagination = $result['data']['links'] ?? null;

    return view('contacts.index', compact('contacts', 'pagination'));
}
```

---

## Paso 5: Definir Rutas

### Archivo: `routes/web.php`

```php
// Ruta raíz (redirecciona según autenticación)
Route::get('/', function () {
    if (session('token')) {
        return redirect()->route('contacts.index');
    }
    return redirect()->route('login');
});

// Rutas públicas (sin autenticación)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])
         ->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])
         ->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth.session')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])
         ->name('profile');
    Route::post('/logout', [AuthController::class, 'logout'])
         ->name('logout');

    Route::resource('contacts', ContactController::class)
         ->only(['index', 'create', 'store', 'show']);
});
```

### Explicación de Rutas

| Ruta               | Método | Controlador                 | Acceso    | Nombre          |
| ------------------ | ------ | --------------------------- | --------- | --------------- |
| `/`                | GET    | -                           | Público   | -               |
| `/register`        | GET    | AuthController@showRegister | Público   | register        |
| `/register`        | POST   | AuthController@register     | Público   | -               |
| `/login`           | GET    | AuthController@showLogin    | Público   | login           |
| `/login`           | POST   | AuthController@login        | Público   | -               |
| `/profile`         | GET    | AuthController@profile      | Protegido | profile         |
| `/logout`          | POST   | AuthController@logout       | Protegido | logout          |
| `/contacts`        | GET    | ContactController@index     | Protegido | contacts.index  |
| `/contacts/create` | GET    | ContactController@create    | Protegido | contacts.create |
| `/contacts`        | POST   | ContactController@store     | Protegido | contacts.store  |
| `/contacts/{id}`   | GET    | ContactController@show      | Protegido | contacts.show   |

### Nombres de Rutas (Named Routes)

Ventajas:

```blade
<!-- En vistas: más seguro que hardcodear URLs -->
<a href="{{ route('login') }}">Iniciar Sesión</a>

<!-- En controladores: redirección fácil -->
redirect()->route('contacts.index')
```

---

## Paso 6: Crear Vistas

### Estructura de Vistas

```
resources/views/
├── layouts/
│   └── app.blade.php           # Layout base
├── auth/
│   ├── register.blade.php
│   ├── login.blade.php
│   └── profile.blade.php
└── contacts/
    ├── index.blade.php
    ├── create.blade.php
    └── show.blade.php
```

### Layout Base: `app.blade.php`

**Características:**

1. **Header** con navegación
2. **Main content** con alertas
3. **Footer** con información
4. **CSS personalizado** (sin frameworks)
5. **Responsive** con media queries

**Estructura:**

```html
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="..." />
        <title>@yield('title', 'Contacts Web')</title>
        <style>
            /* CSS personalizado aquí */
        </style>
        @yield('extra-styles')
    </head>
    <body>
        <div class="container">
            <header>
                <h1>ContactsWeb</h1>
                <nav>
                    <!-- Navegación condicional -->
                    @if(session('token'))
                    <!-- Usuario autenticado -->
                    @else
                    <!-- Usuario no autenticado -->
                    @endif
                </nav>
            </header>

            <main>
                <!-- Mostrar errores -->
                @if($errors->any()) @foreach($errors->all() as $error)
                <div class="alert alert-error">{{ $error }}</div>
                @endforeach @endif

                <!-- Mostrar mensajes de éxito -->
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Contenido de cada página -->
                @yield('content')
            </main>

            <footer>
                <p>&copy; 2025 ContactsWeb.</p>
            </footer>
        </div>
    </body>
</html>
```

### Vistas de Autenticación

**`auth/register.blade.php`:**

```blade
@extends('layouts.app')
@section('title', 'Registro')
@section('content')
    <!-- Formulario con validación -->
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <!-- Campos: nombre, apellido, email, password -->
    </form>
@endsection
```

**Características:**

-   Token CSRF con `@csrf`
-   Validación con `@error('campo')`
-   Old values con `old('campo')`
-   Inputs con estilos personalizados

### Vistas de Contactos

**`contacts/index.blade.php`:**

```blade
@extends('layouts.app')
@section('title', 'Mis Contactos')
@section('content')
    <!-- Grid de contactos -->
    <div class="contacts-grid">
        @foreach($contacts as $contact)
            <div class="contact-card">
                <!-- Información del contacto -->
            </div>
        @endforeach
    </div>
@endsection
```

**Diseño:**

-   Grid CSS3 responsivo
-   Tarjetas (cards) con hover
-   Iconos emoji
-   Botones de acción

### CSS Personalizado

**Decisión:** Sin frameworks

```css
/* Gradiente de fondo */
body {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Grid responsivo */
.contacts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

/* Media queries para móvil */
@media (max-width: 768px) {
    .contacts-grid {
        grid-template-columns: 1fr;
    }
}
```

**Beneficios:**

✅ Sin dependencias externas  
✅ Control total del diseño  
✅ Menos peso en CSS  
✅ Mejor compatibilidad

---

## Paso 7: Implementar Middleware

### Middleware Personalizado

Laravel proporciona middleware para autenticación:

```php
// En routes/web.php
Route::middleware('auth.session')->group(...)
```

### Middleware Personalizado en Controlador

Se implementó directamente en el constructor:

```php
public function __construct(ApiContactService $apiService)
{
    $this->middleware(function ($request, $next) {
        if (!session('token')) {
            return redirect()->route('login')
                           ->withErrors(['error' => 'Debe iniciar sesión']);
        }
        return $next($request);
    });

    $this->apiService = $apiService;
}
```

### Alternativa: Crear Middleware Personalizado

```php
// app/Http/Middleware/EnsureApiTokenExists.php
php artisan make:middleware EnsureApiTokenExists
```

```php
public function handle(Request $request, Closure $next)
{
    if (!session('token')) {
        return redirect()->route('login');
    }
    return $next($request);
}
```

Registro en `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'api-token' => EnsureApiTokenExists::class,
    ]);
})
```

---

## Patrones y Decisiones

### 1. Inyección de Dependencias

```php
// ❌ MALO: Crear instancia directamente
public function __construct()
{
    $this->apiService = new ApiContactService();
}

// ✅ BUENO: Inyectar vía constructor
public function __construct(ApiContactService $apiService)
{
    $this->apiService = $apiService;
}
```

**Ventaja:** Más fácil de testear

### 2. Separación de Responsabilidades

```php
// ❌ MALO: Lógica de API en controlador
public function login(Request $request)
{
    $response = $client->post('/api/auth/login', ...);
    // Más lógica aquí
}

// ✅ BUENO: Lógica en servicio
public function login(Request $request)
{
    $result = $this->apiService->login($request->all());
    // Solo lógica de controlador
}
```

### 3. Manejo de Errores

```php
// ✅ Siempre usar try-catch en API calls
try {
    $response = $this->client->post(...);
    return json_decode($response->getBody()->getContents(), true);
} catch (GuzzleException $e) {
    Log::error('Error:', ['error' => $e->getMessage()]);
    return ['success' => false, 'message' => $e->getMessage()];
}
```

### 4. Flujo de Datos

```
Usuario → Formulario → Controlador → Validación → Servicio → API
   ↓                                                   ↓
Sesión ← Respuesta ← Controlador ← Servicio ← API Response
```

### 5. Manejo de Token

```php
// Token se almacena en sesión
session(['token' => $result['data']['token']]);

// Se recupera y se envía con cada request
$token = session('token');
$this->apiService->setToken($token)->method();
```

### 6. Respuesta Estructurada

```php
// Formato consistente en toda la aplicación
[
    'success' => true|false,
    'message' => 'Descripción',
    'data' => [
        'user' => [...],
        'token' => '...'
    ]
]
```

---

## Flujo de Ejecución

### Registro de Usuario

```
1. Usuario envía formulario
   ↓
2. Route /register -> AuthController@register
   ↓
3. Validación en RequestValidation
   ↓
4. Controlador llama a ApiContactService->register()
   ↓
5. Servicio hace POST a API http://localhost:8001/api/auth/register
   ↓
6. API devuelve respuesta JSON
   ↓
7. Servicio procesa y retorna resultado estructurado
   ↓
8. Controlador verifica success
   ↓
9. Si OK: Guarda en sesión y redirige a contacts.index
   Si ERROR: Vuelve a formulario con errores
```

### Ver Contactos

```
1. Usuario accede a /contacts
   ↓
2. Route contacts.index -> ContactController@index
   ↓
3. Middleware verifica session('token')
   ↓
4. Controlador recupera token de sesión
   ↓
5. Controlador llama a ApiContactService->listContacts($page)
   ↓
6. Servicio hace GET a API /api/contacts?page=1
   ↓
7. Servicio envía Authorization: Bearer {token}
   ↓
8. API devuelve contactos en JSON
   ↓
9. Controlador pasa datos a vista
   ↓
10. Blade renderiza HTML con contactos
   ↓
11. Usuario ve página con tarjetas de contactos
```

---

## Buenas Prácticas Implementadas

✅ **Configuración en .env**: Variables sensibles no en código  
✅ **Servicio centralizado**: Una clase para toda lógica de API  
✅ **Manejo de errores**: Try-catch en todas las llamadas HTTP  
✅ **Logging**: Errores se registran en `storage/logs/laravel.log`  
✅ **Validación**: Server-side en controladores  
✅ **CSRF Protection**: Token @csrf en formularios  
✅ **Middleware**: Verificación de autenticación en rutas  
✅ **Nombres de rutas**: Route names en lugar de URLs hardcodeadas  
✅ **Responsivo**: Media queries para todos los tamaños  
✅ **Seguridad**: Token en sesión, no expuesto en URLs

---

## Testing

### Test Manual

```bash
# 1. Iniciar API en otra terminal
cd ../contacts-api
php artisan serve --port=8001

# 2. Iniciar aplicación web
cd ../contacts-web
php artisan serve

# 3. Probar en navegador
http://localhost:8000
```

### Test Unitario (Ejemplo)

```php
// tests/Unit/ApiContactServiceTest.php
class ApiContactServiceTest extends TestCase
{
    public function test_register_user()
    {
        $service = new ApiContactService();

        $result = $service->register([
            'nombre' => 'John',
            'apellido' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ]);

        $this->assertTrue($result['success']);
        $this->assertArrayHasKey('token', $result['data']);
    }
}
```

---

## Mejoras Futuras

💡 **Posibles expansiones:**

1. **Edición de contactos**: Agregar ruta PUT /contacts/{id}
2. **Eliminación de contactos**: Agregar ruta DELETE /contacts/{id}
3. **Búsqueda**: Implementar /contacts/search
4. **Exportación**: Exportar contactos a CSV/PDF
5. **Autenticación OAuth**: Integrar con Google/GitHub
6. **Caché**: Cachear contactos con Redis
7. **Tests**: Suite completa de tests
8. **API Documentation**: Swagger/OpenAPI
9. **Notificaciones**: Email/SMS al crear contacto
10. **Roles y Permisos**: Sistema de autorización

---

## Conclusión

ContactsWeb demuestra:

✅ Integración correcta con API REST  
✅ Arquitectura limpia y mantenible  
✅ UI moderna sin frameworks CSS  
✅ Buenas prácticas de Laravel  
✅ Seguridad en autenticación  
✅ Código escalable y reutilizable

El proyecto está listo para producción con pequeños ajustes de configuración.

---

## 📚 Documentación Completa del Proyecto

Este proyecto incluye documentación exhaustiva:

| Documento                                             | Propósito                        | Audiencia        |
| ----------------------------------------------------- | -------------------------------- | ---------------- |
| **[README.md](../README.md)**                         | Guía general y características   | Todos            |
| **[INSTALL.md](../INSTALL.md)**                       | Instalación rápida (5 min)       | Usuarios         |
| **[USO.md](./USO.md)**                                | Manual completo de usuario       | Usuarios finales |
| **[DESARROLLO.md](./DESARROLLO.md)**                  | Guía técnica de desarrollo       | Desarrolladores  |
| **[VALIDACION.md](./VALIDACION.md)**                  | Referencia de validaciones       | Desarrolladores  |
| **[RESUMEN_DESARROLLO.md](../RESUMEN_DESARROLLO.md)** | Resumen ejecutivo                | Todos            |
| **[ANALISIS_PROYECTO.md](../ANALISIS_PROYECTO.md)**   | Análisis completo y arquitectura | Desarrolladores  |

---

## 🔗 Enlaces Útiles

-   **GitHub**: https://github.com/rdsdevs/contacts-web
-   **API REST**: http://localhost:8001
-   **Aplicación Web**: http://localhost:8000
-   **Logs**: storage/logs/laravel.log

---

**Versión:** 1.0.0  
**Autor:** Equipo de Desarrollo  
**Última actualización:** Noviembre 2025  
**Estado:** ✅ Producción
