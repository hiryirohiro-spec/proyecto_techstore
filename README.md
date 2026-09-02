<p align="center">
  <img src="https://placehold.co/120x120/22d3ee/0b0f19?text=%E2%9A%A1" width="90" alt="TechStore Logo">
</p>

<h1 align="center">TechStore ⚡</h1>

<p align="center">
  Tienda online de electrónica construida con <strong>Laravel 12</strong>. Catálogo de productos, carrito de compras, checkout e impuestos locales (bolivianos) y panel de administración completo.
</p>

---

## Descripción

**TechStore** es una aplicación web de comercio electrónico desarrollada con **Laravel 12** que permite explorar y comprar productos de electrónica (laptops, smartphones, audífonos, televisores, consolas y más). Incluye un **panel de administración** para gestionar productos, categorías, ventas e inventario, y una experiencia de compra completa con **moneda boliviana (Bs)** e **IVA del 13%**.

## Características

- **Tienda pública**: catálogo con filtros por categoría, ordenamiento y búsqueda; productos destacados y nuevos ingresos.
- **Requiere inicio de sesión**: los visitantes son redirigidos al login antes de acceder a la tienda.
- **Carrito de compras**: agregar, actualizar cantidades, eliminar y vaciar.
- **Checkout**: métodos de pago locales (tarjeta, efectivo, transferencia bancaria, QR/Pagomóvil), dirección de envío y notas; cálculo automático de **IVA 13%**.
- **Sistema de pedidos**: historial de compras por usuario con código de venta y detalle.
- **Panel de administración**: dashboard con métricas (ingresos, ventas, ticket promedio, inventario bajo).
  - **Productos**: CRUD completo con categorías, imágenes, precios, costos, stock y estados (activo, agotado, defectuoso).
  - **Categorías**: CRUD con conteo de productos.
  - **Ventas**: listado con filtros y detalle de cada venta con sus ítems e impuestos.
  - **Inventario**: monitoreo de stock y alertas de productos con pocas unidades.
- **Moneda e impuestos bolivianos**: precios reales de mercado en **bolivianos (Bs)** y **IVA 13%**.
- **Tema visual**: fondo oscuro con luces **neón** animadas, tipografía moderna y **imágenes reales** de los productos.
- **Autenticación**: registro e inicio de sesión con roles `admin` y `cliente`.

## Requisitos

- PHP >= 8.2
- Composer
- SQLite (por defecto) u otro motor soportado por Laravel

## Instalación

```bash
# 1. Instalar dependencias
composer install

# 2. Configurar entorno
copy .env.example .env        # Windows
php artisan key:generate

# 3. Base de datos (SQLite por defecto)
#    Asegúrate de que exista database/database.sqlite (tocar archivo vacío en Windows):
type nul > database\database.sqlite

# 4. Migrar y sembrar datos de demostración
php artisan migrate:fresh --seed

# 5. Vínculo del almacenamiento (para imágenes)
php artisan storage:link

# 6. Servidor local
php artisan serve
```

## Credenciales de demostración

| Rol | Correo | Contraseña |
| --- | --- | --- |
| Administrador | `admin@techstore.com` | `admin123` |
| Cliente | `cliente@techstore.com` | `cliente123` |

> Cambia las credenciales de los usuarios demo antes de usar el sistema en producción.

## Roles y permisos

| Módulo | Admin | Cliente |
| --- | --- | --- |
| Tienda / catálogo | ✓ | ✓ |
| Carrito y checkout | ✓ | ✓ |
| Mis pedidos | ✓ | ✓ |
| Panel / dashboard | ✓ | — |
| Productos (CRUD) | ✓ | — |
| Categorías (CRUD) | ✓ | — |
| Ventas (listado y detalle) | ✓ | — |
| Inventario | ✓ | — |

## Moneda e impuestos

- **Moneda**: Boliviano (`Bs`) con formato local, p. ej. `Bs 14.500` o `Bs 12.500,50`.
- **Impuesto**: IVA boliviano del **13%** aplicado automáticamente en el checkout.
- **Métodos de pago**: tarjeta, efectivo, transferencia bancaria y QR / Pagomóvil.

## Rutas principales

| Ruta | Descripción |
| --- | --- |
| `/login`, `/registro` | Autenticación de usuarios |
| `/` | Inicio / tienda |
| `/tienda` | Catálogo de productos (filtros y búsqueda) |
| `/tienda/{slug}` | Detalle de producto |
| `/carrito` | Carrito de compras |
| `/checkout` | Proceso de compra |
| `/mis-pedidos` | Historial de pedidos del usuario |
| `/admin` | Panel de administración |
| `/admin/products` | Gestión de productos |
| `/admin/categories` | Gestión de categorías |
| `/admin/sales` | Ventas registradas |
| `/admin/inventory` | Control de inventario |

## Pruebas

```bash
php artisan test
```

La suite cubre la redirección de usuarios invitados al login y el acceso autenticado a la tienda.

## Stack

Laravel 12 · Blade · Bootstrap 5 · Bootstrap Icons · SQLite · PHPUnit

## Licencia

Proyecto de código abierto bajo la licencia [MIT](https://opensource.org/licenses/MIT).