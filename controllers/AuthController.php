<?php
// controllers/AuthController.php
//include 'config/secure-session.php';

class AuthController                                   // la clase AuthController contiene un objeto usuario (el que autentica)
{
    private $userModel;

    public function __construct()                     // aquí lo crea
    {
        $this->userModel = new User();
    }

    public function login()                           // aquí ejecuta el login (en realidad, la vista login)
    {
        // Carga la vista del formulario de login
        include 'views/login.php';
    }

    public function authenticate()                    // aquí confronta con la base de datos
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {

                // variable de sesión de attempts que controla las veces
                // que el usuario hace login
                if (!isset($_SESSION['attempts'])) {
                    $_SESSION['attempts'] = 0;
                }

                if(!isset($_SESSION['next_attempt'])) {
                    $_SESSION['next_attempt'] = 900; // tiempo de espera de 15 mins para nuevo intento
                }

                if(!isset($_SESSION['last_attempt'])) {
                    $_SESSION['last_attempt'] = time(); // tiempo transcurrido desde el último intento
                }

                if(!isset($_SESSION['blocked'])) {
                    $_SESSION['blocked'] = false; // indica si el usuario está bloqueado
                }

                if(time() - $_SESSION['last_attempt'] > $_SESSION['next_attempt'] && $_SESSION['attempts'] >=5) {
                    // si ha pasado el tiempo de espera, reseteamos los intentos
                    $_SESSION['attempts'] = 0;
                    $_SESSION['next_attempt'] = 900; // reseteamos el tiempo de espera a 15 mins
                    $_SESSION['last_attempt'] = time();
                    $_SESSION['blocked'] = false;
                }

                // 'restringe' el acceso
                if ($_SESSION['attempts'] >= 5) {

                    $_SESSION['blocked'] = true;
                    $_SESSION['error'] = "You have exceeded the number of attempts allowed. Please try again later.";
                    include 'views/login.php';

                } else {

                    $username = htmlspecialchars($_POST['agentId']);
                    $password = htmlspecialchars($_POST['passwd']);

                    $login = $this->userModel->login($username, $password);

                    // comrpbaciones de las credenciales
                    if ($login === 'u_notfound') {
                        // Usuario inexistente o incorrecto, redireccion al enrutador para enviar de vuelta al login
                        $_SESSION['error'] = "User not found.";
                        $_SESSION['attempts']++; // aumento de numero de attempts fallidos
                        include 'views/login.php';
                    
                    } else if ($login === 'p_notfound') {
                        // Contraseña incorrecta, redireccion al enrutador para enviar de vuelta al login
                        $_SESSION['error'] = "Incorrect password.";
                        $_SESSION['attempts']++;
                        include 'views/login.php';

                    } else {
                        // Autenticación exitosa, iniciar sesión y redirigir al enrutador para que éste envíe al dashboard-inicio
                        $_SESSION['idusuario'] = $username;
                        $_SESSION['attempts'] = 0;
                        header('Location: index.php?action=dashboard');
                        exit();
                    }
                }

            } else {
                $_SESSION['error'] = "Credentials required to access the system.";
                include 'views/login.php';
            }

        } else {
            $_SESSION['error'] = "Invalid request.";
            include 'views/login.php';
        }
    }

    public function dashboard()
    {
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['idusuario'])) {
            header('Location: index.php?action=login');
            exit();
        }
        // Carga la vista del dashboard (página de bienvenida)
        $_SESSION['usuario_logueado'] = true;
        include 'views/dashboard.php';
    }

    public function logout()
    {
        // restablece los datos de la sesión para el resto del tiempo de ejecución
        $_SESSION = [];
        // envía como Set-Cookie para invalidar la cookie de sesión
        /*** destruccion de cookies de forma explicita y otras potencialmente peligrosas ***/
        if (isset($_COOKIE[session_name()])) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 60, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
        }

        session_destroy();

        $_SESSION['error'] = "Logout successful.";
        header('Location: index.php?action=login');
        exit();
    }
}