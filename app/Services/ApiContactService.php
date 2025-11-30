<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ApiContactService
{
    private Client $client;
    private string $baseUrl;
    private int $timeout;
    private ?string $token = null;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
        $this->timeout = config('services.api.timeout');

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => $this->timeout,
            'verify' => false, // Para desarrollo local
        ]);
    }

    /**
     * Establecer token de autenticación
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Obtener headers por defecto con token si existe
     */
    private function getHeaders(): array
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if ($this->token) {
            $headers['Authorization'] = "Bearer {$this->token}";
        }

        return $headers;
    }

    /**
     * Registrar un nuevo usuario
     */
    public function register(array $data): array
    {
        try {
            $response = $this->client->post('/api/auth/register', [
                'json' => $data,
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            // Si es una respuesta 422 (validación), intentar obtener el mensaje del API
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();

            if ($statusCode === 422 || $statusCode === 400) {
                try {
                    $data = json_decode($response->getBody()->getContents(), true);
                    Log::error('Error en registro:', ['status' => $statusCode, 'error' => $data['message'] ?? 'Error desconocido']);
                    return [
                        'success' => false,
                        'message' => $data['message'] ?? 'Error al registrar usuario',
                    ];
                } catch (\Exception $parseError) {
                    Log::error('Error al parsear respuesta de registro:', ['error' => $parseError->getMessage()]);
                }
            }

            Log::error('Error en registro:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al registrar usuario',
            ];
        } catch (GuzzleException $e) {
            Log::error('Error en registro:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al registrar usuario',
            ];
        }
    }

    /**
     * Iniciar sesión
     */
    public function login(array $credentials): array
    {
        try {
            $response = $this->client->post('/api/auth/login', [
                'json' => $credentials,
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            // Si es una respuesta 401 o 422, intentar obtener el mensaje del API
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();

            if ($statusCode === 401 || $statusCode === 422) {
                try {
                    $data = json_decode($response->getBody()->getContents(), true);
                    Log::error('Error en login:', ['status' => $statusCode, 'error' => $data['message'] ?? 'Error desconocido']);
                    return [
                        'success' => false,
                        'message' => $data['message'] ?? 'Credenciales incorrectas',
                    ];
                } catch (\Exception $parseError) {
                    Log::error('Error al parsear respuesta de login:', ['error' => $parseError->getMessage()]);
                }
            }

            Log::error('Error en login:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al iniciar sesión',
            ];
        } catch (GuzzleException $e) {
            Log::error('Error en login:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al iniciar sesión',
            ];
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(): array
    {
        try {
            $response = $this->client->post('/api/auth/logout', [
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Error en logout:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al cerrar sesión: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Obtener datos del usuario autenticado
     */
    public function getMe(): array
    {
        try {
            $response = $this->client->get('/api/auth/me', [
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Error al obtener datos del usuario:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al obtener datos del usuario: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Listar contactos con paginación
     */
    public function listContacts(int $page = 1): array
    {
        try {
            $response = $this->client->get('/api/contacts', [
                'query' => ['page' => $page],
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Error al listar contactos:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al listar contactos: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Crear un nuevo contacto
     */
    public function createContact(array $data): array
    {
        try {
            $response = $this->client->post('/api/contacts', [
                'json' => $data,
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Error al crear contacto:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al crear contacto: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Obtener un contacto específico
     */
    public function getContact(int $id): array
    {
        try {
            $response = $this->client->get("/api/contacts/{$id}", [
                'headers' => $this->getHeaders(),
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Error al obtener contacto:', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Error al obtener contacto: ' . $e->getMessage(),
            ];
        }
    }
}
