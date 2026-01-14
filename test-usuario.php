<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        require_once 'models/Usuario.php';
        $usuario = new Usuario();

        echo $usuario->login('MK001', 'MadoKure0_!');
    ?>
</body>
</html>