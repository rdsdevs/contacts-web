# Mensajes de Validación en Español

Este archivo documenta todos los mensajes de validación disponibles en el archivo `resources/lang/es/validation.php`.

## Mensajes de Validación Configurados

### Reglas Básicas

| Regla      | Mensaje                                                      | Descripción          |
| ---------- | ------------------------------------------------------------ | -------------------- |
| `required` | "El campo :attribute es obligatorio."                        | Campo es obligatorio |
| `string`   | "El campo :attribute debe ser una cadena de texto."          | Campo debe ser texto |
| `email`    | "El campo :attribute debe ser un correo electrónico válido." | Email válido         |
| `numeric`  | "El campo :attribute debe ser un número."                    | Solo números         |
| `integer`  | "El campo :attribute debe ser un entero."                    | Número entero        |
| `boolean`  | "El campo :attribute debe ser verdadero o falso."            | Booleano             |
| `url`      | "El formato del campo :attribute es inválido."               | URL válida           |
| `date`     | "El campo :attribute no es una fecha válida."                | Fecha válida         |

### Reglas de Tamaño

| Regla          | Mensaje                                                      | Descripción              |
| -------------- | ------------------------------------------------------------ | ------------------------ |
| `min:3`        | "El campo :attribute debe tener al menos 3 caracteres."      | Mínimo N caracteres      |
| `max:255`      | "El campo :attribute no puede ser mayor que 255 caracteres." | Máximo N caracteres      |
| `between:3,10` | "El campo :attribute debe estar entre 3 y 10 caracteres."    | Rango N-M caracteres     |
| `size:10`      | "El campo :attribute debe tener 10 caracteres."              | Exactamente N caracteres |

### Reglas de Comparación

| Regla             | Mensaje                                                | Descripción                                  |
| ----------------- | ------------------------------------------------------ | -------------------------------------------- |
| `confirmed`       | "La confirmación del campo :attribute no coincide."    | Campo confirmado (ej: password_confirmation) |
| `same:field`      | "Los campos :attribute y :other deben coincidir."      | Igual a otro campo                           |
| `different:field` | "Los campos :attribute y :other deben ser diferentes." | Diferente a otro campo                       |
| `unique:table`    | "El valor del campo :attribute ya existe."             | Valor único en tabla                         |
| `exists:table`    | "El valor seleccionado para :attribute es inválido."   | Existe en tabla                              |

### Reglas de Archivos

| Regla           | Mensaje                                                      | Descripción            |
| --------------- | ------------------------------------------------------------ | ---------------------- |
| `file`          | "El campo :attribute debe ser un archivo."                   | Es archivo             |
| `image`         | "El campo :attribute debe ser una imagen."                   | Es imagen              |
| `mimes:jpg,png` | "El campo :attribute debe ser un archivo de tipo: jpg, png." | Tipos MIME específicos |

### Ejemplos de Uso en Controladores

```php
$validated = $request->validate([
    'nombre' => 'required|string|max:255',
    'apellido' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|string|min:6|confirmed',
    'telefono' => 'required|string',
    'direccion' => 'nullable|string',
]);
```

Mensajes generados:

-   "El campo nombre es obligatorio."
-   "El campo nombre debe ser una cadena de texto."
-   "El campo nombre no puede ser mayor que 255 caracteres."
-   "El campo correo electrónico debe ser un correo electrónico válido."
-   "El valor del campo correo electrónico ya existe."
-   "El campo contraseña debe tener al menos 6 caracteres."
-   "La confirmación del campo contraseña no coincide."

## Personalización de Atributos

En el archivo `resources/lang/es/validation.php`, la sección `attributes` permite personalizar el nombre de los campos en los mensajes:

```php
'attributes' => [
    'nombre'                 => 'nombre',
    'apellido'               => 'apellido',
    'email'                  => 'correo electrónico',
    'password'               => 'contraseña',
    'password_confirmation'  => 'confirmación de contraseña',
    'telefono'               => 'teléfono',
    'direccion'              => 'dirección',
    'correo'                 => 'correo electrónico',
],
```

## Cómo se Muestran en las Vistas

Los mensajes de error se muestran automáticamente en las vistas Blade usando:

```blade
@error('email')
    <div class="form-error">
        <i class="fas fa-times-circle"></i> {{ $message }}
    </div>
@enderror
```

Ejemplo de salida:

```
✗ El campo correo electrónico debe ser un correo electrónico válido.
```

## Referencia Rápida

### Login / Register

-   `email|required` → "El campo correo electrónico es obligatorio."
-   `password|required|min:6` → "El campo contraseña debe tener al menos 6 caracteres."
-   `password_confirmation|required` → "El campo confirmación de contraseña es obligatorio."

### Crear Contacto

-   `nombre|required|string|max:255` → Nombre obligatorio, texto, máximo 255 caracteres
-   `email|required|email` → Email obligatorio y válido
-   `telefono|required|string` → Teléfono obligatorio
-   `direccion|nullable|string` → Dirección opcional

## Notas Importantes

1. Los mensajes se muestran en **español** automáticamente porque `APP_LOCALE=es` en `.env`
2. Los atributos se traducen automáticamente según la configuración en `attributes`
3. Todos los placeholders `:attribute`, `:min`, `:max`, `:value` se reemplazan automáticamente
4. Los estilos CSS de error (rojo, icono) se aplican automáticamente en las vistas mejoradas
