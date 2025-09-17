2025-09-17

- Limpieza: `UpdateUserRequest.php` sobrescrito para eliminar definiciones duplicadas que causaban errores de compilación.
- Validación: `StoreUserRequest.php` verificado; reglas de validación y authorize presentes.
- Controlador: `UserController` actualizado para hashear contraseñas en create/update y sincronizar roles.
- Vistas: CRUD de usuarios (index/create/edit/show/_form) adaptadas para usar `<x-layouts.app>`, modo oscuro y componentes Flux; columna "Rol" añadida.
- Estado actual: compilación PHP limpia respecto a los errores por clases duplicadas; quedan por añadir tests de Feature/Unit para cubrir create/update/validación/autorización.
2025-09-17
- Añadido endpoint GET /debug/permissions para retornar JSON con la lista de permisos (id, name, guard_name). Sólo accesible a usuarios con rol `SuperAdmin`.
- Ruta implementada en `routes/web.php` y protegida con middleware `auth` + chequeo de rol.
- Seeder `RoutePermissionsSeeder` creado previamente para automatizar la creación de permisos usados por el sidebar.
- Se recomienda ejecutar `php artisan db:seed` si necesitás crear los permisos en una instalación nueva.
### Los Pilares de la Arquitectura del Sistema
#### 1. Motor de Flujos de Trabajo Dinámico (Ecosistemas) 🌐
Esta es la mejora más importante. La lógica de negocio deja de estar "quemada" en el código y pasa a ser completamente configurable desde un panel de administración.
Ecosistemas: La plataforma permitirá crear "Ecosistemas" o áreas de trabajo independientes (ej: "Área Legal", "Área Administrativa"). Cada una tendrá sus propios usuarios, flujos y reglas.
Flujos Configurables: Un administrador de cada ecosistema podrá diseñar visualmente el ciclo de vida de una actuación: definir los estados (ej: "En Revisión Legal", "Aprobado por Gerencia"), y las transiciones (quién puede mover un caso de un estado a otro y bajo qué condiciones).
Flexibilidad por Tipo de Actuación: Se podrán crear distintos flujos para diferentes tipos de actuación dentro del mismo ecosistema. Un trámite simple puede tener 3 pasos, mientras que uno complejo puede tener 7, todo configurable sin necesidad de un programador.
#### 2. Gestión de Roles y Permisos Granulares 🔐
El manejo de usuarios se vuelve mucho más sofisticado y seguro.
Roles Ilimitados y Configurables: Un administrador podrá crear, modificar o eliminar roles ("Agente", "Revisor", "Auditor", etc.) según las necesidades de la organización.
Selector de Rol por Sesión: Los usuarios con múltiples responsabilidades (ej: un "Agente" que también es "Revisor") deberán elegir con qué "sombrero" ingresan al sistema en cada sesión. Esto asegura que solo tengan los permisos y la vista correspondiente a la tarea que van a realizar, evitando errores y conflictos.
Roles de "Solo Lectura": Se podrán crear roles de consulta para gerentes, directores o auditores. Estos usuarios podrán ver el estado de las actuaciones según reglas específicas (ej: "ver todo lo del Área Legal" o "ver solo los casos listos para firma"), pero sin la capacidad de modificarlos.
#### 3. Administración Delegada y Jerárquica 🧑‍💼
Se establece una estructura de gobierno clara que fomenta la autonomía y la seguridad.
Superadministrador: Tendrá control total sobre la plataforma, incluyendo la creación de Ecosistemas y la asignación de sus administradores.
Administrador de Ecosistema: Cada área tendrá su propio administrador, quien gestionará los usuarios, roles y flujos de trabajo únicamente de su ecosistema. Esto descentraliza la gestión y da autonomía a cada departamento para adaptar el sistema a sus necesidades.
#### 4. Modernización Tecnológica y de Usuario ✨
La experiencia de uso y la base tecnológica darán un salto cualitativo.
Plataforma Robusta: Usar Laravel y MySQL nos da un sistema más rápido, seguro y capaz de manejar un volumen mucho mayor de datos y usuarios.
Interfaz Moderna: Se construirá una interfaz de usuario completamente nueva, más intuitiva y rápida, mejorando la experiencia del día a día.
Creación de Actuaciones desde el Sistema: Se elimina la dependencia de Google Sheets. Las nuevas actuaciones se crearán a través de un formulario web controlado, asegurando que los datos ingresen de forma correcta y auditable desde el inicio.
#### 5. Auditoría Completa y Control de Tiempos ⏱️
Se introduce un registro inmutable de cada acción realizada en el sistema.
Historial Completo: Cada cambio de estado, modificación de datos o asignación quedará registrado en un historial detallado, respondiendo siempre a las preguntas: quién, qué y cuándo.
Métricas y Reportes: Este historial es una mina de oro para la gestión. Permitirá generar reportes precisos sobre los tiempos de cada etapa, identificar cuellos de botella y medir el rendimiento del proceso.
De un Vistazo: Antes y Después
Característica
Sistema Actual (Google Sheets)
Nuevo Sistema (Plataforma Laravel)
Lógica de Negocio
Rígida, programada en el código.
Flexible, configurable en la base de datos.
Flujos de Trabajo
Un único flujo para todos.
Múltiples flujos por "Ecosistema" y tipo de actuación.
Gestión de Roles
Limitada. Requiere un programador para cambios.
Ilimitada. Un administrador crea y modifica roles.
Creación de Casos
Manual, directamente en la hoja de cálculo.
Controlada, a través de un formulario web.
Permisos
Mezclados para usuarios con múltiples roles.
Aislados por sesión con un selector de rol.
Administración
Centralizada y técnica.
Delegada a los administradores de cada Ecosistema.
Trazabilidad
Limitada a las últimas modificaciones.
Total y detallada, con un historial de cada acción.
Escalabilidad
Baja, limitada por la tecnología de Sheets.
Alta, preparada para el crecimiento de la organización.

