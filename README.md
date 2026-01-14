# CCG Login System - PHP MVC
![MySQL](https://img.shields.io/badge/mysql-4479A1.svg?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white)
![CSS](https://img.shields.io/badge/css-%23663399.svg?style=for-the-badge&logo=css&logoColor=white)
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

**Tecnologías usadas:** PHP 7.4+, PDO (MySQL), Bootstrap 5, JavaScript (ES6), HTML5, CSS3, XAMPP (opción de despliegue), phpMyAdmin.

Una aplicación de autenticación desarrollada bajo el patrón MVC (Modelo-Vista-Controlador). Este sistema está pensado para gestionar el acceso de agentes (metafóricamente, los "investigadores" de CCG) con múltiples capas de protección en front y back.

## 🚀 Funcionalidades

+ Arquitectura MVC: separación de responsabilidades entre Modelo, Vista y Controlador para facilitar mantenimiento y pruebas.
+ Front Controller: `index.php` centraliza el enrutamiento y la resolución de acciones.
+ Medidas de seguridad integradas:
  - **CSRF**: tokens por formulario y verificación en servidor para mitigar falsificación de peticiones.
  - **Gestión de sesiones**: cookies con flags (HttpOnly, Secure recomendado, SameSite), regeneración periódica de `session_id` y expiración por inactividad.
  - **Mitigación de fuerza bruta**: límite de intentos y bloqueo temporal con registro de eventos.
  - **Prevención de inyección/XSS**: consultas parametrizadas (PDO) y escape/saneamiento de salidas.
+ Validación en dos capas: validación en cliente (JS) para UX y validación estricta en servidor (PHP) como fuente de confianza.

## 📁 Estructura del Proyecto

```
LOGIN_MVC2/
├── config/              # Configuración de BD y seguridad de sesión
│   ├── Database.php
│   └── secure-session.php
|
├── controllers/            # Lógica de control de flujo
│   └── AuthController.php
|
├── models/                 # Lógica de datos y acceso a BD
│   └── User.php
|
├── public/                 # Recursos estáticos (CSS, JS, Imágenes)
│   ├── css/
│   ├── img/
│   └── js/
│       └── validation.js
|
├── views/                  # Plantillas de interfaz de usuario
│   ├── dashboard.php
│   └── login.php
└── index.php               # Front Controller (Punto de entrada)
```

## ℹ️ Función de cada componente

- `config/Database.php` — Inicializa y devuelve una instancia PDO configurada para la base de datos.
- `config/secure-session.php` — Configura la política de sesión: parámetros de cookie, tiempo de expiración y mecanismos de regeneración de `session_id`.
- `controllers/AuthController.php` — Controlador de autenticación: valida entradas, maneja la lógica de login/logout, actualiza estado de sesión y redirige a las vistas.
- `models/User.php` — Encapsula acceso a la tabla de usuarios: consultas parametrizadas, verificación de credenciales y retorno de resultados (registro o códigos de error).
- `public/css/`, `public/js/`, `public/img/` — Recursos estáticos servidos por el servidor web; `validation.js` implementa validaciones en el cliente.
- `views/login.php` y `views/dashboard.php` — Plantillas que renderizan HTML; deben escapar contenido dinámico antes de imprimir.
- `index.php` — Front Controller: procesa la petición HTTP, instancia el controlador correspondiente y ejecuta la acción solicitada.

## 🛠️ Instalación y Uso con XAMPP

1. Copia la carpeta del proyecto dentro de `htdocs` de XAMPP (ej. `C:/xampp/htdocs/login_mvc2` o `/opt/lampp/htdocs/login_mvc2`).
2. Inicia Apache y MySQL desde el panel de control de XAMPP.
3. Abre `phpMyAdmin` en `http://localhost/phpmyadmin` e importa el script SQL incluido para crear la base de datos `login_php` y la tabla de usuarios.
4. Ajusta `config/Database.php` con las credenciales correctas si no coinciden con las del script.
5. Accede a la app en `http://localhost/login_mvc2/` o `http://localhost/login_mvc2/index.php?action=login`.

> Consejo: Si usas entornos Linux, asegúrate de que Apache puede leer los archivos (permisos) y que el puerto 80/443 no está en uso por otro proceso.

## 🔐 Seguridad

### Front-end

- Validación de entrada en cliente para mejorar UX y reducir tráfico inválido; nunca sustituye la validación del servidor.
- Escape y saneamiento de salida donde aplica para minimizar XSS; se recomienda aplicar Content Security Policy (CSP) en producción.
- Uso de componentes y atributos estándar (por ejemplo `data-bs-*`) para comportamiento predecible en UI.

### Back-end

- Acceso a BD mediante PDO con consultas parametrizadas para prevenir SQL Injection.
- Gestión de sesiones robusta: configuración de parámetros de cookie (HttpOnly, Secure, SameSite), regeneración de `session_id` y expiración por inactividad.
- CSRF: tokens vinculados a sesión y verificados en todas las rutas que procesan datos (POST).
- Protección contra fuerza bruta: contador de intentos, bloqueo temporal y logging para auditoría.

**Nota técnica:** El método `User::login()` actualmente compara contraseñas directamente; es recomendable migrar a almacenamiento y verificación con hashing seguro (`password_hash()` y `password_verify()`, p. ej. bcrypt o argon2).

## 📸 Capturas de Pantalla

![Login](/pictures/login.png "Pantalla de Login")
*Pantalla de acceso — los agentes se identifican con su Agent ID.*

![Dashboard](/pictures/dashboard.png "Dashboard")
*Dashboard — vista tras autenticación exitosa.*

> Las imágenes están en `pictures/login.png` y `pictures/dashboard.png`.

## 🧭 Uso básico

1. Importa la BD con phpMyAdmin.
2. Asegúrate de que `config/Database.php` tiene tus credenciales.
3. Accede a la URL del proyecto y usa un Agent ID registrado para iniciar sesión.