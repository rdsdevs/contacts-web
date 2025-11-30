<?php

namespace App\Http\Controllers;

use App\Services\ApiContactService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private ApiContactService $apiService;

    public function __construct(ApiContactService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Listar contactos
     */
    public function index(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login')->withErrors(['error' => 'Debe iniciar sesión']);
        }

        $token = session('token');
        $page = $request->get('page', 1);

        $result = $this->apiService->setToken($token)->listContacts($page);

        if (!$result['success']) {
            return redirect()->route('login')->withErrors(['error' => 'Error al cargar contactos']);
        }

        $contacts = $result['data']['data'] ?? [];
        $pagination = $result['data']['links'] ?? null;

        return view('contacts.index', compact('contacts', 'pagination'));
    }

    /**
     * Mostrar formulario crear contacto
     */
    public function create()
    {
        if (!session('token')) {
            return redirect()->route('login')->withErrors(['error' => 'Debe iniciar sesión']);
        }

        return view('contacts.create');
    }

    /**
     * Guardar nuevo contacto
     */
    public function store(Request $request)
    {
        if (!session('token')) {
            return redirect()->route('login')->withErrors(['error' => 'Debe iniciar sesión']);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'direccion' => 'nullable|string|max:500',
        ]);

        $token = session('token');
        $result = $this->apiService->setToken($token)->createContact($validated);

        if ($result['success']) {
            return redirect()->route('contacts.index')->with('success', 'Contacto creado exitosamente');
        }

        return back()->withErrors(['error' => $result['message']])->withInput();
    }

    /**
     * Ver detalle de contacto
     */
    public function show($id)
    {
        if (!session('token')) {
            return redirect()->route('login')->withErrors(['error' => 'Debe iniciar sesión']);
        }

        $token = session('token');
        $result = $this->apiService->setToken($token)->getContact($id);

        if (!$result['success']) {
            return redirect()->route('contacts.index')->withErrors(['error' => 'Contacto no encontrado']);
        }

        $contact = $result['data'];
        return view('contacts.show', compact('contact'));
    }
}