---

Beneficios Clave
Agilidad: La organización podrá adaptar sus procesos de negocio rápidamente sin depender de ciclos de desarrollo de software.
Autonomía: Cada área o "Ecosistema" gestiona sus propios flujos y usuarios.
Seguridad: El acceso granular, el selector de roles y el control centralizado aumentan la seguridad de los datos.
Escalabilidad: La plataforma está diseñada para crecer junto con la organización, soportando más usuarios, más áreas y procesos más complejos sin problemas.

---

Plan de Implementación Detallado


Fase 0: Preparación del Entorno de Desarrollo (Fundamentos)

El objetivo de esta fase es tener un proyecto Laravel limpio y listo para empezar a construir.
1. Instalar Herramientas Requeridas:
PHP (versión compatible con Laravel 12).
Composer (para gestionar las dependencias de PHP).
Node.js y npm (para las herramientas de frontend).
Un servidor de base de datos MySQL (o MariaDB).
Un cliente de base de datos (como DBeaver o TablePlus).
2. Crear el Proyecto Laravel:
En tu terminal, ejecuta: composer create-project laravel/laravel sistema_actuaciones
Esto creará una nueva carpeta sistema_actuaciones con la última versión de Laravel.
3. Configuración Inicial (Framework):
Conexión a la Base de Datos: Abre el archivo .env en la raíz del proyecto. Configura las credenciales de tu base de datos local:
Fragmento de código
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=actuaciones_db
DB_USERNAME=root
DB_PASSWORD=tu_contraseña


Crear la Base de Datos (Base de Datos): Usando tu cliente de base de datos, crea una nueva base de datos vacía llamada actuaciones_db.
4. Control de Versiones:
Inicializa un repositorio de Git en la carpeta del proyecto (git init). Realiza el primer commit para guardar el estado inicial.

Fase 1: Construcción del Esquema de la Base de Datos

Aquí creamos el esqueleto de nuestra base de datos usando las "migraciones" de Laravel, que son como un control de versiones para la estructura de la base de datos.
1. Crear las Migraciones (Framework):
Ejecuta los siguientes comandos de Artisan en tu terminal. Laravel creará un archivo de migración para cada tabla en la carpeta database/migrations/.
Bash
php artisan make:migration create_roles_table
php artisan make:migration create_ecosistemas_table
php artisan make:migration create_flujos_trabajo_table
php artisan make:migration create_estados_table
php artisan make:migration create_actuaciones_table
php artisan make:migration create_transiciones_table
php artisan make:migration create_historial_actuaciones_table
php artisan make:migration create_permisos_lectura_table
php artisan make:migration create_ecosistema_administrador_table


Laravel ya incluye una migración para la tabla users.
2. Definir las Columnas y Relaciones (Base de Datos):
Abre cada uno de los archivos de migración generados y define las columnas y claves foráneas que diseñamos. Por ejemplo, para create_actuaciones_table:
PHP
// database/migrations/xxxx_xx_xx_xxxxxx_create_actuaciones_table.php
Schema::create('actuaciones', function (Blueprint $table) {
    $table->id();
    $table->string('numero_expediente')->unique();
    $table->string('motivo');
    // ... otras columnas ...
    $table->foreignId('estado_id')->constrained('estados');
    $table->foreignId('asignado_id')->constrained('usuarios');
    $table->foreignId('flujo_trabajo_id')->constrained('flujos_trabajo');
    $table->timestamps();
    $table->timestamp('cerrado_en')->nullable();
});


