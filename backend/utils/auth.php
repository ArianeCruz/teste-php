<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isAuthenticated() {
    $isAuthenticated = isset($_SESSION['user_id']) && isset($_SESSION['role']);

    return $isAuthenticated;
}


