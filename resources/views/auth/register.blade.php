@extends('layouts.app')

@section('title', 'Registro')

@section('extra-styles')
<style>
    .register-container {
        max-width: 500px;
        margin: 0 auto;
    }

    .register-card {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .register-header {
        text-align: center;
        color: #4A90E2;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 24px;
    }

    .error-alert {
        background-color: #fde8e8;
        border: 1px solid #FF6B6B;
        border-left: 4px solid #FF6B6B;
        color: #721c24;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .error-alert i {
        font-size: 18px;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .error-content {
        flex: 1;
    }

    .error-title {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .error-message {
        font-size: 14px;
        line-height: 1.5;
    }

    .field-error input {
        border-color: #FF6B6B !important;
        background-color: #fff5f5;
    }

    .field-error label {
        color: #721c24;
        font-weight: 600;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-with-icon i {
        position: absolute;
        left: 12px;
        color: #4A90E2;
        pointer-events: none;
    }

    .input-with-icon input {
        padding-left: 38px !important;
    }

    .password-requirements {
        background: #e3f2fd;
        border-left: 4px solid #4A90E2;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 13px;
        color: #004085;
    }

    .password-requirements ul {
        margin: 8px 0 0 20px;
        padding: 0;
    }

    .password-requirements li {
        margin: 3px 0;
    }

    .register-footer {
        text-align: center;
        margin-top: 25px;
        padding-top: 15px;
        border-top: 2px solid #FFD700;
        color: #666;
    }

    .register-footer a {
        color: #4A90E2;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .register-footer a:hover {
        color: #2E5C8A;
    }

    @media (max-width: 768px) {
        .register-card {
            padding: 20px;
        }

        .register-header {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <span>Crear Cuenta</span>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div class="error-content">
                    <div class="error-title">Errores en el formulario</div>
                    <div class="error-message">
                        @if ($errors->has('error'))
                            {{ $errors->first('error') }}
                        @else
                            Por favor, verifica los campos marcados y completa correctamente todos los datos requeridos.
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" novalidate>
            @csrf

            <div class="form-group @error('nombre') field-error @enderror">
                <label for="nombre">
                    <i class="fas fa-user" style="margin-right: 5px;"></i>Nombre *
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-pen-fancy"></i>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                           placeholder="Tu nombre">
                </div>
                @error('nombre')
                    <div class="form-error">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group @error('apellido') field-error @enderror">
                <label for="apellido">
                    <i class="fas fa-user" style="margin-right: 5px;"></i>Apellido *
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-pen-fancy"></i>
                    <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required
                           placeholder="Tu apellido">
                </div>
                @error('apellido')
                    <div class="form-error">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group @error('email') field-error @enderror">
                <label for="email">
                    <i class="fas fa-envelope" style="margin-right: 5px;"></i>Email *
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-at"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           placeholder="tu.email@ejemplo.com">
                </div>
                @error('email')
                    <div class="form-error">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group @error('password') field-error @enderror">
                <label for="password">
                    <i class="fas fa-lock" style="margin-right: 5px;"></i>Contraseña *
                </label>
                <div class="password-requirements">
                    <strong><i class="fas fa-info-circle"></i> Requisitos:</strong>
                    <ul>
                        <li>Mínimo 6 caracteres</li>
                        <li>Usa mayúsculas, minúsculas y números para mayor seguridad</li>
                    </ul>
                </div>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required
                           placeholder="Crea una contraseña segura">
                </div>
                @error('password')
                    <div class="form-error">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group @error('password_confirmation') field-error @enderror">
                <label for="password_confirmation">
                    <i class="fas fa-lock" style="margin-right: 5px;"></i>Confirmar Contraseña *
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           placeholder="Confirma tu contraseña">
                </div>
                @error('password_confirmation')
                    <div class="form-error">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 16px;">
                <i class="fas fa-user-plus"></i> Registrarse
            </button>
        </form>

        <div class="register-footer">
            ¿Ya tienes cuenta? 
            <a href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Inicia sesión aquí
            </a>
        </div>
    </div>
</div>
@endsection