3. Ejecutar las Migraciones (Base de Datos):
Una vez definidas todas las migraciones, ejecuta: php artisan migrate
Este comando creará todas las tablas y relaciones en tu base de datos actuaciones_db.
4. Crear los Modelos (Framework):
Crea un modelo Eloquent para cada tabla. Esto le permite a Laravel interactuar con tus tablas de forma orientada a objetos.
Bash
php artisan make:model Rol
php artisan make:model Ecosistema
php artisan make:model FlujoTrabajo
// ... y así para cada tabla ...


Dentro de cada archivo de modelo (en app/Models/), define las relaciones (ej: belongsTo, hasMany).

Fase 2: Lógica de Negocio y Autenticación

Con la base de datos lista, construimos el cerebro de la aplicación.
1. Configurar Autenticación para SPA (Framework):
Instala y configura Laravel Sanctum para manejar la autenticación de forma segura entre el backend y el frontend. composer require laravel/sanctum
2. Crear el ServicioFlujoTrabajo (Framework):
Crea una carpeta app/Services y dentro, el archivo ServicioFlujoTrabajo.php.
Programa el método realizarTransicion() que contendrá la lógica principal para verificar y ejecutar los cambios de estado.
3. Desarrollar la API (Framework):
Define las rutas en routes/api.php (ej: GET /actuaciones, PUT /actuaciones/{id}).
Crea el ActuacionController (php artisan make:controller Api/ActuacionController --api).
Implementa los métodos del controlador, que recibirán las peticiones, llamarán al ServicioFlujoTrabajo y devolverán las respuestas en formato JSON.
4. Implementar el Selector de Rol (Framework):
Crea una ruta y un controlador para la página "Seleccionar Rol".
Modifica el sistema de login para que, después de una autenticación exitosa, verifique la cantidad de roles del usuario y lo redirija a la página principal o al selector de rol según corresponda.

Fase 3: Panel de Administración

Esta es la interfaz que te permitirá configurar los flujos sin tocar código.
1. Elegir e Instalar una Herramienta de Administración (Framework):
Opciones recomendadas: Filament (gratuito y muy potente) o Laravel Nova (oficial, de pago).
Sigue las instrucciones de instalación de la herramienta elegida.
2. Crear los "Recursos" de Administración (Framework):
Configura un CRUD (Crear, Leer, Actualizar, Borrar) para cada modelo clave: Ecosistemas, Usuarios, Roles, Flujos de Trabajo, Estados y, fundamentalmente, Transiciones.
Esta interfaz debe ser muy visual e intuitiva, permitiendo a un administrador crear un flujo completo seleccionando estados y roles de listas desplegables.
3. Cargar el Flujo Inicial (Base de Datos):
Usando el panel de administración recién creado, configura el primer "Ecosistema" y mapea el flujo de trabajo actual (el que describiste: Agente -> Revisor -> Firmante -> Agente).

Fase 4: Migración de Datos y Despliegue

1. Crear el Script de Migración (Framework):
Crea un comando de Artisan personalizado: php artisan make:command MigrarDatosSheets
Dentro de este comando, programa la lógica para leer los datos desde un archivo CSV (exportado desde Google Sheets) y, usando los modelos de Eloquent, insertarlos en las nuevas tablas de MySQL, mapeando los antiguos valores a los nuevos IDs.
2. Ejecutar la Migración (Base de Datos):
Corre el comando php artisan app:migrar-datos-sheets. Este es un paso único y crucial que se realiza antes de la puesta en marcha.
3. Preparar para Despliegue (Framework):
Configura el entorno de producción (servidor web, base de datos de producción).
Sube el código al servidor.
Ejecuta los comandos de despliegue: composer install --no-dev, php artisan optimize, php artisan migrate --force.
Una vez completadas estas fases, tendrás el backend y la administración completamente funcionales. El siguiente gran paso sería el desarrollo del frontend (la SPA en Vue.js) que se conectará a la API que has construido.

---

