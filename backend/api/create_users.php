<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../utils/functions_users.php';

header('Content-Type: application/json');

try {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Método não permitido", 405);
    }

    if (!isAuthenticated()) {
        throw new Exception("Acesso não autorizado", 403);
    }

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    if (empty($role)) {
        throw new Exception("Função é um campo obrigatório", 400);
    }    

    if (empty($name) || empty($email)) {
        throw new Exception("Nome e email são campos obrigatórios", 400);
    }

    if ($role === 'vendedor' || $role === 'adm') {
        if (empty($password)) {
            throw new Exception("Senha é obrigatória para vendedores e administradores", 400);
        }
    }

    $db = (new Database())->getConnection();
    $db->beginTransaction();

    if (emailExists($email, $db)) {
        throw new Exception("O e-mail já está em uso", 400);
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    switch ($role) {
        case 'vendedor':
            $userId = createUser($db, $name, $hashedPassword, $role, $email);
            $sellerId = createSeller($db, $userId, $name, $email);

            break;
        case 'cliente':
            $cpf = $_POST['cpf'] ?? '';
            $date_of_birth = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;
            $street = isset($_POST['street']) && !empty($_POST['street']) ? $_POST['street'] : null;
            $house_number = isset($_POST['house_number']) && !empty($_POST['house_number']) ? intval($_POST['house_number']) : null;
            $city = isset($_POST['city']) && !empty($_POST['city']) ? $_POST['city'] : null;
            $state = isset($_POST['state']) && !empty($_POST['state']) ? $_POST['state'] : null;
            $zip_code = isset($_POST['zip_code']) && !empty($_POST['zip_code']) ? $_POST['zip_code'] : null;

            if (empty($name) || empty($email) || empty($cpf)) {
                throw new Exception("Os campos nome, email e CPF são obrigatórios", 400);
            }

            if (emailExistsClients($email, $db)) {
                throw new Exception("O e-mail já está em uso", 400);
            }

            $create_users_id = $_SESSION['user_id'];
            $clientId = createClient($db, $create_users_id, $name, $email, $cpf, $date_of_birth, $street, $house_number, $city, $state, $zip_code);

            break;

        case 'adm':
            $userId = createUser($db, $name, $hashedPassword, $role, $email);
            break;

        default:
            throw new Exception("Tipo de usuário não reconhecido", 400);
            break;
    }

    $db->commit();

    echo json_encode(["success" => true, "message" => "Usuário criado com sucesso", "email" => $email]);
} catch (Exception $e) {
    $errorCode = $e->getCode() ? (int)$e->getCode() : 500;
    http_response_code($errorCode);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
