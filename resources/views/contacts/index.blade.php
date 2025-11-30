@extends('layouts.app')

@section('title', 'Mis Contactos')

@section('extra-styles')
<style>
    .contacts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .contact-card {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        transition: all 0.3s ease;
        border-top: 3px solid #FFD700;
    }

    .contact-card:hover {
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
        border-color: #4A90E2;
        border-top: 3px solid #FFD700;
        transform: translateY(-2px);
    }

    .contact-name {
        font-size: 18px;
        font-weight: 700;
        color: #4A90E2;
        margin-bottom: 10px;
    }

    .contact-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-info label {
        font-weight: 600;
        margin: 0;
        min-width: 70px;
    }

    .contact-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #ddd;
    }

    .contact-actions a {
        flex: 1;
        text-align: center;
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .header-with-btn {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #FFD700;
    }

    @media (max-width: 768px) {
        .contacts-grid {
            grid-template-columns: 1fr;
        }

        .header-with-btn {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="header-with-btn">
    <h2 style="color: #4A90E2; margin: 0;">Mis Contactos</h2>
    <a href="{{ route('contacts.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo Contacto</a>
</div>

@if(count($contacts) > 0)
    <div class="contacts-grid">
        @foreach($contacts as $contact)
            <div class="contact-card">
                <div class="contact-name">
                    {{ $contact['nombre'] ?? '' }} {{ $contact['apellido'] ?? '' }}
                </div>

                <div class="contact-info">
                    <label><i class="fas fa-envelope"></i> Email:</label>
                    <span>{{ $contact['email'] ?? 'N/A' }}</span>
                </div>

                <div class="contact-info">
                    <label><i class="fas fa-phone"></i> Teléfono:</label>
                    <span>{{ $contact['telefono'] ?? 'N/A' }}</span>
                </div>

                @if($contact['direccion'] ?? null)
                    <div class="contact-info">
                        <label><i class="fas fa-map-marker-alt"></i> Dirección:</label>
                        <span>{{ $contact['direccion'] }}</span>
                    </div>
                @endif

                <div class="contact-actions">
                    <a href="{{ route('contacts.show', $contact['id']) }}" class="btn btn-secondary" style="flex: 1;">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    @if($pagination)
        <div style="margin-top: 30px; text-align: center;">
            <!-- Paginación aquí si es necesario -->
        </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-inbox" style="color: #4A90E2;"></i></div>
        <h3>No tienes contactos aún</h3>
        <p>Crea tu primer contacto para empezar a gestionar tu agenda</p>
        <a href="{{ route('contacts.create') }}" class="btn btn-primary" style="margin-top: 15px;">
            <i class="fas fa-plus"></i> Crear Primer Contacto
        </a>
    </div>
@endif
@endsection
