# Servicio RESTful de Productos

## 📋 Descripción General

Se ha implementado un servicio RESTful completo para listar y gestionar productos (calzados) en la aplicación. El servicio utiliza una arquitectura de herencia donde `ProductoRestfulService` hereda de `RestfulController` para reutilizar métodos comunes de respuestas JSON.

---

## 🏗️ Estructura de Clases

### 1. **RestfulController** (Clase Base)
**Ubicación:** `app/Http/Controllers/RestfulController.php`

Clase base que proporciona métodos auxiliares para respuestas JSON estandarizadas.

#### Métodos disponibles:

```php
// Respuesta exitosa simple
protected function successResponse($data, $message, $code)
```
- **Parámetros:**
  - `$data`: Los datos a devolver
  - `$message`: Mensaje descriptivo (default: "Operación exitosa")
  - `$code`: Código HTTP (default: 200)
- **Retorna:** JsonResponse con estructura `{success, message, data}`

**Ejemplo de respuesta:**
```json
{
  "success": true,
  "message": "Operación exitosa",
  "data": { /* datos aquí */ }
}
```

---

```php
// Respuesta de error
protected function errorResponse($message, $code, $errors)
```
- **Parámetros:**
  - `$message`: Descripción del error
  - `$code`: Código HTTP (default: 400)
  - `$errors`: Array con detalles de errores (opcional)
- **Retorna:** JsonResponse con estructura `{success: false, message, errors}`

**Ejemplo de respuesta:**
```json
{
  "success": false,
  "message": "Error al listar productos",
  "errors": null
}
```

---

```php
// Respuesta paginada
protected function paginatedResponse($data, $message, $code)
```
- **Parámetros:**
  - `$data`: Objeto paginado de Laravel
  - `$message`: Mensaje descriptivo
  - `$code`: Código HTTP (default: 200)
- **Retorna:** JsonResponse con datos + información de paginación

**Ejemplo de respuesta:**
```json
{
  "success": true,
  "message": "Productos listados correctamente",
  "data": [ /* productos */ ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 50,
    "last_page": 4,
    "from": 1,
    "to": 15
  }
}
```

---

### 2. **ProductoRestfulService** (Clase Derivada)
**Ubicación:** `app/Http/Controllers/ProductoRestfulService.php`

Servicio que hereda de `RestfulController` e implementa la lógica de negocio para productos.

#### Métodos disponibles:

#### 📌 `listar(Request $request)`
Lista todos los productos con paginación.

**Parámetros de query:**
- `per_page` (int): Productos por página (default: 15)
- `page` (int): Número de página (default: 1)

**Ejemplo de uso:**
```
GET /api/productos
GET /api/productos?per_page=10&page=1
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Productos listados correctamente",
  "data": [
    {
      "id": 1,
      "categoria_id": 2,
      "modelo": "Nike Air Max",
      "marca": "Nike",
      "talla": "42",
      "color": "Negro",
      "precio": 150000,
      "stock": 25,
      "imagen": "nike-air-max.jpg",
      "descripcion": "Zapato deportivo de alta calidad"
    },
    /* más productos */
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 45,
    "last_page": 3,
    "from": 1,
    "to": 15
  }
}
```

---

#### 📌 `listarPorCategoria(Request $request, $categoriaId)`
Lista productos filtrados por categoría.

**Parámetros:**
- `$categoriaId` (int): ID de la categoría
- `per_page` (query): Productos por página (default: 15)

**Ejemplo de uso:**
```
GET /api/productos/categoria/2
GET /api/productos/categoria/2?per_page=20
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Productos por categoría listados correctamente",
  "data": [ /* productos de la categoría */ ],
  "pagination": { /* info de paginación */ }
}
```

**Respuesta si no hay productos:**
```json
{
  "success": true,
  "message": "Productos por categoría listados correctamente",
  "data": [],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 0,
    "last_page": 1,
    "from": null,
    "to": null
  }
}
```

---

#### 📌 `obtener($id)`
Obtiene un producto específico por su ID.

**Parámetros:**
- `$id` (int): ID del producto

**Ejemplo de uso:**
```
GET /api/productos/5
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Producto obtenido correctamente",
  "data": {
    "id": 5,
    "categoria_id": 1,
    "modelo": "Adidas Ultra Boost",
    "marca": "Adidas",
    "talla": "43",
    "color": "Blanco",
    "precio": 180000,
    "stock": 12,
    "imagen": "adidas-ultra-boost.jpg",
    "descripcion": "Zapato premium para correr"
  }
}
```

