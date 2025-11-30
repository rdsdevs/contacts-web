<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Contacts Web')</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #4A90E2 0%, #2E5C8A 100%);
            min-height: 100vh;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 4px solid #FFD700;
        }

        header h1 {
            font-size: 24px;
            color: #4A90E2;
        }

        nav {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        nav a, nav form {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #4A90E2;
        }

        nav .user-info {
            color: #4A90E2;
            font-weight: 600;
        }

        nav form {
            display: inline;
        }

        nav button {
            background: #4A90E2;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.3s;
        }

        nav button:hover {
            background: #2E5C8A;
        }

        main {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #FFD700;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            border-left: 4px solid;
        }

        .alert-success {
            background-color: #d4f5e8;
            color: #0d6c47;
            border-color: #1ABC9C;
        }

        .alert-error {
            background-color: #fde8e8;
            color: #c2185b;
            border-color: #FF6B6B;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
            border-left: 3px solid #FFD700;
            padding-left: 8px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        textarea:focus {
            outline: none;
            border-color: #4A90E2;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-error {
            font-size: 13px;
            color: #FF6B6B;
            margin-top: 5px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #4A90E2;
            color: white;
        }

        .btn-primary:hover {
            background: #2E5C8A;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(74, 144, 226, 0.4);
        }

        .btn-secondary {
            background: #FFD700;
            color: #333;
        }

        .btn-secondary:hover {
            background: #FFC700;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
        }

        .btn-danger {
            background: #FF6B6B;
            color: white;
        }

        .btn-danger:hover {
            background: #E55555;
        }

        .text-center {
            text-align: center;
        }

        .text-muted {
            color: #999;
        }

        footer {
            text-align: center;
            color: white;
            margin-top: 30px;
            font-size: 14px;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            nav {
                width: 100%;
                flex-wrap: wrap;
            }

            main {
                padding: 20px;
            }
        }
    </style>
    @yield('extra-styles')
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-address-book"></i> ContactsWeb</h1>
            <nav>
                @if(session('token'))
                    <span class="user-info">{{ session('user')['nombre'] ?? 'Usuario' }}</span>
                    <a href="{{ route('profile') }}">Perfil</a>
                    <a href="{{ route('contacts.index') }}">Contactos</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                    <a href="{{ route('register') }}">Registrarse</a>
                @endif
            </nav>
        </header>

        <main>
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-error">{{ $error }}</div>
                @endforeach
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @yield('content')
        </main>

        <footer>
            <p>&copy; 2025 ContactsWeb. Gestiona tus contactos fácilmente.</p>
        </footer>
    </div>
</body>
</html>
