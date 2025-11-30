@extends('layouts.app')

@section('title', 'Detalles del Contacto')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div style="background: #f8f9fa; padding: 30px; border-radius: 8px;">
        <h2 style="color: #4A90E2; margin-bottom: 30px; border-bottom: 2px solid #FFD700; padding-bottom: 15px;">
            {{ $contact['nombre'] ?? '' }} {{ $contact['apellido'] ?? '' }}
        </h2>

        <div class="form-group">
            <label><i class="fas fa-envelope"></i> Email</label>
            <p style="color: #333; font-size: 16px; padding: 10px; background: white; border-radius: 4px; border-left: 3px solid #4A90E2;">
                {{ $contact['email'] ?? 'N/A' }}
            </p>
        </div>

        <div class="form-group">
            <label><i class="fas fa-phone"></i> Teléfono</label>
            <p style="color: #333; font-size: 16px; padding: 10px; background: white; border-radius: 4px; border-left: 3px solid #4A90E2;">
                {{ $contact['telefono'] ?? 'N/A' }}
            </p>
        </div>

        @if($contact['direccion'] ?? null)
            <div class="form-group">
                <label><i class="fas fa-map-marker-alt"></i> Dirección</label>
                <p style="color: #333; font-size: 16px; padding: 10px; background: white; border-radius: 4px; border-left: 3px solid #4A90E2; white-space: pre-wrap;">
                    {{ $contact['direccion'] }}
                </p>
            </div>
        @endif

        <div class="form-group">
            <label><i class="fas fa-clock"></i> Registrado</label>
            <p style="color: #666; font-size: 14px; padding: 10px; background: white; border-radius: 4px; border-left: 3px solid #4A90E2;">
                {{ $contact['created_at'] ?? 'N/A' }}
            </p>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>
@endsection