**Respuesta si no existe (404):**
```json
{
  "success": false,
  "message": "Producto no encontrado",
  "errors": null
}
```

---

#### 📌 `buscar(Request $request)`
Busca productos por término en modelo, marca o color.

**Parámetros de query:**
- `q` (string): Término de búsqueda (requerido)
- `per_page` (int): Productos por página (default: 15)

**Ejemplo de uso:**
```
GET /api/productos/buscar?q=nike
GET /api/productos/buscar?q=negro&per_page=10
GET /api/productos/buscar?q=adidas&page=2
```

**Respuesta exitosa (200):**
```json
{
  "success": true,
  "message": "Búsqueda completada correctamente",
  "data": [ /* productos que coinciden */ ],
  "pagination": { /* info de paginación */ }
}
```

**Respuesta si no proporciona término (400):**
```json
{
  "success": false,
  "message": "El término de búsqueda es requerido",
  "errors": null
}
```

---

## 🛣️ Rutas API

Todas las rutas están prefijadas con `/api/productos`:

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/productos` | Listar todos los productos |
| GET | `/api/productos/{id}` | Obtener un producto específico |
| GET | `/api/productos/categoria/{id}` | Listar por categoría |
| GET | `/api/productos/buscar` | Buscar productos |

---

## 📚 Ejemplos de uso con cURL

### Listar todos los productos
```bash
curl -X GET "http://localhost/api/productos"
```

### Listar con paginación personalizada
```bash
curl -X GET "http://localhost/api/productos?per_page=20&page=1"
```

### Obtener un producto específico
```bash
curl -X GET "http://localhost/api/productos/5"
```

### Listar productos de una categoría
```bash
curl -X GET "http://localhost/api/productos/categoria/2"
```

### Buscar productos
```bash
curl -X GET "http://localhost/api/productos/buscar?q=nike"
```

---

## 🔧 Cómo usar en JavaScript/Frontend

### Listar productos
```javascript
fetch('/api/productos')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Productos:', data.data);
      console.log('Total:', data.pagination.total);
    }
  });
```

### Obtener un producto
```javascript
fetch('/api/productos/5')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      console.log('Producto:', data.data);
    } else {
      console.log('Producto no encontrado');
    }
  });
```

### Buscar productos
```javascript
const termino = 'nike';
fetch(`/api/productos/buscar?q=${termino}`)
  .then(response => response.json())
  .then(data => {
    console.log('Resultados de búsqueda:', data.data);
  });
```

### Con async/await
```javascript
async function obtenerProductos() {
  try {
    const response = await fetch('/api/productos?per_page=10');
    const data = await response.json();
    
    if (data.success) {
      console.log('Productos:', data.data);
      console.log('Página actual:', data.pagination.current_page);
      console.log('Total de páginas:', data.pagination.last_page);
    }
  } catch (error) {
    console.error('Error:', error);
  }
}
```

---

## 🔍 Estructura de respuestas

### Respuesta exitosa
```json
{
  "success": true,
  "message": "...",
  "data": { /* o array */ },
  "pagination": { /* solo en métodos que paginen */ }
}
```

### Respuesta de error
```json
{
  "success": false,
  "message": "...",
  "errors": null
}
```

---

## ⚠️ Códigos HTTP utilizados

| Código | Situación |
|--------|-----------|
| 200 | Operación exitosa |
| 400 | Solicitud inválida (ej: falta parámetro requerido) |
| 404 | Recurso no encontrado |
| 500 | Error interno del servidor |

---

## 🎯 Ventajas de esta arquitectura

✅ **Reutilización de código:** Los métodos de respuesta JSON se heredan  
✅ **Consistencia:** Todas las respuestas siguen el mismo formato  
✅ **Mantenibilidad:** Fácil de extender con más servicios  
✅ **Escalabilidad:** Nuevos servicios pueden heredar de `RestfulController`  
✅ **Documentación clara:** Respuestas estructuradas y predecibles  

---

## 📝 Notas

- Todas las respuestas JSON incluyen un campo `success` para fácil validación en el frontend
- La paginación es automática en métodos que lo requieren
- Las búsquedas son case-insensitive (no distinguen mayúsculas/minúsculas)
- Los errores están capturados y devuelven mensajes descriptivos

