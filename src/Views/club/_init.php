<?php
session_start();

require_once __DIR__ . '/../../_init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . $appUrl . "/src/Views/auth/login");
    exit();
}
