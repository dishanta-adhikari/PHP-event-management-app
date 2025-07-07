<?php
session_start();

require_once __DIR__ . '/../../_init.php';

$_SESSION = array();

session_destroy();

header("Location: " . $appUrl . "/src/Views/auth/login");
exit();
