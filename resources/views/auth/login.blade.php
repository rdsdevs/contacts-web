@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('extra-styles')
<style>
    .login-container {
        max-width: 500px;
        margin: 0 auto;
    }

    .login-card {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }

    .login-header {
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

    .error-hint {
        font-size: 13px;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        color: #5a1420;
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

    .login-footer {
        text-align: center;
        margin-top: 25px;
        padding-top: 15px;
        border-top: 2px solid #FFD700;
        color: #666;
    }

    .login-footer a {
        color: #4A90E2;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .login-footer a:hover {
        color: #2E5C8A;
    }

    @media (max-width: 768px) {
        .login-card {
            padding: 20px;
        }

        .login-header {
            font-size: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <i class="fas fa-lock"></i>
            <span>Iniciar Sesión</span>
        </div>

        @if ($errors->has('error'))
            <div class="error-alert">
                <i class="fas fa-exclamation-circle"></i>
                <div class="error-content">
                    <div class="error-title">Error de autenticación</div>
                    <div class="error-message">{{ $errors->first('error') }}</div>
                    <div class="error-hint">
                        <i class="fas fa-lightbulb"></i>
                        Verifica que tu email y contraseña sean correctos. Si no tienes cuenta, 
                        <a href="{{ route('register') }}" style="color: inherit; text-decoration: underline;">regístrate aquí</a>.
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" novalidate>
            @csrf

            <div class="form-group @error('email') field-error @enderror">
                <label for="email">
                    <i class="fas fa-envelope" style="margin-right: 5px;"></i>Email *
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-at"></i>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                           placeholder="tu.email@ejemplo.com"
                           style="@error('email') border-color: #FF6B6B; background-color: #fff5f5; @enderror">
                </div>
                @error('email')
                    <div class="form-error">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group @error('password') field-error @enderror">
                <label for="password">
                    <i class="fas fa-key" style="margin-right: 5px;"></i>Contraseña *
                </label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required 
                           placeholder="Ingresa tu contraseña"
                           style="@error('password') border-color: #FF6B6B; background-color: #fff5f5; @enderror">
                </div>
                @error('password')
                    <div class="form-error">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 16px;">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>

        <div class="login-footer">
            ¿No tienes cuenta? 
            <a href="{{ route('register') }}">
                <i class="fas fa-user-plus"></i> Regístrate aquí
            </a>
        </div>
    </div>
</div>
@endsection
