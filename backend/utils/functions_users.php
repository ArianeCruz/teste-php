<?php
function emailExists($email, $db) {
    $query = "SELECT COUNT(*) FROM users WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function emailExistsClients($email, $db) {
    $query = "SELECT COUNT(*) FROM clients WHERE email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function createUser($db, $name, $hashedPassword, $role, $email, $status = 'ativo') {
    $query = "INSERT INTO users (name, password, role, email, status) VALUES (:name, :password, :role, :email, :status)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':status', $status);
    if ($stmt->execute()) {
        return $db->lastInsertId();
    }
    return false;
}

function createSeller($db, $userId, $name, $email) {
    $query = "INSERT INTO seller (user_id, name, email) VALUES (:user_id, :name, :email)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    if ($stmt->execute()) {
        return $db->lastInsertId();
    }
    return false;
}

function createClient($db, $create_users_id, $name, $email, $cpf, $date_of_birth, $street, $house_number, $city, $state, $zip_code) {
    $query = "INSERT INTO clients (create_users_id, name, email, cpf, date_of_birth, street, house_number, city, state, zip_code) VALUES (:create_users_id, :name, :email, :cpf, :date_of_birth, :street, :house_number, :city, :state, :zip_code)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':create_users_id', $create_users_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':date_of_birth', $date_of_birth);
    $stmt->bindParam(':street', $street);
    $stmt->bindParam(':house_number', $house_number);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':state', $state);
    $stmt->bindParam(':zip_code', $zip_code);
    if ($stmt->execute()) {
        return $db->lastInsertId();
    }
    return false;
}
?>
