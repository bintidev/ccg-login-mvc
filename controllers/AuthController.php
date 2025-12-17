<?php

include './config/secure-session.php';
require_once 'models/Usuario.php';

class AuthController                                   // la clase AuthController contiene un objeto usuario (el que autentica)
{
    private $userModel;

    public function __construct()                     // aquí lo crea
    {
        $this->userModel = new Usuario();
    }

    public function login()                           // aquí ejecuta el login (en realidad, la vista login)
    {
        // Carga la vista del formulario de login
        header('Location: index.php?action=login');
        exit();
    }

    public function authenticate()                    // aquí confronta con la base de datos
    {
        if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {

            $agentId = $_POST['agentId'];
            $passwd = $_POST['passwd'];

            if ($this->userModel->login($agentId, $passwd)) {
                // Autenticación exitosa, iniciar sesión y redirigir al enrutador para que éste envíe al dashboard-inicio
                $_SESSION['idusuario'] = $agentId;
                header('Location: index.php?action=dashboard');
                exit();
            } else {
                // Autenticación fallida, recargar login con error que mostraría mensaje
                $_SESSION['error'] = "Usuario o contraseña incorrectos.";
                header('Location: index.php?action=login');
                exit();
            }
        } else {
            // mensaje de error si el usuario intenta acceder directamente desde el enlace
            // habiendose saltado la autenticacion
            $_SESSION['error'] = 'Debe proporcionar las credenciales para acceder al sistema.';
            // se muestra en el alert del formulario de login
            header('Location: index.php?action=login');
            exit();
        }
    }

    public function dashboard()
    {
        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['csrf_token'])) {
            header('Location: index.php?action=login');
            exit();
        }
        // Carga la vista del dashboard (página de bienvenida)
        header('Location: index.php?action=dashboard');
        exit();
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
        header('Location: index.php?action=login');
        exit();
    }
}