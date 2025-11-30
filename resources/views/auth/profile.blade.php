@extends('layouts.app')

@section('title', 'Perfil de Usuario')

@section('extra-styles')
<style>
    .profile-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .profile-card {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, #4A90E2 0%, #2E5C8A 100%);
        color: white;
        padding: 30px;
        text-align: center;
    }

    .profile-header h1 {
        margin: 0;
        font-size: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .profile-header i {
        font-size: 32px;
    }

    .profile-content {
        padding: 30px;
    }

    .profile-field {
        margin-bottom: 25px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px;
        background: white;
        border-radius: 6px;
        border-left: 4px solid #4A90E2;
    }

    .profile-field-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e3f2fd;
        border-radius: 50%;
        color: #4A90E2;
        font-size: 18px;
    }

    .profile-field-content {
        flex: 1;
    }

    .profile-field-label {
        font-weight: 600;
        color: #4A90E2;
        margin-bottom: 5px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-field-value {
        color: #333;
        font-size: 16px;
        line-height: 1.6;
    }

    .profile-actions {
        display: flex;
        gap: 10px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 2px solid #FFD700;
    }

    .profile-actions a {
        flex: 1;
    }

    @media (max-width: 768px) {
        .profile-header h1 {
            font-size: 22px;
        }

        .profile-content {
            padding: 20px;
        }

        .profile-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <div class="profile-card">
        <div class="profile-header">
            <h1>
                <i class="fas fa-user-circle"></i>
                Mi Perfil
            </h1>
        </div>

        <div class="profile-content">
            <div class="profile-field">
                <div class="profile-field-icon">
                    <i class="fas fa-pen-fancy"></i>
                </div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Nombre</div>
                    <div class="profile-field-value">{{ $user['nombre'] ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="profile-field">
                <div class="profile-field-icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Apellido</div>
                    <div class="profile-field-value">{{ $user['apellido'] ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="profile-field">
                <div class="profile-field-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Email</div>
                    <div class="profile-field-value">{{ $user['email'] ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="profile-field">
                <div class="profile-field-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="profile-field-content">
                    <div class="profile-field-label">Registrado desde</div>
                    <div class="profile-field-value">{{ $user['created_at'] ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('contacts.index') }}" class="btn btn-primary">
                    <i class="fas fa-address-book"></i> Volver a Contactos
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
