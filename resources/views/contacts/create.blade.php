@extends('layouts.app')

@section('title', 'Crear Contacto')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <h2 style="color: #4A90E2; margin-bottom: 30px; border-bottom: 2px solid #FFD700; padding-bottom: 15px;">Crear Nuevo Contacto</h2>

    <form action="{{ route('contacts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre *</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
            @error('nombre')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="apellido">Apellido *</label>
            <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
            @error('apellido')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono *</label>
            <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
            @error('telefono')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea id="direccion" name="direccion">{{ old('direccion') }}</textarea>
            @error('direccion')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">
                <i class="fas fa-save"></i> Guardar Contacto
            </button>
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">
                <i class="fas fa-ban"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
