<?php

namespace App\Http\Controllers;

use App\Services\ApiContactService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private ApiContactService $apiService;

    public function __construct(ApiContactService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Procesar registro
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $result = $this->apiService->register($validated);

        if ($result['success']) {
            session(['token' => $result['data']['token']]);
            session(['user' => $result['data']['user']]);
            return redirect()->route('contacts.index')->with('success', 'Registro exitoso');
        }

        return back()->withErrors(['error' => $result['message']])->withInput();
    }

    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $result = $this->apiService->login($validated);

        if ($result['success']) {
            session(['token' => $result['data']['token']]);
            session(['user' => $result['data']['user']]);
            return redirect()->route('contacts.index')->with('success', 'Inicio de sesión exitoso');
        }

        return back()->withErrors(['error' => $result['message']])->withInput();
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $token = session('token');

        if ($token) {
            $this->apiService->setToken($token)->logout();
        }

        session()->flush();
        return redirect()->route('login')->with('success', 'Sesión cerrada exitosamente');
    }

    /**
     * Ver perfil del usuario
     */
    public function profile()
    {
        $token = session('token');

        if (!$token) {
            return redirect()->route('login');
        }

        $result = $this->apiService->setToken($token)->getMe();

        if (!$result['success']) {
            session()->flush();
            return redirect()->route('login')->withErrors(['error' => 'Sesión expirada']);
        }

        return view('auth.profile', ['user' => $result['data']['user']]);
    }
}
