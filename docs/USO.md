# 📚 Documentación de Uso - ContactsWeb

## Guía Completa de Uso de la Aplicación

Esta documentación te proporciona instrucciones paso a paso para usar todas las funcionalidades de ContactsWeb.

---

## Tabla de Contenidos

1. [Primeros Pasos](#primeros-pasos)
2. [Autenticación](#autenticación)
3. [Panel de Contactos](#panel-de-contactos)
4. [Gestión de Contactos](#gestión-de-contactos)
5. [Perfil de Usuario](#perfil-de-usuario)
6. [Solución de Problemas](#solución-de-problemas)

---

## Primeros Pasos

### Instalación y Configuración

1. **Asegúrate de tener instalados los requisitos:**

    - PHP 8.1+
    - Composer
    - Una API REST en `http://localhost:8001`

2. **Instala las dependencias:**

    ```bash
    composer install
    ```

3. **Configura el archivo `.env`:**

    ```env
    API_BASE_URL=http://localhost:8001
    API_TIMEOUT=10
    ```

4. **Inicia la aplicación:**

    ```bash
    php artisan serve
    ```

5. **Accede a la aplicación:**
   Abre tu navegador en `http://localhost:8000`

---

## Autenticación

### Registrarse

El registro es el primer paso para usar ContactsWeb.

**Pasos:**

1. En la página principal, haz clic en el botón **"Registrarse"**
2. Serás redirigido a `/register`
3. Completa el formulario con los siguientes datos:

    | Campo                    | Descripción             | Validación                                |
    | ------------------------ | ----------------------- | ----------------------------------------- |
    | **Nombre**               | Tu nombre de pila       | Requerido, máx. 255 caracteres            |
    | **Apellido**             | Tu apellido             | Requerido, máx. 255 caracteres            |
    | **Email**                | Tu correo electrónico   | Requerido, debe ser único, formato válido |
    | **Contraseña**           | Tu contraseña de acceso | Requerido, mínimo 6 caracteres            |
    | **Confirmar Contraseña** | Repetir la contraseña   | Debe coincidir exactamente                |

4. Haz clic en **"Registrarse"**
5. Si todos los datos son válidos:
    - Se crea tu cuenta
    - Tu token se almacena en sesión
    - Serás redirigido automáticamente al **Panel de Contactos**
6. Si hay errores:
    - Se mostrará un mensaje de error en rojo
    - Los campos se rellenarán nuevamente para corregir

**Ejemplo de datos válidos:**

```
Nombre: Juan
Apellido: Pérez
Email: juan.perez@example.com
Contraseña: MiPassword123
```

---

### Iniciar Sesión

Si ya tienes una cuenta registrada.

**Pasos:**

1. En la página principal, haz clic en **"Iniciar Sesión"**
2. Se abrirá el formulario de login en `/login`
3. Completa los campos:

    | Campo          | Descripción         |
    | -------------- | ------------------- |
    | **Email**      | El email registrado |
    | **Contraseña** | Tu contraseña       |

4. Haz clic en **"Iniciar Sesión"**
5. Si las credenciales son correctas:
    - Tu token se almacena en sesión
    - Serás redirigido al **Panel de Contactos**
6. Si hay error:
    - Verás el mensaje "Credenciales incorrectas"
    - Intenta de nuevo

**Nota:** El token se almacena en la sesión y se usa para todas las peticiones posteriores a la API.

---

### Cerrar Sesión

Para salir de tu cuenta.

**Pasos:**

1. En cualquier página autenticada, localiza el botón **"Salir"** en la esquina superior derecha
2. Haz clic en **"Salir"**
3. Se ejecutará un POST a `/logout`
4. Tu sesión se cerrará y vuelves a la página de login

**Resultado:**

-   Tu token se elimina
-   Tu información de usuario se borra de la sesión
-   Se muestra mensaje de confirmación

---

## Panel de Contactos

### Acceder al Panel

El panel de contactos es la página principal después de iniciar sesión.

**URL:** `/contacts`

**Cómo acceder:**

-   Automáticamente después de registrarse o iniciar sesión
-   Haz clic en **"Contactos"** en el menú superior
-   Haz clic en el logo **"ContactsWeb"** para ir al panel

---

### Vista del Panel

El panel muestra todos tus contactos en una **cuadrícula responsiva** con las siguientes características:

1. **Header de bienvenida**

    - Título "Mis Contactos"
    - Botón "+ Nuevo Contacto"

2. **Tarjetas de contactos**

    - Nombre y Apellido en grande
    - Email con icono 📧
    - Teléfono con icono 📱
    - Dirección con icono 📍 (si existe)
    - Botón "Ver" para detalles

3. **Estado vacío**
    - Si no tienes contactos, se muestra un mensaje
    - Opción de crear el primer contacto

**Ejemplo de tarjeta:**

```
┌─────────────────────────────┐
│ Juan Pérez                  │
│                             │
│ 📧 juan.perez@example.com   │
│ 📱 +34 600 123 456          │
│ 📍 Calle Principal, 123     │
│                             │
│ [        Ver        ]       │
└─────────────────────────────┘
```

---

## Gestión de Contactos

### Crear un Nuevo Contacto

**Pasos:**

1. En el **Panel de Contactos**, haz clic en el botón **"+ Nuevo Contacto"**
2. Serás redirigido a `/contacts/create`
3. Completa el formulario con los siguientes campos:

    | Campo         | Descripción           | Obligatorio | Validación                      |
    | ------------- | --------------------- | ----------- | ------------------------------- |
    | **Nombre**    | Nombre del contacto   | Sí          | Máx. 255 caracteres             |
    | **Apellido**  | Apellido del contacto | Sí          | Máx. 255 caracteres             |
    | **Email**     | Email del contacto    | Sí          | Email válido, único por usuario |
    | **Teléfono**  | Número de teléfono    | Sí          | Máx. 20 caracteres              |
    | **Dirección** | Domicilio             | No          | Máx. 500 caracteres             |

4. Haz clic en **"Guardar Contacto"**
5. Si todo es válido:

    - El contacto se crea
    - Se muestra un mensaje de éxito
    - Vuelves al panel de contactos y ves el nuevo contacto

6. Si hay errores:
    - Se muestran en rojo
    - Los campos se conservan para editar

**Validaciones:**

-   ❌ Email duplicado: No puedes tener dos contactos con el mismo email
-   ❌ Email inválido: Formato no válido
-   ❌ Campos obligatorios vacíos: Se indicará el campo faltante

**Ejemplo:**

```
Nombre: Maria
Apellido: García
Email: maria.garcia@example.com
Teléfono: +34 600 987 654
Dirección: Avenida Secundaria, 456
```

---

### Ver Lista de Contactos

**Ubicación:** `/contacts`

**Características:**

1. **Cuadrícula de contactos**

    - Se muestra en grid responsivo
    - En desktop: múltiples columnas
    - En móvil: una columna

2. **Información en cada tarjeta:**

    - Nombre y apellido
    - Email
    - Teléfono
    - Dirección (si existe)

3. **Acciones:**

    - Botón "Ver" para ver detalles completos

4. **Estado vacío:**
    - Si no tienes contactos: mensaje amigable
    - Opción de crear el primer contacto

---

### Ver Detalles de Contacto

Para ver toda la información de un contacto específico.

**Pasos:**

1. En el **Panel de Contactos**, localiza el contacto deseado
2. Haz clic en el botón **"Ver"** de la tarjeta
3. Serás redirigido a `/contacts/{id}`
4. Se mostrará toda la información:

    | Campo               | Descripción              |
    | ------------------- | ------------------------ |
    | **Nombre Completo** | Nombre y Apellido        |
    | **Email**           | Con icono 📧             |
    | **Teléfono**        | Con icono 📱             |
    | **Dirección**       | Con icono 📍 (si existe) |
    | **Registrado**      | Fecha de creación        |

5. Haz clic en **"Volver"** para regresar al panel

**Diseño:**

-   Fondo gris claro
-   Bordes izquierdos coloreados
-   Fácil lectura
-   Botón de regreso prominente

---

## Perfil de Usuario

Para ver tus datos de usuario registrados.

**Pasos:**

1. Haz clic en **"Perfil"** en el menú superior derecho
2. Serás redirigido a `/profile`
3. Se mostrará tu información:

    | Campo          | Descripción                    |
    | -------------- | ------------------------------ |
    | **Nombre**     | Tu nombre registrado           |
    | **Apellido**   | Tu apellido registrado         |
    | **Email**      | Tu email registrado            |
    | **Registrado** | Fecha de creación de tu cuenta |

4. Haz clic en **"Volver a Contactos"** para regresar

---

## Navegación

### Menú Superior

El menú superior contiene:

**Cuando NO estás autenticado:**

-   📱 Icono/Logo "ContactsWeb"
-   🔗 Enlace "Iniciar Sesión"
-   🔗 Enlace "Registrarse"

**Cuando estás autenticado:**

-   📱 Icono/Logo "ContactsWeb"
-   👤 Nombre del usuario (en morado)
-   🔗 Enlace "Perfil"
-   🔗 Enlace "Contactos"
-   🔘 Botón "Salir"

### Flujo de Navegación

```
Inicio
  ├─ Registrarse ──→ Formulario ──→ Panel Contactos
  └─ Login ────────→ Formulario ──→ Panel Contactos
                          │
                          └──→ Crear Contacto
                          └──→ Ver Contacto
                          └──→ Perfil
                          └──→ Salir
```

---

## Solución de Problemas

### Error: "Debe iniciar sesión"

**Causa:** Intentaste acceder a una página protegida sin autenticación

**Solución:**

1. Ve a la página de login
2. Ingresa tus credenciales
3. Intenta acceder nuevamente

---

### Error: "Sesión expirada"

**Causa:** Tu token expiró o fue revocado

**Solución:**

1. Inicia sesión nuevamente
2. Tu nuevo token se generará automáticamente

---

### Error: "Error al cargar contactos"

**Causa:** La API no está disponible o hay un problema de conexión

**Solución:**

1. Verifica que la API está corriendo en `http://localhost:8001`
2. Comprueba la URL en el archivo `.env`
3. Revisa los logs en `storage/logs/laravel.log`

---

### Error: "Email duplicado"

**Causa:** Ya existe un contacto con ese email en tu cuenta

**Solución:**

1. Usa un email diferente
2. O verifica si ya existe ese contacto

---

### Formulario no se envía

**Causa:** Hay campos sin completar o con datos inválidos

**Solución:**

1. Revisa los mensajes de error en rojo
2. Completa todos los campos obligatorios
3. Verifica el formato del email
4. Intenta de nuevo

---

### Página en blanco

**Causa:** Error en la aplicación o problema de conexión

**Solución:**

1. Recarga la página (F5)
2. Limpia el caché del navegador
3. Reinicia el servidor con `php artisan serve`
4. Comprueba la consola del navegador (F12) para errores

---

## Tips y Trucos

✅ **Guarda tus contactos importantes con números de teléfono válidos**

✅ **Usa direcciones completas para mayor claridad**

✅ **Recuerda tu email de registro para futuros inicios de sesión**

✅ **La sesión se mantiene mientras tengas el navegador abierto**

✅ **Haz clic en el logo para ir rápidamente al panel principal**

---

## Seguridad

🔒 **Recomendaciones:**

1. Usa contraseñas fuertes (mínimo 6 caracteres)
2. No compartas tu email de acceso
3. Cierra sesión cuando uses computadoras públicas
4. Mantén la URL de la API privada
5. No expongas tu token en URLs o logs públicos

---

## 📖 Documentación Relacionada

Para más información:

-   **[README.md](../README.md)** - Características principales
-   **[DESARROLLO.md](./DESARROLLO.md)** - Detalles técnicos de desarrollo
-   **[VALIDACION.md](./VALIDACION.md)** - Referencia de validaciones
-   **[ANALISIS_PROYECTO.md](../ANALISIS_PROYECTO.md)** - Análisis completo

---

**Versión:** 1.0.0  
**Última actualización:** Noviembre 2025  
**Estado:** ✅ Completada
