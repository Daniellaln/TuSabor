<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    /**
     * Procesar mensaje del chatbot con IA de OpenAI
     * Funciona para usuarios autenticados y no autenticados
     */
    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->message;
        $isAuthenticated = Auth::check();

        // Verificar si la pregunta requiere autenticación
        $requiresAuth = $this->requiereAutenticacion($userMessage);

        // Si requiere auth y no está autenticado, devolver mensaje
        if ($requiresAuth && !$isAuthenticated) {
            return response()->json([
                'response' => 'Para ayudarte con esto necesito que inicies sesión o te registres. Así podré darte una ayuda personalizada con tu pedido. 😊',
                'requires_auth' => true
            ]);
        }

        // Obtener información del contexto del restaurante
        $contexto = $this->obtenerContextoRestaurante($isAuthenticated);

        // Verificar si hay API key configurada
        $apiKey = env('OPENAI_API_KEY');
        
        if (!$apiKey) {
            // Si no hay API key, usar respuestas predefinidas
            return response()->json([
                'response' => $this->respuestaPredefinida($userMessage, $contexto, $isAuthenticated),
                'requires_auth' => $requiresAuth && !$isAuthenticated
            ]);
        }

        try {
            // Llamar a OpenAI API con contexto limitado
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->obtenerPromptSistema($contexto, $isAuthenticated)
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'max_tokens' => 200,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $botResponse = $data['choices'][0]['message']['content'] ?? 'Lo siento, no pude procesar tu pregunta.';
                
                return response()->json([
                    'response' => trim($botResponse),
                    'requires_auth' => false
                ]);
            } else {
                // Si falla la API, usar respuesta predefinida
                return response()->json([
                    'response' => $this->respuestaPredefinida($userMessage, $contexto, $isAuthenticated),
                    'requires_auth' => $requiresAuth && !$isAuthenticated
                ]);
            }

        } catch (\Exception $e) {
            // En caso de error, usar respuesta predefinida
            return response()->json([
                'response' => $this->respuestaPredefinida($userMessage, $contexto, $isAuthenticated),
                'requires_auth' => $requiresAuth && !$isAuthenticated
            ]);
        }
    }

    /**
     * Verificar si el mensaje requiere autenticación
     */
    private function requiereAutenticacion($mensaje)
    {
        $mensaje = strtolower($mensaje);
        
        $palabrasAuth = [
            'carrito', 'comprar', 'agregar', 'pedido', 'mis pedidos',
            'historial', 'cuenta', 'perfil', 'reserva', 'reservar',
            'pagar', 'checkout', 'orden'
        ];

        foreach ($palabrasAuth as $palabra) {
            if (str_contains($mensaje, $palabra)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Obtener contexto del restaurante desde la base de datos
     */
    private function obtenerContextoRestaurante($isAuthenticated = false)
    {
        try {
            // Obtener productos destacados
            $productosDestacados = DB::table('productos')
                ->where('destacado', true)
                ->where('disponible', true)
                ->select('nombre', 'descripcion', 'precio')
                ->limit(5)
                ->get();

            // Obtener categorías
            $categorias = DB::table('categorias')
                ->where('activo', true)
                ->pluck('nombre')
                ->toArray();

            // Obtener total de productos disponibles
            $totalProductos = DB::table('productos')
                ->where('disponible', true)
                ->count();

            $contexto = [
                'nombre_restaurante' => 'TuSabor',
                'descripcion' => 'Restaurante de alta cocina donde la tradición se encuentra con la innovación',
                'servicios' => ['Menú Gourmet', 'Delivery Rápido', 'Reserva de Mesas'],
                'horarios' => [
                    'lunes_jueves' => '12:00 PM - 10:00 PM',
                    'viernes_sabado' => '12:00 PM - 11:00 PM',
                    'domingos' => '12:00 PM - 9:00 PM'
                ],
                'ubicacion' => 'Av. Principal 123, Ciudad',
                'telefono' => '+51 999 888 777',
                'email' => 'contacto@tusabor.com',
                'metodos_pago' => ['Efectivo', 'Tarjetas', 'Yape', 'Plin'],
                'categorias' => $categorias,
                'total_productos' => $totalProductos,
                'productos_destacados' => $productosDestacados->map(function($p) {
                    return $p->nombre . ' - S/ ' . number_format($p->precio, 2);
                })->toArray(),
                'fundadora' => 'Daniella León Andrés',
                'valores' => ['Calidad', 'Innovación', 'Sostenibilidad'],
                'is_authenticated' => $isAuthenticated
            ];

            // Si está autenticado, agregar info del usuario
            if ($isAuthenticated) {
                $user = Auth::user();
                $contexto['user_name'] = $user->name;
                $contexto['user_email'] = $user->email;
            }

            return $contexto;
        } catch (\Exception $e) {
            return $this->contextoBasico($isAuthenticated);
        }
    }

    /**
     * Contexto básico si falla la consulta a BD
     */
    private function contextoBasico($isAuthenticated = false)
    {
        return [
            'nombre_restaurante' => 'TuSabor',
            'descripcion' => 'Restaurante de alta cocina',
            'servicios' => ['Menú Gourmet', 'Delivery', 'Reservas'],
            'horarios' => [
                'lunes_jueves' => '12:00 PM - 10:00 PM',
                'viernes_sabado' => '12:00 PM - 11:00 PM',
                'domingos' => '12:00 PM - 9:00 PM'
            ],
            'is_authenticated' => $isAuthenticated
        ];
    }

    /**
     * Prompt del sistema para limitar el chatbot SOLO a temas del restaurante
     */
    private function obtenerPromptSistema($contexto, $isAuthenticated)
    {
        $productosTexto = !empty($contexto['productos_destacados']) 
            ? implode(', ', $contexto['productos_destacados']) 
            : 'Consulta nuestro menú en línea';

        $categoriasTexto = !empty($contexto['categorias']) 
            ? implode(', ', $contexto['categorias']) 
            : 'Entradas, Platos principales, Postres, Bebidas';

        $authInfo = $isAuthenticated 
            ? "El usuario está autenticado como {$contexto['user_name']}. Puedes ayudarle con pedidos, carrito y reservas personalizadas."
            : "El usuario NO está autenticado. Solo puedes dar información general. Si pregunta por funciones personalizadas (carrito, pedidos, reservas), indícale que debe iniciar sesión.";

        return "Eres el asistente virtual de {$contexto['nombre_restaurante']}, un restaurante de alta cocina.

REGLAS ESTRICTAS - DEBES CUMPLIRLAS SIEMPRE:
1. SOLO puedes responder preguntas sobre el restaurante TuSabor
2. NO respondas preguntas sobre política, deportes, noticias, matemáticas, programación, etc.
3. Si te preguntan algo fuera del restaurante, responde: 'Lo siento, solo puedo ayudarte con información sobre TuSabor. ¿Tienes alguna pregunta sobre nuestro menú, reservas o servicios?'
4. Sé amable, profesional y conciso (máximo 3-4 oraciones)
5. Usa español y emojis apropiados

ESTADO DE AUTENTICACIÓN:
{$authInfo}

INFORMACIÓN DEL RESTAURANTE:
- Nombre: {$contexto['nombre_restaurante']}
- Descripción: {$contexto['descripcion']}
- Servicios: " . implode(', ', $contexto['servicios']) . "
- Horarios:
  * Lunes a Jueves: {$contexto['horarios']['lunes_jueves']}
  * Viernes y Sábado: {$contexto['horarios']['viernes_sabado']}
  * Domingos: {$contexto['horarios']['domingos']}
- Ubicación: {$contexto['ubicacion']}
- Teléfono: {$contexto['telefono']}
- Métodos de pago: " . implode(', ', $contexto['metodos_pago']) . "
- Categorías: {$categoriasTexto}
- Productos destacados: {$productosTexto}
- Fundadora: {$contexto['fundadora']}

TEMAS PERMITIDOS:
✅ Menú y productos
✅ Precios
✅ Horarios
✅ Ubicación
✅ Reservas (solo si está autenticado)
✅ Delivery
✅ Métodos de pago
✅ Historia del restaurante
✅ Pedidos (solo si está autenticado)

TEMAS PROHIBIDOS:
❌ Política, deportes, noticias
❌ Otros restaurantes
❌ Temas no relacionados con TuSabor";
    }

    /**
     * Respuestas predefinidas cuando no hay API key o falla la API
     */
    private function respuestaPredefinida($mensaje, $contexto, $isAuthenticated)
    {
        $mensaje = strtolower($mensaje);

        // Detectar palabras clave
        if (str_contains($mensaje, 'menu') || str_contains($mensaje, 'menú') || str_contains($mensaje, 'plato') || str_contains($mensaje, 'comida')) {
            $productos = !empty($contexto['productos_destacados']) 
                ? 'Algunos platos destacados: ' . implode(', ', array_slice($contexto['productos_destacados'], 0, 3)) . '. '
                : '';
            return $productos . 'Puedes ver nuestro menú completo en la sección Catálogo. 🍽️';
        }

        if (str_contains($mensaje, 'horario') || str_contains($mensaje, 'hora') || str_contains($mensaje, 'abierto')) {
            return "Nuestros horarios: Lunes a Jueves {$contexto['horarios']['lunes_jueves']}, Viernes y Sábado {$contexto['horarios']['viernes_sabado']}, Domingos {$contexto['horarios']['domingos']}. ⏰";
        }

        if (str_contains($mensaje, 'reserva') || str_contains($mensaje, 'mesa')) {
            if ($isAuthenticated) {
                return "Puedes hacer tu reserva desde nuestra sección de Reservas. También puedes llamarnos al {$contexto['telefono']}. 📅";
            } else {
                return "Para hacer una reserva, inicia sesión o regístrate. También puedes llamarnos al {$contexto['telefono']}. 📞";
            }
        }

        if (str_contains($mensaje, 'delivery') || str_contains($mensaje, 'domicilio')) {
            return "Sí, ofrecemos delivery. Haz tu pedido desde nuestro catálogo. Aceptamos " . implode(', ', $contexto['metodos_pago']) . ". 🚚";
        }

        if (str_contains($mensaje, 'ubicación') || str_contains($mensaje, 'ubicacion') || str_contains($mensaje, 'donde')) {
            return "Estamos en {$contexto['ubicacion']}. Contáctanos al {$contexto['telefono']}. 📍";
        }

        if (str_contains($mensaje, 'pago') || str_contains($mensaje, 'pagar')) {
            return "Aceptamos: " . implode(', ', $contexto['metodos_pago']) . ". 💳";
        }

        if (str_contains($mensaje, 'carrito') || str_contains($mensaje, 'comprar') || str_contains($mensaje, 'agregar')) {
            if (!$isAuthenticated) {
                return "Para agregar productos al carrito y hacer compras, necesitas iniciar sesión o registrarte. 🛒";
            }
        }

        // Respuesta por defecto
        return "Soy el asistente de TuSabor. Puedo ayudarte con información sobre nuestro menú, horarios, reservas y delivery. ¿En qué puedo ayudarte? 😊";
    }
}
