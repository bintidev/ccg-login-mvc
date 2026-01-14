<?php
require_once 'config/Database.php';                      // incluimos el código de conexión a la BD

class User
{
    private $PDO;
    private $tabla_nombre = "admins";                 // Tu tabla de usuarios

    public function __construct()
    {
        $database = new Database();                    // aquí se invoca al constructor Database, que crea la conexión
        $this->PDO = $database->getConnection();       // y se almacena en el objeto usuario, cuando se invoca su constructor
    }

    // Método para verificar usuario y contraseña
    public function login($idusuario, $password)      // para un objeto usuario, se puede invocar el método login()
    {                                                 // si tuviéramos registro, también se declararía un método para ello...
        $query = "SELECT * FROM " . $this->tabla_nombre . " WHERE agentid = ?";
        $stmt = $this->PDO->prepare($query);
        $stmt->bindParam(1, $idusuario);
        $stmt->execute();

        $num = $stmt->rowCount(); 

        if ($num == 0) { // comprueba solo la existencia del usuario
            return 'u_notfound'; // mensaje error usuario
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['password'] == $password) { // si existe usuario comprueba que la contraseña es correcta
            return $row;
        }
        return 'p_notfound'; // mensaje de error contraseña
    }
}
