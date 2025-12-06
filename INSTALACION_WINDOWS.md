# 🪟 Guía de Instalación en Windows - TuSabor

## 📋 Requisitos Previos

Antes de comenzar, necesitas instalar lo siguiente en tu Windows:

### 1. XAMPP (Incluye PHP y MySQL)
- Descargar desde: https://www.apachefriends.org/
- Instalar XAMPP en `C:\xampp`
- Versión recomendada: PHP 8.1 o superior

### 2. Composer (Gestor de dependencias de PHP)
- Descargar desde: https://getcomposer.org/download/
- Ejecutar el instalador para Windows
- Verificar instalación: abrir CMD y ejecutar `composer --version`

### 3. Node.js (Para compilar assets)
- Descargar desde: https://nodejs.org/
- Instalar la versión LTS (Long Term Support)
- Verificar instalación: abrir CMD y ejecutar `node --version`

---

## 🚀 Pasos de Instalación

### Paso 1: Descomprimir el Proyecto

1. Descomprimir `tusabor-proyecto-completo.zip`
2. Mover la carpeta `tusabor` a `C:\xampp\htdocs\`
3. La ruta final debe ser: `C:\xampp\htdocs\tusabor`

### Paso 2: Iniciar XAMPP

1. Abrir **XAMPP Control Panel**
2. Iniciar **Apache**
3. Iniciar **MySQL**

### Paso 3: Crear Base de Datos

1. Abrir navegador y ir a: http://localhost/phpmyadmin
2. Clic en "Nueva" (o "New") en el panel izquierdo
3. Nombre de la base de datos: `tusabor`
4. Cotejamiento: `utf8mb4_unicode_ci`
5. Clic en "Crear"

### Paso 4: Configurar el Proyecto

1. Abrir **CMD** o **PowerShell** como Administrador
2. Navegar a la carpeta del proyecto:
```cmd
cd C:\xampp\htdocs\tusabor
```

3. Copiar archivo de configuración:
```cmd
copy .env.example .env
```
*(Si .env ya existe, omitir este paso)*

4. Editar el archivo `.env` con Notepad o cualquier editor:
```
Buscar las líneas:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tusabor
DB_USERNAME=root
DB_PASSWORD=