🗃️ Fase 1: Construcción del Esquema de la Base de Datos
Hito 1.1: Generar las migraciones para las tablas principales ejecutando los comandos php artisan make:migration para: roles, ecosistemas, flujos_trabajo, estados, actuaciones, transiciones, historial_actuaciones, permisos_lectura, ecosistema_administrador.
Hito 1.2: Definir la estructura de columnas y relaciones (foreign keys) en el archivo de migración de actuaciones (incluyendo estado_id, asignado_id, flujo_trabajo_id).
Hito 1.3: Definir la estructura de columnas y relaciones en el resto de archivos de migración (siguiendo el diseño acordado).
Hito 1.4: Ejecutar todas las migraciones con php artisan migrate y verificar que todas las tablas se crearon correctamente en la base de datos actuaciones_db.
Hito 1.5: Generar los modelos Eloquent para cada tabla (Rol, Ecosistema, FlujoTrabajo, Estado, Actuacion, Transicion, HistorialActuacion, PermisoLectura, EcosistemaAdministrador) usando php artisan make:model.
Hito 1.6: Definir las relaciones Eloquent (belongsTo, hasMany, belongsToMany, etc.) dentro de cada modelo.
⚙️ Fase 2: Lógica de Negocio y Autenticación
Hito 2.1: Instalar y configurar Laravel Sanctum para autenticación de API: composer require laravel/sanctum y seguir los pasos de configuración oficial.
Hito 2.2: Crear la carpeta app/Services y dentro, el archivo ServicioFlujoTrabajo.php.
Hito 2.3: Implementar el método realizarTransicion() en ServicioFlujoTrabajo.php con la lógica de validación de roles, campos obligatorios y cambio de estado.
Hito 2.4: Definir las rutas API en routes/api.php para gestionar actuaciones (GET, POST, PUT, DELETE).
Hito 2.5: Crear el controlador Api/ActuacionController con php artisan make:controller Api/ActuacionController --api.
Hito 2.6: Implementar los métodos del controlador (index, store, show, update, destroy) para interactuar con el servicio y devolver respuestas JSON.
Hito 2.7: Crear una ruta y un controlador para la página "Selector de Rol" (ej: RoleSelectionController).
Hito 2.8: Modificar el flujo de login para que, tras autenticar, redirija al usuario a la página principal si tiene un solo rol, o al selector de rol si tiene múltiples roles.
🖥️ Fase 3: Panel de Administración
Hito 3.1: Elegir e instalar una herramienta de administración (Filament o Laravel Nova) siguiendo su guía oficial de instalación.
Hito 3.2: Crear el recurso de administración para Ecosistema (CRUD completo).
Hito 3.3: Crear el recurso de administración para Rol (CRUD completo).
Hito 3.4: Crear el recurso de administración para FlujoTrabajo (CRUD completo).
Hito 3.5: Crear el recurso de administración para Estado (CRUD completo).
Hito 3.6: Crear el recurso de administración para Transicion, con una interfaz visual que permita seleccionar el estado origen, destino y el rol responsable desde listas desplegables.
Hito 3.7: Crear el recurso de administración para Usuario (gestión de roles y asignación a ecosistemas).
Hito 3.8: Crear el recurso de administración para EcosistemaAdministrador (asignar administradores a ecosistemas).
Hito 3.9: Usar el panel de administración para crear el primer ecosistema de prueba (ej: "Recursos Humanos").
Hito 3.10: Configurar el primer flujo de trabajo en el panel (ej: "Solicitud de Vacaciones": Agente → Revisor → Firmante → Agente).
🔄 Fase 4: Migración de Datos y Despliegue
Hito 4.1: Crear un comando Artisan personalizado: php artisan make:command MigrarDatosSheets.
Hito 4.2: Implementar la lógica en el comando MigrarDatosSheets para leer un archivo CSV y mapear sus datos a los modelos Eloquent, insertándolos en la base de datos.
Hito 4.3: Preparar el archivo CSV de prueba con datos reales (o de ejemplo) para validar la migración.
Hito 4.4: Ejecutar el comando de migración en el entorno local: php artisan app:migrar-datos-sheets y verificar que los datos se cargaron correctamente.
Hito 4.5: Configurar el entorno de producción (servidor, base de datos, variables de entorno).
Hito 4.6: Subir el código fuente al servidor de producción (vía Git, FTP, o el método elegido).
Hito 4.7: Ejecutar en producción: composer install --no-dev para instalar dependencias.
Hito 4.8: Ejecutar en producción: php artisan migrate --force para crear las tablas.
Hito 4.9: Ejecutar en producción: php artisan optimize para optimizar el rendimiento.
Hito 4.10: Ejecutar el comando de migración de datos en producción para cargar los datos reales.