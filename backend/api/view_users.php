<?php
include_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/auth.php';

try {
    if (!isAuthenticated()) {
        throw new Exception("Acesso não autorizado", 403);
    }

    $database = new Database();
    $db = $database->getConnection();

    $query = "
        SELECT name, email, role FROM users
        UNION
        SELECT name, email, 'cliente' AS role FROM clients
        ORDER BY name
    ";

    $stmt = $db->query($query);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "data" => $users]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Erro ao buscar usuários: " . $e->getMessage()]);
    exit;
}
?>