Dejar DB_PASSWORD vacío (sin contraseña) si es instalación por defecto de XAMPP
```

### Paso 5: Instalar Dependencias de PHP

En CMD/PowerShell dentro de `C:\xampp\htdocs\tusabor`:

```cmd
composer install
```

**Nota:** Este proceso puede tardar varios minutos.

### Paso 6: Generar Clave de Aplicación

```cmd
php artisan key:generate
```

### Paso 7: Ejecutar Migraciones y Seeders

```cmd
php artisan migrate
php artisan db:seed
```

### Paso 8: Importar Procedimientos Almacenados

**Opción A - Desde CMD:**
```cmd
C:\xampp\mysql\bin\mysql -u root tusabor < database\stored_procedures.sql
```

**Opción B - Desde phpMyAdmin:**
1. Ir a http://localhost/phpmyadmin
2. Seleccionar base de datos `tusabor`
3. Clic en pestaña "SQL"
4. Abrir el archivo `database\stored_procedures.sql` con Notepad
5. Copiar todo el contenido
6. Pegar en el área de texto de phpMyAdmin
7. Clic en "Continuar" o "Go"

### Paso 9: Crear Enlace de Storage

```cmd
php artisan storage:link
```

### Paso 10: Instalar Dependencias de Node.js

```cmd
npm install
```

**Nota:** Este proceso puede tardar varios minutos.

### Paso 11: Compilar Assets

```cmd
npm run build
```

### Paso 12: Iniciar el Servidor

```cmd
php artisan serve
```

Verás un mensaje como:
```
INFO  Server running on [http://127.0.0.1:8000]
```

---

## 🌐 Acceder a la Aplicación

Abrir navegador y visitar: **http://localhost:8000**

---

## 👥 Usuarios de Prueba

### Administrador
- **Email:** admin@tusabor.com
- **Contraseña:** admin123

### Cliente
- **Email:** cliente@tusabor.com
- **Contraseña:** cliente123

---

## 🔧 Solución de Problemas Comunes en Windows

### Error: "composer no se reconoce como comando"
**Solución:** Reiniciar CMD/PowerShell después de instalar Composer, o reiniciar Windows.

### Error: "php no se reconoce como comando"
**Solución:** 
1. Agregar PHP a las variables de entorno:
   - Buscar "Variables de entorno" en Windows
   - Editar la variable "Path"
   - Agregar: `C:\xampp\php`
2. Reiniciar CMD/PowerShell

### Error: "SQLSTATE[HY000] [1045] Access denied"
**Solución:** Verificar que en `.env`:
- `DB_USERNAME=root`
- `DB_PASSWORD=` (vacío, sin nada después del =)

### Error: "npm no se reconoce como comando"
**Solución:** Reiniciar CMD/PowerShell después de instalar Node.js, o reiniciar Windows.

### Error al ejecutar migraciones
**Solución:** 
1. Verificar que MySQL esté corriendo en XAMPP
2. Verificar que la base de datos `tusabor` exista en phpMyAdmin

### Puerto 8000 ya en uso
**Solución:** Usar otro puerto:
```cmd
php artisan serve --port=8080
```
Luego acceder a: http://localhost:8080

### Página en blanco o Error 500
**Solución:**
1. Dar permisos a las carpetas:
```cmd
icacls "C:\xampp\htdocs\tusabor\storage" /grant Everyone:(OI)(CI)F /T
icacls "C:\xampp\htdocs\tusabor\bootstrap\cache" /grant Everyone:(OI)(CI)F /T
```

---

## 📱 Chatbot con IA (Opcional)

Si quieres activar el chatbot, necesitas una API Key de OpenAI:

1. Obtener API Key en: https://platform.openai.com/api-keys
2. Editar `.env` y agregar:
```
OPENAI_API_KEY=sk-tu-api-key-aqui
```
3. Reiniciar el servidor (`Ctrl+C` y luego `php artisan serve`)

**Nota:** El chatbot es opcional. Si no tienes API Key, la aplicación funciona perfectamente sin él.

---

## 🎯 Verificar que Todo Funciona

1. ✅ Página principal carga correctamente
2. ✅ Puedes iniciar sesión con admin@tusabor.com
3. ✅ Dashboard muestra estadísticas
4. ✅ Puedes crear categorías y productos
5. ✅ Puedes iniciar sesión como cliente@tusabor.com
6. ✅ Catálogo muestra productos
7. ✅ Puedes agregar productos al carrito

---

## 📞 Comandos Útiles

**Detener el servidor:**
- Presionar `Ctrl + C` en la ventana de CMD donde está corriendo

**Limpiar caché:**
```cmd
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**Ver rutas disponibles:**
```cmd
php artisan route:list
```

**Resetear base de datos (CUIDADO: borra todos los datos):**
```cmd
php artisan migrate:fresh --seed
```

---

## ✅ Checklist de Instalación

- [ ] XAMPP instalado y corriendo (Apache + MySQL)
- [ ] Composer instalado
- [ ] Node.js instalado
- [ ] Proyecto descomprimido en `C:\xampp\htdocs\tusabor`
- [ ] Base de datos `tusabor` creada en phpMyAdmin
- [ ] Archivo `.env` configurado
- [ ] `composer install` ejecutado exitosamente
- [ ] `php artisan migrate` ejecutado exitosamente
- [ ] `php artisan db:seed` ejecutado exitosamente
- [ ] Procedimientos almacenados importados
- [ ] `npm install` ejecutado exitosamente
- [ ] `npm run build` ejecutado exitosamente
- [ ] Servidor corriendo con `php artisan serve`
- [ ] Aplicación accesible en http://localhost:8000

---

**¡Listo! Tu aplicación TuSabor está funcionando en Windows** 🎉
