<?php
include_once __DIR__ . '/../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Email e senha são obrigatórios"]);
    exit;
}

$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$password = $data['password'];

function authenticateUser($email, $password, $db) {
    $query = "SELECT id, role, password FROM users WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode(["success" => false, "message" => "Email ou senha incorretos"]);
        exit;
    }

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];


    return ["user_id" => $user['id'], "role" => $user['role']];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $result = authenticateUser($email, $password, $db);

    if ($result) {
        echo json_encode(["success" => true, "user_id" => $result['user_id'], "role" => $result['role']]);
    } else {
        echo json_encode(["success" => false, "error" => "Autenticação falhou."]);
    }
}