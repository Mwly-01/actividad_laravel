# Taller de Laravel 11 — **Coworking & Reservas de Salas**

**Objetivo:** Repasar los comandos de Artisan centrados en **modelos**, **migraciones**, **seeders**, **factories** y **CRUDs**. Además, implementar **validaciones básicas** con enfoque de **API**.

> Temática: **Gestión de un Coworking** (reservas de salas). Se construirán recursos para manejar salas, espacios, membresías, reservas y pagos.
>

---

## Preparación

```bash
# Crear proyecto (ejemplo con Laravel 11)
composer create-project laravel/laravel:^11.6.1 coworking-api
cd coworking-api

# Copiar .env y configurar DB
cp .env.example .env
php artisan key:generate

# Instalar soporte API en Laravel 11 si no existe
php artisan install:api

# Ejecutar servidor
php artisan serve --host=0.0.0.0 --port=8000
```
Verifica conexión a la base de datos con:
```bash
php artisan migrate:status
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## 1) Modelado

> **Nota**: Mínimo 6 modelos

**Coworking (salas y reservas).**

- **User** (Laravel por defecto)
- **Member** (perfil del usuario como miembro del coworking)
- **Plan** (plan de membresía: Basic, Pro, Enterprise)
- **Space** (sede o piso del coworking)
- **Room** (sala dentro de un `Space`)
- **Amenity** (amenidades: proyector, pizarra, TV, etc.)
- **Booking** (reserva de una `Room` por un `Member`)
- **Payment** (pago asociado a una reserva o a un plan)
- **Invoice** (comprobante/factura emitida por un pago)

Relaciones sugeridas:
- `Member belongsTo User`
- `Member belongsTo Plan`
- `Space hasMany Room`
- `Room belongsTo Space`
- `Room belongsToMany Amenity` (N:M con tabla pivote `amenity_room`)
- `Booking belongsTo Member` y `Booking belongsTo Room`
- `Payment belongsTo Booking`
- `Invoice belongsTo Payment`

**Ejercicio 1 — Crear modelos con migración y factory**
```bash
php artisan make:model Member    -m -f
php artisan make:model Plan      -m -f
php artisan make:model Space     -m -f
php artisan make:model Room      -m -f
php artisan make:model Amenity   -m -f
php artisan make:model Booking   -m -f
php artisan make:model Payment   -m -f
php artisan make:model Invoice   -m -f
```
> Revisa `database/migrations` y define columnas siguiendo los enunciados de cada tabla (abajo).

### 1.1 Estructuras mínimas de migraciones 

> Las siguientes estructuras solo son una **guía** o **sugerencia**.

**plans**
```php
$table->id();
$table->string('name', 80)->unique();          // Basic, Pro, Enterprise
$table->unsignedInteger('monthly_hours');      // Horas incluidas/mes
$table->unsignedInteger('guest_passes')->default(0);
$table->decimal('price', 10, 2);
$table->timestamps();
```
**members**
```php
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
$table->foreignId('plan_id')->constrained()->cascadeOnDelete();
$table->string('company')->nullable();
$table->date('joined_at')->nullable();
$table->timestamps();
```
**spaces**

```php
$table->id();
$table->string('name', 120);
$table->string('address')->nullable();
$table->timestamps();
```
**rooms**
```php
$table->id();
$table->foreignId('space_id')->constrained()->cascadeOnDelete();
$table->string('name', 120);
$table->unsignedInteger('capacity');
$table->enum('type', ['meeting','workshop','phonebooth','auditorium']);
$table->boolean('is_active')->default(true);
$table->timestamps();
```
**amenities**
```php
$table->id();
$table->string('name', 80)->unique();  // projector, whiteboard, tv, etc.
$table->timestamps();
```
**amenity_room** (pivote N:M)
```php
$table->id();
$table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
$table->foreignId('room_id')->constrained()->cascadeOnDelete();
$table->timestamps();
$table->unique(['amenity_id','room_id']);
```
**bookings**
```php
$table->id();
$table->foreignId('member_id')->constrained()->cascadeOnDelete();
$table->foreignId('room_id')->constrained()->cascadeOnDelete();
$table->dateTime('start_at');
$table->dateTime('end_at');
$table->enum('status',['pending','confirmed','cancelled'])->default('pending');
$table->string('purpose')->nullable();  // Reunión, Taller, etc.
$table->timestamps();
$table->index(['room_id','start_at','end_at']);
```
**payments**
```php
$table->id();
$table->foreignId('booking_id')->constrained()->cascadeOnDelete();
$table->enum('method',['card','cash','transfer']);
$table->decimal('amount', 10, 2);
$table->enum('status',['pending','paid','failed'])->default('pending');
$table->timestamps();
```
**invoices**
```php
$table->id();
$table->foreignId('payment_id')->constrained()->cascadeOnDelete();
$table->string('number', 40)->unique();
$table->date('issued_date');
$table->json('meta')->nullable(); // datos extra: razón social, nit, etc.
$table->timestamps();
```

**Ejercicio 2 — Ejecuta migraciones y valida estado**
```bash
php artisan migrate
php artisan migrate:status
```

---

## 2) Factories & Seeders
**Objetivo:** Poblar datos reales para pruebas rápidas.

**Ejercicio 3 — Crear seeders**
```bash
php artisan make:seeder PlanSeeder
php artisan make:seeder AmenitySeeder
php artisan make:seeder SpaceRoomSeeder
php artisan make:seeder MemberSeeder
php artisan make:seeder BookingPaymentSeeder
```

**Planes (PlanSeeder)**
```php
Plan::query()->insert([
  ['name'=>'Basic','monthly_hours'=>10,'guest_passes'=>1,'price'=>99.00,'created_at'=>now(),'updated_at'=>now()],
  ['name'=>'Pro','monthly_hours'=>30,'guest_passes'=>3,'price'=>249.00,'created_at'=>now(),'updated_at'=>now()],
  ['name'=>'Enterprise','monthly_hours'=>100,'guest_passes'=>10,'price'=>799.00,'created_at'=>now(),'updated_at'=>now()],
]);
```
**Amenidades (AmenitySeeder)**
```php
collect(['projector','whiteboard','tv','conference_speaker','coffee_machine'])
  ->each(fn($n)=> Amenity::create(['name'=>$n]));
