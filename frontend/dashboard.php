<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo ao Dashboard</h1>
    
    <?php
    if (isset($_SESSION['role'])) {
        $role = $_SESSION['role'];

        if ($role === 'adm') {
            echo '<ul>';
            echo '<li><a href="users.php">Usuários</a></li>';
            echo '</ul>';
        } elseif ($role === 'vendedor') {
            echo '<ul>';
            echo '<li><a href="clients.php">Clientes</a></li>';
            echo '</ul>';
        } else {
            echo "<p>Você não autorização para ver as funcionalidades.</p>";
        }
    } else {
        echo "<p>Você não está autenticado.</p>";
    }
    ?>

</body>
</html>
