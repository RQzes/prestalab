# PrestaLab – Sistema de préstamo de equipos

Sistema web hecho en **Laravel** para controlar el préstamo de equipos del laboratorio (laptops, proyectores, kits Arduino, multímetros, etc.): qué equipo está disponible y quién tiene cada uno.

**Integrantes:** Simon Rodriguez Anculle, Xavi Mamani Machaca, Kevyn Parancco Nina, Erick Rimache Salcedo

## Qué hace
- Ingreso con correo y contraseña (mensaje claro si los datos son incorrectos) y cierre de sesión.
- Dos roles, cada uno con su panel (muestra nombre y rol):
  - **Encargado:** registra, ve, edita y elimina equipos; presta un equipo a un estudiante y registra su devolución.
  - **Estudiante:** solo consulta los equipos **disponibles**; no puede modificar nada.
- Datos en MySQL. Si falla la base de datos se muestra un mensaje entendible, no un error técnico.

## Requisitos
PHP 8.2+, Composer, Node.js 18+ (con npm) y MySQL/MariaDB (XAMPP o Laragon sirven).

## Instalación
```bash
git clone <URL-DEL-REPOSITORIO> prestalab
cd prestalab
composer install
npm install && npm run build
cp .env.example .env        # en Windows (cmd): copy .env.example .env
php artisan key:generate
```
1. Crea la base de datos vacía en MySQL:
   ```sql
   CREATE DATABASE prestalab CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Revisa en `.env` los datos de conexión (`DB_DATABASE=prestalab`, `DB_USERNAME=root`, `DB_PASSWORD=` según tu MySQL).
3. Crea las tablas y los datos de prueba, y arranca el servidor:
   ```bash
   php artisan migrate:fresh --seed
   php artisan serve
   ```
4. Abre <http://127.0.0.1:8000>.

## Usuarios de prueba
| Rol | Correo | Contraseña |
|---|---|---|
| Encargado | encargado@lab.com | password |
| Estudiante | ana@lab.com | password |
| Estudiante | luis@lab.com | password |

El seeder también crea **8 equipos** (2 laptops, 2 proyectores, 2 kits Arduino, 2 multímetros), todos disponibles.

## Organización del código (MVC)
| Capa | Archivos |
|---|---|
| Rutas | `routes/web.php` |
| Controladores | `app/Http/Controllers/EquipoController.php` (CRUD, préstamo, devolución), `PanelController.php` (panel según rol) |
| Modelos | `app/Models/Equipo.php`, `app/Models/User.php` |
| Vistas | `resources/views/panel/`, `resources/views/equipos/`, `resources/views/errors/bd.blade.php` |
| Middleware | `app/Http/Middleware/RolMiddleware.php` (restringe por rol) |
| Base de datos | `database/migrations/`, `database/seeders/DatabaseSeeder.php` |

Para el ingreso se usa el kit de inicio **Laravel Breeze (Blade)**.

## Cómo funciona la seguridad
- **Sesión:** al iniciar sesión, Laravel guarda el ID del usuario en la sesión (identificada por una cookie). `Auth::user()` / `auth()->user()` lo recupera en cada petición. Cerrar sesión la invalida.
- **Páginas protegidas:** el middleware `auth` agrupa todas las rutas internas; sin sesión redirige al login. El middleware `RolMiddleware` además impide que un Estudiante abra las páginas del Encargado.
- **Formularios:** `@csrf` protege contra peticiones falsificadas; `$request->validate()` valida y limpia los datos; Eloquent usa **consultas preparadas**, así que lo escrito en un formulario no puede alterar el SQL (evita inyección SQL). Blade escapa la salida (`{{ }}`) contra XSS.
- **Errores de base de datos:** los controladores capturan `QueryException` y muestran un mensaje amable; además `bootstrap/app.php` tiene un manejador global que muestra `errors/bd.blade.php`.
- **Contraseñas:** guardadas con hash (bcrypt), nunca en texto plano.