```
**Spaces/Rooms (SpaceRoomSeeder)**
- Crea 2–3 `Space` con 3–5 `Room` cada uno (usa factories).
- Asigna aleatoriamente 1–3 amenidades a cada sala (`attach`).

**Members (MemberSeeder)**
- Crea 5–10 `User` y su `Member` asociado con un `Plan` aleatorio.

**Bookings/Payments (BookingPaymentSeeder)**
- Genera reservas válidas (sin solaparse por `Room`).
- Crea `Payment` para algunas reservas (método aleatorio).

**RoomFactory**

```php
public function definition(): array {
  return [
    'space_id' => Space::factory(),
    'name'     => fake()->unique()->bothify('Sala-###'),
    'capacity' => fake()->numberBetween(2, 30),
    'type'     => fake()->randomElement(['meeting','workshop','phonebooth','auditorium']),
    'is_active'=> true,
  ];
}
```

**BookingFactory**

```php
public function definition(): array {
  $start = fake()->dateTimeBetween('+1 day', '+10 days');
  $end   = (clone $start)->modify('+2 hours');
  return [
    'member_id' => Member::factory(),
    'room_id'   => Room::factory(),
    'start_at'  => $start,
    'end_at'    => $end,
    'status'    => 'pending',
  ];
}
```



**Ejercicio 4 — Registrar seeders en `DatabaseSeeder` y ejecutar**
```php
$this->call([
  PlanSeeder::class,
  AmenitySeeder::class,
  SpaceRoomSeeder::class,
  MemberSeeder::class,
  BookingPaymentSeeder::class,
  //...
]);
```
```bash
php artisan db:seed
# o puedes reiniciar todo:
php artisan migrate:fresh --seed
```

---

## 3) CRUDs con enfoque API

Crea controladores API y rutas con `apiResource`.

**Ejercicio 5 — Generar controladores API**

```bash
php artisan make:controller PlanController --api
php artisan make:controller SpaceController --api
php artisan make:controller RoomController --api
php artisan make:controller AmenityController --api
php artisan make:controller MemberController --api
php artisan make:controller BookingController --api
php artisan make:controller PaymentController --api
php artisan make:controller InvoiceController --api
```
**Rutas `routes/api.php`**
```php
Route::apiResources([
  'plans'     => PlanController::class,
  'spaces'    => SpaceController::class,
  'rooms'     => RoomController::class,
  'amenities' => AmenityController::class,
  'members'   => MemberController::class,
  'bookings'  => BookingController::class,
  'payments'  => PaymentController::class,
  'invoices'  => InvoiceController::class,
]);
// Relación amenities<->rooms (atach/detach) como endpoints específicos:
Route::post('rooms/{room}/amenities/{amenity}', [RoomController::class,'attachAmenity']);
Route::delete('rooms/{room}/amenities/{amenity}', [RoomController::class,'detachAmenity']);
```

---

## 4) Validación básica con **Form Requests**

**Ejercicio 6 — Crear Requests**
```bash
php artisan make:request StoreRoomRequest
php artisan make:request UpdateRoomRequest
php artisan make:request StoreBookingRequest
php artisan make:request UpdateBookingRequest
```
**Reglas mínimas sugeridas**
**StoreRoomRequest**
```php
public function rules(): array {
  return [
    'space_id'  => ['required','exists:spaces,id'],
    'name'      => ['required','string','min:3','max:120','unique:rooms,name'],
    'capacity'  => ['required','integer','min:1','max:200'],
    'type'      => ['required','in:meeting,workshop,phonebooth,auditorium'],
    'is_active' => ['boolean'],
  ];
}
```
**StoreBookingRequest**
```php
public function rules(): array {
  return [
    'member_id' => ['required','exists:members,id'],
    'room_id'   => ['required','exists:rooms,id'],
    'start_at'  => ['required','date','after_or_equal:now'],
    'end_at'    => ['required','date','after:start_at'],
    'purpose'   => ['nullable','string','max:160'],
  ];
}
```
> **Reto:** Agrega validación para evitar **solapamiento** de reservas por sala (`room_id`) creando una **Regla personalizada** o validación en `withValidator` que consulte rangos (`start_at`–`end_at`).

**Uso en `RoomController@store` (ejemplo)**

```php
public function store(StoreRoomRequest $request) {
  $room = Room::create($request->validated());
  return response()->json($room, 201);
}
```
**Uso en `BookingController@store` (ejemplo)**
```php
public function store(StoreBookingRequest $request) {
  $data = $request->validated();
  // TODO: validar no-solapamiento aquí o con Rule custom
  $booking = Booking::create($data);
  return response()->json($booking, 201);
}
```

---

## 5) Endpoints con colecciones Postman

1. `GET /api/spaces` — listar sedes.
2. `POST /api/spaces` — crear `Space`.
3. `POST /api/rooms` — crear sala (con `StoreRoomRequest`).
4. `POST /api/rooms/{room}/amenities/{amenity}` — asociar amenidad.
5. `GET /api/rooms?space_id=...` — filtrar por sede.
6. `POST /api/bookings` — crear reserva (validada).
7. `PUT /api/bookings/{id}` — actualizar horarios.
8. `POST /api/payments` — registrar pago.
9. `POST /api/invoices` — emitir factura.
10. `GET /api/members/{id}/bookings` — reservas por miembro.

**Payloads de ejemplo**
**Crear Room**
```json
{
  "space_id": 1,
  "name": "Sala Norte 301",
  "capacity": 10,
  "type": "meeting",
  "is_active": true
}
```
**Crear Booking**
```json
{
  "member_id": 2,
  "room_id": 5,
  "start_at": "2025-09-05 14:00:00",
  "end_at": "2025-09-05 16:00:00",
  "purpose": "Reunión proyecto A"
}
```

---

## 6) Retos

> **Nota:** Los retos deben resolverse en orden (Básico → Intermedio → Avanzado).
> Para obtener la puntuación de cada nivel es obligatorio **completar todos los retos de ese nivel**.
> Si un camper quiere alcanzar el nivel **Avanzado (18 puntos)**, deberá haber completado previamente todos los retos de **Básico (5 puntos)** e **Intermedio (12 puntos)**.

**Básico** *5 puntos*

- Implementar **Soft Deletes** en los modelos `rooms` y `bookings`, agregando los endpoints necesarios para **restaurar registros eliminados** con **soft deletes** .
- Agregar **paginación** y **filtros dinámicos** en los listados (por ejemplo: `?status=confirmed&space_id=1`).

**Intermedio** *12 puntos*

- Crear validación que evite el **solapamiento de reservas** en una misma sala (`room_id`) usando consultas de rangos de fechas (`start_at`–`end_at`).
- Implementar una **BookingPolicy** para que únicamente el **miembro dueño de la reserva** pueda cancelarla.
- Configurar un **BookingObserver** para que, al confirmar una reserva, se genere automáticamente un `Payment` con estado `pending`.

**Avanzado** *18 puntos*

- Implementar **Rate Limiting**: restringir la creación de reservas, por ejemplo a un máximo de **3 reservas por minuto por usuario**.

> **Regla final:** Para obtener los **18 puntos máximos del nivel Avanzado**, el camper debe completar **todos los retos de Básico e Intermedio además del reto Avanzado**.

---

## Comandos Artisan

```bash
php artisan list
php artisan help make:model
php artisan make:model X -m -f
php artisan make:migration add_column_to_table --table=table
php artisan migrate / migrate:rollback / migrate:fresh --seed
php artisan make:seeder XSeeder && php artisan db:seed --class=XSeeder
php artisan make:factory XFactory
php artisan make:controller XController --api
php artisan make:request StoreXRequest
php artisan route:list
php artisan tinker
php artisan config:cache && php artisan route:cache && php artisan cache:clear
```

---

## Criterios de evaluación

- Estructura de **migraciones** y **relaciones** correcta.
- Uso de **factories** y **seeders** coherente y reproducible.
- Endpoints **RESTful** con **validación** y estados HTTP adecuados, usando `Traits`.
- Cobertura de **Artisan** (creación, migración, seed, factory, controladores, requests).
- Claridad de código y **convenciones** de Laravel.

---

## Entregables

- Repositorio con:
  - `app/Models` completos y relaciones.
  - `database/migrations`, `database/factories`, `database/seeders`.
  - Controladores API + Requests de validación.
  - `routes/api.php` con recursos y endpoints adicionales.
  - Colección de Postman/Insomnia exportada.
- Instrucciones en `README.md` para correr `migrate:fresh --seed`.
