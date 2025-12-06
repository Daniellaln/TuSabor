# TuSabor - Sistema de Gestión de Restaurante

## 📋 Descripción del Proyecto

**TuSabor** es una aplicación web completa desarrollada en Laravel para la gestión integral de un restaurante fino. El sistema implementa arquitectura MVC, autenticación diferenciada por roles, y funcionalidades avanzadas como chatbot con IA, sistema de pedidos delivery y reservas de mesas.

## ✨ Características Principales

### Funcionalidades Generales
- ✅ Autenticación diferenciada (Admin/Cliente)
- ✅ Arquitectura MVC completa
- ✅ Base de datos relacional MySQL
- ✅ **7 Procedimientos almacenados**
- ✅ Chatbot con IA (OpenAI GPT-4)
- ✅ Diseño responsivo con colores de restaurante fino

### Panel de Administrador
- Dashboard con estadísticas en tiempo real
- CRUD completo de Categorías
- CRUD completo de Productos
- CRUD completo de Mesas
- Gestión de Pedidos (cambio de estados)
- Gestión de Reservas (confirmación/cancelación)

### Panel de Cliente
- Catálogo de productos con filtros
- Carrito de compras
- Sistema de pedidos delivery
- Sistema de reservas de mesas
- Chatbot de asistencia con IA

## 🚀 Instalación Local

### Requisitos Previos
- PHP >= 8.1
- Composer
- MySQL >= 8.0
- Node.js >= 18.x

### Paso 1: Instalar dependencias de PHP

```bash
cd tusabor
composer install
```

### Paso 2: Configurar base de datos

Editar el archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tusabor
DB_USERNAME=tu_usuario_mysql
DB_PASSWORD=tu_contraseña_mysql
```

### Paso 3: Crear base de datos

```bash
# En MySQL o phpMyAdmin
CREATE DATABASE tusabor;
```

### Paso 4: Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

### Paso 5: Importar procedimientos almacenados

```bash
mysql -u tu_usuario -p tusabor < database/stored_procedures.sql
```

### Paso 6: Configurar storage

```bash
php artisan storage:link
```

### Paso 7: Instalar dependencias de Node.js y compilar assets

```bash
npm install
npm run build
```

### Paso 8: Iniciar servidor

```bash
php artisan serve
```

Acceder a: `http://localhost:8000`

## 👥 Usuarios de Prueba

### Administrador
- **Email:** admin@tusabor.com
- **Contraseña:** admin123

### Cliente
- **Email:** cliente@tusabor.com
- **Contraseña:** cliente123

## 📦 Procedimientos Almacenados (7 implementados)

1. **sp_productos_por_categoria** - Obtiene productos disponibles por categoría
2. **sp_calcular_total_carrito** - Calcula el total del carrito de un usuario
3. **sp_estadisticas_ventas** - Genera estadísticas de ventas por período
4. **sp_productos_mas_vendidos** - Lista los productos más vendidos
5. **sp_verificar_disponibilidad_mesa** - Verifica disponibilidad de mesa para reserva
6. **sp_crear_pedido_desde_carrito** - Crea un pedido completo desde el carrito
7. **sp_reservas_por_fecha** - Obtiene reservas filtradas por fecha

## 🎨 Paleta de Colores

- **Borgoña:** #8B1538 (Color principal)
- **Dorado:** #D4AF37 (Acentos)
- **Crema:** #F5F5DC (Fondo)

## 🤖 Chatbot con IA (Opcional)

Para activar el chatbot, agregar en `.env`:

```env
OPENAI_API_KEY=tu_api_key
```

Si no tienes API key, el chatbot no funcionará pero el resto de la aplicación sí.

## 📁 Estructura del Proyecto

```
tusabor/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controladores admin
│   │   ├── Cliente/        # Controladores cliente
│   │   └── ChatbotController.php
│   ├── Models/             # Modelos Eloquent
│   └── Middleware/         # AdminMiddleware, ClienteMiddleware
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── stored_procedures.sql
├── resources/views/
└── routes/web.php
```

## 🔧 Solución de Problemas

### Error de conexión a base de datos
Verifica credenciales en `.env` y que MySQL esté corriendo.

### Error 500
Dar permisos de escritura:
```bash
chmod -R 775 storage bootstrap/cache
```

## 📝 Cumplimiento de Requisitos

✅ Laravel con arquitectura MVC
✅ Base de datos relacional MySQL
✅ **Mínimo 5 procedimientos almacenados (7 implementados)**
✅ Autenticación diferenciada (admin/cliente)
✅ CRUDs administrativos completos
✅ Dashboard con estadísticas
✅ Carrito de compras funcional
✅ Sistema de pedidos delivery
✅ Sistema de reservas de mesas
✅ Chatbot con IA (función adicional)

---

**Desarrollado para el curso de Base de Datos**
